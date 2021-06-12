import axios from 'axios';

const AddressApi = {
	/**
	 * Store new address
	 *
	 * @param payload
	 *
	 * @return JSON response
	 */
	store: (payload) => axios.post('api/v1/addresses', payload),

	/**
	 * Update address
	 *
	 * @param payload
	 *
	 * @return JSON response
	 */
	update: ({ id, ...payload }) => axios.patch(`api/v1/addresses/${id}`, payload),

	/**
	 * Delete address
	 *
	 * @param payload
	 *
	 * @return JSON response
	 */
	destroy: ({ id, ...payload }) => axios.delete(`api/v1/addresses/${id}`)
};

export default AddressApi;
