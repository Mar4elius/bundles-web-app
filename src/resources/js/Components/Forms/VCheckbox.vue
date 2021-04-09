<template>
	<input
		type="checkbox"
		:value="value"
		v-model="checked"
		class="rounded border-gray-300 text-indigo-600 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50"
	/>
</template>

<script>
	import { computed } from '@vue/runtime-core';
	export default {
		props: {
			isChecked: {
				type: Boolean,
				default: false
			},

			value: {
				default: null
			}
		},

		setup(props, { emit }) {
			const checked = computed({
				get() {
					return props.isChecked;
				},

				set(val) {
					emit('update:checked', val);
				}
			});

			return {
				checked
			};
		}
	};
</script>
