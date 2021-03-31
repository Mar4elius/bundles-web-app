import axios from 'axios';

const bundlesApi = {
	searchBundles: (params) =>
		axios.get('/api/v1/bundles/search', {
			params: {
				params: params
			}
		}),

	getTopTenBundles: (sortBy) =>
		axios.get('/api/v1/bundles/get-top-ten', {
			params: {
				sort_by: sortBy
			}
		})
};

export default bundlesApi;
