<template>
	<div class="mx-5 mb-5 sm:mx-6 sm:mb-6">
		<div class="h-full flex content-between flex-wrap">
			<div @mouseenter="handleMouseEnterEvent" @mouseleave="handleMouseLeaveEvent">
				<div class="relative">
					<img class="rounded-md" :src="bundle.image_path" :alt="bundle.name" />
					<div
						v-show="showHoverText"
						class="bg-black bg-opacity-60 absolute rounded-md h-full w-full top-0 left-0"
					>
						<h4 class="text-white text-center">Description</h4>
						<p class="text-white mx-4">{{ bundle.description }}</p>
					</div>
				</div>
				<h4>{{ bundle.name }}</h4>
				<p class="text-gray-600 mb-3">
					Starts from <span class="font-bold">{{ calculatePrice(bundle.price) }}</span>
				</p>

				<bundle-products-list :products="bundle.products" />
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
	import BundleProductsList from '@/Components/App/Bundle/BundleProductsList';
	import BundleTags from '@/Components/App/Bundle/BundleTags';
	// Functions
	import { useShowTextOnHover } from '@/Composables/useShowTextOnHover';
	// Helpers
	import { calculatePrice } from '@/helpers';

	export default {
		components: {
			BundleDetailsButtons,
			BundleProductsList,
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
				calculatePrice,
				showHoverText,
				handleMouseEnterEvent,
				handleMouseLeaveEvent
			};
		}
	};
</script>
