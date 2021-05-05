<template>
	<app-layout>
		<template v-slot:main>
			<user-profile />
			<user-shipping-address />
			<user-update-password />
		</template>
	</app-layout>
</template>

<script>
	// Components
	import AppLayout from '@/Layouts/AppLayout';
	import UserProfile from '@/Components/App/User/UserProfile';
	import UserUpdatePassword from '@/Components/App/User/UserUpdatePassword';
	import UserShippingAddress from '@/Components/App/User/UserShippingAddress';

	export default {
		components: {
			AppLayout,
			UserProfile,
			UserShippingAddress,
			UserUpdatePassword
		}
	};
</script>
