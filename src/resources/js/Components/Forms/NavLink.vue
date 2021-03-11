<template>
	<inertia-link :href="href" :class="classes">
		<slot></slot>
	</inertia-link>
</template>

<script>
	export default {
		props: ['href', 'active'],

		computed: {
			classes() {
				return this.active
					? 'bg-gray-900 text-white block px-3 py-2 rounded-md text-base font-medium'
					: 'text-gray-300 hover:bg-gray-700 hover:text-white block px-3 py-2 rounded-md text-base font-medium';
			}
		}
	};
</script>
