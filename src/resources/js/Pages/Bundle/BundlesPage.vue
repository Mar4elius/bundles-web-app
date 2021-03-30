<template>
	<app-layout>
		<template v-slot:main>
			<h1>Bundles</h1>
			<p>
				Our Bundles are limited-time collections of games, books, software, and more. Simply pay what you want
				and choose where your money goes, including to charity. Most Bundles come in tiers starting at only $1 -
				the more you give, the more you get!
			</p>

			<div class="flex justify-start items-center flex-wrap w-full">
				<v-button
					id="all"
					:is-rounded="true"
					size="small"
					:classes="`mr-4 mt-8`"
					@btnOnClickEvent="filterBundles"
					>All</v-button
				>
				<v-button
					:is-rounded="true"
					size="small"
					:classes="`mr-4 mt-8`"
					v-for="section in sections"
					:key="section.slug"
					@btnOnClickEvent="filterBundles"
					:id="section.slug"
				>
					{{ section.name }}
				</v-button>
			</div>

			<div class="bg-white rounded-md">
				<div v-for="section in sectionBundles" :key="section.id" class="my-8">
					<h3 class="p-4 md:p-6">{{ section.name }}</h3>
					<div class="grid grid-cols-1 md:grid-cols-3 md:gap-4">
						<bundle-tile-short v-for="bundle in section.bundles" :bundle="bundle" :key="bundle.slug" />
					</div>
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
	import BundleTileShort from '@/Components/App/BundleTileShort';
	export default {
		components: {
			AppLayout,
			BundleTileShort,
			vButton
		},

		props: {
			sections: {
				type: Array,
				require: true
			}
		},

		setup(props) {
			const store = useStore();
			let sectionBundles = ref([]);

			async function filterBundles(btnId) {
				const { data } = await store.dispatch('bundles/filterBundles', btnId);
				sectionBundles.value = [...data.bundles];
			}

			onMounted(filterBundles('all'));

			return {
				sectionBundles,
				filterBundles
			};
		}
	};
</script>

AppLayout
