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
	 * @param {*} bundleName
	 *
	 * @returns FIXME: what does it return?
	 */
	filterBundles({ commit }, bundleName) {
		//TODO: add loading thing
		return bundlesApi.filterBundles(bundleName);
	},

	/**
	 *Sort bundles by passed parameter
	 *
	 * @param {*} context
	 * @param {*} sortBy
	 *
	 * @returns FIXME: what does it return?
	 */
	sortBundles({ commit }, sortBy) {
		//TODO: add loading thing
		return bundlesApi.sortBundles(sortBy);
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
