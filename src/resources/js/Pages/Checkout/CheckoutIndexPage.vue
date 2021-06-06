<template>
	<app-layout>
		<template v-slot:main>
			<div class="flex flex-col-reverse md:flex-row">
				<!-- left side -->
				<div class="bg-white rounded-md w-full lg:w-1/2">
					<div class="flex flex-col md:flex-row justify-center items-center min-h-screen">
						<div class="w-full p-4 md:p-6">
							<breadcrumb-menu :tabs="tabs" @handleOnClickEvent="(...args) => (activeTab = args)" />
							<keep-alive>
								<component :is="activeTab"></component>
							</keep-alive>
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
	import { ref, reactive } from '@vue/reactivity';
	import { computed, onMounted } from '@vue/runtime-core';
	import { useStore } from 'vuex';
	// Components
	import AppLayout from '@/Layouts/AppLayout';
	import BreadcrumbMenu from '@/Components/Support/BreadcrumbMenu';
	import CartBundleDetails from '@/Components/App/Cart/CartBundleDetails';
	import CheckoutInformation from '@/Components/App/Checkout/CheckoutInformation';
	import CheckoutShipping from '@/Components/App/Checkout/CheckoutShipping';
	import CheckoutPayment from '@/Components/App/Checkout/CheckoutPayment';
	// Composables
	import useCartFunctions from '@/Composables/useCartFunctions';

	export default {
		components: {
			AppLayout,
			BreadcrumbMenu,
			CartBundleDetails,
			CheckoutInformation,
			CheckoutShipping,
			CheckoutPayment
		},

		setup() {
			const store = useStore();
			let cartBundles = computed(() => store.state.cart.items);

			const activeTab = ref('CheckoutInformation');
			const tabs = ref([
				{
					name: 'Information',
					component: 'CheckoutInformation',
					is_active: true
				},
				{
					name: 'Shipping',
					component: 'CheckoutShipping',
					is_active: false
				},
				{
					name: 'Payment',
					component: 'CheckoutPayment',
					is_active: false
				}
			]);

			const { cartTotalPrice } = useCartFunctions();

			return {
				cartBundles,
				cartTotalPrice,
				tabs,
				activeTab
			};
		}
	};
</script>
