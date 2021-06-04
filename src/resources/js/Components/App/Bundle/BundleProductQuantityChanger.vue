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
		<span class="mx-2" v-if="product.quantity && product.quantity >= 0">
			{{ product.quantity }}
		</span>
		<span class="mx-2" v-else>
			{{ product.pivot.quantity }}
		</span>
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
			console.log(props.product);
			const isDecrementDisabled = computed(() => {
				return (
					props.disabled ||
					// product from bundle
					(props.product.quantity && props.product.quantity === 0) ||
					// product from cart bundle
					(props.product.pivot && props.product.pivot.quantity === 0)
				);
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
