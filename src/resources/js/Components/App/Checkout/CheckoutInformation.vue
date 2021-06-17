<template>
	<div class="flex-col flex-shrink-0 flex items-center">
		<div class="w-full flex justify-between items-center">
			<h6>Contact information</h6>
			<p v-if="!activeUser.user.id">
				Already have an account?
				<inertia-link href="/login" class="font-bold text-indigo-600 hover:text-indigo-500">
					Log in
				</inertia-link>
			</p>
		</div>
		<form class="w-full">
			<v-text-input
				name="email"
				type="email"
				label="Email"
				placeholder="Your email address"
				:value="activeUser.user.email"
				@update:value="setValue"
				class="w-full"
				:is-disabled="isSubmitting"
			/>
			<h6>Shipping address</h6>
			<div class="lg:flex">
				<v-text-input
					name="first_name"
					type="text"
					label="First Name"
					:value="activeUser.user.first_name"
					@update:value="setValue"
					class="w-full lg:w-1/2 mr-2 md:mr-4 lg:mr-6"
					:is-disabled="isSubmitting"
				/>

				<v-text-input
					name="last_name"
					type="text"
					label="Last Name"
					:value="activeUser.user.last_name"
					@update:value="setValue"
					class="w-full lg:w-1/2"
					:is-disabled="isSubmitting"
				/>
			</div>

			<div class="lg:flex">
				<v-text-input
					name="address"
					type="text"
					label="Address"
					:value="activeUser.address.address"
					@update:value="setValue"
					class="w-full lg:w-1/2 mr-2 md:mr-4 lg:mr-6"
				/>

				<v-text-input
					name="apartment"
					type="text"
					label="Apartments, Suit, etc. (optional)"
					:value="activeUser.address.apartment"
					@update:value="setValue"
					class="w-full lg:w-1/2"
				/>
			</div>

			<div class="lg:flex">
				<v-text-input
					name="city"
					type="text"
					label="City"
					placeholder="City"
					:value="activeUser.address.city"
					@update:value="setValue"
					class="w-full lg:w-1/2 mr-2 md:mr-4 lg:mr-6"
				/>
				<v-text-input
					name="postal_code"
					type="text"
					label="Postal Code"
					:value="activeUser.address.postal_code"
					@update:value="setValue"
					class="w-full lg:w-1/2"
					maska="A#A-#A#"
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
					:loading="provinces.length === 0 && activeUser.address.province_id"
					:disabled="activeCountry && !activeCountry.value"
					styles="w-full"
				/>
			</div>
			<div class="w-full">
				<v-text-input
					name="phone"
					type="text"
					label="Phone Number"
					:value="activeUser.address.phone"
					@update:value="setValue"
					class="w-full lg:w-1/2 mr-2 md:mr-4 lg:mr-6"
					maska="+1(###)-###-####"
				/>
			</div>

			<div class="w-full text-right">
				<v-button-filled id="continut-to-shipping" :is-disabled="isSubmitting"
					>Continue to shipping</v-button-filled
				>
			</div>
		</form>
	</div>
</template>
<script>
	// Vue
	import { useStore } from 'vuex';
	import { reactive, toRefs } from '@vue/reactivity';
	import { computed, onMounted } from '@vue/runtime-core';
	// Components
	import VButtonFilled from '@/Components/Forms/VButtonFilled';
	import VDropDownList from '@/Components/Forms/VDropDownList';
	import VTextInput from '@/Components/Forms/VTextInput';
	// Composables
	import useCountriesData from '@/Composables/useCountriesData';
	// Vee-validation and Yup
	import { useForm } from 'vee-validate';
	import { string, required, email, object, shape } from 'yup';

	export default {
		components: {
			VButtonFilled,
			VDropDownList,
			VTextInput
		},

		setup() {
			const store = useStore();
			// both logged in or not logged in
			let activeUser = reactive({
				user: { ...store.state.users.active },
				address: {
					...(store.state.users.active?.addresses.find((a) => a.pivot.is_active && a.pivot.is_shipping) || {
						address: null,
						country_id: null,
						province_id: null,
						city: null,
						postal_code: null,
						phone: null
					})
				}
			});

			const schema = object().shape({
				email: string().required().email().nullable(),
				first_name: string().required().nullable(),
				last_name: string().required().nullable(),
				address: string().required().nullable(),
				country_id: string().required().nullable(),
				province_id: string().required().nullable(),
				city: string().required().nullable(),
				postal_code: string().required().min(7).nullable(),
				phone: string().required().min(16).nullable()
			});

			const {
				activeCountry,
				activeProvince,
				getCountries,
				getProvinces,
				countries,
				provinces,
				setCountry,
				setProvince
			} = useCountriesData();

			onMounted(() => {
				getCountries().then((_) => {
					const country = countries?.value.find((c) => c.value === activeUser.address?.province?.country_id);
					console.log('country', activeCountry);
					console.log('province', activeProvince);
					if (country?.value) {
						setCountry(country.value);
						setFieldValue('country_id', activeCountry.value);
					}
					getProvinces().then((_) => {
						if (activeUser.address.province_id) {
							const province = provinces.value.find((c) => c.value === activeUser.address.province_id);
							setProvince(province.value);
							setFieldValue('province_id', activeProvince.value);
						}
					});
				});
			});

			const { handleSubmit, setFieldValue, isSubmitting } = useForm({
				initialValues: {
					country_id: activeCountry.value,
					province_id: activeProvince.value
				},
				validationSchema: schema
			});

			function setValue(data) {
				// if (data.key === 'country_id') {
				// 	// if country ddl is empty we have to reset value of province ddl
				// 	if (data.value === '') {
				// 		activeProvince.value = '';
				// 		setFieldValue('province_id', data.value);
				// 	}
				// 	activeCountry.value = data.value;
				// } else if (data.key === 'province_id') {
				// 	activeProvince.value = data.value;
				// 	activeUser.data[data.key] = data.value;
				// 	// update mutable data
				// 	// updateMutableData(activeUser.data);
				// } else {
				// 	activeUser.data[data.key] = data.value;
				// 	// update mutable data
				// 	// updateMutableData(activeUser.data);
				// }
				// // sets vee-validate field so the validation works
				// setFieldValue(data.key, data.value);
			}

			return {
				activeCountry,
				activeProvince,
				activeUser,
				countries,
				isSubmitting,
				getCountries,
				getProvinces,
				provinces,
				setValue
			};
		}
	};
</script>
