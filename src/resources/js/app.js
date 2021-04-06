require('./bootstrap');

// Import modules...
import { createApp, h } from 'vue';
import { App as InertiaApp, plugin as InertiaPlugin } from '@inertiajs/inertia-vue3';
import { InertiaProgress } from '@inertiajs/progress';
import { FontAwesomeIcon } from '@/Plugins/font-awesome';
import axios from 'axios';
// Store
import store from './store/index';

// Enable loader display
axios.defaults.showLoader = true;

const el = document.getElementById('app');
createApp({
	created() {
		axios.interceptors.request.use(
			(config) => {
				if (config.showLoader) {
					store.dispatch('loader/pending');
				}
				return config;
			},
			(error) => {
				if (error.config.showLoader) {
					store.dispatch('loader/done');
				}
				return Promise.reject(error);
			}
		);
		axios.interceptors.response.use(
			(response) => {
				if (response.config.showLoader) {
					store.dispatch('loader/done');
				}

				return response;
			},
			(error) => {
				let response = error.response;

				if (response.config.showLoader) {
					store.dispatch('loader/done');
				}

				return Promise.reject(error);
			}
		);
	},
	render: () =>
		h(InertiaApp, {
			initialPage: JSON.parse(el.dataset.page),
			resolveComponent: (name) => require(`./Pages/${name}`).default
		})
})
	.mixin({ methods: { route } })
	.use(InertiaPlugin)
	.use(store)
	.component('font-awesome-icon', FontAwesomeIcon)
	.mount(el);

InertiaProgress.init({ color: '#4B5563' });
