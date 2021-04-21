<template>
	<auth-layout>
		<div class="flex-col flex-shrink-0 flex items-center">
			<img
				class="block h-10 w-auto"
				src="https://tailwindui.com/img/logos/workflow-mark-indigo-500.svg"
				alt="Workflow"
			/>
			<h3 class="text-center">Sign in to your account</h3>
		</div>
		<validate-form @submit="onSubmit" :validation-schema="schema">
			<v-text-input name="email" type="email" label="E-mail" placeholder="Your email address" />
			<v-text-input name="password" type="password" label="Password" placeholder="Your password" />

			<div class="w-full flex justify-center my-4 md:my-6">
				<v-button-filled id="create-accoung">Sign in</v-button-filled>
			</div>
		</validate-form>
		<div class="flex justify-between">
			<div class="flex">
				<v-checkbox :is-checked="false" class="flex flex-row-reverse" label="Remember me" />
				<v-label value="Remember me" />
			</div>
			<inertia-link :href="route('password.request')" class="font-bold text-indigo-600 hover:text-indigo-500"
				>Forgot your password?</inertia-link
			>
		</div>
		<div class="mt-4 md:mt-6 text-center">
			<p>
				Do not have an account?<inertia-link
					href="/register"
					class="font-bold text-indigo-600 hover:text-indigo-500"
				>
					Register
				</inertia-link>
			</p>
		</div>
	</auth-layout>
</template>

<script>
	// Vue
	import { useStore } from 'vuex';
	// Components
	import AuthLayout from '@/Layouts/AuthLayout';
	import VButtonFilled from '@/Components/Forms/VButtonFilled';
	import VCheckbox from '@/Components/Forms/VCheckbox';
	import VTextInput from '@/Components/Forms/VTextInput';
	// Vee-validation and Yup
	import { Form as ValidateForm } from 'vee-validate';
	import { string, required, email, object, shape } from 'yup';

	export default {
		components: {
			AuthLayout,
			ValidateForm,
			VButtonFilled,
			VCheckbox,
			VTextInput
		},

		setup(props) {
			const store = useStore();
			async function onSubmit(values, actions) {
				const response = await store.dispatch('auth/login', values);
				if (!response.errors) {
					window.location.href = route('bundles.index');
				} else {
					actions.setErrors(response.errors);
				}
			}

			const schema = object().shape({
				email: string().email().required(),
				password: string().required()
			});

			return {
				onSubmit,
				schema
			};
		}
	};
</script>
