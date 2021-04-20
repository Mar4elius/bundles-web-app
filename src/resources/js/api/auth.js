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
	 * Send link for resetting a password
	 *
	 * @param {Object} payload
	 *
	 * @returns
	 */
	sendForgotPasswordLink: (payload) => axios.post('/forgot-password', payload),

	/**
	 * Reset password
	 *
	 * @param {Object} payload
	 *
	 * @returns
	 */
	resetPassword: (payload) => axios.post('/reset-password', payload)
};

export default authApi;
