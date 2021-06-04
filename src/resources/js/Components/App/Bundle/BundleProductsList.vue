<template>
	<table class="mb-5 w-full">
		<thead>
			<tr>
				<th v-if="isEditable" />
				<th class="text-left">Item</th>
				<th class="text-left">$/Item</th>
				<th class="text-right">Quantity</th>
			</tr>
		</thead>
		<tbody>
			<tr v-for="product in products" :key="product.slug">
				<td class="w-1/12" v-if="isEditable">
					<v-checkbox :is-checked="product.is_active" @update:checked="product.is_active = $event" />
				</td>
				<td class="w-5/12" :class="[product.is_active ? '' : 'bg-gray-300']">
					{{ product.name }}
				</td>
				<td class="w-3/12">
					{{ calculatePrice(product.price) }}
				</td>
				<td class="flex align-baseline justify-end" :class="[product.is_active ? '' : 'bg-gray-300']">
					<bundle-product-quantity-changer
						classes="w-5"
						:product="product"
						@incrementQuantityBtnClick="incrementProductCount"
						@decrementQuantityBtnClick="decrementProductCount"
						:disabled="isEditable"
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
	import VCheckbox from '@/Components/Forms/VCheckbox';
	// Helpers
	import { calculatePrice } from '@/helpers.js';

	export default {
		components: {
			BundleProductQuantityChanger,
			VButtonIcon,
			VCheckbox
		},

		props: {
			products: {
				type: Array,
				required: true
			},

			isEditable: {
				type: Boolean,
				default: false
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
