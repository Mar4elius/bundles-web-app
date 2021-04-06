<template>
	<app-layout>
		<template v-slot:main>
			<h1>Hell</h1>
			{{ data }}
		</template>
	</app-layout>
</template>
<script>
	// Vue
	import { onMounted, reactive } from 'vue';
	import { useStore } from 'vuex';
	// Components
	import AppLayout from '@/Layouts/AppLayout';

	export default {
		components: {
			AppLayout
		},

		props: {
			bundle: {
				type: Object,
				required: true
			}
		},

		setup(props) {
			const store = useStore();
			const data = reactive({ bundle: {} });

			async function getBundleDetails() {
				const response = await store.dispatch('bundles/getBundleDetails', props.bundle.slug);
				data.bundle = response.data.bundle_details;
			}

			onMounted(getBundleDetails());

			return {
				data
			};
		}
	};
</script>
