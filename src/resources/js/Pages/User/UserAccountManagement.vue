<template>
	<app-layout>
		<template v-slot:main>
			<user-profile />
		</template>
	</app-layout>
</template>

<script>
	// Components
	import AppLayout from '@/Layouts/AppLayout';
	import UserProfile from '@/Components/App/User/UserProfile';
	export default {
		components: {
			AppLayout,
			UserProfile
		}
	};
</script>
