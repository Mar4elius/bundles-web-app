import AddressApi from '@/api/address';

// initial State
const state = {
	active: null,
	all: []
};

// getters
const getters = {
	//
};

// actions
const actions = {
	async store({ commit }, data) {
		const response = await AddressApi.store(data);
		return response;
	}
};

const mutations = {
	//
};

export default {
	namespaced: true,
	state,
	getters,
	actions,
	mutations
};
