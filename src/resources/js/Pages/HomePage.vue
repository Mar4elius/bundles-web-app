<template>
	<app-layout>
		<template v-slot:header>
			<hero-banner />
		</template>

		<template v-slot:main>
			<div class="max-w-7xl mx-auto sm:px-6 lg:px-8 my-8">
				<div class="w-full flex justify-center">
					<h1 class="my-4">Our most popular bundles:</h1>
				</div>
				<bundle-tile v-for="bundle in bundles" :key="bundle.id" :bundle="bundle" />
			</div>
		</template>
	</app-layout>
</template>

<script>
	import HeroBanner from '@/Pages/HeroBanner';
	import AppLayout from '@/Layouts/AppLayout';
	import BundleTile from '@/Components/App/BundleTile';

	export default {
		components: {
			AppLayout,
			BundleTile,
			HeroBanner
		},

		props: {
			bundles: {
				type: Array,
				required: true
			}
		},

		created() {}
	};
</script>
