// where we assemble modules and export the store

import { createStore, createLogger } from 'vuex';
import loader from './modules/loader';
import cart from './modules/cart';
import products from './modules/products';
import bundles from './modules/bundles';

const debug = process.env.NODE_ENV !== 'production';

export default createStore({
	modules: {
		bundles,
		cart,
		loader,
		products
	},
	strict: debug,
	plugins: debug ? [createLogger()] : []
});
