<template>
	<h3 class="text-indigo-600">Sort by:</h3>
	<div class="flex flex-wrap">
		<div v-for="(sort, index) in availableSorts" :key="sort.group_name" class="flex items-center">
			<h4 class="mr-4 md:mr-6">{{ capitalizeFirstLetter(sort.group_name) }}:</h4>
			<label
				v-for="order in sort.orders"
				:key="sort + order"
				:for="order.id"
				class="hover:text-indigo-600"
				:class="[selectedSorts[index].order === order.value ? 'text-indigo-600' : '']"
			>
				<svg-hero-icon v-if="order.value === 'desc'">
					<input
						type="radio"
						:id="order.id"
						:name="order.name"
						value="desc"
						class="absolute w-0 h-0 opacity-0"
						v-model="selectedSorts[index].order"
						@click="sortBundles()"
					/>
					<svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
						<path
							stroke-linecap="round"
							stroke-linejoin="round"
							stroke-width="2"
							d="M9 11l3-3m0 0l3 3m-3-3v8m0-13a9 9 0 110 18 9 9 0 010-18z"
						/>
					</svg>
				</svg-hero-icon>
				<svg-hero-icon v-else>
					<input
						type="radio"
						:id="order.id"
						:name="order.name"
						value="asc"
						class="absolute w-0 h-0 opacity-0"
						v-model="selectedSorts[index].order"
						@click="sortBundles()"
					/>
					<svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
						<path
							stroke-linecap="round"
							stroke-linejoin="round"
							stroke-width="2"
							d="M15 13l-3 3m0 0l-3-3m3 3V8m0 13a9 9 0 110-18 9 9 0 010 18z"
						/>
					</svg>
				</svg-hero-icon>
			</label>
		</div>
	</div>
</template>

<script>
	// Vue
	import { onMounted, readonly, ref } from 'vue';
	import { useStore } from 'vuex';
	// Components
	import SvgHeroIcon from '@/Components/Support/SvgHeroIcon';
	// Functions
	import { capitalizeFirstLetter } from '@/helpers.js';
	export default {
		components: {
			SvgHeroIcon
		},

		setup(props, { emit }) {
			const store = useStore();
			let availableSorts = ref([]);
			let selectedSorts = ref([]);

			async function getSortOptions() {
				const { data } = await store.dispatch('bundles/getSortOptions');
				availableSorts.value = data.sorts;
				selectedSorts.value = data.sorts.map((sort) => {
					return {
						name: sort.group_name,
						order: null
					};
				});
			}

			function sortBundles() {
				// silly hack that makes sure that selectedSorts array v-model is updated before emit
				// function fires
				setTimeout(() => {
					emit('radioBtnOnClickEvent', readonly(selectedSorts.value));
				}, 100);
			}

			onMounted(getSortOptions());

			return {
				availableSorts,
				capitalizeFirstLetter,
				selectedSorts,
				sortBundles
			};
		}
	};
</script>
