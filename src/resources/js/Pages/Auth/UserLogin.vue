<template>
	<div class="bg-gray-100 min-h-screen flex">
		<div class="w-full lg:w-1/2">
			<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
				<div class="flex flex-col md:flex-row justify-center items-center min-h-screen">
					<div class="w-full sm:w-4/5 md:w-3/5 lg:w-4/5 xl:w-3/5 bg-white rounded-md p-4 md:p-6">
						<div class="flex-col flex-shrink-0 flex items-center">
							<img
								class="block h-10 w-auto"
								src="https://tailwindui.com/img/logos/workflow-mark-indigo-500.svg"
								alt="Workflow"
							/>
							<h3>Sign in to your account</h3>
						</div>
						<Form @submit="onSubmit" :validation-schema="schema">
							<v-text-input
								name="email"
								type="email"
								label="E-mail"
								placeholder="Your email address"
								success-message="Got it, we won't spam you!"
							/>
							<v-text-input
								name="password"
								type="password"
								label="Password"
								placeholder="Your password"
								success-message="Nice and secure!"
							/>

							<div class="w-full flex justify-center my-4 md:my-6">
								<v-button-filled id="create-accoung"> Sign in</v-button-filled>
							</div>
						</Form>
						<div class="flex justify-between">
							<div class="flex">
								<v-checkbox :is-checked="false" class="flex flex-row-reverse" label="Remember me" />
								<v-label value="Remember me" />
							</div>
							<inertia-link href="#" class="font-bold text-indigo-600 hover:text-indigo-500"
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
					</div>
				</div>
			</div>
		</div>
		<div class="hidden lg:block lg:w-1/2 bg-signup-image h-auto bg-no-repeat bg-cover bg-center" />
	</div>
</template>

<script>
	// Vue
	import { useStore } from 'vuex';
	// Components
	import VButtonFilled from '@/Components/Forms/VButtonFilled';
	import VCheckbox from '@/Components/Forms/VCheckbox';
	import VTextInput from '@/Components/Forms/VTextInput';
	// Vee-validation and Yup
	import { Form } from 'vee-validate';
	import { string, required, email, object, shape } from 'yup';

	export default {
		components: {
			Form,
			VButtonFilled,
			VCheckbox,
			VTextInput
		},

		setup() {
			const store = useStore();

			function onSubmit(values) {
				store.dispatch('users/store', values);
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
