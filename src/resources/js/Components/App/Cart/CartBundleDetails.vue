<template>
	<div>
		<div class="flex justify-between">
			<div class="w-1/2 flex justify-start">
				<img class="h-20 w-20 rounded mr-5" :src="cartBundle.image_path" :alt="cartBundle.name" />
				<div class="flex flex-col content-between">
					<h6>{{ cartBundle.name }}</h6>
					<bundle-product-quantity-changer
						:product="cartBundle"
						@incrementQuantityBtnClick="incrementBundleCount"
						@decrementQuantityBtnClick="decrementBundleCount"
					/>
				</div>
			</div>
			<div class="w-1/2 flex justify-end align-bottom">
				<v-button-icon @btnOnClickEvent="removeBundleFromCart">
					<svg
						class="w-6 md:w-8 text-red-600"
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
		</div>

		<table class="mb-5 w-full">
			<thead>
				<tr>
					<!-- image -->
					<th />
					<th class="text-left">Item</th>
					<th class="text-center">Quantity</th>
					<th class="text-right">$/Item</th>
					<th class="text-right">$/Items</th>
				</tr>
			</thead>
			<tbody>
				<tr v-for="product in cartBundle.products" :key="product.slug">
					<td class="w-1/12 text-center">
						<img class="h-10 w-10 rounded" :src="cartBundle.image_path" :alt="cartBundle.name" />
					</td>
					<td class="w-5/12">
						{{ product.name }}
					</td>
					<td class="w-1/12 text-center">
						<bundle-product-quantity-changer
							classes="w-5"
							:product="product"
							@incrementQuantityBtnClick="incrementProductCount"
							@decrementQuantityBtnClick="decrementProductCount"
						/>
					</td>
					<td class="w-2/12 text-right">
						{{ calculatePrice(product.price) }}
					</td>
					<td class="w-2/12 text-right">
						{{ calculateItemTotalPrice(product) }}
					</td>
				</tr>
			</tbody>
		</table>
		<div class="flex items-center justify-end">
			<h6 class="mr-5 text-indigo-600">Total Per Bundle:</h6>
			<p class="text-lg font-bold">{{ calculatePrice(cartBundle.price_per_bundle) }}</p>
		</div>
	</div>
</template>

<script>
	// Vue
	import { useStore } from 'vuex';
	import { computed, watch } from '@vue/runtime-core';
	// Components
	import BundleProductQuantityChanger from '@/Components/App/Bundle/BundleProductQuantityChanger';
	import VButtonIcon from '@/Components/Forms/VButtonIcon';
	// Modals
	import InformationModal from '@/Components/Support/InformationModal';
	// Helpers
	import { calculatePrice } from '@/helpers.js';
	// Toast messages
	import { useToast } from 'vue-toastification';

	export default {
		props: {
			cartBundle: {
				type: Object,
				default: null
			}
		},

		components: {
			BundleProductQuantityChanger,
			InformationModal,
			VButtonIcon
		},

		setup(props) {
			const store = useStore();
			const toast = useToast();
			let cartBundles = computed(() => store.state.cart.items);

			function calculateItemTotalPrice(item) {
				const totalPrice = item.pivot.quantity * item.price;
				return calculatePrice(totalPrice);
			}
			// bundle qnt change
			async function incrementBundleCount() {
				const data = {
					cart_bundle_id: props.cartBundle.id,
					increment_qnt: true
				};
				await store.dispatch('cart/updateCartBundle', data);
			}

			async function decrementBundleCount() {
				const data = {
					cart_bundle_id: props.cartBundle.id,
					increment_qnt: false
				};
				if (props.cartBundle.quantity > 1) {
					await store.dispatch('cart/updateCartBundle', data);
				}
			}
			// \\ bundle qnt change

			// bundle product qnt change
			async function incrementProductCount({ id }) {
				const data = {
					cart_bundle_id: props.cartBundle.id,
					cart_bundle_product_id: id,
					increment_qnt: true
				};
				await store.dispatch('cart/updateCartBundleProduct', data);
			}

			async function decrementProductCount({ id }) {
				const data = {
					cart_bundle_id: props.cartBundle.id,
					cart_bundle_product_id: id,
					increment_qnt: false
				};
				await store.dispatch('cart/updateCartBundleProduct', data);
			}
			// \\ bundle product qnt change

			async function removeBundleFromCart() {
				// remove cart bundle from cart
				if (cartBundles.value.length > 1) {
					await store.dispatch('cart/destroyCartBundle', props.cartBundle.id);
				} else {
					// if there is 1 bundle left remove it
					await store.dispatch('cart/destroyCartBundle', props.cartBundle.id);
					// then delete cart
					await store.dispatch('cart/destroy', props.cartBundle.cart_id);
				}
			}

			watch(
				() => props.cartBundle,
				(newValue, oldValue) => {
					if (newValue.products.every((b) => b.pivot.quantity === 0)) {
						toast.warning(
							`All items that are in ${newValue.name} seem to have quantity of 0. Do you want to remove this bundle from your cart?`,
							{ timeout: false, hideProgressBar: true }
						);
					}
				}
			);

			return {
				calculatePrice,
				calculateItemTotalPrice,
				incrementBundleCount,
				incrementProductCount,
				decrementBundleCount,
				decrementProductCount,
				removeBundleFromCart
			};
		}
	};
</script>
