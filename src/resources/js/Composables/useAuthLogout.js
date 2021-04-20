import { useStore } from 'vuex';

/**
 * Logs out active user
 *
 * @param {string} route ['bundles.index']
 */
export function useAuthLogout(routeParameter = 'bundles.index') {
	const store = useStore();
	async function logout() {
		await store.dispatch('auth/logout');
		window.location.href = route(routeParameter);
	}

	return {
		logout
	};
}
