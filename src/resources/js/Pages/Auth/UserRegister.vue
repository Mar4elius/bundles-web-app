<template>
	<div class="bg-gray-100 min-h-screen flex">
		<div class="w-full lg:w-1/2">
			<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
				<div class="flex flex-col md:flex-row justify-center items-center min-h-screen">
					<div class="w-full sm:w-4/5 md:w-3/5 lg:w-4/5 xl:w-3/5 bg-white rounded-md p-4 md:p-6">
						<div class="flex-col flex-shrink-0 flex items-center">
							<img
								class="block h-8 w-auto"
								src="https://tailwindui.com/img/logos/workflow-mark-indigo-500.svg"
								alt="Workflow"
							/>
							<h3>Sign Up</h3>
						</div>
						<Form @submit="onSubmit" :validation-schema="schema">
							<VTextInput
								name="first_name"
								type="text"
								label="First Name"
								placeholder="Firt Name"
								success-message="Nice to meet you!"
							/>
							<VTextInput
								name="last_name"
								type="text"
								label="Last Name"
								placeholder="Last Name"
								success-message="Nice to meet you!"
							/>
							<VTextInput
								name="email"
								type="email"
								label="E-mail"
								placeholder="Your email address"
								success-message="Got it, we won't spam you!"
							/>
							<VTextInput
								name="password"
								type="password"
								label="Password"
								placeholder="Your password"
								success-message="Nice and secure!"
							/>
							<VTextInput
								name="confirm_password"
								type="password"
								label="Confirm Password"
								placeholder="Type it again"
								success-message="Glad you remembered it!"
							/>

							<div class="w-full flex justify-center my-4 md:my-6">
								<v-button-filled id="create-accoung"> Create Account</v-button-filled>
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
	import VButtonFilled from '@/Components/Forms/VButtonFilled';
	import VCheckbox from '@/Components/Forms/VCheckbox';
	import VTextInput from '@/Components/Forms/VTextInput';
	import { Form } from 'vee-validate';
	import * as Yup from 'yup';

	export default {
		components: {
			Form,
			VButtonFilled,
			VCheckbox,
			VTextInput
		},

		setup() {
			function onSubmit(values) {
				console.log(values);
				// alert(JSON.stringify(values, null, 2));
			}

			const schema = Yup.object().shape({
				first_name: Yup.string().required(),
				last_name: Yup.string().required(),
				email: Yup.string().email().required(),
				password: Yup.string().min(6).required(),
				confirm_password: Yup.string()
					.required()
					.oneOf([Yup.ref('password')], 'Passwords do not match')
			});

			return {
				onSubmit,
				schema
			};
		}
	};
</script>
