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

	cartTotalPrice: (state) => {
		return state.items.reduce((grandTotal, item) => {
			return (
				grandTotal +
				item.products.reduce((total, product) => {
					return total + product.price * product.quantity;
				}, 0) *
					item.quantity
			);
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

	addBundleToCart({ state, commit }, bundle) {
		commit('setCheckoutStatus', null);
		if (bundle.quantity > 0) {
			const cartItem = state.items.find((item) => item.cart_id === bundle.cart_id);
			if (!cartItem) {
				commit('pushBundleToCart', bundle);
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

	incrementItemQuantity(state, { cart_id, quantity }) {
		const cartItem = state.items.find((item) => item.cart_id === cart_id);
		cartItem.quantity += quantity;
	},

	decrementItemQuantity(state, { cart_id, quantity }) {
		const cartItem = state.items.find((item) => item.cart_id === cart_id);
		if (cartItem.quantity > 1) {
			cartItem.quantity -= quantity;
		}
	},

	removeBundleFromCart(state, { cart_id }) {
		state.items = state.items.filter((item) => item.cart_id !== cart_id);
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
