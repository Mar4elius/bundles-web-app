<template>
	<div class="mx-5 mb-5 sm:mx-6 sm:mb-6">
		<div class="h-full flex content-between flex-wrap">
			<div>
				<img :src="bundle.image_path" :alt="bundle.name" />
				<h4>{{ bundle.name }}</h4>
				<table class="mb-5">
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
			<div class="w-full">
				<bundle-tags :tags="bundle.tags" :id="bundle.slug" />

				<bundle-details-buttons :bundle="bundle" />
			</div>
		</div>
	</div>
</template>

<script>
	import BundleDetailsButtons from '@/Components/App/BundleDetailsButtons';
	import BundleTags from '@/Components/App/BundleTags';
	export default {
		components: {
			BundleDetailsButtons,
			BundleTags
		},

		props: {
			bundle: {
				type: Object,
				required: true
			}
		}
	};
</script>
