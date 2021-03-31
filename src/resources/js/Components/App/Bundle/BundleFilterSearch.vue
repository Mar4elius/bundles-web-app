<template>
	<h3>Filter by:</h3>
	<div class="flex justify-start items-center flex-wrap w-full">
		<v-button-outlined
			id="all"
			:is-rounded="true"
			:is-active="filters.includes('all')"
			size="small"
			:classes="`mr-4 mt-8`"
			@btnOnClickEvent="searchBundles"
			>All</v-button-outlined
		>
		<v-button-outlined
			:is-rounded="true"
			:is-active="filters.includes(section.slug)"
			size="small"
			:classes="`mr-4 mt-8`"
			v-for="section in sections"
			:key="section.slug"
			@btnOnClickEvent="searchBundles"
			:id="section.slug"
		>
			{{ section.name }}
		</v-button-outlined>
	</div>
</template>

<script>
	// Vue
	import { ref } from 'vue';
	// Components
	import VButtonOutlined from '@/Components/Forms/VButtonOutlined';
	export default {
		components: {
			VButtonOutlined
		},

		setup(props, { emit }) {
			let filters = ref([]);

			function searchBundles(btnId) {
				if (filters.value.includes(btnId)) {
					filters.value = filters.value.filter((item) => !item === btnId);
				} else {
					filters.value = [...filters.value, btnId];
				}

				emit('btnOnClickEvent', [...filters.value]);
			}

			return {
				filters,
				searchBundles
			};
		}
	};
</script>
