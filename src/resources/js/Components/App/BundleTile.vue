<template>
	<!-- Product description -->
	<div class="flex flex-col sm:flex-row-reverse bg-white my-8 rounded-md">
		<div class="m-4 items-center relative" @mouseenter="handleMouseEnterEvent" @mouseleave="handleMouseLeaveEvent">
			<img :src="bundle.image_path" :alt="bundle.name" />
			<div v-show="showBundleDetails" class="bg-black bg-opacity-60 absolute h-full w-full top-0 left-0">
				<h2 class="text-white text-center">Includes:</h2>
				<ul class="m-10 text-white">
					<li><strong>Sun Needs: </strong>Full Sun</li>
					<li><strong>Soil Needs: </strong>Damp</li>
					<li><strong>Zones: </strong>9 - 11</li>
					<li><strong>Height: </strong>2 - 3 feet</li>
					<li><strong>Blooms in: </strong>Mid‑Summer - Mid‑Fall</li>
					<li><strong>Features: </strong>Tolerates heat</li>
				</ul>
			</div>
		</div>
		<div class="m-4 flex flex-col content-between">
			<div class="h-full">
				<h3>{{ bundle.name }}</h3>
				<p class="mb-4 mt">{{ bundle.description }}</p>
			</div>
			<div>
				<v-button>Read more</v-button>
			</div>
		</div>
	</div>
</template>

<script>
	import { ref } from '@vue/reactivity';
	import VButton from '@/Components/Forms/VButton';
	export default {
		components: {
			VButton
		},

		props: {
			bundle: {
				type: Object,
				required: true
			}
		},

		setup() {
			let showBundleDetails = ref(false);
			function handleMouseEnterEvent() {
				showBundleDetails.value = true;
				console.log('hello');
			}

			function handleMouseLeaveEvent() {
				showBundleDetails.value = false;
				console.log('bye');
			}

			return {
				handleMouseEnterEvent,
				handleMouseLeaveEvent,
				showBundleDetails
			};
		}
	};
</script>
