<template>
	<div class="flex justify-between items-center">
		<div class="my-4 md:my-6 lg:my-8 flex">
			<div v-if="activeUser.profile_photo_path">
				<img
					:src="activeUser.profile_photo_path"
					class="rounded-full flex justify-center items-center bg-indigo-600 w-20 h-20"
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

			const activeUser = computed(() => store.state.users.active);

			function updateProfileImage(image) {
				console.log('incoming', image);
				//update active user image
				// if image has been uploaded already and user changes it - delete it from memory
				// if (newImage) {
				// 	URL.revokeObjectURL(newImage);
				// }

				// let newImage = URL.createObjectURL(image);
				// const data = {
				// 	...activeUser.value,
				// 	profile_photo_path: newImage
				// };
				console.log('emit', image);
				// store.commit('users/updateActiveUser', data);
				emit('onImageChange', image);
				showModal.value = false;
			}

			return {
				activeUser,
				getUserInitials,
				showModal,
				updateProfileImage
			};
		}
	};
</script>
