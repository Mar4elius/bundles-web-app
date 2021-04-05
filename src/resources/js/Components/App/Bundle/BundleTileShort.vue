<template>
	<div class="mx-5 mb-5 sm:mx-6 sm:mb-6">
		<div class="h-full flex content-between flex-wrap">
			<div @mouseenter="handleMouseEnterEvent" @mouseleave="handleMouseLeaveEvent">
				<div class="relative">
					<img :src="bundle.image_path" :alt="bundle.name" />
					<div v-show="showHoverText" class="bg-black bg-opacity-60 absolute h-full w-full top-0 left-0">
						<h4 class="text-white text-center">Description</h4>
						<p class="text-white text-center">{{ bundle.description }}</p>
					</div>
				</div>
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
	// Components
	import BundleDetailsButtons from '@/Components/App/Bundle/BundleDetailsButtons';
	import BundleTags from '@/Components/App/Bundle/BundleTags';
	// Functions
	import { useShowTextOnHover } from '@/Composables/useShowTextOnHover';
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
		},

		setup() {
			const { showHoverText, handleMouseEnterEvent, handleMouseLeaveEvent } = useShowTextOnHover();

			return {
				showHoverText,
				handleMouseEnterEvent,
				handleMouseLeaveEvent
			};
		}
	};
</script>
