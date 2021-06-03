/**
 * Capitalizes first letter of the string
 *
 * @param {String} str
 *
 * @return string
 */
function capitalizeFirstLetter(str) {
	return str.charAt(0).toUpperCase() + str.slice(1);
}

/**
 * Calculate price
 *
 * @param {Number} price
 *
 * @return Number/Decimal
 */
function calculatePrice(price) {
	price = price / 100;
	// return price.toLocaleString('en-CA', { style: 'currency', currency: 'CAD' });
	return new Intl.NumberFormat('en-CA', {
		style: 'currency',
		currency: 'CAD'
	}).format(price);
}

/**
 * Generate random alpha numeric string
 *
 * @param {Number} length
 *
 * @return String
 */
function randomAlphaNumericString(length) {
	let result = [];
	let characters = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789';
	let charactersLength = characters.length;

	for (let i = 0; i < length; i++) {
		result.push(characters.charAt(Math.floor(Math.random() * charactersLength)));
	}
	return result.join('');
}

/**
 * Get cookie from client
 *
 * @param {String} name
 *
 * @return String
 */
function getCookie(name) {
	const value = `; ${document.cookie}`;
	const parts = value.split(`; ${name}=`);
	if (parts.length === 2) return parts.pop().split(';').shift();
}

/**
 * Get first letter from user's first and last name
 *
 * @param {Object} user
 *
 * @return String
 */
function getUserInitials(user) {
	const firstNameFirstLetter = user.first_name.charAt(0).toUpperCase();
	const lastNameFirstLetter = user.last_name.charAt(0).toUpperCase();

	return `${firstNameFirstLetter}${lastNameFirstLetter}`;
}

/**
 * Get user full name
 *
 * @param {Object} user
 *
 * @return String
 */
function getUserFullName(user) {
	return `${user.first_name} ${user.last_name}`;
}

export { capitalizeFirstLetter, calculatePrice, getCookie, randomAlphaNumericString, getUserInitials, getUserFullName };
