<template>
	<app-layout>
		<template v-slot:main>
			<bundle-details :bundle-slug="bundle.slug" />
			<bundles-more-products :title="moreFromCategoryTitle" :bundle="bundle" :params="categoryParams" />
			<bundles-more-products :title="moreRandomBundlesTitle" :bundle="bundle" :params="randomParams" />
		</template>
	</app-layout>
</template>
<script>
	// Components
	import AppLayout from '@/Layouts/AppLayout';
	import BundleDetails from '@/Components/App/Bundle/BundleDetails';
	import BundlesMoreProducts from '@/Components/App/Bundle/BundlesMoreProducts';

	export default {
		components: {
			AppLayout,
			BundleDetails,
			BundlesMoreProducts
		},

		props: {
			bundle: {
				type: Object,
				required: true
			}
		},

		setup(props) {
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
				moreFromCategoryTitle,
				moreRandomBundlesTitle,
				randomParams
			};
		}
	};
</script>
