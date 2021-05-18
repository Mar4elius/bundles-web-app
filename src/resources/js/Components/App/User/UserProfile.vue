<template>
	<div class="md:flex md:justify-between w-full my-6 md:my-8">
		<div class="w-full md:w-2/5 mb-4 md:mb-6">
			<div class="flex justify-between items-center">
				<h3>Profile Information</h3>
				<loading-animation classes="w-6 h-6 mr-2 md:mr-4" />
			</div>
			<p>Update your account's profile information and email address.</p>
		</div>
		<div class="w-full md:w-3/5 rounded-md bg-white p-4 md:p-6 lg:p-8">
			<!-- user photo -->
			<user-photo @onImageChange="updateUserData" :show-button="true" />
			<validate-form @submit="onSubmit" :validation-schema="schema" v-slot="{ isSubmitting }">
				<div class="flex">
					<v-text-input
						name="first_name"
						type="text"
						label="First Name"
						placeholder="Firt Name"
						:value="activeUser.first_name"
						class="w-full md:w-1/2 mr-2 md:mr-4 lg:mr-6"
						:is-disabled="isSubmitting"
					/>
					<v-text-input
						name="last_name"
						type="text"
						label="Last Name"
						placeholder="Last Name"
						:value="activeUser.last_name"
						class="w-full md:w-1/2"
						:is-disabled="isSubmitting"
					/>
				</div>
				<div class="flex">
					<v-text-input
						name="email"
						type="email"
						label="E-mail"
						placeholder="Your email address"
						:value="activeUser.email"
						class="w-full md:w-1/2 mr-2 md:mr-4 lg:mr-6"
						:is-disabled="isSubmitting"
					/>
					<div class="w-full md:w-1/2" />
				</div>
				<div class="text-right">
					<v-button-filled
						id="update-user-data"
						:is-disabled="isSubmitting"
						:type="isSubmitting ? 'disabled' : 'primary'"
						>Save</v-button-filled
					>
				</div>
			</validate-form>
		</div>
	</div>
</template>
<script>
	// Components
	import LoadingAnimation from '@/Components/Support/LoadingAnimation';
	import VTextInput from '@/Components/Forms/VTextInput';
	import VButtonFilled from '@/Components/Forms/VButtonFilled';
	import UserPhoto from '@/Components/App/User/UserPhoto';
	// Vee-validation and Yup
	import { Form as ValidateForm } from 'vee-validate';
	import { string, required, email, object, shape } from 'yup';
	// Vue
	import { useStore } from 'vuex';
	import { computed, onUnmounted, ref } from '@vue/runtime-core';
	// Toast
	import { useToast } from 'vue-toastification';

	export default {
		components: {
			LoadingAnimation,
			ValidateForm,
			VButtonFilled,
			VTextInput,
			UserPhoto
		},

		setup(props) {
			onUnmounted(() => URL.revokeObjectURL(tempImage.value));

			const store = useStore();
			const activeUser = computed(() => store.state.users.active);
			const formData = new FormData();
			const tempImage = ref(null);
			const toast = useToast();

			const schema = object().shape({
				first_name: string().required(),
				last_name: string().required(),
				email: string().email().required()
			});

			async function onSubmit(values, actions) {
				// update use profile fiels that have been changed
				let updatedActiveUser = {
					...activeUser.value,
					...values,
					is_user_profile_update: true
				};

				// https://dev.to/diogoko/file-upload-using-laravel-and-vue-js-the-right-way-1775
				// When using FormData, for complex data structure we have to convert data to JSON format
				Object.keys(updatedActiveUser).forEach((key) => {
					formData.append(key, updatedActiveUser[key]);
				});

				let data = {
					activeUser: updatedActiveUser,
					formData: formData
				};
				// https://stackoverflow.com/questions/47676134/laravel-request-all-is-empty-using-multipart-form-data
				// append form method to PUT or PATCH so to overcome PHP mulitp form bug (which works only with POST request)
				// this way we will make use of correct route (PUT) and overcome php bug (POST)
				formData.append('_method', 'PUT');

				const response = await store.dispatch('users/update', data);

				if (!response.errors) {
					toast.success(response.data.message);
					if (response.data?.is_email_changed) {
						setTimeout(() => {
							window.location.href = route('verification.notice');
						}, 5000);
					}
				} else {
					toast.danger(response.data);
				}

				// delete locally saved image
				URL.revokeObjectURL(tempImage.value);
				tempImage.value = null;
			}

			function updateUserData(data) {
				tempImage.value = data.tempImage;
				formData.append('image', data.imageToSave, data.imageToSave.name);
			}

			return {
				activeUser,
				onSubmit,
				updateUserData,
				schema
			};
		}
	};
</script>
