import axios from 'axios';

const bundlesApi = {
	searchBundles: (payload) =>
		axios.get('/api/v1/bundles/search', {
			params: payload
		}),

	getTopTenBundles: (sortBy) =>
		axios.get('/api/v1/bundles/top-ten', {
			params: {
				sort_by: sortBy
			}
		}),

	getFilterOptions: () => axios.get('/api/v1/bundles/filter-options', { showLoader: false }),
	getSortOptions: () => axios.get('/api/v1/bundles/sort-options', { showLoader: false })
};

export default bundlesApi;
