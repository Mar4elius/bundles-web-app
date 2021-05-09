<template>
	<div class="md:flex md:justify-between w-full my-6 md:my-8">
		<div class="w-full md:w-2/5 mb-4 md:mb-6">
			<h3>Shipping Address</h3>
			<p>Update your shipping information.</p>
		</div>
		<div class="w-full md:w-3/5 rounded-md bg-white p-4 md:p-6 lg:p-8">
			<validate-form @submit="onSubmit">
				<v-text-input
					name="address"
					type="text"
					label="Address"
					placeholder="Address"
					:value="activeUser.address"
					class="w-full md:w-1/2 mr-2 md:mr-4 lg:mr-6"
				/>

				<v-text-input
					name="apartment"
					type="text"
					label="Aparetents, Suit, etc. (optional)"
					placeholder="Address"
					:value="activeUser.apartment"
					class="w-full md:w-1/2 mr-2 md:mr-4 lg:mr-6"
				/>

				<!-- Countries -->
				<label class="block mb-2 md:mb-3 w-full text-md font-medium text-gray-700" for="countries"
					>Country</label
				>

				<multiselect
					name="country"
					id="countries"
					:value-prop="value"
					label="label"
					v-model="activeCountry"
					:options="countries"
					:loading="countries.length === 0"
					class="w-1/2 mb-6"
					@change="getProvinces"
					:object="true"
				/>
				<!-- // countries -->

				<!-- Provinces -->
				<label class="block mb-2 md:mb-3 w-full text-md font-medium text-gray-700" for="provinces"
					>Province</label
				>

				<multiselect
					name="province"
					id="provinces"
					v-model="activeProvince"
					:options="provinces"
					:loading="provinces.length === 0 && activeUser.province_id"
					class="w-1/2 mb-6"
					:disabled="!activeCountry.value"
				/>
				<!-- // provinces -->

				<v-text-input
					name="city"
					type="text"
					label="City"
					placeholder="City"
					:value="activeUser.city"
					class="w-full md:w-1/2"
				/>
				<v-text-input
					name="postal_code"
					type="text"
					label="Postal Code"
					placeholder="Postal Code"
					:value="activeUser.postal_code"
					class="w-full md:w-1/2"
				/>
				<v-text-input
					name="phone"
					type="text"
					label="Phone Number"
					placeholder="Phone Number"
					:value="activeUser.phone"
					class="w-full md:w-1/2 mr-2 md:mr-4 lg:mr-6"
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
			const activeCountry = reactive({
				value: '',
				label: ''
			});
			const activeProvince = reactive({
				value: '',
				label: ''
			});
			const toast = useToast();

			const activeUser = computed(() => store.state.users.active);

			const selectedCountry = computed({
				get() {
					return countries?.value.find((c) => c.value === activeUser.value?.province?.country?.id) || {};
				},
				set(value) {
					console.log(value);
					activeCountry.value = countries.value.find((c) => c.value === value);
				}
			});

			const selectedProvince = computed({
				get() {
					return provinces?.value.find((p) => p.value === activeUser.value?.province?.id) || {};
				},
				set(value) {
					activeProvince.value = provinces.value.find((c) => c.value === value);
				}
			});

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
					}
				}
			}

			async function getProvinces() {
				if (activeCountry.value !== '') {
					console.log('if');
					const response = await store.dispatch('options/getProvinces', activeCountry.value);
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
				const updatedActiveUser = {
					...activeUser.value,
					...values,
					active_country: activeCountry.value,
					active_province: activeProvince.value
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
					if (country) {
						activeCountry.value = country;
					}
					console.log(activeCountry);
					getProvinces();
					if (activeUser.value.province_id) {
						activeProvince.value = provinces.value.find((c) => c.value === value);
					}
				});
			});

			return {
				activeUser,
				activeCountry,
				countries,
				getCountries,
				getProvinces,
				onSubmit,
				provinces,
				selectedCountry,
				selectedProvince
			};
		}
	};
</script>
