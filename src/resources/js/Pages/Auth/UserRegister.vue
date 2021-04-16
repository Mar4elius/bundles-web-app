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
						<div>
							<v-label value="First Name" />
							<v-input @update:input="signUpForm.first_name = $event" />
						</div>
						<div>
							<v-label value="Last Name" />
							<v-input @update:input="signUpForm.last_name = $event" />
						</div>
						<div>
							<v-label value="Email" />
							<v-input type="email" @update:input="signUpForm.email = $event" />
						</div>
						<div>
							<v-label value="Password" />
							<v-input type="password" @update:input="signUpForm.password = $event" />
						</div>
						<div>
							<v-label value="Confirm Password" />
							<v-input type="password" @update:input="signUpForm.password_confirmation = $event" />
						</div>
						<div class="flex justify-between">
							<div class="flex">
								<v-checkbox :is-checked="false" class="mr-4">Remember me</v-checkbox>
								<v-label value="Remember me" />
							</div>
							<inertia-link href="#" class="font-bold text-indigo-600 hover:text-indigo-500"
								>Forgot your password?</inertia-link
							>
						</div>
						<div class="w-full flex justify-center mt-4 md:mt-6">
							<v-button-filled id="create-accoung"> Create Account</v-button-filled>
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
	import VInput from '@/Components/Forms/VInput';
	import VLabel from '@/Components/Forms/VLabel';
	import { reactive } from '@vue/reactivity';

	export default {
		components: {
			VButtonFilled,
			VCheckbox,
			VInput,
			VLabel
		},

		setup() {
			const signUpForm = reactive({
				first_name: '',
				last_name: '',
				email: '',
				password: '',
				password_confirmation: ''
			});

			return {
				signUpForm
			};
		}
	};
</script>
