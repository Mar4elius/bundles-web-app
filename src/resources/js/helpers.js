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

export { capitalizeFirstLetter, calculatePrice };
