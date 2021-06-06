<template>
	<modal-dialog :show="showModal" :is-click-outside="false" @btnOnClickEvent="showModal = !showModal">
		<template v-slot:header>
			<div class="flex flex-col">
				<h4>Your Shopping Cart</h4>
				<p>Total Bundles ({{ cartTotalBundles }})</p>
			</div>
		</template>
		<template v-slot:content>
			<template v-if="cartBundles.length > 0">
				<div v-for="bundle in cartBundles" :key="bundle.slug">
					<cart-bundle-details :cart-bundle="bundle" />
					<hr class="border-indigo-600 border-1 rounded-md md:mb-4 lg:mb-6" />
				</div>
				<div class="flex justify-end items-center">
					<h5 class="mr-5 text-indigo-600">Subtotal:</h5>
					<p class="text-lg font-bold">{{ cartTotalPrice }}</p>
				</div>
			</template>
			<template v-else>
				<p class="text-small text-gray-600 text-center">You cart is empty at the moment.</p>
			</template>
		</template>
		<template v-slot:footer>
			<div class="w-full flex justify-center">
				<v-button-filled
					id="continue-shopping"
					classes="flex items-center justify-center mt-4 mr-5"
					@btnOnClickEvent="showModal = !showModal"
					>Continue Shopping</v-button-filled
				>
				<v-button-filled
					id="checkout-button"
					:is-disabled="cartBundles.length === 0 || bundleHasAllProducts0"
					classes="flex items-center justify-center mt-4"
					@btnOnClickEvent="goToCheckoutPage"
				>
					<span>Checkout</span>
					<svg
						class="h-5 w-5 mx-2"
						fill="none"
						stroke-linecap="round"
						stroke-linejoin="round"
						stroke-width="2"
						viewBox="0 0 24 24"
						stroke="currentColor"
					>
						<path d="M17 8l4 4m0 0l-4 4m4-4H3"></path>
					</svg>
				</v-button-filled>
			</div>
		</template>
	</modal-dialog>
</template>

<script>
	// Vue
	import { computed } from '@vue/runtime-core';
	// Components
	import CartBundleDetails from '@/Components/App/Cart/CartBundleDetails';
	import ModalDialog from '@/Components/Support/ModalDialog';
	import VButtonFilled from '@/Components/Forms/VButtonFilled';
	//Composables
	import useCartFunctions from '@/Composables/useCartFunctions';
	// Helpers
	import { calculatePrice } from '@/helpers.js';

	export default {
		props: {
			cartBundles: {
				type: Object,
				required: true
			},

			showModal: {
				type: Boolean,
				default: false
			}
		},

		components: {
			CartBundleDetails,
			ModalDialog,
			VButtonFilled
		},

		setup(props) {
			const { cartTotalPrice, cartTotalBundles, bundleHasAllProducts0 } = useCartFunctions();

			function goToCheckoutPage() {
				window.location.href = route('payment.index');
			}

			return {
				bundleHasAllProducts0,
				cartTotalBundles,
				cartTotalPrice,
				goToCheckoutPage
			};
		}
	};
</script>
