// Vue
import { useStore } from 'vuex';
// Toast
import { useToast } from 'vue-toastification';

export default function useStoreUpdateUser() {
	const store = useStore();
	const toast = useToast();

	async function updateUser(data) {
		// update user profile data
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
	}

	async function updateUserAvatar(data) {
		const response = await store.dispatch('users/updateAvatar', data);

		if (!response.errors) {
			toast.success(response.data.message);
		} else {
			toast.danger(response.data);
		}
	}

	return {
		updateUser,
		updateUserAvatar
	};
}
