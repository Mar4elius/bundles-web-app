import axios from 'axios';

const productsApi = {
	getAllProducts: () => axios.get('/api/v1/products/all')
};

export default productsApi;
