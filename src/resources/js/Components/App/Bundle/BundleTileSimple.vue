<template>
	<div class="w-full max-w-sm mx-auto rounded-md shadow-md overflow-hidden">
		<div class="flex items-end justify-end h-56 w-full bg-cover">
			<img class="w-full object-cover rounded-md" :src="bundle.image_path" :alt="bundle.name" />
		</div>
		<div class="px-5 py-3">
			<h6 class="text-gray-700 uppercase text-sm">{{ bundle.name }}</h6>
			<span class="text-gray-500 mt-3">{{ calculatePrice(bundle.price) }}</span>
			<div class="flex justify-center mt-3">
				<v-button-filled id="read-more" @btnOnClickEvent="goToBundleDetails">
					<svg-hero-icon>
						<svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
							<path
								stroke-linecap="round"
								stroke-linejoin="round"
								stroke-width="2"
								d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"
							/>
						</svg>
					</svg-hero-icon>
				</v-button-filled>
			</div>
		</div>
	</div>
</template>

<script>
	// Components
	import VButtonFilled from '@/Components/Forms/VButtonFilled';
	import SvgHeroIcon from '@/Components/Support/SvgHeroIcon';
	// Helpers
	import { calculatePrice } from '@/helpers.js';
	export default {
		components: {
			VButtonFilled,
			SvgHeroIcon
		},

		props: {
			bundle: {
				type: Object,
				required: true
			}
		},

		setup(props) {
			function goToBundleDetails() {
				window.location.href = route('bundles.show', props.bundle.slug);
			}

			return {
				calculatePrice,
				goToBundleDetails
			};
		}
	};
</script>
