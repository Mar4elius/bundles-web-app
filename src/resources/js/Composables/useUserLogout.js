import { useStore } from 'vuex';

/**
 * Logs out active user
 *
 * @param {string} route ['bundles.index']
 */
export function useUserLogout(routeParameter = 'bundles.index') {
	const store = useStore();
	async function logout() {
		await store.dispatch('users/logout');
		window.location.href = route(routeParameter);
	}

	return {
		logout
	};
}
