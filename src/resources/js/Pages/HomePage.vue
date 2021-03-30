<template>
	<app-layout>
		<template v-slot:header>
			<hero-banner />
		</template>

		<template v-slot:main>
			<div class="w-full flex justify-start sm:justify-center">
				<h1>Our most popular bundles:</h1>
			</div>
			<bundle-tile-long v-for="bundle in bundles" :key="bundle.id" :bundle="bundle" />
		</template>
	</app-layout>
</template>

<script>
	import HeroBanner from '@/Pages/HeroBanner';
	import AppLayout from '@/Layouts/AppLayout';
	import BundleTileLong from '@/Components/App/BundleTileLong';

	export default {
		components: {
			AppLayout,
			BundleTileLong,
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
