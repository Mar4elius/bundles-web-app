<template>
	<div
		:class="cartOpen ? 'translate-x-0 ease-out' : 'translate-x-full ease-in'"
		class="fixed right-0 top-0 max-w-xs w-full h-full px-6 py-4 transition duration-300 transform overflow-y-auto bg-white border-l-2 border-gray-300"
	>
		<div class="flex items-center justify-between">
			<h3 class="text-indigo-600">Your cart</h3>
			<button @click="closeCart" class="text-gray-600 focus:outline-none">
				<svg
					class="h-6 w-6"
					fill="none"
					stroke-linecap="round"
					stroke-linejoin="round"
					stroke-width="2"
					viewBox="0 0 24 24"
					stroke="currentColor"
				>
					<path d="M6 18L18 6M6 6l12 12"></path>
				</svg>
			</button>
		</div>
		<hr class="my-3" />
		<div class="flex justify-between mt-6" v-for="product in cartProducts" :key="product.id">
			<div class="flex">
				<img class="h-20 w-20 object-cover rounded" :src="product.image_path" :alt="product.name" />
				<div class="mx-3">
					<h3 class="text-sm text-gray-600">{{ product.name }}</h3>
					<div class="flex items-center mt-2">
						<button class="text-gray-500 focus:outline-none focus:text-gray-600">
							<svg
								class="h-5 w-5"
								fill="none"
								stroke-linecap="round"
								stroke-linejoin="round"
								stroke-width="2"
								viewBox="0 0 24 24"
								stroke="currentColor"
							>
								<path d="M12 9v3m0 0v3m0-3h3m-3 0H9m12 0a9 9 0 11-18 0 9 9 0 0118 0z"></path>
							</svg>
						</button>
						<span class="text-gray-700 mx-2">{{ product.count }}</span>
						<button class="text-gray-500 focus:outline-none focus:text-gray-600">
							<svg
								class="h-5 w-5"
								fill="none"
								stroke-linecap="round"
								stroke-linejoin="round"
								stroke-width="2"
								viewBox="0 0 24 24"
								stroke="currentColor"
							>
								<path d="M15 12H9m12 0a9 9 0 11-18 0 9 9 0 0118 0z"></path>
							</svg>
						</button>
					</div>
				</div>
			</div>
			<span class="text-gray-600">{{ product.price }}</span>
		</div>
		<v-button-filled id="checkout" classes="flex items-center justify-center mt-4 w-full">
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
	import VButtonFilled from '@/Components/Forms/VButtonFilled';

	export default {
		components: {
			VButtonFilled
		},

		setup() {
			const store = useStore();
			let cartOpen = computed(() => store.state.cart.isOpen);
			let cartProducts = computed(() => store.state.cart.items);
			function closeCart() {
				store.commit('cart/setIsOpen', false);
			}

			return {
				cartOpen,
				cartProducts,
				closeCart
			};
		}
	};
</script>
