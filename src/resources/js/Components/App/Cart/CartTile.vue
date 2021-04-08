<template>
	<div class="flex">
		<img class="h-20 w-20 object-cover rounded" :src="bundle.image_path" :alt="bundle.name" />
		<div class="mx-3">
			<h3 class="text-sm text-gray-600">{{ bundle.name }}</h3>
			<div class="flex items-center mt-2">
				<button @click="incrementQuantity()" class="text-gray-500 focus:outline-none focus:text-gray-600">
					<svg
						class="w-5 md:w-6"
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
				<span class="text-gray-700 mx-2">{{ bundle.quantity }}</span>
				<button @click="decrementQuantity()" class="text-gray-500 focus:outline-none focus:text-gray-600">
					<svg
						class="w-5 md:w-6"
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
		<div class="flex flex-wrap content-between justify-end">
			<button @click="removeBundleFromCart()" class="text-gray-500 focus:outline-none focus:text-gray-600">
				<svg
					class="w-5 md:w-6 text-red-600"
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
			<span class="text-gray-600">{{ calculatePrice(bundle.price) }}</span>
		</div>
	</div>
</template>

<script>
	// Vue
	import { useStore } from 'vuex';
	// Helpers
	import { calculatePrice } from '@/helpers.js';

	export default {
		props: {
			bundle: {
				type: Object,
				requried: true
			}
		},

		setup(props) {
			const store = useStore();

			function incrementQuantity() {
				store.commit('cart/incrementItemQuantity', {
					id: props.bundle.id,
					quantity: 1
				});
			}

			function decrementQuantity() {
				store.commit('cart/decrementItemQuantity', {
					id: props.bundle.id,
					quantity: 1
				});
			}

			function removeBundleFromCart() {
				store.commit('cart/removeBundleFromCart', props.bundle);
			}

			return {
				calculatePrice,
				incrementQuantity,
				decrementQuantity,
				removeBundleFromCart
			};
		}
	};
</script>
