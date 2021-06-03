<template>
	<div>
		<template v-if="cartBundle">
			<div class="flex justify-center">
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

			<table class="mb-5 w-full">
				<thead>
					<tr>
						<!-- checkbox -->
						<th />
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
						<td class="w-1/12">
							<v-checkbox :is-checked="product.is_active" @update:checked="product.is_active = $event" />
						</td>
						<td class="w-1/12 text-center">
							<img class="h-10 w-10 rounded" :src="cartBundle.image_path" :alt="cartBundle.name" />
						</td>
						<td class="w-5/12" :class="[product.is_active ? '' : 'bg-gray-300']">
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
		</template>
		<template v-else>
			<p class="text-small text-gray-600 text-center">You cart is empty at the moment.</p>
		</template>
	</div>
</template>

<script>
	// Components
	import BundleProductQuantityChanger from '@/Components/App/Bundle/BundleProductQuantityChanger';
	import VCheckbox from '@/Components/Forms/VCheckbox';
	// Helpers
	import { calculatePrice } from '@/helpers.js';
	import { useStore } from 'vuex';

	export default {
		props: {
			cartBundle: {
				type: Object,
				default: null
			}
		},

		components: {
			BundleProductQuantityChanger,
			VCheckbox
		},

		setup(props) {
			const store = useStore();

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

			return {
				calculatePrice,
				calculateItemTotalPrice,
				incrementBundleCount,
				incrementProductCount,
				decrementBundleCount,
				decrementProductCount
			};
		}
	};
</script>
