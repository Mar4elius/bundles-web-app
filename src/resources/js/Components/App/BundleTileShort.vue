<template>
	<div class="mx-5 mb-5 sm:mx-6 sm:mb-6">
		<div class="h-full flex content-between flex-wrap">
			<img :src="bundle.image_path" :alt="bundle.name" />
			<h4>{{ bundle.name }}</h4>
			<table class="w-full mb-5">
				<thead>
					<tr>
						<th class="text-left">Items</th>
						<th class="text-right">Quantity</th>
					</tr>
				</thead>
				<tbody>
					<tr v-for="product in bundle.products" :key="product.slug">
						<td>{{ product.name }}</td>
						<td class="text-center">{{ product.pivot.default_quantity }}</td>
					</tr>
				</tbody>
			</table>
			<bundle-details-buttons :bundle="bundle" />
		</div>
	</div>
</template>

<script>
	import BundleDetailsButtons from '@/Components/App/BundleDetailsButtons';
	export default {
		components: {
			BundleDetailsButtons
		},

		props: {
			bundle: {
				type: Object,
				required: true
			}
		}
	};
</script>
