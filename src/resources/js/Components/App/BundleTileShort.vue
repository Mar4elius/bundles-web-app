<template>
	<div class="mx-5 mb-5 sm:mx-6 sm:mb-6">
		<div class="h-full flex content-between flex-wrap">
			<div>
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
							<td class="w-4/5">{{ product.name }}</td>
							<td class="text-center w-1/5">{{ product.pivot.default_quantity }}</td>
						</tr>
					</tbody>
				</table>
			</div>
			<div>
				<h4>Great for:</h4>
			</div>
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
