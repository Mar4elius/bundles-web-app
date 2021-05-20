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
						@update:value="setValue"
						class="w-full md:w-1/2 mr-2 md:mr-4 lg:mr-6"
						:is-disabled="isSubmitting"
					/>

					<v-text-input
						name="last_name"
						type="text"
						label="Last Name"
						placeholder="Last Name"
						:value="activeUser.last_name"
						@update:value="setValue"
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
						@update:value="setValue"
						class="w-full md:w-1/2 mr-2 md:mr-4 lg:mr-6"
						:is-disabled="isSubmitting"
					/>
					<div class="w-full md:w-1/2" />
				</div>
				<div class="text-right">
					<v-button-filled
						id="update-user-data"
						:is-disabled="isSubmitting || !hasDataChanged"
						:type="isSubmitting || !hasDataChanged ? 'disabled' : 'primary'"
						>Save</v-button-filled
					>
				</div>
			</validate-form>
		</div>
	</div>
</template>
<script>
	// Vue
	import { useStore } from 'vuex';
	import { computed, onUnmounted, reactive, ref } from '@vue/runtime-core';
	// Components
	import LoadingAnimation from '@/Components/Support/LoadingAnimation';
	import VTextInput from '@/Components/Forms/VTextInput';
	import VButtonFilled from '@/Components/Forms/VButtonFilled';
	import UserPhoto from '@/Components/App/User/UserPhoto';
	// Composables
	import useHasDataChanged from '@/Composables/useHasDataChanged';
	// Vee-validation and Yup
	import { Form as ValidateForm } from 'vee-validate';
	import { string, required, email, object, shape } from 'yup';
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
			// remove image from local storage. Useful when user uploaded the image but didn't save it to the server
			onUnmounted(() => URL.revokeObjectURL(tempImage.value));

			const store = useStore();
			let activeUser = reactive({ ...store.state.users.active });
			let vuexStoreActiveUser = computed(() => store.state.users.active);
			const formData = new FormData();
			const tempImage = ref(null);
			const toast = useToast();

			const schema = object().shape({
				first_name: string().required(),
				last_name: string().required(),
				email: string().email().required()
			});

			let { hasDataChanged, updateInitialData, updateMutableData } = useHasDataChanged(
				vuexStoreActiveUser.value,
				activeUser
			);
			async function onSubmit(values, actions) {
				// update use profile fiels that have been changed
				let updatedActiveUser = {
					...activeUser,
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
					// update active user data after request wiht new data;
					activeUser = { ...store.state.users.active };
					// update initial data for change detection functionality
					updateInitialData(vuexStoreActiveUser.value);
					// update mutable data for change detection functionality
					updateMutableData(activeUser);

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

			function setValue(data) {
				activeUser[data.key] = data.value;
				// update mutable data so to disable/enable button
				// if data has changed
				updateMutableData(activeUser);
			}

			return {
				activeUser,
				hasDataChanged,
				onSubmit,
				updateUserData,
				schema,
				setValue
			};
		}
	};
</script>
