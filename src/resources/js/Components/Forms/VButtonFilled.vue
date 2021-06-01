<template>
	<button :id="id" :type="type" :class="combinedClasses" :disabled="isDisabled" @click="handelOnClickEvent($event)">
		<slot></slot>
	</button>
</template>

<script>
	import { computed, ref, watch } from '@vue/runtime-core';
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
			let defaultClasses = ref(
				`text-white font-bold uppercase shadow hover:shadow-md transition-all duration-150 focus:outline-none focus:ring-2`
			);

			const type = computed(() => (props.isDisabled ? 'disabled' : props.type));

			// set button color
			switch (type.value) {
				case 'disabled':
					defaultClasses.value += ' bg-gray-600 hover:bg-gray-700 focus:border-gray-600 cursor-not-allowed ';
					break;
				case 'primary':
					defaultClasses.value += ' bg-indigo-600 hover:bg-indigo-700 focus:border-indigo-600';
					break;
				case 'success':
					defaultClasses.value += ' bg-emerarld-600 hover:bg-emerarld-700 focus:border-emerald-600';
					break;
				case 'danger':
					defaultClasses.value += ' bg-red-600 hover:bg-red-700 focus:border-red-600';
					break;
				case 'warning':
					defaultClasses.value += ' bg-amber-600 hover:bg-amber-700 focus:border-amber-600';
					break;
			}
			// set button size
			switch (props.size) {
				case 'x-small':
					defaultClasses.value += ' px-2 py-1 text-xs';
					break;
				case 'small':
					defaultClasses.value += ' px-4 py-2';
					break;
				case 'regular':
					defaultClasses.value += ' px-6 py-3';
					break;
				case 'large':
					defaultClasses.value += ' px-8 py-3';
					break;
				default:
					defaultClasses.value += ' px-4 py-2 md:px-6 md:py-3 lg:px-8';
					break;
			}
			// set button shape
			props.isRounded ? (defaultClasses.value += ' rounded-full') : (defaultClasses.value += ' rounded');

			const combinedClasses = computed(() => defaultClasses.value.concat(' ' + props.classes));

			function handelOnClickEvent(e) {
				emit('btnOnClickEvent', e.target.id);
			}

			watch(
				() => type.value,
				(curr, prev) => {
					// set button color
					defaultClasses.value = `text-white font-bold uppercase shadow hover:shadow-md transition-all duration-150 focus:outline-none focus:ring-2`;
					switch (curr) {
						case 'disabled':
							defaultClasses.value +=
								' bg-gray-600 hover:bg-gray-700 focus:border-gray-600 cursor-not-allowed ';
							break;
						case 'primary':
							defaultClasses.value += ' bg-indigo-600 hover:bg-indigo-700 focus:border-indigo-600';
							break;
						case 'success':
							defaultClasses.value += ' bg-emerarld-600 hover:bg-emerarld-700 focus:border-emerald-600';
							break;
						case 'danger':
							defaultClasses.value += ' bg-red-600 hover:bg-red-700 focus:border-red-600';
							break;
						case 'warning':
							defaultClasses.value += ' bg-amber-600 hover:bg-amber-700 focus:border-amber-600';
							break;
					}

					// set button size
					switch (props.size) {
						case 'x-small':
							defaultClasses.value += ' px-2 py-1 text-xs';
							break;
						case 'small':
							defaultClasses.value += ' px-4 py-2';
							break;
						case 'regular':
							defaultClasses.value += ' px-6 py-3';
							break;
						case 'large':
							defaultClasses.value += ' px-8 py-3';
							break;
						default:
							defaultClasses.value += ' px-4 py-2 md:px-6 md:py-3 lg:px-8';
							break;
					}

					// set button shape
					props.isRounded ? (defaultClasses.value += ' rounded-full') : (defaultClasses.value += ' rounded');
				}
			);

			return {
				combinedClasses,
				handelOnClickEvent
			};
		}
	};
</script>
