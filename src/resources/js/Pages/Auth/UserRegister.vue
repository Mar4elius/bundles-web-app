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
							<h3>Sign Up</h3>
						</div>
						<Form @submit="onSubmit" :validation-schema="schema">
							<v-text-input
								name="first_name"
								type="text"
								label="First Name"
								placeholder="Firt Name"
								success-message="Nice to meet you!"
							/>
							<v-text-input
								name="last_name"
								type="text"
								label="Last Name"
								placeholder="Last Name"
								success-message="Nice to meet you!"
							/>
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
							<v-text-input
								name="password_confirmation"
								type="password"
								label="Confirm Password"
								placeholder="Type it again"
								success-message="Glad you remembered it!"
							/>

							<div class="w-full flex justify-center my-4 md:my-6">
								<v-button-filled id="create-accoung"> Create Account</v-button-filled>
							</div>
						</Form>

						<div class="mt-4 md:mt-6 text-center">
							<p>
								Already have an account?<inertia-link
									href="/login"
									class="font-bold text-indigo-600 hover:text-indigo-500"
								>
									Log in
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
	import VTextInput from '@/Components/Forms/VTextInput';
	// Vee-validation and Yup
	import { Form } from 'vee-validate';
	import { string, required, email, min, oneOf, object, shape, ref } from 'yup';

	export default {
		components: {
			Form,
			VButtonFilled,
			VTextInput
		},

		setup() {
			const store = useStore();

			async function onSubmit(values) {
				await store.dispatch('users/store', values);
				window.location.href = route('verification.notice');
			}

			const schema = object().shape({
				first_name: string().required(),
				last_name: string().required(),
				email: string().email().required(),
				password: string().min(8).required(),
				password_confirmation: string()
					.required()
					.oneOf([ref('password')], 'Passwords do not match')
			});

			return {
				onSubmit,
				schema
			};
		}
	};
</script>
