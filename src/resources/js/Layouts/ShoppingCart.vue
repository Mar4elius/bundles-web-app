<template>
	<div
		:class="cartOpen ? 'translate-x-0 ease-out' : 'translate-x-full ease-in'"
		class="fixed right-0 top-0 max-w-xs w-full h-full px-6 py-4 transition duration-300 transform overflow-y-auto bg-white border-l-2 border-gray-300"
	>
		<div class="flex items-center justify-between">
			<h3 class="text-indigo-600">Your cart</h3>
			<button @click="closeCart" class="text-gray-600 focus:outline-none">
				<svg-hero-icon>
					<svg
						fill="none"
						stroke-linecap="round"
						stroke-linejoin="round"
						stroke-width="2"
						viewBox="0 0 24 24"
						stroke="currentColor"
					>
						<path d="M6 18L18 6M6 6l12 12"></path>
					</svg>
				</svg-hero-icon>
			</button>
		</div>
		<hr class="my-3" />

		<template v-if="cartBundles.length">
			<div class="flex justify-between mt-6" v-for="bundle in cartBundles" :key="bundle.id">
				<cart-tile :bundle="bundle" />
			</div>
		</template>
		<template v-else>
			<p class="text-small text-gray-600 text-center">You cart is empty at the moment.</p>
		</template>

		<v-button-filled
			id="checkout"
			:is-disabled="!!cartBundles.length"
			classes="flex items-center justify-center mt-4 w-full"
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

<script>
	// Vuex
	import { computed } from '@vue/runtime-core';
	import { useStore } from 'vuex';
	// Components
	import CartTile from '@/Components/App/Cart/CartTile';
	import VButtonFilled from '@/Components/Forms/VButtonFilled';
	import SvgHeroIcon from '@/Components/Support/SvgHeroIcon';

	export default {
		components: {
			CartTile,
			VButtonFilled,
			SvgHeroIcon
		},

		setup() {
			const store = useStore();
			let cartOpen = computed(() => store.state.cart.isOpen);
			let cartBundles = computed(() => store.state.cart.items);

			function closeCart() {
				store.commit('cart/setIsOpen', false);
			}

			return {
				cartOpen,
				cartBundles,
				closeCart
			};
		}
	};
</script>
