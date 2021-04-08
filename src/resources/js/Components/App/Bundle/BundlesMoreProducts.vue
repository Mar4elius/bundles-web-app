<template>
	<div class="my-6 p-4 md:my-8 md:p-6 bg-white rounded-md">
		<h3 class="text-indigo-600">{{ title }}</h3>
		<div class="grid gap-6 grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 mt-6">
			<div v-for="bundle in bundles" :key="bundle.id">
				<bundle-tile-simple :bundle="bundle" />
			</div>
		</div>
	</div>
</template>

<script>
	// Vue
	import { onMounted, ref } from '@vue/runtime-core';
	import { useStore } from 'vuex';
	// Components
	import BundleTileSimple from '@/Components/App/Bundle/BundleTileSimple';

	export default {
		components: {
			BundleTileSimple
		},

		props: {
			bundle: {
				type: Object,
				required: true
			},

			title: {
				type: String,
				required: true
			},

			params: {
				type: Object,
				required: true
			}
		},

		setup(props) {
			const store = useStore();

			const bundles = ref([]);

			async function getAdditionalBundles(params) {
				const { data } = await store.dispatch('bundles/getAdditionalBundles', params);
				bundles.value = [...data.bundles];
			}

			onMounted(getAdditionalBundles(props.params));

			return {
				bundles
			};
		}
	};
</script>
