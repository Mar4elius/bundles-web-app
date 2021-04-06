<template>
	<div class="bg-white rounded-md p-4 md:p-6">
		<div class="container mx-auto">
			<div class="md:flex">
				<div class="w-full h-64 md:w-1/2 lg:h-96">
					<img
						class="h-full w-full rounded-md object-cover max-w-xl"
						:src="data.bundle.image_path"
						:alt="data.bundle.name"
					/>
				</div>

				<div class="w-full max-w-lg mx-auto mt-5 md:ml-8 md:mt-0 md:w-1/2">
					<h3 class="text-indigo-600 uppercase">{{ data.bundle.name }}</h3>
					<span class="text-gray-500 mt-3">{{
						data.bundle.price ? `$${data.bundle.price / 100}` : 'Calculating...'
					}}</span>

					<hr class="my-3" />

					<div class="mt-2">
						<p>{{ data.bundle.description }}</p>
					</div>

					<div class="mt-2">
						<h4>Includes:</h4>
						<bundle-products-list :products="data.bundle.products" />
					</div>

					<div class="mt-2">
						<label class="text-gray-700 text-sm" for="count">Count:</label>
						<div class="flex items-center mt-1">
							<button class="text-gray-500 focus:outline-none focus:text-gray-600">
								<svg
									class="h-5 w-5"
									fill="none"
									stroke-linecap="round"
									stroke-linejoin="round"
									stroke-width="2"
									viewBox="0 0 24 24"
									stroke="currentColor"
								>
									<path d="M12 9v3m0 0v3m0-3h3m-3 0H9m12 0a9 9 0 11-18 0 9 9 0 0118 0z"></path>
								</svg>
							</button>
							<span class="text-gray-700 text-lg mx-2">{{ count }}</span>
							<button class="text-gray-500 focus:outline-none focus:text-gray-600">
								<svg
									class="h-5 w-5"
									fill="none"
									stroke-linecap="round"
									stroke-linejoin="round"
									stroke-width="2"
									viewBox="0 0 24 24"
									stroke="currentColor"
								>
									<path d="M15 12H9m12 0a9 9 0 11-18 0 9 9 0 0118 0z"></path>
								</svg>
							</button>
						</div>
					</div>
					<div class="flex items-center mt-6">
						<button
							class="px-8 py-2 bg-indigo-600 text-white text-sm font-medium rounded hover:bg-indigo-500 focus:outline-none focus:bg-indigo-500"
						>
							Order Now
						</button>
						<button class="mx-2 text-gray-600 border rounded-md p-2 hover:bg-gray-200 focus:outline-none">
							<svg
								class="h-5 w-5"
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
						</button>
					</div>
				</div>
			</div>
		</div>
	</div>
</template>

<script>
	// Vue
	import { onMounted, reactive, ref } from 'vue';
	import { useStore } from 'vuex';
	// Components
	import BundleProductsList from '@/Components/App/Bundle/BundleProductsList';
	export default {
		props: {
			bundleSlug: {
				type: String,
				required: true
			}
		},

		components: {
			BundleProductsList
		},

		setup(props) {
			const store = useStore();
			const data = reactive({ bundle: {} });
			const count = ref(1);

			async function getBundleDetails() {
				const response = await store.dispatch('bundles/getBundleDetails', props.bundleSlug);
				data.bundle = response.data.bundle;
			}

			onMounted(getBundleDetails());

			return {
				count,
				data
			};
		}
	};
</script>
