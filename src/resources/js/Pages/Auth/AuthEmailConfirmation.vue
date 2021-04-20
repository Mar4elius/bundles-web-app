<template>
	<auth-layout>
		<img
			class="block h-10 w-auto mx-auto mb-2 sm:mb-6 lg:mb-8"
			src="https://tailwindui.com/img/logos/workflow-mark-indigo-500.svg"
			alt="Workflow"
		/>
		<div>
			<p>
				Thanks for signing up! Before getting started, could you verify your email address by clicking on the
				link we just emailed to you? If you didn't receive the email, we will gladly send you another.
			</p>
		</div>

		<div class="my-4 md:my-6 flex justify-between">
			<v-button-filled id="resend-verification-email" @btnOnClickEvent="resendVerificationEmail" classes="md:mr-6"
				>Resend Verification Email</v-button-filled
			>

			<v-button-outlined id="logout" @btnOnClickEvent="logout"> Sign out </v-button-outlined>
		</div>
	</auth-layout>
</template>

<script>
	// Components
	import AuthLayout from '@/Layouts/AuthLayout';
	import VButtonFilled from '@/Components/Forms/VButtonFilled';
	import VButtonOutlined from '@/Components/Forms/VButtonOutlined';
	// Functions
	import { useAuthLogout } from '@/Composables/useAuthLogout';
	import { useStore } from 'vuex';

	export default {
		components: {
			AuthLayout,
			VButtonFilled,
			VButtonOutlined
		},

		setup() {
			const store = useStore();
			function resendVerificationEmail() {
				store.dispatch('auth/sendEmailVerification');
			}

			const { logout } = useAuthLogout();
			return {
				resendVerificationEmail,
				logout
			};
		}
	};
</script>
