<template>
	<h3 class="text-indigo-600">Filter by:</h3>
	<!-- Cateogory -->

	<h4 class="mr-4">Category</h4>
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

	<h4 class="mr-4">Tags</h4>
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
</template>

<script>
	// Vue
	import { computed, onMounted, reactive, readonly } from 'vue';
	import { useStore } from 'vuex';
	// Components
	import VButtonOutlined from '@/Components/Forms/VButtonOutlined';

	export default {
		components: {
			VButtonOutlined
		},

		setup(props, { emit }) {
			const store = useStore();
			const defaultFilters = {
				sections: ['all'],
				tags: ['all']
			};

			let availableFilters = reactive({ ...defaultFilters });
			let selectedFilters = reactive({ ...defaultFilters });

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
			}

			onMounted(getFilterOptions());

			return {
				availableFilters,
				isAllSelectedForTags,
				isAllSelectedForSections,
				searchBundles,
				selectedFilters
			};
		}
	};
</script>
