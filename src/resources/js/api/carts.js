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
	 *  Get cart's data (bundles and their products)
	 *
	 * @param {Object} payload
	 *
	 * @returns
	 */
	storeCartBundle: (payload) => axios.post('/api/v1/cart-bundles/', payload)
};

export default cartsApi;
