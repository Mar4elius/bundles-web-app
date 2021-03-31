<template>
	<app-layout>
		<template v-slot:main>
			<h1>Bundles</h1>
			<p>
				Our Bundles are limited-time collections of games, books, software, and more. Simply pay what you want
				and choose where your money goes, including to charity. Most Bundles come in tiers starting at only $1 -
				the more you give, the more you get!
			</p>

			<div class="bg-white rounded-md">
				<bundle-filter-search @btnOnClickEvent="searchBundles" />
			</div>
			<div class="bg-white rounded-md">
				<div v-for="section in sectionBundles" :key="section.id" class="my-8">
					<h3 class="p-4 md:p-6">{{ section.name }}</h3>
					<div class="grid grid-cols-1 md:grid-cols-3 md:gap-4">
						<bundle-tile-short v-for="bundle in section.bundles" :bundle="bundle" :key="bundle.slug" />
					</div>
				</div>
			</div>
		</template>
	</app-layout>
</template>

<script>
	// vue
	import { useStore } from 'vuex';
	import { ref, onMounted } from '@vue/runtime-core';
	// Components
	import AppLayout from '@/Layouts/AppLayout';
	import BundleTileShort from '@/Components/App/Bundle/BundleTileShort';
	import BundleFilterSearch from '@/Components/App/Bundle/BundleFilterSearch';

	export default {
		components: {
			AppLayout,
			BundleFilterSearch,
			BundleTileShort
		},

		props: {
			sections: {
				type: Array,
				require: true
			}
		},

		setup() {
			const store = useStore();
			let sectionBundles = ref([]);

			async function searchBundles(params) {
				console.log(params);
				const { data } = await store.dispatch('bundles/searchBundles', params);
				sectionBundles.value = [...data.bundles];
			}

			onMounted(searchBundles(['all']));

			return {
				searchBundles,
				sectionBundles
			};
		}
	};
</script>
