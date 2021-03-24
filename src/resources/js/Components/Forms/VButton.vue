<template>
	<button :type="type" :class="combinedClasses" :disabled="isDisabled" @click="handelOnClickEvent">
		<slot></slot>
	</button>
</template>

<script>
	import { computed, emit } from '@vue/runtime-core';
	export default {
		props: {
			type: {
				type: String,
				default: 'primary',
				validator: function (value) {
					return ['success', 'warning', 'danger', 'disabled', 'primary'].includes(value.toLowerCase());
				}
			},

			classes: {
				type: String,
				default: ' '
			},

			isDisabled: {
				type: Boolean,
				default: false
			},

			isRounded: {
				type: Boolean,
				default: false
			},

			size: {
				type: String,
				default: 'all',
				validator: function (value) {
					return ['small', 'regular', 'large', 'all'].includes(value.toLowerCase());
				}
			}
		},

		setup(props, { emit }) {
			// let defaultClasses = `px-8 py-3 border border-transparent text-base font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 md:py-4 md:text-lg md:px-10 `;
			let defaultClasses = `text-white font-bold uppercase shadow hover:shadow-md transition-all duration-150 focus:outline-none focus:ring-2`;
			// set button color
			switch (props.type) {
				case 'disabled':
					defaultClasses += ' bg-blueGray-600 hover:bg-blueGray-700 focus:border-blueGray-600 ';
					break;
				case 'primary':
					defaultClasses += ' bg-indigo-600 hover:bg-indigo-700 focus:border-indigo-600';
					break;
				case 'success':
					defaultClasses += ' bg-emerarld-600 hover:bg-emerarld-700 focus:border-emerald-600';
					break;
				case 'danger':
					defaultClasses += ' bg-red-600 hover:bg-red-700 focus:border-red-600';
					break;
				case 'warning':
					defaultClasses += ' bg-amber-600 hover:bg-amber-700 focus:border-amber-600';
					break;
			}

			switch (props.size) {
				case 'small':
					defaultClasses += ' px-4 py-2';
					break;
				case 'regular':
					defaultClasses += ' px-6 py-3';
					break;

				case 'large':
					defaultClasses += ' px-8 py-3';
					break;
				default:
					defaultClasses += ' px-4 py-2 md:px-6 md:py-3 lg:px-8';
					break;
			}

			props.isRounded ? (defaultClasses += ' rounded-full') : (defaultClasses += ' rounded');

			const combinedClasses = computed(() => defaultClasses.concat(' ' + props.classes));

			function handelOnClickEvent() {
				emit('btnOnClickEvent');
			}

			return {
				combinedClasses,
				handelOnClickEvent
			};
		}
	};
</script>
