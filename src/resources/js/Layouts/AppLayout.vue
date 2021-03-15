<template>
	<div class="min-h-screen bg-gray-100">
		<!-- Navigation -->
		<top-navigation />

		<!-- Page Heading -->
		<header class="shadow" v-if="$slots.header">
			<slot name="header"></slot>
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
