<template>
	<input
		class="appearance-none border border-gray-300 placeholder-gray-500 text-gray-900 w-full px-3 py-2 rounded mb-4 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 focus:z-10 sm:text-sm"
		@input="$emit('input', $event.target.value)"
		ref="input"
		:type="type"
	/>
</template>

<script>
	export default {
		props: {
			value: {
				type: String,
				default: ''
			},
			type: {
				type: String,
				default: 'text'
			}
		},

		setup(props, { refs }) {
			function focus() {
				refs.input.focus();
			}
		}
	};
</script>
