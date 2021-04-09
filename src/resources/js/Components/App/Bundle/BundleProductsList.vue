<template>
	<table class="mb-5 w-full">
		<thead>
			<tr>
				<th />
				<th class="text-left">Item</th>
				<th class="text-right">Quantity</th>
			</tr>
		</thead>
		<tbody>
			<tr v-for="product in products" :key="product.slug">
				<td class="w-1/12"><input type="checkbox" /></td>
				<td class="w-3/5">{{ product.name }}</td>
				<td class="flex align-baseline justify-end">
					<v-button-icon @btnOnClickEvent="incrementQuantity()">
						<svg
							class="w-5"
							fill="none"
							stroke-linecap="round"
							stroke-linejoin="round"
							stroke-width="2"
							viewBox="0 0 24 24"
							stroke="currentColor"
						>
							<path d="M12 9v3m0 0v3m0-3h3m-3 0H9m12 0a9 9 0 11-18 0 9 9 0 0118 0z"></path>
						</svg>
					</v-button-icon>
					<span class="mx-2">{{ product.pivot.default_quantity }}</span>
					<v-button-icon @btnOnClickEvent="decrementQuantity()">
						<svg
							class="w-5"
							fill="none"
							stroke-linecap="round"
							stroke-linejoin="round"
							stroke-width="2"
							viewBox="0 0 24 24"
							stroke="currentColor"
						>
							<path d="M15 12H9m12 0a9 9 0 11-18 0 9 9 0 0118 0z"></path>
						</svg>
					</v-button-icon>
				</td>
			</tr>
		</tbody>
	</table>
</template>
<script>
	// Components
	import VButtonIcon from '@/Components/Forms/VButtonIcon';
	// Helpers
	import { incrementQuantity, decrementQuantity } from '@/helpers.js';
	export default {
		components: {
			VButtonIcon
		},

		props: {
			products: {
				type: Array,
				required: true
			}
		},

		setup() {
			return {
				incrementQuantity,
				decrementQuantity
			};
		}
	};
</script>
