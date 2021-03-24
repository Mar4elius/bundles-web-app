<template>
	<button :type="type" :class="combinedClasses" :disabled="isDisabled">
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
				default: 'primary',
				validator: function (value) {
					return ['success', 'warning', 'danger', 'disabled'].includes(value.toLowerCase);
				}
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
			// let defaultClasses = `px-8 py-3 border border-transparent text-base font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 md:py-4 md:text-lg md:px-10 `;
			let defaultClasses = `text-white px-4 py-2 md:px-6 md:py-3 lg:px-8 py-3 font-bold uppercase rounded shadow hover:shadow-md outline-none transition-all duration-150`;

			switch (props.type) {
				case 'disabled':
					defaultClasses += ' bg-blueGray-500';
					break;
				case 'primary':
					defaultClasses += ' bg-indigo-600';
				case 'success':
					defaultClasses += ' bg-emerarld-600';
				case 'danger':
					defaultClasses += ' bg-red-600';
				case 'warning':
					defaultClasses += ' bg-amber-600';
			}

			const combinedClasses = computed(() => defaultClasses.concat(props.classes));

			return {
				combinedClasses
			};
		}
	};
</script>
