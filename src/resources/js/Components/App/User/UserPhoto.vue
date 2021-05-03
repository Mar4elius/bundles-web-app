<template>
	<div class="flex justify-between items-center">
		<div class="my-4 md:my-6 lg:my-8 flex">
			<div v-if="activeUser.profile_photo_path">
				<img
					:src="[tempImage ? `${activeUser.profile_photo_path}` : `storage/${activeUser.profile_photo_path}`]"
					class="rounded-full flex justify-center items-center bg-indigo-600 w-20 h-20"
					alt="avatar"
				/>
			</div>
			<div v-else class="rounded-full flex justify-center items-center bg-indigo-600 w-20 h-20">
				<span class="text-xl text-white">{{ getUserInitials(activeUser) }}</span>
			</div>
		</div>
		<div>
			<v-button-filled classes="w-" id="select-new-photo" @btnOnClickEvent="showModal = !showModal">
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

		setup(props, { emit }) {
			const store = useStore();
			const showModal = ref(false);
			const tempImage = ref(null); // temporary image untill it is saved
			const activeUser = computed(() => store.state.users.active);

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
				showModal,
				tempImage,
				updateProfileImage
			};
		}
	};
</script>
