<template>
	<modal-dialog :show="showModal" @btnOnClickEvent="showModal = !showModal">
		<template v-slot:header>
			<div class="flex flex-col">
				<h4>Your Shopping Cart</h4>
				<p>Total Bundles ({{ cartTotalBundles }})</p>
			</div>
		</template>
		<template v-slot:content>
			<div v-for="bundle in cartBundles" :key="bundle.slug">
				<cart-bundle-details :cart-bundle="bundle" />
			</div>
			<div class="flex justify-end items-center">
				<h5 class="mr-5 text-indigo-600">Subtotal:</h5>
				<p class="text-lg font-bold">{{ cartTotalPrice }}</p>
			</div>
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
					:is-disabled="cartBundles.length === 0"
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
	// Components
	import CartBundleDetails from '@/Components/App/Cart/CartBundleDetails';
	import ModalDialog from '@/Components/Support/ModalDialog';
	import VButtonFilled from '@/Components/Forms/VButtonFilled';
	import { computed } from '@vue/runtime-core';
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
			const cartTotalPrice = computed(() => {
				const price = props.cartBundles.reduce((curr, acc) => {
					return curr + acc.price_per_bundle * acc.quantity;
				}, 0);
				return calculatePrice(price);
			});

			const cartTotalBundles = computed(() => {
				return props.cartBundles.reduce((curr, acc) => {
					return curr + acc.quantity;
				}, 0);
			});

			function goToCheckoutPage() {
				window.location.href = route('payment.index');
			}

			return {
				cartTotalBundles,
				cartTotalPrice,
				goToCheckoutPage
			};
		}
	};
</script>
