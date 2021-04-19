import usersApi from '@/api/users';
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
	 * Store new user
	 *
	 * @param {Object} data
	 *
	 * @return JSON Response
	 */
	store({ commit }, data) {
		return usersApi.store(data);
	},

	/**
	 * Login user
	 *
	 * @param {Object} data
	 *
	 * @return JSON Response
	 */
	login({ commit }, data) {
		try {
			return usersApi.login(data);
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
		console.log('logout');
		try {
			return usersApi.logout();
		} catch (error) {
			if (process.env.NODE_ENV !== 'production') {
				console.error(error);
			}
		}
	}
};

const mutations = {
	setActiveUser(state, data) {
		state.active = JSON.parse(data);
	}
};

export default {
	namespaced: true,
	state,
	getters,
	actions,
	mutations
};
