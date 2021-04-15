<template>
	<label class="block text-md font-medium text-gray-700 mb-2 md:mb-3">
		<span v-if="value">{{ value }}</span>
		<span v-else><slot></slot></span>
	</label>
</template>

<script>
	export default {
		props: {
			value: {
				type: String,
				required: true
			}
		}
	};
</script>
