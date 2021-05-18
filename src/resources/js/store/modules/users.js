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
	async store({ commit }, data) {
		try {
			return await usersApi.store(data);
		} catch (error) {
			if (process.env.NODE_ENV !== 'production') {
				console.error(error);
			}
			return error.response.data;
		}
	},

	/**
	 * Update user password
	 *
	 * @param {Object} data
	 *
	 * @return JSON Response
	 */
	async updatePassword({ commit }, data) {
		try {
			return await usersApi.updatePassword(data);
		} catch (error) {
			if (process.env.NODE_ENV !== 'production') {
				console.error(error);
			}
			return error.response.data;
		}
	},

	/**
	 * Update user personal data
	 *
	 * @param {Object} data
	 *
	 * @return JSON Response
	 */
	async update({ commit }, data) {
		try {
			const response = await usersApi.update(data);
			commit('updateActiveUser', response.data.user);
			return response;
		} catch (error) {
			if (process.env.NODE_ENV !== 'production') {
				console.error(error);
			}
			return error.response.data;
		}
	}
};

const mutations = {
	setActiveUser(state, data) {
		state.active = JSON.parse(data);
	},

	updateActiveUser(state, data) {
		state.active = { ...data };
	}
};

export default {
	namespaced: true,
	state,
	getters,
	actions,
	mutations
};
