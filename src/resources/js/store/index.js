// where we assemble modules and export the store

import { createStore, createLogger } from 'vuex';
import address from './modules/address';
import auth from './modules/auth';
import bundles from './modules/bundles';
import cart from './modules/cart';
import loader from './modules/loader';
import options from './modules/options';
import products from './modules/products';
import users from './modules/users';

const debug = process.env.NODE_ENV !== 'production';

export default createStore({
	modules: {
		address,
		auth,
		bundles,
		cart,
		loader,
		options,
		products,
		users
	},
	strict: debug,
	plugins: debug ? [createLogger()] : []
});
