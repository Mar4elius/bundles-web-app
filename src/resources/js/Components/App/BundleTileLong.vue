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
			<div class="flex justify-between items-center">
				<v-button>Read more</v-button>
				<v-button @mouseleave="showButtonPrice">
					<div v-show="showPrice" class="flex" @mouseenter="showButtonText">
						<span class="mr-1"
							><strong>${{ bundlePrice }}</strong></span
						>
						|
						<div class="w-8 ml-1">
							<svg
								xmlns="http://www.w3.org/2000/svg"
								fill="none"
								viewBox="0 0 24 24"
								stroke="currentColor"
							>
								<path
									stroke-linecap="round"
									stroke-linejoin="round"
									stroke-width="2"
									d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"
								/>
							</svg>
						</div>
					</div>
					<div v-show="!showPrice">Add To Cart</div>
				</v-button>
			</div>
		</div>
	</div>
</template>

<script>
	// FIXME: https://codepen.io/linux/pen/LjWrPZ come back to that later to make better styles
	import { ref, computed } from '@vue/reactivity';
	import VButton from '@/Components/Forms/VButton';
	import FontAwesomeIcon from '@/Components/Support/FontAwesomeIcon.vue';
	export default {
		components: {
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
			let showPrice = ref(true);

			const bundlePrice = computed(() => props.bundle.price / 100);

			function handleMouseEnterEvent() {
				showBundleDetails.value = true;
			}

			function handleMouseLeaveEvent() {
				showBundleDetails.value = false;
			}

			function showButtonText() {
				showPrice.value = false;
			}

			function showButtonPrice() {
				showPrice.value = true;
			}

			function addItemToCart() {
				console.log('addItemtocart');
			}

			function goToBundleDetails() {
				console.log('gotobundledetails');
			}

			return {
				addItemToCart,
				bundlePrice,
				handleMouseEnterEvent,
				handleMouseLeaveEvent,
				goToBundleDetails,
				showBundleDetails,
				showButtonPrice,
				showButtonText,
				showPrice
			};
		}
	};
</script>
