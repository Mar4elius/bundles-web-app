<template>
	<table class="mb-5 w-full">
		<thead>
			<tr>
				<th class="text-left">Items</th>
				<th class="text-right">Quantity</th>
			</tr>
		</thead>
		<tbody>
			<tr v-for="product in products" :key="product.slug">
				<td class="w-4/5">{{ product.name }}</td>
				<td class="text-center w-1/5">{{ product.pivot.default_quantity }}</td>
			</tr>
		</tbody>
	</table>
</template>
<script>
	export default {
		props: {
			products: {
				type: Array,
				required: true
			}
		}
	};
</script>
