<template>
	<div class="flex justify-between items-center">
		<div v-if="activeUser.profile_photo_path">
			<img
				:src="[
					isUserImageLocal ? `${activeUser.profile_photo_path}` : `storage/${activeUser.profile_photo_path}`
				]"
				:class="classes"
				alt="avatar"
			/>
		</div>
		<div v-else :class="classes" class="rounded-full bg-indigo-600 flex justify-center items-center">
			<span class="text-xl text-white">{{ getUserInitials(activeUser) }}</span>
		</div>
		<!-- This component is used on Top Navigation component as well, where we don't want to display button -->
		<div v-if="showButton">
			<v-button-filled id="select-new-photo" @btnOnClickEvent="showModal = !showModal">
				Select A New Photo
			</v-button-filled>
		</div>

		<modal-dialog :show="showModal" @btnOnClickEvent="showModal = !showModal">
			<template v-slot:header>
				<h4>Upload New Photo</h4>
			</template>
			<template v-slot:content>
				<upload-files @onImageChange="updateProfileImage" />
			</template>
		</modal-dialog>
	</div>
</template>
<script>
	// Vue
	import { useStore } from 'vuex';
	import { computed, ref } from '@vue/runtime-core';
	// Components
	import VButtonFilled from '@/Components/Forms/VButtonFilled';
	import ModalDialog from '@/Components/Support/ModalDialog';
	import UploadFiles from '@/Components/Forms/UploadFiles';
	// Helpers
	import { getUserInitials } from '@/helpers';

	export default {
		components: {
			ModalDialog,
			VButtonFilled,
			UploadFiles
		},

		props: {
			showButton: {
				type: Boolean,
				default: false
			},

			classes: {
				type: String,
				default: 'rounded-full flex justify-center items-center bg-indigo-600 w-20 h-20 my-4 md:my-6 lg:my-8'
			}
		},

		setup(props, { emit }) {
			const store = useStore();
			const showModal = ref(false);
			const tempImage = ref(null); // temporary image untill it is saved
			const activeUser = computed(() => store.state.users.active);
			const isUserImageLocal = computed(() => activeUser.value?.profile_photo_path?.includes('blob', 0));

			function updateProfileImage(image) {
				//update active user image
				// if image has been uploaded already and user changes it - delete it from memory
				if (tempImage.value) {
					URL.revokeObjectURL(tempImage);
				}

				tempImage.value = URL.createObjectURL(image);
				const data = {
					...activeUser.value,
					profile_photo_path: tempImage.value
				};
				store.commit('users/updateActiveUser', data);

				emit('onImageChange', {
					imageToSave: image,
					tempImage: tempImage
				});

				showModal.value = false;
			}

			return {
				activeUser,
				getUserInitials,
				isUserImageLocal,
				showModal,
				tempImage,
				updateProfileImage
			};
		}
	};
</script>
