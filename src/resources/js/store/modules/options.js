import optionsApi from '@/api/options';

// initial state
const state = {
	all: []
};

// getters
const getters = {};

// actions
const actions = {
	/**
	 * Get all available countries
	 */
	getCountries() {
		return optionsApi.getCountries();
	},

	/**
	 * Get country provinces
	 *
	 * @param {Object} country
	 */
	getProvinces({ context }, country) {
		return optionsApi.getProvinces(country);
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
	mutations,
	actions
};
