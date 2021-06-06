<template>
	<app-layout>
		<template v-slot:main>
			<div class="flex flex-col-reverse md:flex-row">
				<!-- left side -->
				<div class="bg-white rounded-md w-full lg:w-1/2">
					<div class="flex flex-col md:flex-row justify-center items-center min-h-screen">
						<div class="w-full p-4 md:p-6">
							<div class="flex-col flex-shrink-0 flex items-center">
								<img
									class="block h-10 w-auto"
									src="https://tailwindui.com/img/logos/workflow-mark-indigo-500.svg"
									alt="Workflow"
								/>
								<!-- Add crunber menu -->
								<div class="w-full flex justify-between items-center">
									<h6>Contact information</h6>
									<p>
										Already have an account?
										<inertia-link
											href="/login"
											class="font-bold text-indigo-600 hover:text-indigo-500"
										>
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
										:value="activeUser.email"
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
											:value="activeUser.first_name"
											@update:value="setValue"
											class="w-full lg:w-1/2 mr-2 md:mr-4 lg:mr-6"
											:is-disabled="isSubmitting"
										/>

										<v-text-input
											name="last_name"
											type="text"
											label="Last Name"
											:value="activeUser.last_name"
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
											:value="activeUser.address"
											@update:value="setValue"
											class="w-full lg:w-1/2 mr-2 md:mr-4 lg:mr-6"
										/>

										<v-text-input
											name="apartment"
											type="text"
											label="Aparetents, Suit, etc. (optional)"
											:value="activeUser.apartment"
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
											:value="activeUser.city"
											@update:value="setValue"
											class="w-full lg:w-1/2 mr-2 md:mr-4 lg:mr-6"
										/>
										<v-text-input
											name="postal_code"
											type="text"
											label="Postal Code"
											:value="activeUser.postal_code"
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
											:classes="`mr-2 md:mr-4 lg:mr-6`"
										/>

										<v-drop-down-list
											name="province_id"
											label="Province"
											:value="activeProvince.value"
											@update:value="setValue"
											:options="provinces"
											:loading="provinces.length === 0 && activeUser.province_id"
											:disabled="activeCountry && !activeCountry.value"
										/>
									</div>
									<div class="w-full">
										<v-text-input
											name="phone"
											type="text"
											label="Phone Number"
											:value="activeUser.phone"
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
						</div>
					</div>
				</div>
				<!-- right side -->
				<div class="bg-gray-100 w-full lg:w-1/2 p-4 md:p-6">
					<h1>Order details</h1>
					<div v-for="bundle in cartBundles" :key="bundle.slug">
						<cart-bundle-details :cart-bundle="bundle" />
						<hr class="border-indigo-600 border-1 rounded-md md:mb-4 lg:mb-6" />
						<div class="flex justify-end items-center">
							<h5 class="mr-5 text-indigo-600">Subtotal:</h5>
							<p class="text-lg font-bold">{{ cartTotalPrice }}</p>
						</div>
					</div>
				</div>
			</div>
		</template>
	</app-layout>
</template>

<script>
	// Vue
	import { reactive } from '@vue/reactivity';
	import { computed, onMounted } from '@vue/runtime-core';
	// Components
	import AppLayout from '@/Layouts/AppLayout';
	import CartBundleDetails from '@/Components/App/Cart/CartBundleDetails';
	import VButtonFilled from '@/Components/Forms/VButtonFilled';
	import VDropDownList from '@/Components/Forms/VDropDownList';
	import VTextInput from '@/Components/Forms/VTextInput';
	// Composables
	import useCountriesData from '@/Composables/useCountriesData';
	import useCartFunctions from '@/Composables/useCartFunctions';
	// Vee-validation and Yup
	import { useForm } from 'vee-validate';
	import { string, required, email, object, shape } from 'yup';
	import { useStore } from 'vuex';
	export default {
		components: {
			AppLayout,
			CartBundleDetails,
			VButtonFilled,
			VDropDownList,
			VTextInput
		},

		setup() {
			const store = useStore();
			// both logged in or not logged in
			const activeUser = reactive({
				first_name: null,
				last_name: null,
				address: null,
				appartment: null,
				city: null,
				postal_code: null,
				email: null,
				phone: null,
				country_id: 1,
				province_id: null
			});

			let cartBundles = computed(() => store.state.cart.items);

			const schema = object().shape({
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
				provinces
			} = useCountriesData();

			const { cartTotalPrice } = useCartFunctions();

			const { handleSubmit, setFieldValue, isSubmitting } = useForm({
				initialValues: {
					country_id: activeCountry.value,
					province_id: activeProvince.value
				},
				validationSchema: schema
			});

			onMounted(() => {
				getCountries().then((_) => {
					const country = countries?.value.find((c) => c.value === activeUser?.province?.country?.id);
					if (country?.value) {
						activeCountry.value = country.value;
						setFieldValue('country_id', activeCountry.value);
					}
					getProvinces().then((_) => {
						if (activeUser.province_id) {
							activeProvince.value = provinces.value.find(
								(c) => c.value === activeUser.province_id
							).value;
							setFieldValue('province_id', activeProvince.value);
						}
					});
				});
			});

			function setValue(data) {
				console.log(data);
			}

			return {
				activeUser,
				activeCountry,
				activeProvince,
				cartBundles,
				cartTotalPrice,
				countries,
				getProvinces,
				isSubmitting,
				provinces,
				setValue
			};
		}
	};
</script>
