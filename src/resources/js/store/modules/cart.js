import cartsApi from '@/api/carts';

// initial state
const state = {
	active: null,
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
			return grandTotal + item.price_per_bundle * item.quantity;
		}, 0);
		return 1;
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
	},

	/**
	 * Store new cart in db
	 *
	 * @param {Object} bundle
	 *
	 * @returns JSON Response
	 */
	async store({ commit }, bundle) {
		// save bundle first
		const cartResponse = await cartsApi.store({
			// use bundle sub total because we will create a new cart
			// that will have only 1 bundle at the start
			cart_sub_total: bundle.price
		});

		commit('setActiveCart', cartResponse.data.cart);
		if (cartResponse.status === 200) {
			// update cart_id value
			console.log(cartResponse);
			bundle.cart_id = cartResponse.data.cart.id;
			const cartBundleResponse = await cartsApi.storeCartBundle(bundle);
			// update store with newly created data
			commit('setCartItems', cartBundleResponse.data.cart_bundles);

			return cartBundleResponse;
		}
	},

	/**
	 * Show cart in db
	 *
	 * @param {Object} cart
	 *
	 * @returns JSON Response
	 */
	async show({ state, commit }, cart) {
		const response = await cartsApi.show(cart);
		// if cart exists - update store
		if (response.data.cart) {
			// Destructure object
			const { cart_bundles: cartBundles, ...cart } = { ...response.data.cart };
			commit('setActiveCart', cart);
			commit('setCartItems', cartBundles);
		} else {
			// else remove cookie
			document.cookie = `bundle_cart_id=; expires=Thu, 01 Jan 1970 00:00:00 UTC; path=/;`;
		}
	},

	/**
	 * Destroy cart
	 *
	 * @param {Number} cart_id
	 *
	 * @returns JSON Response
	 */
	async destroy({ state, commit }, cart_id) {
		const response = await cartsApi.destroy(cart_id);
		commit('setActiveCart', null);
	},

	/**
	 * Create new bundle that belong to cart
	 *
	 * @param {Object} bundle
	 *
	 * @returns JSON Response
	 */
	async storeCartBundle({ state, commit }, bundle) {
		const response = await cartsApi.storeCartBundle(bundle);
		commit('setCartItems', response.data.cart_bundles);
	},

	/**
	 * Destroy cart bundle that belongs to cart
	 *
	 * @param {Number} cartBundleId
	 *
	 * @returns JSON Response
	 */
	destroyCartBundle({ state, commit }, cart_bundle_id) {
		try {
			const response = cartsApi.destroyCartBundle(cart_bundle_id);
			commit('removeBundleFromCart', cart_bundle_id);
			return response;
		} catch (error) {
			console.error(error);
		}
	},

	/**
	 * Update cart bundle that belongs to cart
	 *
	 * @param {Number} cartBundleId
	 *
	 * @returns JSON Response
	 */
	async updateCartBundle({ state, commit }, cartBundle) {
		try {
			const response = await cartsApi.updateCartBundle(cartBundle);
			commit('updateCartItems', response.data.cart_bundle);
			return response;
		} catch (error) {
			console.error(error);
		}
	},

	/**
	 * Update cart bundle PRODUCT that belongs to cart
	 *
	 * @param {Number} cartBundleProductId
	 *
	 * @returns JSON Response
	 */
	async updateCartBundleProduct({ state, commit }, cartBundleProductId) {
		try {
			const response = await cartsApi.updateCartBundleProduct(cartBundleProductId);
			commit('updateCartItems', response.data.cart_bundle);
			return response;
		} catch (error) {
			console.error(error);
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

	removeBundleFromCart(state, cart_bundle_id) {
		state.items = state.items.filter((item) => item.id !== cart_bundle_id);
	},

	setActiveCart(state, cart) {
		state.active = cart;
	},

	setCartItems(state, cart) {
		state.items = cart;
	},

	setCheckoutStatus(state, status) {
		state.checkoutStatus = status;
	},

	setIsOpen(state, value) {
		state.isOpen = value;
	},

	updateCartItems(state, cartBundle) {
		state.items = state.items.map((item) => (item.id === cartBundle.id ? cartBundle : item));
	}
};

export default {
	namespaced: true,
	state,
	getters,
	actions,
	mutations
};
