import axios from 'axios';

const bundlesApi = {
	searchBundles: (params) =>
		axios.get('/api/v1/bundles/search', {
			params: {
				params: params
			}
		}),

	getTopTenBundles: (sortBy) =>
		axios.get('/api/v1/bundles/top-ten', {
			params: {
				sort_by: sortBy
			}
		}),

	getFilterOptions: () => axios.get('/api/v1/bundles/filter-options')
};

export default bundlesApi;
