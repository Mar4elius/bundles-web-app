<template>
	<div class="md:flex md:justify-between w-full my-6 md:my-8">
		<div class="w-full md:w-2/5 mb-4 md:mb-6">
			<div class="flex justify-between items-center">
				<h3>{{ title.name }}</h3>
			</div>
			<p>{{ title.description }}</p>
		</div>
		<div class="w-full md:w-3/5 rounded-md bg-white p-4 md:p-6 lg:p-8">
			<form @submit="onSubmit" :validation-schema="schema">
				<div class="lg:flex">
					<v-text-input
						name="address"
						type="text"
						label="Address"
						placeholder="Address"
						:value="activeAddress.address"
						@update:value="setValue"
						class="w-full mr-2 md:mr-4 lg:mr-6"
					/>

					<v-text-input
						name="apartment"
						type="text"
						label="Aparetents, Suit, etc. (optional)"
						placeholder="Address"
						:value="activeAddress.apartment"
						@update:value="setValue"
						class="w-full"
					/>
				</div>

				<div class="lg:flex">
					<v-drop-down-list
						name="country_id"
						label="Country"
						:value="activeCountry.value"
						@update:value="setValue"
						@handle-select="getProvinces()"
						:options="countries"
						:loading="countries.length === 0"
						:required="true"
						styles="w-full mr-2 md:mr-4 lg:mr-6"
					/>

					<v-drop-down-list
						name="province_id"
						label="Province"
						:value="activeProvince.value"
						@update:value="setValue"
						:options="provinces"
						:loading="provinces.length === 0 && activeAddress.province_id"
						:disabled="activeCountry && !activeCountry.value"
						styles="w-full"
					/>
				</div>

				<div class="lg:flex">
					<v-text-input
						name="city"
						type="text"
						label="City"
						placeholder="City"
						:value="activeAddress.city"
						@update:value="setValue"
						class="w-full mr-2 md:mr-4 lg:mr-6"
					/>
					<v-text-input
						name="postal_code"
						type="text"
						label="Postal Code"
						placeholder="Postal Code"
						:value="activeAddress.postal_code"
						@update:value="setValue"
						class="w-full"
						maska="A#A-#A#"
					/>
				</div>
				<div class="lg:flex">
					<v-text-input
						name="phone"
						type="text"
						label="Phone Number"
						placeholder="Phone Number"
						:value="activeAddress.phone"
						@update:value="setValue"
						class="w-full mr-2 md:mr-4 lg:mr-6"
						maska="+1(###)-###-####"
					/>
					<div class="w-full" />
				</div>
				<!-- show checkbox only if it is a shiiping address -->
				<div class="w-full flex justify-start" v-if="type === `shipping`">
					<v-checkbox
						name="is_billing_and_shipping_same"
						:is-checked="isBillingSameAsShipping"
						class="flex flex-row-reverse items-center"
						label="Billing address is the same as Shipping address"
						@update:checked="setBillingAddressSameAsShipping"
					/>
				</div>
				<div class="flex justify-end items-center">
					<loading-animation classes="w-6 h-6 mr-2 md:mr-4" v-if="loading" />
					<!-- <v-button-filled id="update-shipping-address" :is-disabled="isSubmitting || !hasDataChanged"
						>Save</v-button-filled
					> -->
					<v-button-filled id="update-shipping-address">Save</v-button-filled>
				</div>
			</form>
		</div>
	</div>
</template>
<script>
	// Vue
	import { useStore } from 'vuex';
	import { computed, onMounted, reactive, ref, watch } from '@vue/runtime-core';
	// Components
	import VCheckbox from '@/Components/Forms/VCheckbox';
	import VTextInput from '@/Components/Forms/VTextInput';
	import VButtonFilled from '@/Components/Forms/VButtonFilled';
	import VDropDownList from '@/Components/Forms/VDropDownList';
	import LoadingAnimation from '@/Components/Support/LoadingAnimation';
	// Composable functions
	import useCountriesData from '@/Composables/useCountriesData';
	import useMultiselectDropDown from '@/Composables/useMultiselectDropDown';
	import useHasDataChanged from '@/Composables/useHasDataChanged';
	import useLocalLoadingFlag from '@/Composables/useLocalLoadingFlag';
	// Vee-validation
	import { useForm } from 'vee-validate';
	// Yup
	import { string, required, object, shape, max, nullable, boolean } from 'yup';
	// Toast
	import { useToast } from 'vue-toastification';

	export default {
		components: {
			LoadingAnimation,
			VCheckbox,
			VButtonFilled,
			VDropDownList,
			VTextInput
		},

		props: {
			activeAddress: {
				type: Object,
				required: true
			},

			title: {
				type: Object,
				default: null
			},

			type: {
				type: String,
				required: true
			}
		},

		setup(props) {
			const store = useStore();
			let activeUser = computed(() => store.state.users.active);

			let activeAddress = reactive({
				...props.activeAddress
			});

			const toast = useToast();
			const schema = object().shape({
				address: string().required().nullable(),
				country_id: string().required().nullable(),
				province_id: string().required().nullable(),
				city: string().required().nullable(),
				postal_code: string().required().min(7).nullable(),
				phone: string().required().min(16).nullable(),
				is_billing: boolean().required()
			});
			const isBillingSameAsShipping = computed(() => store.state.address.isBillingSameAsShipping);

			// const { hasDataChanged, updateInitialData, updateMutableData } = useHasDataChanged(
			// 	vuexStoreActiveUser.value,
			// 	activeUser
			// );
			const { hasDataChanged, updateInitialData, updateMutableData } = useHasDataChanged(
				props.activeAddress,
				activeAddress
			);

			const { loading, setLocalLoadingFlag } = useLocalLoadingFlag();

			const {
				activeCountry,
				activeProvince,
				getCountries,
				getProvinces,
				countries,
				provinces
			} = useCountriesData();

			const { handleSubmit, setFieldValue, isSubmitting } = useForm({
				initialValues: {
					country_id: activeCountry.value,
					province_id: activeProvince.value
				},
				validationSchema: schema
			});

			onMounted(() => {
				getCountries().then((_) => {
					const country = countries?.value.find((c) => c.value === activeAddress?.province?.country_id);
					if (country?.value) {
						activeCountry.value = country.value;
						setFieldValue('country_id', activeCountry.value);
					}
					getProvinces().then((_) => {
						if (activeAddress.province_id) {
							activeProvince.value = provinces.value.find(
								(c) => c.value === activeAddress.province_id
							).value;
							setFieldValue('province_id', activeProvince.value);
						}
					});
				});
			});

			const onSubmit = handleSubmit(async (values) => {
				setLocalLoadingFlag(true);
				const data = {
					user_id: activeUser.value.id,
					is_billing: props.type === 'shipping' ? false : true,
					is_billing_and_shipping_same: isBillingSameAsShipping.value,
					...values,
					...activeAddress
				};
				// update address
				let response = null;
				if (activeAddress?.id) {
					response = await store.dispatch('address/update', data);
				} else {
					// create new address
					response = await store.dispatch('address/store', data);
				}

				if (!response.errors) {
					// get updated user info
					await store.dispatch('users/show', activeUser.value);
					toast.success(response.data.message);
				} else {
					toast.danger(response.data);
				}
				setLocalLoadingFlag(false);
			});

			const { createMultiselectDdlObject, setDdlValue } = useMultiselectDropDown();

			function setValue(data) {
				console.log(data);
				if (data.key === 'country_id') {
					// if country ddl is empty we have to reset value of province ddl
					if (data.value === '') {
						activeProvince.value = '';
						setFieldValue('province_id', data.value);
					}
					activeCountry.value = data.value;
				} else if (data.key === 'province_id') {
					activeProvince.value = data.value;
					activeAddress[data.key] = data.value;
					// update mutable data
					updateMutableData(activeAddress);
				} else {
					activeAddress[data.key] = data.value;
					// update mutable data
					updateMutableData(activeAddress);
				}
				// sets vee-validate field so the validation works
				setFieldValue(data.key, data.value);
			}

			function setBillingAddressSameAsShipping(data) {
				setFieldValue(data.key, data.value);
				store.commit('address/setBillingAddressSameAsShipping', data.value);
			}

			// User data can be updated from 2 components:
			// - UserProfile
			// - UserShippingAddress
			// When data is changes in one of the components, it will update the vuex
			// state. With watcher we making sure that activeUser will have the same
			// data in both components
			watch(props.activeAddress, (newValue, oldValue) => {
				updateInitialData(newValue);
				activeAddress = { ...newValue };
				updateMutableData(activeAddress);
			});

			return {
				activeAddress,
				activeCountry,
				activeProvince,
				countries,
				getCountries,
				getProvinces,
				hasDataChanged,
				isSubmitting,
				isBillingSameAsShipping,
				loading,
				onSubmit,
				provinces,
				schema,
				setValue,
				setBillingAddressSameAsShipping
			};
		}
	};
</script>
