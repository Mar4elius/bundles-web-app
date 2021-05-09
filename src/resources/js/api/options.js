import axios from 'axios';

const optionsApi = {
	/**
	 * Get all available countries
	 */
	getCountries: () => axios.get('/api/v1/options/countries'),

	/**
	 * Get country provinces
	 *
	 * @param {Object} country
	 */
	getProvinces: (country) => axios.get(`/api/v1/options/countries/${country.value}/provinces`)
};

export default optionsApi;
