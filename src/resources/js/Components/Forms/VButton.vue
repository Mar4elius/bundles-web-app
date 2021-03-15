<template>
	<button :type="button" :class="combinedClasses" :disabled="isDisabled">
		<slot></slot>
	</button>
</template>

<script>
	import { computed } from '@vue/runtime-core';
	export default {
		props: {
			onClick: {
				type: Function,
				required: true
			},

			type: {
				type: String,
				default: 'button'
			},

			classes: {
				type: String,
				default: ' '
			},

			isDisabled: {
				type: Boolean,
				default: false
			}
		},

		setup(props) {
			let defaultClasses = `px-8 py-3 border border-transparent text-base font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 md:py-4 md:text-lg md:px-10 `;

			const combinedClasses = computed(() => defaultClasses.concat(props.classes));

			return {
				combinedClasses
			};
		}
	};
</script>
