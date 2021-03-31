<template>
	<div class="p-4 md:p-6">
		<h3>Filter by:</h3>
		<!-- Cateogory -->
		<h4 class="text-indigo-600">Category</h4>
		<div class="flex justify-start items-center flex-wrap w-full">
			<v-button-outlined
				id="all"
				:is-rounded="true"
				:is-active="selectedFilters.includes('all')"
				size="small"
				:classes="`mr-4 mb-4`"
				@btnOnClickEvent="searchBundles"
				>All</v-button-outlined
			>
			<v-button-outlined
				v-for="section in availableFilters.sections"
				:key="section.slug"
				:is-rounded="true"
				:is-active="selectedFilters.includes(section.slug)"
				size="small"
				:classes="`mr-4 mb-4`"
				@btnOnClickEvent="searchBundles"
				:id="section.slug"
			>
				{{ section.name }}
			</v-button-outlined>
		</div>

		<!-- Tags -->
		<h4 class="text-indigo-600">Tags</h4>
		<div class="flex justify-start items-center flex-wrap w-full">
			<v-button-outlined
				id="all"
				:is-rounded="true"
				:is-active="selectedFilters.includes('all')"
				size="small"
				:classes="`mr-4 mb-4`"
				@btnOnClickEvent="searchBundles"
				>All</v-button-outlined
			>
			<v-button-outlined
				v-for="tag in availableFilters.tags"
				:key="tag.slug"
				:is-rounded="true"
				:is-active="selectedFilters.includes(tag.slug)"
				size="small"
				:classes="`mr-4 mb-4`"
				@btnOnClickEvent="searchBundles"
				:id="tag.slug"
			>
				{{ tag.name }}
			</v-button-outlined>
		</div>
	</div>
</template>

<script>
	// Vue
	import { onMounted, reactive, ref, toRefs } from 'vue';
	import { useStore } from 'vuex';
	// Components
	import VButtonOutlined from '@/Components/Forms/VButtonOutlined';
	export default {
		components: {
			VButtonOutlined
		},

		setup(props, { emit }) {
			const store = useStore();
			let availableFilters = reactive({
				sections: [],
				tags: []
			});
			let selectedFilters = ref([]);

			async function getFilterOptions() {
				const { data } = await store.dispatch('bundles/getFilterOptions');
				availableFilters.sections = data.sections;
				availableFilters.tags = data.tags;
			}

			function searchBundles(btnId) {
				if (selectedFilters.value.includes(btnId)) {
					selectedFilters.value = selectedFilters.value.filter((item) => !item === btnId);
				} else {
					selectedFilters.value = [...selectedFilters.value, btnId];
				}

				emit('btnOnClickEvent', [...selectedFilters.value]);
			}

			onMounted(getFilterOptions());

			return {
				availableFilters,
				searchBundles,
				selectedFilters
			};
		}
	};
</script>
