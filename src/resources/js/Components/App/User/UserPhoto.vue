<template>
	<div class="flex justify-between items-center">
		<div class="my-4 md:my-6 lg:my-8 flex">
			<div v-if="activeUser.profile_photo_path"></div>
			<div v-else class="rounded-full flex justify-center items-center bg-indigo-600 w-20 h-20">
				<span class="text-xl text-white">{{ test(activeUser) }}</span>
			</div>
		</div>
		<div>
			<v-button-filled classes="w-" id="select-new-photo" @btnOnClickEvent="selectNewPhoto">
				Select A New Photo
			</v-button-filled>
		</div>
	</div>
</template>
<script>
	// Vue
	import { useStore } from 'vuex';
	import { computed } from '@vue/runtime-core';
	// Components
	import VButtonFilled from '@/Components/Forms/VButtonFilled';

	export default {
		components: {
			VButtonFilled
		},

		setup() {
			const store = useStore();

			const activeUser = computed(() => store.state.users.active);

			function test(user) {
				const firstNameFirstLetter = user.first_name.charAt(0).toUpperCase();
				const lastNameFirstLetter = user.last_name.charAt(0).toUpperCase();

				return `${firstNameFirstLetter}${lastNameFirstLetter}`;
			}

			return {
				activeUser,
				test
			};
		}
	};
</script>
