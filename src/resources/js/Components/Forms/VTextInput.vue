<template>
	<div class="relative w-full mb-6">
		<label class="block mb-2 md:mb-3 w-full text-md font-medium text-gray-700" :for="name">{{ label }}</label>
		<input
			:name="name"
			:id="name"
			:type="type"
			:value="inputValue"
			@input="handleChange"
			@blur="handleBlur"
			:disabled="isDisabled"
			class="appearance-none border border-gray-300 placeholder-gray-500 text-gray-900 w-full px-3 py-2 rounded mb-2 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 focus:z-10 sm:text-sm transition-colors duration-300 ease-in-out"
			:class="{ 'bg-red-200': !!errorMessage }"
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
	import { useField } from 'vee-validate';

	export default {
		props: {
			type: {
				type: String,
				default: 'text'
			},
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
			successMessage: {
				type: String,
				default: ''
			},
			isDisabled: {
				type: Boolean,
				default: false
			}
		},
		setup(props) {
			// we don't provide any rules here because we are using form-level validation
			// https://vee-validate.logaretm.com/v4/guide/validation#form-level-validation
			const { value: inputValue, errorMessage, handleBlur, handleChange, meta } = useField(
				props.name,
				undefined,
				{
					initialValue: props.value
				}
			);

			return {
				handleChange,
				handleBlur,
				errorMessage,
				inputValue,
				meta
			};
		}
	};
</script>
