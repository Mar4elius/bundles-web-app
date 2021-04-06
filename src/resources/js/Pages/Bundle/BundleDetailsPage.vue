<template>
	<app-layout>
		<template v-slot:main>
			<!-- TODO: Create crumbersum menu -->
			<div class="w-full text-gray-700 text-2xl font-semibold">Bundles->{{ bundle.name }}</div>
			<bundle-details :bundle-slug="bundle.slug" />
			<bundles-more-products />
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
		}
	};
</script>
