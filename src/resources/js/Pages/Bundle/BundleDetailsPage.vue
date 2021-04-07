<template>
	<app-layout>
		<template v-slot:main>
			<whole-page-loading-animation v-if="isLoading" />
			<bundle-details :bundle-slug="bundle.slug" />
			<bundles-more-products :title="moreFromCategoryTitle" :bundle="bundle" :params="categoryParams" />
			<bundles-more-products :title="moreRandomBundlesTitle" :bundle="bundle" :params="randomParams" />
		</template>
	</app-layout>
</template>
<script>
	// Vue
	import { computed } from 'vue';
	import { useStore } from 'vuex';
	// Components
	import AppLayout from '@/Layouts/AppLayout';
	import BundleDetails from '@/Components/App/Bundle/BundleDetails';
	import BundlesMoreProducts from '@/Components/App/Bundle/BundlesMoreProducts';
	import WholePageLoadingAnimation from '@/Components/Support/WholePageLoadingAnimation';

	export default {
		components: {
			AppLayout,
			BundleDetails,
			BundlesMoreProducts,
			WholePageLoadingAnimation
		},

		props: {
			bundle: {
				type: Object,
				required: true
			}
		},

		setup(props) {
			const store = useStore();
			const isLoading = computed(() => store.state.loader.loading);
			const randomParams = {
				quantity: '6',
				order: '',
				sort_by: '',
				section_id: ''
			};

			const categoryParams = {
				quantity: '6',
				order: '',
				sort_by: '',
				section_id: props.bundle.section_id
			};

			const moreFromCategoryTitle = `More bundles from ${props.bundle.section?.name} category`;
			const moreRandomBundlesTitle = `More bundles`;

			return {
				categoryParams,
				isLoading,
				moreFromCategoryTitle,
				moreRandomBundlesTitle,
				randomParams
			};
		}
	};
</script>
