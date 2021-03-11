<template>
	<app-layout>
		<template v-slot:header>
			<hero-banner />
		</template>

		<template v-slot:main>
			<div class="py-12">
				<div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
					<div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
						<h1>Main content</h1>
					</div>
				</div>
			</div>
		</template>
	</app-layout>
</template>

<script>
	import HeroBanner from '@/Pages/HeroBanner';
	import AppLayout from '@/Layouts/AppLayout';

	export default {
		components: {
			AppLayout,
			HeroBanner
		},

		created() {}
	};
</script>
