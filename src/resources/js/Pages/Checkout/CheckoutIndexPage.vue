<template>
	<app-layout>
		<template v-slot:main>
			<div class="flex flex-col-reverse md:flex-row">
				<!-- left side -->
				<div class="bg-white rounded-md w-full lg:w-1/2">
					<div class="pt-4 md:pt-6">
						<img
							class="block h-10 w-auto m-auto"
							src="https://tailwindui.com/img/logos/workflow-mark-indigo-500.svg"
							alt="Workflow"
						/>
					</div>
					<div class="flex flex-col md:flex-row justify-center items-center">
						<div class="w-full p-4 md:p-6">
							<breadcrumb-menu :tabs="tabs" @handleOnClickEvent="setActiveTab" />
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
	import { ref } from '@vue/reactivity';
	import { computed } from '@vue/runtime-core';
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
			let activeTab = computed(() => tabs.value.find((t) => t.is_active).component);
			const tabs = ref([
				{
					name: 'Information',
					component: 'CheckoutInformation',
					is_active: true,
					is_completed: false
				},
				{
					name: 'Shipping',
					component: 'CheckoutShipping',
					is_active: false,
					is_completed: false
				},
				{
					name: 'Payment',
					component: 'CheckoutPayment',
					is_active: false,
					is_completed: false
				}
			]);

			const { cartTotalPrice } = useCartFunctions();

			function setActiveTab(tab) {
				tabs.value = tabs.value.map((t) => {
					t.is_active = false;
					return t;
				});
				tabs.value.find((t) => t.name === tab.name).is_active = true;
			}

			return {
				activeTab,
				cartBundles,
				cartTotalPrice,
				tabs,
				setActiveTab
			};
		}
	};
</script>
