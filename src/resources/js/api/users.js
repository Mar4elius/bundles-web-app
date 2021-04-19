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
	login: (payload) => axios.post('/login', payload),

	/**
	 * Logout user
	 *
	 * @param {Object} payload
	 *
	 * @returns
	 */
	logout: () => axios.post('/logout')
};

export default usersApi;
