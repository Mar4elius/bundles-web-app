<template>
	<div class="min-h-screen bg-gray-100">
		<!-- Navigation -->
		<top-navigation />

		<!-- Page Heading -->
		<header class="shadow" v-if="$slots.header">
			<slot name="header"></slot>
		</header>

		<!-- Page Content -->
		<main class="max-w-7xl mx-auto px-2 sm:px-6 lg:px-8">
			<slot name="main"></slot>
		</main>
		<shopping-cart />

		<!-- Page Footer -->
		<page-footer />
	</div>
</template>

<script>
	import TopNavigation from '@/Layouts/TopNavigation';
	import PageFooter from '@/Layouts/PageFooter';
	import ShoppingCart from '@/Layouts/ShoppingCart';

	export default {
		components: {
			TopNavigation,
			ShoppingCart,
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
