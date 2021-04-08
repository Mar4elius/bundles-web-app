<template>
	<app-layout>
		<template v-slot:main>
			<whole-page-loading-animation v-if="isLoading" />
			<bundle-show :bundle-slug="bundle.slug" />
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
	import BundleShow from '@/Components/App/Bundle/BundleShow';
	import BundlesMoreProducts from '@/Components/App/Bundle/BundlesMoreProducts';
	import WholePageLoadingAnimation from '@/Components/Support/WholePageLoadingAnimation';

	export default {
		components: {
			AppLayout,
			BundleShow,
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
				quantity: '8',
				order: '',
				sort_by: '',
				bundle: {
					section_id: '',
					bundle_id: props.bundle.id
				}
			};

			const categoryParams = {
				quantity: '8',
				order: '',
				sort_by: '',
				bundle: {
					section_id: props.bundle.section_id,
					bundle_id: props.bundle.id
				}
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
