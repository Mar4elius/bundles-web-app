import axios from 'axios';

const bundlesApi = {
	filterBundles: (name) =>
		axios.get('/api/v1/bundles/filter', {
			params: {
				term: name
			}
		}),

	sortBundles: (sortBy) =>
		axios.get('/api/v1/bundles/sort', {
			params: {
				sort_by: sortBy
			}
		})
};

export default bundlesApi;
