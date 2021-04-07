<template>
	<app-layout>
		<template v-slot:header>
			<hero-banner />
		</template>

		<template v-slot:main>
			<div class="w-full flex justify-start sm:justify-center">
				<h1>Our most popular bundles:</h1>
			</div>
			<whole-page-loading-animation v-if="isLoading" />
			<bundle-tile-long v-else v-for="bundle in bundlesByPopularity" :key="bundle.id" :bundle="bundle" />
		</template>
	</app-layout>
</template>

<script>
	// Vue
	import { useStore } from 'vuex';
	import { computed, onMounted, ref } from 'vue';
	// Components
	import HeroBanner from '@/Pages/HeroBanner';
	import AppLayout from '@/Layouts/AppLayout';
	import BundleTileLong from '@/Components/App/Bundle/BundleTileLong';
	import WholePageLoadingAnimation from '@/Components/Support/WholePageLoadingAnimation';

	export default {
		components: {
			AppLayout,
			BundleTileLong,
			HeroBanner,
			WholePageLoadingAnimation
		},

		setup() {
			const store = useStore();
			let bundlesByPopularity = ref([]);
			const params = {
				quantity: 10,
				order: 'desc',
				sort_by: 'popularity',
				category: '',
				section_id: ''
			};
			const isLoading = computed(() => store.state.loader.loading);

			async function getAdditionalBundles(params) {
				const { data } = await store.dispatch('bundles/getAdditionalBundles', params);
				bundlesByPopularity.value = [...data.bundles];
			}

			onMounted(getAdditionalBundles(params));

			return {
				bundlesByPopularity,
				isLoading
			};
		}
	};
</script>
