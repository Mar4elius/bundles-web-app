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
	 * @returns
	 */
	logout: () => axios.post('/logout'),

	/**
	 * Send verification email to logged in user
	 *
	 * @returns
	 */
	sendEmailVerification: () => axios.post('/email/verification-notification')
};

export default usersApi;
