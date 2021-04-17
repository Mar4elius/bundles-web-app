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
		return usersApi.login(data);
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
