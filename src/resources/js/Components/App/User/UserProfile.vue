<template>
	<div class="md:flex md:justify-between w-full my-6 md:my-8">
		<div class="w-full md:w-2/5 mb-4 md:mb-6">
			<h3>Profile Information</h3>
			<p>Update your account's profile information and email address.</p>
		</div>
		<div class="w-full md:w-3/5 rounded-md bg-white p-4 md:p-6 lg:p-8">
			<validate-form @submit="onSubmit" :validation-schema="schema">
				<!-- user photo -->
				<div>
					<h6>Photo</h6>
					<user-photo />
				</div>
				<div class="flex">
					<v-text-input
						name="first_name"
						type="text"
						label="First Name"
						placeholder="Firt Name"
						:value="activeUser.first_name"
						class="w-full md:w-1/2 mr-2 md:mr-4 lg:mr-6"
					/>
					<v-text-input
						name="last_name"
						type="text"
						label="Last Name"
						placeholder="Last Name"
						:value="activeUser.last_name"
						class="w-full md:w-1/2"
					/>
				</div>
				<v-text-input
					name="email"
					type="email"
					label="E-mail"
					placeholder="Your email address"
					:value="activeUser.email"
				/>
				<div class="text-right">
					<v-button-filled id="order-now" @btnOnClickEvent="pushProductToCart">Save</v-button-filled>
				</div>
			</validate-form>
		</div>
	</div>
</template>
<script>
	// Components
	import VTextInput from '@/Components/Forms/VTextInput';
	import VButtonFilled from '@/Components/Forms/VButtonFilled';
	import UserPhoto from '@/Components/App/User/UserPhoto';
	// Vee-validation and Yup
	import { Form as ValidateForm } from 'vee-validate';
	import { string, required, email, object, shape } from 'yup';
	import { useStore } from 'vuex';
	import { computed } from '@vue/runtime-core';
	export default {
		components: {
			ValidateForm,
			VButtonFilled,
			VTextInput,
			UserPhoto
		},

		setup(props) {
			const store = useStore();

			const activeUser = computed(() => store.state.users.active);

			return {
				activeUser
			};
		}
	};
</script>
