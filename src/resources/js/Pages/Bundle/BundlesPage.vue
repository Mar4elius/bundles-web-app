<template>
	<app-layout>
		<template v-slot:main>
			<div class="max-w-7xl mx-auto sm:px-6 lg:px-8 my-8">
				<h1 class="ml-0">Bundles</h1>
				<p>
					Our Bundles are limited-time collections of games, books, software, and more. Simply pay what you
					want and choose where your money goes, including to charity. Most Bundles come in tiers starting at
					only $1 - the more you give, the more you get!
				</p>
				<div class="flex justify-start w-full mt-6">
					<v-button
						id="all"
						:is-rounded="true"
						size="small"
						:classes="`mr-4`"
						@btnOnClickEvent="filterBundles"
						>All</v-button
					>
					<v-button
						:is-rounded="true"
						size="small"
						:classes="`mr-4`"
						v-for="section in sections"
						:key="section.slug"
						@btnOnClickEvent="filterBundles"
						:id="section.slug"
					>
						{{ section.name }}
					</v-button>
				</div>
			</div>
		</template>
	</app-layout>
</template>

<script>
	// vue
	import { useStore } from 'vuex';
	import { ref, onMounted } from '@vue/runtime-core';
	// Components
	import AppLayout from '@/Layouts/AppLayout';
	import vButton from '@/Components/Forms/VButton';
	export default {
		components: {
			AppLayout,
			vButton
		},

		props: {
			sections: {
				type: Array,
				require: true
			}
		},

		setup() {
			const store = useStore();
			let bundles = ref([]);

			async function filterBundles(btnId) {
				const { data } = await store.dispatch('bundles/filterBundles', btnId);
				bundles.value = [...data.bundles];
			}

			onMounted(filterBundles('all'));

			return {
				bundles,
				filterBundles
			};
		}
	};
</script>

AppLayout
