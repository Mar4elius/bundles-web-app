<template>
	<div class="relative w-full mb-6 lg:mr-6">
		<label class="block mb-2 md:mb-3 w-full text-md font-medium text-gray-700" :for="name">{{ label }}</label>
		<!-- using long version of v-model. This way we can change @input event handler -->
		<!-- handleChange will emit event to parent where the prop value will be update -->
		<!-- this will trigger all props to update in child components -->
		<multiselect
			:name="name"
			:id="name"
			:model-value="value"
			@update:model-value="handleChange($event)"
			:options="options"
			:loading="loading"
			:disabled="disabled"
			class="mb-2 rounded"
			:class="{ 'bg-red-200': !!errorMessage }"
			@select="handleSelect"
		/>
		<p
			class="absolute left-0 m-0"
			:class="{ 'text-red-600': !!errorMessage, 'text-emerarld-600': meta.valid }"
			v-show="errorMessage || meta.valid"
		>
			{{ errorMessage || successMessage }}
		</p>
	</div>
</template>

<script>
	import Multiselect from '@vueform/multiselect';
	import { useField } from 'vee-validate';
	export default {
		components: {
			Multiselect
		},

		emits: ['update:value'],

		props: {
			value: {
				type: String,
				default: ''
			},
			name: {
				type: String,
				required: true
			},
			label: {
				type: String,
				required: true
			},

			options: {
				type: Array,
				default: () => []
			},

			loading: {
				type: Boolean,
				default: false
			},

			successMessage: {
				type: String,
				default: ''
			},

			disabled: {
				type: Boolean,
				default: false
			}
		},

		setup(props, { emit }) {
			// we don't provide any rules here because we are using form-level validation
			// https://vee-validate.logaretm.com/v4/guide/validation#form-level-validation
			const { value: inputValue, errorMessage, handleBlur, meta } = useField(props.name, undefined, {
				initialValue: props.value
			});
			// change for v-model binding
			function handleChange(event) {
				emit('update:value', {
					key: props.name,
					value: event || ''
				});
			}

			function handleSelect() {
				emit('handleSelect');
			}

			return {
				handleBlur,
				handleChange,
				handleSelect,
				errorMessage,
				inputValue,
				meta
			};
		}
	};
</script>
