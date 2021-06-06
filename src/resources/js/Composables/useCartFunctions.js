// Vue
import { useStore } from 'vuex';
import { computed } from 'vue';
// Helpers
import { calculatePrice } from '@/helpers.js';

export default function useCartFunctions() {
	const store = useStore();
	let cartBundles = computed(() => store.state.cart.items);

	const cartTotalPrice = computed(() => {
		const price = cartBundles.value.reduce((curr, acc) => {
			return curr + acc.price_per_bundle * acc.quantity;
		}, 0);
		return calculatePrice(price);
	});

	const bundleHasAllProducts0 = computed(() => {
		return cartBundles.value.some((cart) => {
			return cart.products.every((product) => product.pivot.quantity === 0);
		});
	});

	const cartTotalBundles = computed(() => {
		return cartBundles.value.reduce((curr, acc) => {
			return curr + acc.quantity;
		}, 0);
	});

	// bundle qnt change
	async function incrementBundleCount(bundle) {
		const data = {
			cart_bundle_id: bundle.id,
			increment_qnt: true
		};
		await store.dispatch('cart/updateCartBundle', data);
	}

	async function decrementBundleCount(bundle) {
		const data = {
			cart_bundle_id: bundle.id,
			increment_qnt: false
		};
		if (bundle.quantity > 1) {
			await store.dispatch('cart/updateCartBundle', data);
		}
	}
	// \\ bundle qnt change

	// bundle product qnt change
	async function incrementProductCount(bundle, { id }) {
		console.log(id);
		console.log(bundle);
		const data = {
			cart_bundle_id: bundle.id,
			cart_bundle_product_id: id,
			increment_qnt: true
		};
		await store.dispatch('cart/updateCartBundleProduct', data);
	}

	async function decrementProductCount(bundle, { id }) {
		const data = {
			cart_bundle_id: bundle.id,
			cart_bundle_product_id: id,
			increment_qnt: false
		};
		await store.dispatch('cart/updateCartBundleProduct', data);
	}
	// \\ bundle product qnt change

	async function removeBundleFromCart(bundle) {
		// remove cart bundle from cart
		if (cartBundles.value.length > 1) {
			await store.dispatch('cart/destroyCartBundle', bundle.id);
		} else {
			// if there is 1 bundle left remove it
			await store.dispatch('cart/destroyCartBundle', bundle.id);
			// then delete cart
			await store.dispatch('cart/destroy', bundle.cart_id);
		}
	}

	function calculateProductTotalPrice(product) {
		const totalPrice = product.pivot.quantity * product.price;
		return calculatePrice(totalPrice);
	}

	return {
		cartTotalPrice,
		calculateProductTotalPrice,
		cartTotalBundles,
		bundleHasAllProducts0,
		incrementBundleCount,
		decrementBundleCount,
		incrementProductCount,
		decrementProductCount,
		removeBundleFromCart
	};
}
