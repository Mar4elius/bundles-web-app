<template>
	<div class="p-4 md:p-6 md:flex">
		<div class="w-full sm:w-2/3">
			<h3 class="text-indigo-600">Filter by:</h3>
			<!-- Cateogory -->
			<h4>Category</h4>
			<div class="flex justify-start items-center flex-wrap w-full">
				<v-button-outlined
					id="all"
					:is-rounded="true"
					:is-active="selectedFilters.sections.includes('all')"
					:is-disabled="isAllSelectedForSections"
					size="small"
					:classes="`mr-4 mb-4`"
					@btnOnClickEvent="searchBundles($event, 'sections')"
					>All</v-button-outlined
				>
				<v-button-outlined
					v-for="section in availableFilters.sections"
					:key="section.slug"
					:is-rounded="true"
					:is-active="selectedFilters.sections.includes(section.slug)"
					size="small"
					:classes="`mr-4 mb-4`"
					@btnOnClickEvent="searchBundles($event, 'sections')"
					:id="section.slug"
				>
					{{ section.name }}
				</v-button-outlined>
			</div>

			<!-- Tags -->
			<h4>Tags</h4>
			<div class="flex justify-start items-center flex-wrap w-full">
				<v-button-outlined
					id="all"
					:is-rounded="true"
					:is-active="selectedFilters.tags.includes('all')"
					:is-disabled="isAllSelectedForTags"
					size="small"
					:classes="`mr-4 mb-4`"
					@btnOnClickEvent="searchBundles($event, 'tags')"
					>All</v-button-outlined
				>
				<v-button-outlined
					v-for="tag in availableFilters.tags"
					:key="tag.slug"
					:is-rounded="true"
					:is-active="selectedFilters.tags.includes(tag.slug)"
					size="small"
					:classes="`mr-4 mb-4`"
					@btnOnClickEvent="searchBundles($event, 'tags')"
					:id="tag.slug"
				>
					{{ tag.name }}
				</v-button-outlined>
			</div>
		</div>
		<div class="w-full sm:w-1/3">
			<h3 class="text-indigo-600">Sort by:</h3>
			<div class="flex flex-wrap">
				<div v-for="(sort, index) in availableSorts" :key="sort.group_name" class="flex items-center">
					<h4 class="mr-4 md:mr-6">{{ capitalizeFirstLetter(sort.group_name) }}:</h4>
					<label
						v-for="order in sort.orders"
						:key="sort + order"
						:for="order.id"
						class="hover:text-indigo-600"
						:class="[selectedSorts[index].order === order.value ? 'text-indigo-600' : '']"
					>
						<svg-hero-icon v-if="order.value === 'desc'">
							<input
								type="radio"
								:id="order.id"
								:name="order.name"
								value="desc"
								class="absolute w-0 h-0 opacity-0"
								v-model="selectedSorts[index].order"
							/>
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
									d="M9 11l3-3m0 0l3 3m-3-3v8m0-13a9 9 0 110 18 9 9 0 010-18z"
								/>
							</svg>
						</svg-hero-icon>
						<svg-hero-icon v-else>
							<input
								type="radio"
								:id="order.id"
								:name="order.name"
								value="asc"
								class="absolute w-0 h-0 opacity-0"
								v-model="selectedSorts[index].order"
							/>
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
									d="M15 13l-3 3m0 0l-3-3m3 3V8m0 13a9 9 0 110-18 9 9 0 010 18z"
								/>
							</svg>
						</svg-hero-icon>
					</label>
				</div>
			</div>
		</div>
	</div>
</template>

<script>
	// Vue
	import { computed, onMounted, reactive, readonly, ref } from 'vue';
	import { useStore } from 'vuex';
	// Components
	import VButtonOutlined from '@/Components/Forms/VButtonOutlined';
	import SvgHeroIcon from '@/Components/Support/SvgHeroIcon';
	// Functions
	import { capitalizeFirstLetter } from '@/helpers.js';

	export default {
		components: {
			VButtonOutlined,
			SvgHeroIcon
		},

		setup(props, { emit }) {
			const store = useStore();
			const defaultFilters = {
				sections: ['all'],
				tags: ['all']
			};

			let availableFilters = reactive({ ...defaultFilters });
			let selectedFilters = reactive({ ...defaultFilters });
			let availableSorts = ref([]);
			let selectedSorts = ref([]);

			let isAllSelectedForSections = computed(
				() => selectedFilters.sections.length === 1 && selectedFilters.sections.includes('all')
			);

			let isAllSelectedForTags = computed(
				() => selectedFilters.tags.length === 1 && selectedFilters.tags.includes('all')
			);

			function searchBundles(btnId, filterType) {
				// if all selected remove any selected filters else remove 'all' filter
				selectedFilters[filterType] =
					btnId === 'all'
						? [...defaultFilters[filterType]]
						: selectedFilters[filterType].filter((item) => item !== 'all');
				if (selectedFilters[filterType].includes(btnId) && btnId !== 'all') {
					// remove filter
					selectedFilters[filterType] = selectedFilters[filterType].filter((item) => item !== btnId);
				} else if (btnId !== 'all') {
					// add filter
					selectedFilters[filterType] = [...selectedFilters[filterType], btnId];
				}
				// if all filters have been deselected set All filter back
				if (!selectedFilters[filterType].length) {
					selectedFilters[filterType] = [...defaultFilters[filterType]];
				}

				emit('btnOnClickEvent', readonly(selectedFilters));
			}

			async function getFilterOptions() {
				const { data } = await store.dispatch('bundles/getFilterOptions');
				availableFilters.sections = data.sections;
				availableFilters.tags = data.tags;
				//
			}

			async function getSortOptions() {
				const { data } = await store.dispatch('bundles/getSortOptions');
				availableSorts.value = data.sorts;
				selectedSorts.value = data.sorts.map((sort) => {
					return {
						name: sort.group_name,
						order: null
					};
				});
				console.log(selectedSorts.value);
				console.log(availableSorts);
			}

			onMounted(() => {
				getFilterOptions();
				getSortOptions();
			});

			return {
				availableFilters,
				availableSorts,
				capitalizeFirstLetter,
				isAllSelectedForTags,
				isAllSelectedForSections,
				searchBundles,
				selectedFilters,
				selectedSorts
			};
		}
	};
</script>
