<template>
	<div class="bg-white rounded-md p-4 my-6 md:p-6 md:my-8">
		<div class="container mx-auto">
			<div class="md:flex items-center">
				<div class="w-full h-64 md:w-1/2 lg:h-96 flex justify-center">
					<img
						class="h-full w-full rounded-md object-cover max-w-xl"
						:src="data.bundle.image_path"
						:alt="data.bundle.name"
					/>
				</div>

				<div class="w-full max-w-lg mx-auto mt-5 md:ml-8 md:mt-0 md:w-1/2">
					<h3 class="text-indigo-600 uppercase">{{ data.bundle.name }}</h3>
					<span class="text-gray-500 mt-3">{{
						data.bundle.price ? calculatePrice(totalBundlePrice) : 'Calculating...'
					}}</span>

					<hr class="my-3" />

					<div class="mt-2">
						<p>{{ data.bundle.description }}</p>
					</div>

					<div class="mt-2">
						<h4 class="text-indigo-600">Includes:</h4>
						<bundle-products-list
							:products="data.bundle.products"
							@incrementQuantityBtnClick="incrementProductCount"
							@decrementQuantityBtnClick="decrementProductCount"
						/>
					</div>

					<div class="mt-2">
						<div class="flex items-center mt-1">
							<v-button-icon @btnOnClickEvent="incrementCount()">
								<svg-hero-icon>
									<svg
										fill="none"
										stroke-linecap="round"
										stroke-linejoin="round"
										stroke-width="2"
										viewBox="0 0 24 24"
										stroke="currentColor"
									>
										<path d="M12 9v3m0 0v3m0-3h3m-3 0H9m12 0a9 9 0 11-18 0 9 9 0 0118 0z"></path>
									</svg>
								</svg-hero-icon>
							</v-button-icon>
							<!-- use separate variable so not to interfier with shopping cart quantities -->
							<span class="mx-2">{{ quantity }}</span>
							<v-button-icon @btnOnClickEvent="decrementCount()">
								<svg-hero-icon>
									<svg
										fill="none"
										stroke-linecap="round"
										stroke-linejoin="round"
										stroke-width="2"
										viewBox="0 0 24 24"
										stroke="currentColor"
									>
										<path d="M15 12H9m12 0a9 9 0 11-18 0 9 9 0 0118 0z"></path>
									</svg>
								</svg-hero-icon>
							</v-button-icon>
						</div>
					</div>
					<div class="flex items-center mt-6">
						<v-button-filled
							id="order-now"
							classes="w-32 flex justify-center"
							@btnOnClickEvent="pushProductToCart"
						>
							<svg
								class="w-6 md:w-8"
								fill="none"
								stroke-linecap="round"
								stroke-linejoin="round"
								stroke-width="2"
								viewBox="0 0 24 24"
								stroke="currentColor"
							>
								<path
									d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"
								></path>
							</svg>
						</v-button-filled>
					</div>
				</div>
			</div>
		</div>
	</div>
</template>

<script>
	// Vue
	import { computed, onMounted, reactive, ref } from 'vue';
	import { useStore } from 'vuex';
	// Components
	import BundleProductsList from '@/Components/App/Bundle/BundleProductsList';
	import VButtonFilled from '@/Components/Forms/VButtonFilled';
	import VButtonIcon from '@/Components/Forms/VButtonIcon';
	import SvgHeroIcon from '@/Components/Support/SvgHeroIcon';
	// Helpers
	import { calculatePrice, randomAlphaNumericString } from '@/helpers.js';
	import { useToast } from 'vue-toastification';
	export default {
		props: {
			bundleSlug: {
				type: String,
				required: true
			}
		},

		components: {
			BundleProductsList,
			VButtonIcon,
			VButtonFilled,
			SvgHeroIcon
		},

		setup(props) {
			const store = useStore();
			const toast = useToast();
			const data = reactive({ bundle: {} });
			const quantity = ref(1);
			const totalBundlePrice = computed(() => {
				return data.bundle?.products?.reduce((total, product) => {
					return total + product.price * product.quantity;
				}, 0);
			});
			const activeCart = computed(() => store.state.cart.active);

			async function getBundleDetails() {
				const response = await store.dispatch('bundles/getBundleDetails', props.bundleSlug);
				// add quantity to the bundle so we can track how many user wants to buy
				data.bundle = {
					...response.data.bundle,
					quantity: 1
				};
				// add quantity to the bundle product so we can track how many of products user wants in the bundle
				data.bundle.products = data.bundle.products.map((product) => {
					return {
						...product,
						is_active: true,
						quantity: product.pivot.default_quantity
					};
				});
			}

			function incrementCount() {
				quantity.value++;
			}

			function incrementProductCount(product) {
				const index = data.bundle.products.findIndex((p) => p.id === product.id);
				data.bundle.products[index].quantity++;
			}

			function decrementProductCount(product) {
				const index = data.bundle.products.findIndex((p) => p.id === product.id);
				if (data.bundle.products[index].quantity > 0) {
					data.bundle.products[index].quantity--;
				}
			}

			function decrementCount() {
				if (quantity.value > 1) {
					quantity.value--;
				}
			}

			async function pushProductToCart() {
				// check if at all cart bundle product are 0. If yes return error
				const areAllBundleItems0 = data.bundle.products.every((p) => p.quantity === 0);
				if (areAllBundleItems0) {
					toast.error('At least one of the bundle items should have quantity more then 0.');
					return;
				}
				// break vue reactivity
				let bundle = JSON.parse(
					JSON.stringify({
						...data.bundle,
						price: totalBundlePrice.value,
						products: data.bundle.products.filter((p) => p.is_active), // get only active products
						quantity: quantity.value,
						cart_id: activeCart.value?.id
					})
				);

				if (activeCart.value?.id) {
					// create new cart item and attach it to the cart
					await store.dispatch('cart/storeCartBundle', bundle);
				} else {
					// create new cart
					await store.dispatch('cart/store', bundle);
				}

				// create new cart
				// user wasn't logged in create a cookie so we can retrieve his cart when they come back
				if (!activeCart.value.user_id) {
					const oneMonthFromNow = new Date();
					oneMonthFromNow.setDate(oneMonthFromNow.getDate() + 30);
					document.cookie = `bundle_cart_id=${activeCart.value.id};expires=${oneMonthFromNow};path=/`;
				}
			}

			onMounted(getBundleDetails());

			return {
				calculatePrice,
				data,
				decrementCount,
				decrementProductCount,
				incrementCount,
				incrementProductCount,
				pushProductToCart,
				totalBundlePrice,
				quantity
			};
		}
	};
</script>
