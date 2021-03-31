<template>
	<app-layout>
		<template v-slot:header>
			<hero-banner />
		</template>

		<template v-slot:main>
			<div class="w-full flex justify-start sm:justify-center">
				<h1>Our most popular bundles:</h1>
			</div>
			<bundle-tile-long v-for="bundle in bundlesByPopularity" :key="bundle.id" :bundle="bundle" />
		</template>
	</app-layout>
</template>

<script>
	// Vue
	import { useStore } from 'vuex';
	import { onMounted, ref } from 'vue';
	// Components
	import HeroBanner from '@/Pages/HeroBanner';
	import AppLayout from '@/Layouts/AppLayout';
	import BundleTileLong from '@/Components/App/Bundle/BundleTileLong';

	export default {
		components: {
			AppLayout,
			BundleTileLong,
			HeroBanner
		},

		setup() {
			const store = useStore();
			let bundlesByPopularity = ref([]);

			async function sortBundles(sortBy) {
				const { data } = await store.dispatch('bundles/sortBundles', sortBy);
				bundlesByPopularity.value = [...data.bundles];
			}

			onMounted(sortBundles('popularity'));

			return {
				sortBundles,
				bundlesByPopularity
			};
		}
	};
</script>
