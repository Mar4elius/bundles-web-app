<template>
	<div v-if="isLoading">
		<font-awesome-icon class="text-indigo-600 animate-spin" :class="classes" prefix="fas" icon="circle-notch" />
	</div>
</template>
<script>
	// Vuex
	import { computed } from 'vue';
	import { useStore } from 'vuex';
	// Components
	import FontAwesomeIcon from '@/Components/Support/FontAwesomeIcon';
	export default {
		components: {
			FontAwesomeIcon
		},

		props: {
			classes: {
				type: String,
				default: 'w-8 h-8'
			}
		},

		setup() {
			const store = useStore();
			let isLoading = computed(() => store.state.loader.loading);

			return {
				isLoading
			};
		}
	};
</script>
