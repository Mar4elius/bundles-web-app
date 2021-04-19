<template>
	<inertia-link :href="href" :as="button" :class="classes" :method="method">
		<slot></slot>
	</inertia-link>
</template>

<script>
	import { computed } from '@vue/runtime-core';
	export default {
		props: ['href', 'classes', 'method'],

		setup(props) {
			const requests = ['POST', 'PUT', 'PATCH', 'DELETE'];

			let isButton = computed(() => (requests.includes(props.method) ? 'link' : 'button'));
			console.log(isButton);
			return {
				isButton
			};
		}
	};
</script>
