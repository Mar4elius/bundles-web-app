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
	return price.toLocaleString('en-CA', { style: 'currency', currency: 'CAD' });
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

export { capitalizeFirstLetter, calculatePrice, randomAlphaNumericString };
