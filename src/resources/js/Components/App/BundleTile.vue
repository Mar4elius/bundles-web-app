<template>
	<!-- Product description -->
	<div class="flex flex-col sm:flex-row-reverse bg-white my-8 rounded-md">
		<div class="m-4 flex items-center">
			<img :src="bundle.image_path" :alt="bundle.name" @mouseenter="showBundleDetails" />
			<div class="hidden">
				<!-- Display bundle product -->
				<ul>
					<li>Includes</li>
				</ul>
			</div>
		</div>
		<div class="m-4 flex flex-col content-between">
			<div class="h-full">
				<h3>{{ bundle.name }}</h3>
				<p class="mb-4 mt">{{ bundle.description }}</p>
			</div>
			<v-button>Read more</v-button>
		</div>
	</div>
</template>

<script>
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
			function showBundleDetails() {}

			return {
				showBundleDetails
			};
		}
	};
</script>
