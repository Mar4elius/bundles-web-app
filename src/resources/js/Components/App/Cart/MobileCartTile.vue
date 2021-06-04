<template>
	<div>
		<div class="flex w-full">
			<img class="h-20 w-20 object-cover rounded" :src="cartBundle.image_path" :alt="cartBundle.name" />
			<div class="ml-3 w-full">
				<div class="flex justify-between w-full">
					<h3 class="text-sm text-gray-600 mt-0">{{ cartBundle.name }}</h3>
					<v-button-icon @btnOnClickEvent="removeBundleFromCart(cartBundle)">
						<svg
							class="w-5 md:w-6 text-red-600 mt-0"
							fill="none"
							stroke-linecap="round"
							stroke-linejoin="round"
							stroke-width="2"
							viewBox="0 0 24 24"
							stroke="currentColor"
						>
							<path d="M6 18L18 6M6 6l12 12"></path>
						</svg>
					</v-button-icon>
				</div>
				<div class="w-full">
					<span class="text-gray-600 mt-2 text-right">{{ calculatePrice(cartBundle.price_per_bundle) }}</span>
				</div>
			</div>
		</div>
		<div class="flex justify-between w-full mt-2">
			<div class="w-20 text-center">
				<bundle-product-quantity-changer
					classes="w-5 md:w-6"
					:product="cartBundle"
					@incrementQuantityBtnClick="incrementBundleCount(cartBundle)"
					@decrementQuantityBtnClick="decrementBundleCount(cartBundle)"
				/>
			</div>
			<v-button-icon @btnOnClickEvent="showBundleDetails = !showBundleDetails">
				<svg
					xmlns="http://www.w3.org/2000/svg"
					class="w-5 md:w-6"
					fill="none"
					viewBox="0 0 24 24"
					stroke="currentColor"
				>
					<path
						stroke-linecap="round"
						stroke-linejoin="round"
						stroke-width="2"
						d="M8 12h.01M12 12h.01M16 12h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"
					/>
				</svg>
			</v-button-icon>
		</div>
		<div v-if="showBundleDetails">
			<div v-for="product in cartBundle.products" :key="product.slug">
				<h3 class="text-sm text-indigo-600">{{ product.name }}</h3>
				<div class="flex justify-between items-center">
					<h3 class="text-sm text-gray-600 my-0">Quantity:</h3>
					<bundle-product-quantity-changer
						classes="w-5 md:w-6"
						:product="product"
						@incrementQuantityBtnClick="(...args) => incrementProductCount(cartBundle, ...args)"
						@decrementQuantityBtnClick="(...args) => decrementProductCount(cartBundle, ...args)"
					/>
				</div>
				<div class="flex justify-between items-center">
					<h3 class="text-sm text-gray-600 my-0">$/Item</h3>
					<p>{{ calculatePrice(product.price) }}</p>
				</div>
				<div class="flex justify-between items-center">
					<h3 class="text-sm text-gray-600 my-0">$/Items:</h3>
					<p>{{ calculateProductTotalPrice(product) }}</p>
				</div>
			</div>
			<hr class="border-indigo-600" />
			<div class="w-full flex justify-end items-center">
				<h3 class="text-sm text-indigo-600 mr-2">Total Per Bundle:</h3>
				<p class="text-lg font-bold">{{ calculatePrice(cartBundle.price_per_bundle) }}</p>
			</div>
		</div>
	</div>
</template>

<script>
	// Vue
	import { ref } from 'vue';
	// Helpers
	import { calculatePrice } from '@/helpers.js';
	// Components
	import BundleProductQuantityChanger from '@/Components/App/Bundle/BundleProductQuantityChanger';
	import VButtonIcon from '@/Components/Forms/VButtonIcon';
	// Composables
	import useCartFunctions from '@/Composables/useCartFunctions';

	export default {
		components: {
			BundleProductQuantityChanger,
			VButtonIcon
		},

		props: {
			cartBundle: {
				type: Object,
				requried: true
			}
		},

		setup(props) {
			const showBundleDetails = ref(false);

			const {
				calculateProductTotalPrice,
				incrementBundleCount,
				decrementBundleCount,
				incrementProductCount,
				decrementProductCount,
				removeBundleFromCart
			} = useCartFunctions();

			return {
				calculateProductTotalPrice,
				calculatePrice,
				incrementBundleCount,
				decrementBundleCount,
				incrementProductCount,
				decrementProductCount,
				removeBundleFromCart,
				showBundleDetails
			};
		}
	};
</script>
