import axios from 'axios';

const stripeApi = {
	/**
	 * Create payment intent
	 *
	 * @param {Object} purchase
	 *
	 * return JSON
	 */
	create: (purchase) => axios.post('api/v1/stripe/create', purchase)
};

export default stripeApi;
