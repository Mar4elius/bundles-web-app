import authApi from '@/api/auth';

//initial state
const state = {
	active: null
};

// getter
const getters = {
	//
};

// actions
const actions = {
	/**
	 * Login user
	 *
	 * @param {Object} data
	 *
	 * @return JSON Response
	 */
	login({ commit }, data) {
		try {
			return authApi.login(data);
		} catch (error) {
			if (process.env.NODE_ENV !== 'production') {
				console.error(error);
			}
		}
	},

	/**
	 * Logout user
	 *
	 * @return JSON Response
	 */
	logout({ commit }) {
		try {
			return authApi.logout();
		} catch (error) {
			if (process.env.NODE_ENV !== 'production') {
				console.error(error);
			}
		}
	},

	/**
	 * Send email verification to logged in user
	 *
	 * @return JSON Response
	 */
	sendEmailVerification({ commit }) {
		try {
			return authApi.sendEmailVerification();
		} catch (error) {
			if (process.env.NODE_ENV !== 'production') {
				console.error(error);
			}
		}
	},

	/**
	 * Send link for resetting a password
	 *
	 * @param {Object} data
	 *
	 * @return JSON Response
	 */
	forgotPassword({ commit }, data) {
		try {
			return authApi.forgotPassword();
		} catch (error) {
			if (process.env.NODE_ENV !== 'production') {
				console.error(error);
			}
		}
	}
};

// mutations
const mutations = {
	//
};

export default {
	namespaced: true,
	state,
	getters,
	actions,
	mutations
};
