import axios from 'axios';

const bundlesApi = {
	searchBundles: (payload) =>
		axios.get('/api/v1/bundles/search', {
			params: payload
		}),

	getAdditionalBundles: (payload) =>
		axios.get('/api/v1/bundles/additional', {
			params: payload
		}),

	getFilterOptions: () => axios.get('/api/v1/bundles/filter-options'),
	getSortOptions: () => axios.get('/api/v1/bundles/sort-options'),
	getBundleDetails: (slug) =>
		axios.get('/api/v1/bundles/show', {
			params: {
				slug: slug
			}
		})
};

export default bundlesApi;
