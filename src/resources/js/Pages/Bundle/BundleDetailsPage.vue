<template>
	<app-layout>
		<template v-slot:main>
			<h1>hello</h1>
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
			let bundleDetails = reactive({});
			async function getBundleDetails() {
				const data = await store.dispatch('bundles/getBundleDetails', props.bundle.slug);
				console.log(data);
				bundleDetails = { ...data.bundle };
			}

			onMounted(getBundleDetails());

			return {
				bundleDetails
			};
		}
	};
</script>
