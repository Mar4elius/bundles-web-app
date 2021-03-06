<template>
	<div class="md:flex md:justify-between w-full my-6 md:my-8">
		<div class="w-full md:w-2/5 mb-4 md:mb-6">
			<div class="flex justify-between items-center">
				<h3>Update Password</h3>
			</div>
			<p>Ensure your account is using a long, random password to stay secure.</p>
		</div>
		<div class="w-full md:w-3/5 rounded-md bg-white p-4 md:p-6 lg:p-8">
			<validate-form @submit="onSubmit" :validation-schema="schema" v-slot="{ isSubmitting }">
				<v-text-input
					name="current_password"
					type="password"
					label="Current Password"
					placeholder="Current password"
					:is-disabled="isSubmitting"
				/>

				<v-text-input
					name="password"
					type="password"
					label="Password"
					placeholder="New password"
					:is-disabled="isSubmitting"
				/>

				<v-text-input
					name="password_confirmation"
					type="password"
					label="Confirm Password"
					placeholder="Type it again"
					:is-disabled="isSubmitting"
				/>

				<div class="flex justify-end items-center">
					<loading-animation classes="w-6 h-6 mr-2 md:mr-4" v-if="loading" />
					<v-button-filled id="update-password" :is-disabled="isSubmitting">Save</v-button-filled>
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
	import LoadingAnimation from '@/Components/Support/LoadingAnimation';
	import VTextInput from '@/Components/Forms/VTextInput';
	import VButtonFilled from '@/Components/Forms/VButtonFilled';
	// Composables
	import useLocalLoadingFlag from '@/Composables/useLocalLoadingFlag';
	// Vee-validation and Yup
	import { Form as ValidateForm } from 'vee-validate';
	import { string, required, min, oneOf, object, shape, ref, nullable } from 'yup';
	// Toast
	import { useToast } from 'vue-toastification';

	export default {
		components: {
			LoadingAnimation,
			ValidateForm,
			VButtonFilled,
			VTextInput
		},

		setup(props) {
			const store = useStore();
			const toast = useToast();

			const activeUser = computed(() => store.state.users.active);

			const schema = object().shape({
				current_password: string().required().nullable(),
				password_confirmation: string().required().nullable(),
				password: string().min(8).required().nullable(),
				password_confirmation: string()
					.required()
					.oneOf([ref('password')], 'Passwords do not match')
					.nullable()
			});

			const { loading, setLocalLoadingFlag } = useLocalLoadingFlag();

			async function onSubmit(values, actions) {
				setLocalLoadingFlag(true);
				const response = await store.dispatch('users/updatePassword', values);
				if (!response.errors) {
					toast.success('Password has been updated.');
					actions.setValues({
						current_password: '',
						password: '',
						password_confirmation: ''
					});
					actions.resetForm();
				} else {
					actions.setErrors(response.errors);
				}

				setLocalLoadingFlag(false);
			}

			return {
				activeUser,
				loading,
				onSubmit,
				schema
			};
		}
	};
</script>
