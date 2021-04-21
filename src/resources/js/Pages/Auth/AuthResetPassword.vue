<template>
	<auth-layout>
		<img
			class="block h-10 w-auto mx-auto mb-2 sm:mb-6 lg:mb-8"
			src="https://tailwindui.com/img/logos/workflow-mark-indigo-500.svg"
			alt="Workflow"
		/>
		<div class="my-4 md:my-6">
			<Form @submit="onSubmit" :validation-schema="schema">
				<v-text-input name="email" type="email" label="Email" :value="request.email" :is-disabled="true" />

				<v-text-input
					name="password"
					type="password"
					label="Password"
					placeholder="Your password"
					success-message="Nice and secure!"
				/>
				<v-text-input
					name="password_confirmation"
					type="password"
					label="Confirm Password"
					placeholder="Type it again"
					success-message="Glad you remembered it!"
				/>

				<div class="w-full flex justify-center my-4 md:my-6">
					<v-button-filled id="create-accoung">Reset Password</v-button-filled>
				</div>
			</Form>
		</div>
	</auth-layout>
</template>

<script>
	// Components
	import AuthLayout from '@/Layouts/AuthLayout';
	import VTextInput from '@/Components/Forms/VTextInput';
	import VButtonFilled from '@/Components/Forms/VButtonFilled';
	// Vee-validation and Yup
	import { Form } from 'vee-validate';
	import { string, required, email, min, oneOf, object, shape, ref } from 'yup';
	// Vue
	import { useStore } from 'vuex';
	// Toast
	import { useToast } from 'vue-toastification';

	export default {
		components: {
			AuthLayout,
			Form,
			VButtonFilled,
			VTextInput
		},

		props: {
			request: {
				type: Object,
				required: true
			}
		},

		setup(props) {
			const store = useStore();
			const toast = useToast();

			const schema = object().shape({
				email: string().email().required(),
				password: string().min(8).required(),
				password_confirmation: string()
					.required()
					.oneOf([ref('password')], 'Passwords do not match')
			});

			async function onSubmit(values) {
				// add reset email token that comes from the password reset link
				values.token = route().params.token;
				await store.dispatch('auth/resetPassword', values);
				toast.success('Password has been reset. You will be redirect to login page shortly.');
				setTimeout(() => {
					window.location.href = route('login');
				}, 5000);
			}

			return {
				onSubmit,
				schema
			};
		}
	};
</script>
