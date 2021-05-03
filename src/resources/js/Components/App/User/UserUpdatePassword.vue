<template>
	<div class="md:flex md:justify-between w-full my-6 md:my-8">
		<div class="w-full md:w-2/5 mb-4 md:mb-6">
			<h3>Update Password</h3>
			<p>Ensure your account is using a long, random password to stay secure.</p>
		</div>
		<div class="w-full md:w-3/5 rounded-md bg-white p-4 md:p-6 lg:p-8">
			<validate-form @submit="onSubmit" :validation-schema="schema">
				<v-text-input
					name="current_password"
					type="password"
					label="Current Password"
					placeholder="Current password"
				/>

				<v-text-input
					name="password"
					type="password"
					label="Password"
					placeholder="New password"
					success-message="Nice and secure!"
				/>

				<v-text-input
					name="password_confirmation"
					type="password"
					label="Confirm Password"
					placeholder="Type it again"
					success-message="Glad you remembered it!"
				/>

				<div class="text-right">
					<v-button-filled id="update-password">Save</v-button-filled>
				</div>
			</validate-form>
		</div>
	</div>
</template>
<script>
	// Vue
	import { useStore } from 'vuex';
	import { computed } from '@vue/runtime-core';
	// Components
	import VTextInput from '@/Components/Forms/VTextInput';
	import VButtonFilled from '@/Components/Forms/VButtonFilled';
	// Vee-validation and Yup
	import { Form as ValidateForm } from 'vee-validate';
	import { string, required, min, oneOf, object, shape, ref } from 'yup';

	export default {
		components: {
			ValidateForm,
			VButtonFilled,
			VTextInput
		},

		setup(props) {
			const store = useStore();

			const activeUser = computed(() => store.state.users.active);

			const schema = object().shape({
				password_confirmation: string().required(),
				password: string().min(8).required(),
				password_confirmation: string()
					.required()
					.oneOf([ref('password')], 'Passwords do not match')
			});

			function onSubmit() {
				//
			}

			return {
				activeUser,
				onSubmit,
				schema
			};
		}
	};
</script>
