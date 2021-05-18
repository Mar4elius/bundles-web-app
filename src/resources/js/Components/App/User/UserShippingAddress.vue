<template>
	<div class="md:flex md:justify-between w-full my-6 md:my-8">
		<div class="w-full md:w-2/5 mb-4 md:mb-6">
			<h3>Shipping Address</h3>
			<p>Update your shipping information.</p>
		</div>
		<div class="w-full md:w-3/5 rounded-md bg-white p-4 md:p-6 lg:p-8">
			<form @submit="onSubmit" :validation-schema="schema">
				<div class="lg:flex">
					<v-text-input
						name="address"
						type="text"
						label="Address"
						placeholder="Address"
						:value="activeUser.address"
						class="w-full mr-2 md:mr-4 lg:mr-6"
					/>

					<v-text-input
						name="apartment"
						type="text"
						label="Aparetents, Suit, etc. (optional)"
						placeholder="Address"
						:value="activeUser.apartment"
						class="w-full mr-2 md:mr-4 lg:mr-6"
					/>
				</div>

				<div class="lg:flex">
					<v-drop-down-list
						name="country"
						label="Country"
						:value="activeCountry.value"
						@update:value="setValue"
						@handle-select="getProvinces()"
						:options="countries"
						:loading="countries.length === 0"
						:required="true"
					/>

					<v-drop-down-list
						name="province"
						label="Province"
						:value="activeProvince.value"
						@update:value="setValue"
						:options="provinces"
						:loading="provinces.length === 0 && activeUser.province_id"
						:disabled="activeCountry && !activeCountry.value"
					/>
				</div>

				<div class="lg:flex">
					<v-text-input
						name="city"
						type="text"
						label="City"
						placeholder="City"
						:value="activeUser.city"
						class="w-full lg:mr-6"
					/>
					<v-text-input
						name="postal_code"
						type="text"
						label="Postal Code"
						placeholder="Postal Code"
						:value="activeUser.postal_code"
						class="w-full lg:mr-6"
						maska="A#A-#A#"
					/>
				</div>
				<v-text-input
					name="phone"
					type="text"
					label="Phone Number"
					placeholder="Phone Number"
					:value="activeUser.phone"
					class="w-full md:w-1/2 lg:mr-6"
					maska="+1(###)-###-####"
				/>
				<div class="text-right">
					<v-button-filled id="update-shipping-address" :disabled="isSubmitting">Save</v-button-filled>
				</div>
			</form>
		</div>
	</div>
</template>
<script>
	// Vue
	import { useStore } from 'vuex';
	import { computed, onMounted, reactive, ref } from '@vue/runtime-core';
	// Components
	import VTextInput from '@/Components/Forms/VTextInput';
	import VButtonFilled from '@/Components/Forms/VButtonFilled';
	import VDropDownList from '@/Components/Forms/VDropDownList';
	import Multiselect from '@vueform/multiselect';
	// Composable functions
	import useMultiselectDropDown from '@/Composables/useMultiselectDropDown';
	// Vee-validation
	import { useForm } from 'vee-validate';
	// Yup
	import { string, required, object, shape, max, nullable } from 'yup';
	// Toast
	import { useToast } from 'vue-toastification';

	export default {
		components: {
			Multiselect,
			VButtonFilled,
			VDropDownList,
			VTextInput
		},

		setup(props) {
			const store = useStore();
			const countries = ref([]);
			const provinces = ref([]);
			let activeCountry = reactive({
				value: '',
				label: ''
			});
			let activeProvince = reactive({
				value: '',
				label: ''
			});
			const toast = useToast();

			const schema = object().shape({
				address: string().required().nullable(),
				country: string().required().nullable(),
				province: string().required().nullable(),
				city: string().required().nullable(),
				postal_code: string().required().min(7).nullable(),
				phone: string().required().min(16).nullable()
			});

			const activeUser = computed(() => store.state.users.active);

			const { handleSubmit, setFieldValue, isSubmitting } = useForm({
				initialValues: {
					country: activeCountry.value,
					province: activeProvince.value
				},
				validationSchema: schema
			});

			const onSubmit = handleSubmit((values) => {
				const updatedActiveUser = {
					...activeUser.value,
					...values,
					active_province_id: activeProvince.value
				};

				const formData = new FormData();

				Object.keys(updatedActiveUser).forEach((key) => {
					formData.append(key, updatedActiveUser[key]);
				});

				const data = {
					activeUser: updatedActiveUser,
					formData: formData
				};

				formData.append('_method', 'PUT');
				store.dispatch('users/update', data).then((response) => {
					if (!response.errors) {
						toast.success(response.data.message);
					} else {
						toast.danger(response.data);
					}
				});
			});

			// const { value: country, errorMessage: countryError } = useField('country');
			// const { value: province, errorMessage: provinceError } = useField('country');

			const { createMultiselectDdlObject, setDdlValue } = useMultiselectDropDown();
			async function getCountries() {
				if (!countries.value.length) {
					const response = await store.dispatch('options/getCountries');
					if (response.status === 200) {
						countries.value = createMultiselectDdlObject(response.data.countries);
					}
				}
			}

			async function getProvinces() {
				// reset provinces before getting a new list
				activeProvince.value = '';
				if (activeCountry.value) {
					const response = await store.dispatch('options/getProvinces', activeCountry);
					if (response.status === 200) {
						provinces.value = createMultiselectDdlObject(response.data.provinces);
					}
				}
			}

			onMounted(() => {
				getCountries().then((_) => {
					const country = countries?.value.find((c) => c.value === activeUser.value?.province?.country?.id);
					if (country?.value) {
						activeCountry.value = country.value;
						setFieldValue('country', activeCountry.value);
					}
					getProvinces().then((_) => {
						if (activeUser.value.province_id) {
							activeProvince.value = provinces.value.find(
								(c) => c.value === activeUser.value.province_id
							).value;
							setFieldValue('province', activeProvince.value);
						}
					});
				});
			});

			function setValue(data) {
				if (data.field === 'country') {
					// if country ddl is empty we have to reset value of province ddl
					if (data.value === '') {
						activeProvince.value = '';
						setFieldValue('province', data.value);
					}
					activeCountry.value = data.value;
				} else if (data.field === 'province') {
					activeProvince.value = data.value;
				}
				// sets vee-validate field so the validation works
				setFieldValue(data.field, data.value);
			}

			return {
				activeUser,
				activeCountry,
				activeProvince,
				countries,
				getCountries,
				getProvinces,
				isSubmitting,
				onSubmit,
				provinces,
				schema,
				setValue
			};
		}
	};
</script>
