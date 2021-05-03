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
	 * Update user personal data
	 *
	 * @param {Object}
	 * @param {Object} activeUser
	 * @param {FormData} formData
	 *
	 * @returns
	 */
	// IMPORTANT Have to use post method because incoming data and payload will be instance of the FormData class.
	// PHP does not parse multi part form data unless the request method is POST: https://bugs.php.net/bug.php?id=55815
	// https://stackoverflow.com/questions/47676134/laravel-request-all-is-empty-using-multipart-form-data
	update: (payload) => axios.post(`/api/v1/user/${payload.activeUser.id}`, payload.formData),

	/**
	 * Update user password
	 *
	 * @param {Object} payload
	 *
	 * @returns
	 */
	updatePassword: (payload) => axios.put('/user/password', payload)
};

export default usersApi;
