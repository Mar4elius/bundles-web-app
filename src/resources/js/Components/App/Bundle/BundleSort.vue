<template>
	<div class="flex flex-col h-full">
		<h3 class="text-indigo-600">Sort by:</h3>
		<div class="flex justify-around sm:flex-wrap sm:content-start md:justify-between flex-grow">
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
						<svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
							<path
								d="M3 3a1 1 0 000 2h11a1 1 0 100-2H3zM3 7a1 1 0 000 2h7a1 1 0 100-2H3zM3 11a1 1 0 100 2h4a1 1 0 100-2H3zM15 8a1 1 0 10-2 0v5.586l-1.293-1.293a1 1 0 00-1.414 1.414l3 3a1 1 0 001.414 0l3-3a1 1 0 00-1.414-1.414L15 13.586V8z"
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
						<svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
							<path
								d="M3 3a1 1 0 000 2h11a1 1 0 100-2H3zM3 7a1 1 0 000 2h5a1 1 0 000-2H3zM3 11a1 1 0 100 2h4a1 1 0 100-2H3zM13 16a1 1 0 102 0v-5.586l1.293 1.293a1 1 0 001.414-1.414l-3-3a1 1 0 00-1.414 0l-3 3a1 1 0 101.414 1.414L13 10.414V16z"
							/>
						</svg>
					</svg-hero-icon>
				</label>
			</div>
		</div>
		<div class="text-right">
			<v-button-filled classes="w-40" id="reset-button" @btnOnClickEvent="resetSorts()">Reset</v-button-filled>
		</div>
	</div>
</template>

<script>
	// Vue
	import { onMounted, readonly, ref } from 'vue';
	import { useStore } from 'vuex';
	// Components
	import SvgHeroIcon from '@/Components/Support/SvgHeroIcon';
	import VButtonFilled from '@/Components/Forms/VButtonFilled';
	// Functions
	import { capitalizeFirstLetter } from '@/helpers.js';

	export default {
		components: {
			SvgHeroIcon,
			VButtonFilled
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

			function resetSorts() {
				// so radio buttons stil get the data
				selectedSorts.value = [...availableSorts.value].map((sort) => {
					return {
						name: sort.group_name,
						order: null
					};
				});
				emit('radioBtnOnClickEvent');
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
				resetSorts,
				selectedSorts,
				sortBundles
			};
		}
	};
</script>
