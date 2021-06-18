import stripeApi from '@/api/stripe';

// initial state
const state = {
	all: []
};

// getters
const getters = {};

// actions
const actions = {
	/**
	 * Create payment intent
	 *
	 * @param {Object} purchase
	 *
	 * return JSON
	 */
	async create({ commit }, purchase) {
		await stripeApi.create(purchase);
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
