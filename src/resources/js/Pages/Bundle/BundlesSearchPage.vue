<template>
	<app-layout>
		<template v-slot:main>
			<whole-page-loading-animation v-if="isLoading" />
			<template v-else>
				<h1>Bundles</h1>
				<p class="mb-4 md:mb-6">
					Our Bundles are limited-time collections of games, books, software, and more. Simply pay what you
					want and choose where your money goes, including to charity. Most Bundles come in tiers starting at
					only $1 - the more you give, the more you get!
				</p>

				<div class="bg-white rounded-md">
					<div class="p-4 md:p-6 md:flex">
						<div class="w-full md:w-2/3">
							<bundle-filter @btnOnClickEvent="filterBundles" />
						</div>
						<div class="w-full md:w-1/3">
							<bundle-sort @radioBtnOnClickEvent="sortBundles" />
						</div>
					</div>
				</div>
				<!-- Do not show anything if there no sections-->
				<div class="bg-white rounded-md" v-if="sectionBundles.length">
					<div v-for="section in sectionBundles" :key="section.id" class="my-8">
						<template v-if="section.bundles.length">
							<h3 class="p-4 md:p-6 text-indigo-600">{{ section.name }}</h3>
							<!-- Show if section has any bundles -->
							<div class="grid grid-cols-1 md:grid-cols-3 md:gap-4" v-if="section.bundles.length">
								<bundle-tile-short
									v-for="bundle in section.bundles"
									:bundle="bundle"
									:key="bundle.slug"
								/>
							</div>
							<!-- slot component -->
							<message-component v-else>
								<div class="w-6">
									<svg
										class="text-yellow-500"
										xmlns="http://www.w3.org/2000/svg"
										fill="none"
										viewBox="0 0 24 24"
										stroke="currentColor"
									>
										<path
											stroke-linecap="round"
											stroke-linejoin="round"
											stroke-width="2"
											d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"
										/>
									</svg>
								</div>
								<p class="m-auto text-center">Does not look that we have anything for this category.</p>
							</message-component>
						</template>
					</div>
				</div>
				<message-component v-else>
					<div class="flex justify-center items-center">
						<div class="w-6 mr-2 md:w-8 md:mr-4">
							<svg
								xmlns="http://www.w3.org/2000/svg"
								fill="none"
								viewBox="0 0 24 24"
								stroke="currentColor"
							>
								<path
									class="text-yellow-500"
									stroke-linecap="round"
									stroke-linejoin="round"
									stroke-width="2"
									d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"
								/>
							</svg>
						</div>
						<p>Does not look that we have anything for this request.</p>
					</div>
				</message-component>
			</template>
		</template>
	</app-layout>
</template>

<script>
	// vue
	import { useStore } from 'vuex';
	import { reactive, ref, onMounted, computed } from '@vue/runtime-core';
	// Components
	import AppLayout from '@/Layouts/AppLayout';
	import BundleTileShort from '@/Components/App/Bundle/BundleTileShort';
	import BundleFilter from '@/Components/App/Bundle/BundleFilter';
	import BundleSort from '@/Components/App/Bundle/BundleSort';
	import MessageComponent from '@/Components/Support/MessageComponent';
	import WholePageLoadingAnimation from '@/Components/Support/WholePageLoadingAnimation';

	export default {
		components: {
			AppLayout,
			BundleFilter,
			BundleSort,
			BundleTileShort,
			WholePageLoadingAnimation,
			MessageComponent
		},

		props: {
			sections: {
				type: Array,
				require: true
			}
		},

		setup() {
			const store = useStore();
			const defaultFilters = {
				sections: ['all'],
				tags: ['all']
			};

			let sectionBundles = ref([]); // gets data from emit event from child component
			let selectedFilters = reactive({ ...defaultFilters });
			let selectedSorts = ref([]); // gets data from emit event from child component
			let isLoading = computed(() => store.state.loader.loading);

			async function searchBundles(payload = null) {
				const { data } = await store.dispatch('bundles/searchBundles', payload);
				sectionBundles.value = [...data.bundles];
			}

			function filterBundles(payload) {
				// build payload that inlcudes filter and sort options
				selectedFilters = { ...payload };

				const data = {
					...selectedFilters,
					sort_by: selectedSorts.value
				};

				searchBundles(data);
			}

			function sortBundles(payload = null) {
				// build payload that inlcudes filter and sort options
				const data = {
					...selectedFilters,
					sort_by: payload ? (selectedSorts.value = [...payload]) : []
				};

				searchBundles(data);
			}

			onMounted(searchBundles());

			return {
				filterBundles,
				isLoading,
				searchBundles,
				sectionBundles,
				sortBundles
			};
		}
	};
</script>
