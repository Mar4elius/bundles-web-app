<template>
	<div class="flex justify-between items-end w-full">
		<v-button-filled id="read-more" size="regular" @btnOnClickEvent="goToBundleDetails">Read more</v-button-filled>
		<v-button-filled @mouseleave="showButtonPrice" classes="w-44 ml-5" id="add-to-cart">
			<div v-show="showPrice" class="flex justify-center" @mouseenter="showButtonText">
				<span class="mr-1"
					><strong>${{ bundlePrice }}</strong></span
				>
				|
				<div class="w-6 ml-1">
					<svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
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
		</v-button-filled>
	</div>
</template>

<script>
	// Vue
	import { ref, computed } from 'vue';
	// Components
	import VButtonFilled from '@/Components/Forms/VButtonFilled';
	export default {
		components: {
			VButtonFilled
		},

		props: {
			bundle: {
				type: Object,
				required: true
			}
		},

		setup(props) {
			let showPrice = ref(true);
			const bundlePrice = computed(() => props.bundle.price / 100);

			function showButtonText() {
				showPrice.value = false;
			}

			function showButtonPrice() {
				showPrice.value = true;
			}

			function goToBundleDetails() {
				window.location.href = route('bundles.show', props.bundle.slug);
			}

			return {
				bundlePrice,
				goToBundleDetails,
				showButtonPrice,
				showButtonText,
				showPrice
			};
		}
	};
</script>
