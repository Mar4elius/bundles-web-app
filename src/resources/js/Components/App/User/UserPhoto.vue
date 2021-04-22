<template>
	<div class="flex justify-between items-center">
		<div class="my-4 md:my-6 lg:my-8 flex">
			<div v-if="activeUser.profile_photo_path"></div>
			<div v-else class="rounded-full flex justify-center items-center bg-indigo-600 w-20 h-20">
				<span class="text-xl text-white">{{ getUserInitials(activeUser) }}</span>
			</div>
		</div>
		<div>
			<v-button-filled classes="w-" id="select-new-photo" @btnOnClickEvent="showModal = !showModal">
				Select A New Photo
			</v-button-filled>
		</div>
	</div>
	<modal-dialog :show="showModal" @btnOnClickEvent="showModal = !showModal">
		<p class="mb-4">Gokuu is...</p>
		<img src="https://i.gifer.com/QjMQ.gif" />
	</modal-dialog>
</template>
<script>
	// Vue
	import { useStore } from 'vuex';
	import { computed, ref } from '@vue/runtime-core';
	// Components
	import VButtonFilled from '@/Components/Forms/VButtonFilled';
	import ModalDialog from '@/Components/Support/ModalDialog';
	// Helpers
	import { getUserInitials } from '@/helpers';

	export default {
		components: {
			ModalDialog,
			VButtonFilled
		},

		setup() {
			const store = useStore();
			const showModal = ref(false);

			const activeUser = computed(() => store.state.users.active);

			return {
				activeUser,
				getUserInitials,
				showModal
			};
		}
	};
</script>
