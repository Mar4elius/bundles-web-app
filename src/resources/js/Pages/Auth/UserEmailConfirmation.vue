<template>
	<div class="bg-gray-100 min-h-screen">
		<div class="flex justify-center items-center min-h-screen">
			<div class="max-w-3xl mx-auto bg-white rounded-md p-2 sm:p-6 lg:p-8">
				<img
					class="block h-10 w-auto mx-auto mb-2 sm:mb-6 lg:mb-8"
					src="https://tailwindui.com/img/logos/workflow-mark-indigo-500.svg"
					alt="Workflow"
				/>
				<div class="">
					Thanks for signing up! Before getting started, could you verify your email address by clicking on
					the link we just emailed to you? If you didn't receive the email, we will gladly send you another.
				</div>

				<div class="my-4 md:my-6 flex justify-between">
					<v-button-filled id="resend-verification-email" @btnOnClickEvent="resendVerificationEmail"
						>Resend Verification Email</v-button-filled
					>

					<v-button-outlined id="logout" @btnOnClickEvent="logout"> Sign out </v-button-outlined>
				</div>
			</div>
		</div>
	</div>
	<h1>Hello Email Confirmtaion</h1>
</template>

<script>
	// Components
	import VButtonFilled from '@/Components/Forms/VButtonFilled';
	import VButtonOutlined from '@/Components/Forms/VButtonOutlined';
	// Functions
	import { useUserLogout } from '@/Composables/useUserLogout';

	export default {
		components: {
			VButtonFilled,
			VButtonOutlined
		},

		setup() {
			function resendVerificationEmail() {
				console.log('hello verification');
			}

			const { logout } = useUserLogout();
			return {
				resendVerificationEmail,
				logout
			};
		}
	};
</script>
