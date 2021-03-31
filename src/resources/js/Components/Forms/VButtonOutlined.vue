<template>
	<button :id="id" :type="type" :class="combinedClasses" :disabled="isDisabled" @click="handelOnClickEvent($event)">
		<slot></slot>
	</button>
</template>

<script>
	import { computed, toRefs } from '@vue/runtime-core';
	export default {
		props: {
			classes: {
				type: String,
				default: ' '
			},

			id: {
				type: String,
				required: true
			},

			isDisabled: {
				type: Boolean,
				default: false
			},

			isRounded: {
				type: Boolean,
				default: false
			},

			isActive: {
				type: Boolean,
				default: false
			},

			type: {
				type: String,
				default: 'primary',
				validator: function (value) {
					return ['success', 'warning', 'danger', 'disabled', 'primary'].includes(value.toLowerCase());
				}
			},

			size: {
				type: String,
				default: 'all',
				validator: function (value) {
					return ['x-small', 'small', 'regular', 'large', 'all'].includes(value.toLowerCase());
				}
			}
		},

		setup(props, { emit }) {
			let defaultClasses = `border border-solid border-2 bg-transparent font-bold uppercase shadow hover:shadow-md hover:text-white transition-all duration-150 focus:outline-none focus:ring-2`;
			// set button color
			switch (props.type) {
				case 'disabled':
					defaultClasses +=
						' text-blueGray border-blueGray-600 hover:bg-blueGray-700 focus:border-blueGray-600 ';
					break;
				case 'primary':
					defaultClasses += ' text-ingido border-indigo-600 hover:bg-indigo-700 focus:border-indigo-600';
					break;
				case 'success':
					defaultClasses +=
						' text-emerald border-emerarld-600 hover:bg-emerarld-700 focus:border-emerald-600';
					break;
				case 'danger':
					defaultClasses += ' text-red border-red-600 hover:bg-red-700 focus:border-red-600';
					break;
				case 'warning':
					defaultClasses += ' text-amber border-amber-600 hover:bg-amber-700 focus:border-amber-600';
					break;
			}
			// set button size
			switch (props.size) {
				case 'x-small':
					defaultClasses += ' px-2 py-1 text-xs';
					break;
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
			// set button shape
			props.isRounded ? (defaultClasses += ' rounded-full') : (defaultClasses += ' rounded');

			const combinedClasses = computed(() => defaultClasses.concat(' ' + props.classes));

			function handelOnClickEvent(e) {
				emit('btnOnClickEvent', e.target.id);
			}

			return {
				combinedClasses,
				handelOnClickEvent
			};
		}
	};
</script>
