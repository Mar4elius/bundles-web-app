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
	 * @param {Array} payload
	 *
	 * @returns FIXME: what does it return?
	 */
	searchBundles({ commit }, payload = null) {
		//TODO: add loading thing
		// set default payload if none is supplied
		if (!payload) {
			payload = {
				sections: ['all'],
				tags: ['all']
			};
		}
		return bundlesApi.searchBundles(payload);
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
	 * @param {*} context
	 *
	 * @returns FIXME: what does it return?
	 */
	getFilterOptions({ commit }) {
		return bundlesApi.getFilterOptions();
	},

	/**
	 * Get bundle sort options
	 *
	 * @param {*} context
	 *
	 * @returns FIXME: what does it return?
	 */
	getSortOptions({ commit }) {
		return bundlesApi.getSortOptions();
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
