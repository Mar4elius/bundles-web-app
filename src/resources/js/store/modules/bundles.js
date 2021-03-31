import bundlesApi from '@/api/bundles';

// initial state
const state = {
	all: []
};

// getters
const getters = {};

// actions
const actions = {
	filterBundles({ commit }, bundleName) {
		//TODO: add loading thing
		return bundlesApi.filterBundles(bundleName);
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
