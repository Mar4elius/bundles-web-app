<template>
	<div>
		<label class="block text-md font-medium text-gray-700">
			<span v-if="label">{{ label }}</span>
		</label>
		<input
			type="checkbox"
			:value="value"
			v-model="checked"
			class="rounded border-gray-300 text-indigo-600 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50"
		/>
	</div>
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
				type: String,
				default: null
			},

			label: {
				type: String,
				required: true
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
