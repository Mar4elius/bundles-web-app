<template>
	<table class="mb-5 w-full">
		<thead>
			<tr>
				<th class="text-left">Item</th>
				<th class="text-left">$/Item</th>
				<th class="text-right">Quantity</th>
			</tr>
		</thead>
		<tbody>
			<tr v-for="product in products" :key="product.slug">
				<td class="w-8/12">
					{{ product.name }}
				</td>
				<td class="w-3/12">
					{{ calculatePrice(product.price) }}
				</td>
				<td class="flex align-baseline justify-end">
					<bundle-product-quantity-changer
						classes="w-5"
						:product="product"
						@incrementQuantityBtnClick="incrementProductCount"
						@decrementQuantityBtnClick="decrementProductCount"
					/>
				</td>
			</tr>
		</tbody>
	</table>
</template>
<script>
	// Components
	import BundleProductQuantityChanger from '@/Components/App/Bundle/BundleProductQuantityChanger';
	import VButtonIcon from '@/Components/Forms/VButtonIcon';
	// Helpers
	import { calculatePrice } from '@/helpers.js';

	export default {
		components: {
			BundleProductQuantityChanger,
			VButtonIcon
		},

		props: {
			products: {
				type: Array,
				required: true
			}
		},

		setup(props, { emit }) {
			function incrementProductCount({ id }) {
				emit('incrementQuantityBtnClick', {
					id: id,
					quantity: 1
				});
			}

			function decrementProductCount({ id }) {
				emit('decrementQuantityBtnClick', {
					id: id,
					quantity: 1
				});
			}

			return {
				calculatePrice,
				decrementProductCount,
				incrementProductCount
			};
		}
	};
</script>
