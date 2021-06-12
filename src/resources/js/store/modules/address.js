import AddressApi from '@/api/address';

// initial State
const state = {
	active: null,
	all: [],
	isBillingSameAsShipping: false
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
	},

	async update({ commit }, data) {
		const response = await AddressApi.update(data);
		return response;
	}
};

const mutations = {
	setBillingAddressSameAsShipping(state, data) {
		state.isBillingSameAsShipping = data;
	}
};

export default {
	namespaced: true,
	state,
	getters,
	actions,
	mutations
};
