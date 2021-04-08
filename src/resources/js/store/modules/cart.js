// initial state
const state = {
	isOpen: false,
	items: [],
	checkoutStatus: null
};

// getters
const getters = {
	cartProducts: (state, getters, rootState) => {
		return state.items.map(({ id, quantity }) => {
			const product = rootState.products.all.find((product) => product.id === id);
			return {
				title: product.title,
				price: product.price,
				quantity
			};
		});
	},

	cartTotalPrice: (state, getters) => {
		return getters.cartProducts.reduce((total, product) => {
			return total + product.price * product.quantity;
		}, 0);
	}
};

// actions
const actions = {
	checkout({ commit, state }, products) {
		const savedCartItems = [...state.items];
		commit('setCheckoutStatus', null);
		// empty cart
		commit('setCartItems', { items: [] });
		shop.buyProducts(
			products,
			() => commit('setCheckoutStatus', 'successful'),
			() => {
				commit('setCheckoutStatus', 'failed');
				// rollback to the cart saved before sending the request
				commit('setCartItems', { items: savedCartItems });
			}
		);
	},

	addProductToCart({ state, commit }, bundle) {
		commit('setCheckoutStatus', null);
		if (bundle.quantity > 0) {
			const cartItem = state.items.find((item) => item.id === bundle.id);
			if (!cartItem) {
				commit('pushBundleToCart', bundle);
			} else {
				commit('incrementItemQuantity', bundle);
			}
			// remove 1 item from stock FIXME: figure out the way to update items left quantity
			// commit('products/decrementProductInventory', { id: bundle.id }, { root: true });
		}
	}
};

// mutations
const mutations = {
	pushBundleToCart(state, bundle) {
		state.items.push(bundle);
	},

	incrementItemQuantity(state, { id, quantity }) {
		const cartItem = state.items.find((item) => item.id === id);
		cartItem.quantity += quantity;
	},

	decrementItemQuantity(state, { id, quantity }) {
		const cartItem = state.items.find((item) => item.id === id);
		if (cartItem.quantity > 1) {
			cartItem.quantity -= quantity;
		}
	},

	removeBundleFromCart(state, { id }) {
		state.items = state.items.filter((item) => item.id !== id);
	},

	setCartItems(state, { items }) {
		state.items = items;
	},

	setCheckoutStatus(state, status) {
		state.checkoutStatus = status;
	},

	setIsOpen(state, value) {
		state.isOpen = value;
	}
};

export default {
	namespaced: true,
	state,
	getters,
	actions,
	mutations
};
