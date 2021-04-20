<template>
	<auth-layout>
		<img
			class="block h-10 w-auto mx-auto mb-2 sm:mb-6 lg:mb-8"
			src="https://tailwindui.com/img/logos/workflow-mark-indigo-500.svg"
			alt="Workflow"
		/>
		<div>
			<p>
				Forgot your password? No problem. Just let us know your email address and we will email you a password
				reset link that will allow you to choose a new one.
			</p>
		</div>
		<div class="my-4 md:my-6">
			<Form @submit="onSubmit" :validation-schema="schema">
				<v-text-input name="email" type="email" label="Email" autofocus />

				<div class="w-full flex justify-center my-4 md:my-6">
					<v-button-filled id="create-accoung">Email Password Reset Link</v-button-filled>
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
	import { string, required, email, object, shape } from 'yup';
	// Vue
	import { useStore } from 'vuex';

	export default {
		components: {
			AuthLayout,
			Form,
			VButtonFilled,
			VTextInput
		},

		setup(props) {
			const store = useStore();

			const schema = object().shape({
				email: string().email().required()
			});

			async function onSubmit(values) {
				await store.dispatch('auth/sendForgotPasswordLink', values);
			}

			return {
				onSubmit,
				schema
			};
		}
	};
</script>
