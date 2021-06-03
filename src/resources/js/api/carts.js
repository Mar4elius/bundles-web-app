import axios from 'axios';

const cartsApi = {
	/**
	 *  Create new cart with bundles
	 *
	 * @param {Object} payload
	 *
	 * @returns
	 */
	store: (payload) => axios.post('/api/v1/carts', payload),

	/**
	 *  Get cart's data (bundles and their products)
	 *
	 * @param {Object} cart
	 *
	 * @returns
	 */
	show: ({ cart_id }) => axios.get(`/api/v1/carts/${cart_id}`),

	/**
	 *  Destroy cart
	 *
	 * @param {Number} cart_id
	 *
	 * @returns
	 */
	destroy: (cart_id) => axios.delete(`/api/v1/carts/${cart_id}`),

	/**
	 *  Get cart's data (bundles and their products)
	 *
	 * @param {Object} payload
	 *
	 * @returns
	 */
	storeCartBundle: (payload) => axios.post('/api/v1/cart-bundles/', payload),

	/**
	 * Destroy cart bundle that belongs to cart
	 *
	 * @param {Number} cart_bundle_id
	 *
	 * #returns
	 */
	destroyCartBundle: (cart_bundle_id) => axios.delete(`/api/v1/cart-bundles/${cart_bundle_id}`),

	/**
	 * Update cart bundle that belongs to cart
	 *
	 * @param {Object} payload
	 *
	 * #returns
	 */
	updateCartBundle: ({ cart_bundle_id, ...payload }) =>
		axios.patch(`/api/v1/cart-bundles/${cart_bundle_id}`, payload, {
			showLoader: !payload.hasOwnProperty('increment_qnt') // disable loader if user increments or decrements quantity
		}),

	/**
	 * Update cart bundle PRODUCT that belongs to cart
	 *
	 * @param {Object} payload
	 *
	 * #returns
	 */
	updateCartBundleProduct: ({ cart_bundle_id, cart_bundle_product_id, ...payload }) =>
		axios.patch(`/api/v1/cart-bundles/${cart_bundle_id}/products/${cart_bundle_product_id}`, payload, {
			showLoader: !payload.hasOwnProperty('increment_qnt') // disable loader if user increments or decrements quantity
		})
};

export default cartsApi;
