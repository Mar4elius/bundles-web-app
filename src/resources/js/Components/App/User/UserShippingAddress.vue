<template>
	<div class="md:flex md:justify-between w-full my-6 md:my-8">
		<div class="w-full md:w-2/5 mb-4 md:mb-6">
			<h3>Shipping Address</h3>
			<p>Update your shipping information.</p>
		</div>
		<div class="w-full md:w-3/5 rounded-md bg-white p-4 md:p-6 lg:p-8">
			<validate-form @submit="onSubmit" :validation-schema="schema">
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
					<!-- Countries -->
					<div class="w-full lg:mr-6">
						<label class="block mb-2 md:mb-3 w-full text-md font-medium text-gray-700" for="countries"
							>Country</label
						>
						<multiselect
							name="country"
							id="countries"
							v-model="activeCountry.value"
							:options="countries"
							:loading="countries.length === 0"
							class="mb-6"
							@select="getProvinces()"
						/>
					</div>
					<!-- // countries -->

					<!-- Provinces -->
					<div class="w-full lg:mr-6">
						<label class="block mb-2 md:mb-3 w-full text-md font-medium text-gray-700" for="provinces"
							>Province</label
						>

						<multiselect
							name="province"
							id="provinces"
							v-model="activeProvince.value"
							:options="provinces"
							:loading="provinces.length === 0 && activeUser.province_id"
							class="w-full mb-6"
							:disabled="activeCountry && !activeCountry.value"
							ref="province_ddl"
						/>
					</div>
					<!-- // provinces -->
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
					/>
				</div>
				<v-text-input
					name="phone"
					type="text"
					label="Phone Number"
					placeholder="Phone Number"
					:value="activeUser.phone"
					class="w-full lg:w-1/2 lg:mr-6"
				/>
				<div class="text-right">
					<v-button-filled id="update-user-data">Save</v-button-filled>
				</div>
			</validate-form>
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
	import Multiselect from '@vueform/multiselect';
	// Vee-validation and Yup
	import { Form as ValidateForm } from 'vee-validate';
	import { string, required, email, object, shape } from 'yup';
	// Toast
	import { useToast } from 'vue-toastification';
	import Condition from 'yup/lib/Condition';

	export default {
		components: {
			Multiselect,
			ValidateForm,
			VButtonFilled,
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
				address: string().required(),
				province: string().required(),
				city: string().required(),
				postal_code: string().required(),
				phone: string().required()
			});

			const activeUser = computed(() => store.state.users.active);

			async function getCountries() {
				if (!countries.value.length) {
					const response = await store.dispatch('options/getCountries');
					if (response.status === 200) {
						countries.value = response.data.countries.map((item) => {
							return {
								value: item.id,
								label: item.name
							};
						});
						countries.value = response.data.countries.map((item) => {
							return {
								value: item.id,
								label: item.name
							};
						});
					}
				}
			}

			async function getProvinces() {
				// reset provinces before getting a new list
				activeProvince.value = '';
				if (activeCountry.value) {
					const response = await store.dispatch('options/getProvinces', activeCountry);
					if (response.status === 200) {
						provinces.value = response.data.provinces.map((item) => {
							return {
								value: item.id,
								label: item.name
							};
						});
					}
				}
			}

			async function onSubmit(values, action) {
				console.log('values', values);
				const updatedActiveUser = {
					...activeUser.value,
					...values,
					active_province_id: activeProvince.value
				};

				const formData = new FormData();
				formData.append('data', JSON.stringify(updatedActiveUser));

				const data = {
					activeUser: updatedActiveUser,
					formData: formData
				};

				formData.append('_method', 'PUT');

				const response = await store.dispatch('users/update', data);

				if (!response.errors) {
					toast.success(response.data.message);
				} else {
					toast.danger(response.data);
				}
			}

			onMounted(() => {
				getCountries().then((_) => {
					const country = countries?.value.find((c) => c.value === activeUser.value?.province?.country?.id);
					if (country?.value) {
						activeCountry.value = country.value;
					}
					getProvinces().then((_) => {
						if (activeUser.value.province_id) {
							activeProvince.value = provinces.value.find(
								(c) => c.value === activeUser.value.province_id
							).value;
						}
					});
				});
			});

			return {
				activeUser,
				activeCountry,
				activeProvince,
				countries,
				getCountries,
				getProvinces,
				onSubmit,
				provinces,
				schema
			};
		}
	};
</script>
