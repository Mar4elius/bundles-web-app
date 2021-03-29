// where we assemble modules and export the store

import { createStore, createLogger } from 'vuex';
import cart from './modules/cart';
import products from './modules/products';
import bundles from './modules/bundles';

const debug = process.env.NODE_ENV !== 'production';

export default createStore({
	modules: {
		cart,
		products,
		bundles
	},
	strict: debug,
	plugins: debug ? [createLogger()] : []
});
