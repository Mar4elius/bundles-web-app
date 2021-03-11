<template>
	<div class="min-h-screen bg-white">
		<!-- Navigation -->
		<top-navigation />

		<!-- Page Heading -->
		<header class="shadow" v-if="$slots.header">
			<div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
				<slot name="header"></slot>
			</div>
		</header>

		<!-- Page Content -->
		<main>
			<slot name="main"></slot>
		</main>

		<!-- Page Footer -->
		<page-footer />
	</div>
</template>

<script>
	// import TopNavigation from '@/Layouts/TopNavigation';
	import TopNavigation from '@/Layouts/TopNavigation';
	import PageFooter from '@/Layouts/PageFooter';

	export default {
		components: {
			TopNavigation,
			PageFooter
		},

		methods: {
			switchToTeam(team) {
				this.$inertia.put(
					route('current-team.update'),
					{
						team_id: team.id
					},
					{
						preserveState: false
					}
				);
			},

			logout() {
				this.$inertia.post(route('logout'));
			}
		}
	};
</script>
