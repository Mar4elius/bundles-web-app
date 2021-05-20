<template>
	<div class="relative w-full mb-6">
		<label class="block mb-2 md:mb-3 w-full text-md font-medium text-gray-700" :for="name">{{ label }}</label>
		<input
			:name="name"
			:id="name"
			:type="type"
			:value="inputValue"
			@input="handleInput"
			@blur="handleBlur"
			:disabled="isDisabled"
			class="appearance-none border border-gray-300 placeholder-gray-500 text-gray-900 w-full px-3 py-2 rounded mb-2 focus:outline-none focus:ring-indigo-500 focus:border-indigo-300 focus:z-10 sm:text-sm transition-colors duration-300 ease-in-out"
			:class="{ 'bg-red-200': !!errorMessage }"
			v-maska="maska"
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
	// vee-validate
	import { useField } from 'vee-validate';
	// v-maska
	import { maska } from 'maska';

	export default {
		directives: {
			maska
		},

		emits: ['update:value'],

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
			},
			maska: {
				type: String,
				default: null
			}
		},
		setup(props, { emit }) {
			// we don't provide any rules here because we are using form-level validation
			// https://vee-validate.logaretm.com/v4/guide/validation#form-level-validation
			const { value: inputValue, errorMessage, handleBlur, handleChange, meta } = useField(
				props.name,
				undefined,
				{
					initialValue: props.value
				}
			);

			function handleInput(event) {
				// vee-validate method that update field value
				handleChange(event);
				// updates parent component value
				emit('update:value', {
					key: props.name,
					value: event.target.value
				});
			}

			return {
				errorMessage,
				handleChange,
				handleBlur,
				inputValue,
				meta,
				handleInput
			};
		}
	};
</script>
