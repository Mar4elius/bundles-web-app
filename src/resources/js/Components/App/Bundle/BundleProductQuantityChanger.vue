<template>
	<div class="flex items-center justify-center">
		<v-button-icon @btnOnClickEvent="incrementQuantity(product)" :is-disabled="disabled">
			<svg
				:class="classes"
				fill="none"
				stroke-linecap="round"
				stroke-linejoin="round"
				stroke-width="2"
				viewBox="0 0 24 24"
				stroke="currentColor"
			>
				<path d="M12 9v3m0 0v3m0-3h3m-3 0H9m12 0a9 9 0 11-18 0 9 9 0 0118 0z"></path>
			</svg>
		</v-button-icon>
		<!-- quantity props not always avaialable, so use default that is always there -->
		<span class="mx-2">{{ product.quantity || product.pivot.quantity || product.pivot.default_quantity }}</span>
		<v-button-icon @btnOnClickEvent="decrementQuantity(product)" :is-disabled="isDecrementDisabled">
			<svg
				:class="classes"
				fill="none"
				stroke-linecap="round"
				stroke-linejoin="round"
				stroke-width="2"
				viewBox="0 0 24 24"
				stroke="currentColor"
			>
				<path d="M15 12H9m12 0a9 9 0 11-18 0 9 9 0 0118 0z"></path>
			</svg>
		</v-button-icon>
	</div>
</template>

<script>
	// Components
	import VButtonIcon from '@/Components/Forms/VButtonIcon';
	import { computed } from '@vue/runtime-core';
	export default {
		emits: ['incrementQuantityBtnClick', 'decrementQuantityBtnClick'],
		props: {
			product: {
				type: Object,
				required: true
			},

			classes: {
				type: String,
				default: 'w-6 md:w-8'
			},

			disabled: {
				type: Boolean,
				default: false
			}
		},

		components: {
			VButtonIcon
		},

		setup(props, { emit }) {
			const isDecrementDisabled = computed(() => {
				return props.disabled || props.product.quantity === 1 || props.product.pivot.quantity === 1;
			});

			function incrementQuantity({ id }) {
				emit('incrementQuantityBtnClick', {
					id: id,
					quantity: 1
				});
			}

			function decrementQuantity({ id }) {
				emit('decrementQuantityBtnClick', {
					id: id,
					quantity: 1
				});
			}

			return {
				incrementQuantity,
				isDecrementDisabled,
				decrementQuantity
			};
		}
	};
</script>
