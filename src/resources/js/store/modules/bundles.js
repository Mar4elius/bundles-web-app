import bundlesApi from '@/api/bundles';

// initial state
const state = {
	all: []
};

// getters
const getters = {};

// actions
const actions = {
	/**
	 * Filter bundles by passed parameter
	 *
	 * @param {*} context
	 * @param {Array} params
	 *
	 * @returns FIXME: what does it return?
	 */
	searchBundles({ commit }, params) {
		//TODO: add loading thing
		return bundlesApi.searchBundles(params);
	},
	/**
	 *
	 * @param {*} context
	 * @param {String} sortBy
	 */
	getTopTenBundles({ commit }, sortBy) {
		return bundlesApi.getTopTenBundles(sortBy);
	}
};

// mutations
const mutations = {};

export default {
	namespaced: true,
	state,
	getters,
	actions,
	mutations
};
