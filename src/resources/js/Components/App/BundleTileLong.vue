<template>
	<!-- Product description -->
	<div class="flex flex-col sm:flex-row-reverse bg-white my-8 rounded-md">
		<div class="m-4 items-center relative" @mouseenter="handleMouseEnterEvent" @mouseleave="handleMouseLeaveEvent">
			<img :src="bundle.image_path" :alt="bundle.name" />
			<div v-show="showBundleDetails" class="bg-black bg-opacity-60 absolute h-full w-full top-0 left-0">
				<h2 class="text-white text-center">Includes:</h2>
				<ul class="mx-10 text-white list-disc">
					<li v-for="product in bundle.products" :key="product.id" class="flex justify-between">
						<strong>{{ product.name }}</strong> Quantity: {{ product.pivot.default_quantity }}
					</li>
				</ul>
			</div>
		</div>
		<div class="m-4 flex flex-col content-between">
			<div class="h-full">
				<h3>{{ bundle.name }}</h3>
				<p class="mb-4">{{ bundle.description }}</p>
			</div>

			<bundle-details-buttons :bundle="bundle" />
		</div>
	</div>
</template>

<script>
	// FIXME: https://codepen.io/linux/pen/LjWrPZ come back to that later to make better styles
	// Vue
	import { ref, computed } from '@vue/reactivity';
	// Components
	import VButton from '@/Components/Forms/VButton';
	import BundleDetailsButtons from '@/Components/App/BundleDetailsButtons';
	import FontAwesomeIcon from '@/Components/Support/FontAwesomeIcon.vue';

	export default {
		components: {
			BundleDetailsButtons,
			VButton,
			FontAwesomeIcon
		},

		props: {
			bundle: {
				type: Object,
				required: true
			}
		},

		setup(props) {
			let showBundleDetails = ref(false);

			function handleMouseEnterEvent() {
				showBundleDetails.value = true;
			}

			function handleMouseLeaveEvent() {
				showBundleDetails.value = false;
			}

			function addItemToCart() {
				console.log('addItemtocart');
			}

			function goToBundleDetails() {
				console.log('gotobundledetails');
			}

			return {
				addItemToCart,
				handleMouseEnterEvent,
				handleMouseLeaveEvent,
				goToBundleDetails,
				showBundleDetails
			};
		}
	};
</script>
