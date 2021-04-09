<template>
	<button
		:disabled="isDisabled"
		@click="(event) => $emit('btnOnClickEvent', event)"
		class="text-gray-500 focus:outline-none focus:text-gray-600 hover:text-indigo-600"
	>
		<slot></slot>
	</button>
</template>

<script>
	export default {
		props: {
			isDisabled: {
				type: Boolean,
				default: false
			}
		},

		setup() {
			return {};
		}
	};
</script>
