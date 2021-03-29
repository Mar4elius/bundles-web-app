import axios from 'axios';

const bundlesApi = {
	filterBundles: (name) =>
		axios.get('/api/v1/bundles', {
			params: {
				term: name
			}
		})
};

export default bundlesApi;
