<template>
	<!-- Product description -->
	<div class="flex flex-col sm:flex-row-reverse bg-white my-8 rounded-md">
		<div class="m-4 relative" @mouseenter="handleMouseEnterEvent" @mouseleave="handleMouseLeaveEvent">
			<img class="rounded-md lg:max-w-xl" :src="bundle.image_path" :alt="bundle.name" />
			<div v-show="showHoverText" class="bg-black bg-opacity-60 absolute h-full rounded-md w-full top-0 left-0">
				<h2 class="text-white text-center">Includes:</h2>
				<div class="text-white px-4 md:px-6">
					<bundle-products-list :products="bundle.products" />
				</div>
			</div>
		</div>
		<div class="m-4 flex flex-col content-between">
			<div class="h-full">
				<h3>{{ bundle.name }}</h3>
				<p class="text-gray-600 mb-3">
					Starts from <span class="font-bold">{{ calculatePrice(bundle.price) }}</span>
				</p>
				<p class="mb-4">{{ bundle.description }}</p>
			</div>

			<div class="w-full flex items-center">
				<div class="w-3/5">
					<bundle-tags :tags="bundle.tags" :id="bundle.slug" />
				</div>
				<div class="w-2/5 float-right">
					<bundle-details-buttons :bundle="bundle" />
				</div>
			</div>
		</div>
	</div>
</template>

<script>
	// FIXME: https://codepen.io/linux/pen/LjWrPZ come back to that later to make better styles
	// Components
	import BundleDetailsButtons from '@/Components/App/Bundle/BundleDetailsButtons';
	import BundleProductsList from '@/Components/App/Bundle/BundleProductsList';
	import BundleTags from '@/Components/App/Bundle/BundleTags';
	import FontAwesomeIcon from '@/Components/Support/FontAwesomeIcon.vue';
	// Functions
	import { useShowTextOnHover } from '@/Composables/useShowTextOnHover';
	// Helpers
	import { calculatePrice } from '@/helpers';

	export default {
		components: {
			BundleDetailsButtons,
			BundleProductsList,
			BundleTags,
			FontAwesomeIcon
		},

		props: {
			bundle: {
				type: Object,
				required: true
			}
		},

		setup(props) {
			const { showHoverText, handleMouseEnterEvent, handleMouseLeaveEvent } = useShowTextOnHover();

			function addItemToCart() {
				console.log('addItemtocart');
			}

			function goToBundleDetails() {
				console.log('gotobundledetails');
			}

			return {
				addItemToCart,
				calculatePrice,
				handleMouseEnterEvent,
				handleMouseLeaveEvent,
				goToBundleDetails,
				showHoverText
			};
		}
	};
</script>
