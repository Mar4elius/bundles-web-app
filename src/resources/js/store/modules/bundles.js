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
	 * @returns JSON Response
	 */
	searchBundles({ commit }, payload = null) {
		try {
			// set default payload if none is supplied
			if (!payload) {
				payload = {
					sections: ['all'],
					tags: ['all']
				};
			}
			return bundlesApi.searchBundles(payload);
		} catch (error) {
			console.error('hello');
		}
	},

	/**
	 * Get top 10 bundles based on sort_by params
	 *
	 * @param {*} context
	 * @param {Object} params
	 *
	 * @returns JSON Response
	 */
	getAdditionalBundles({ commit }, params) {
		return bundlesApi.getAdditionalBundles(params);
	},

	/**
	 * Get bundle filter options
	 *
	 * @param {*} context
	 *
	 * @returns JSON Response
	 */
	getFilterOptions({ commit }) {
		return bundlesApi.getFilterOptions();
	},

	/**
	 * Get bundle sort options
	 *
	 * @param {*} context
	 *
	 * @returns JSON Response
	 */
	getSortOptions({ commit }) {
		return bundlesApi.getSortOptions();
	},
	/**
	 * Get bundle details
	 *
	 * @param {*} context
	 * @param string slug
	 *
	 * @returns JSON Response
	 */
	getBundleDetails({ commit }, slug) {
		return bundlesApi.getBundleDetails(slug);
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
