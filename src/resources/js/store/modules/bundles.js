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
	 * Get top 10 bundles based on sort_by params
	 *
	 * @param {*} context
	 * @param {String} sortBy
	 *
	 * @returns FIXME: what does it return?
	 */
	getTopTenBundles({ commit }, sortBy) {
		return bundlesApi.getTopTenBundles(sortBy);
	},
	/**
	 * Get bundle filter options
	 *
	 * @param {*} param0
	 *
	 * @returns FIXME: what does it return?
	 */
	getFilterOptions({ commit }) {
		return bundlesApi.getFilterOptions();
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
