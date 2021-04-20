import axios from 'axios';

const authApi = {
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
	sendEmailVerification: () => axios.post('/email/verification-notification'),

	/**
	 * Send verification email to logged in user
	 *
	 * @param {Object} payload
	 *
	 * @returns
	 */
	forgotPassword: () => axios.post('/forgot-password')
};

export default authApi;
