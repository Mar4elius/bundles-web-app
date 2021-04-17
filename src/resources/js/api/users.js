import axios from 'axios';

const usersApi = {
	/**
	 * Store new user
	 *
	 * @param {Object} payload
	 *
	 * @returns
	 */
	store: (payload) => axios.post('/register', payload),
	/**
	 * Login user
	 *
	 * @param {Object} payload
	 *
	 * @returns
	 */
	login: (payload) => axios.post('/login', payload)
};

export default usersApi;
