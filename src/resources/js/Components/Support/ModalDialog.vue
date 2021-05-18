<template>
	<!-- https://dev.to/alvarosaburido/create-modals-with-vue3-teleport-tailwindcss-48aj -->
	<teleport to="body">
		<transition
			enter-active-class="transition ease-out duration-200 transform"
			enter-from-class="opacity-0"
			enter-to-class="opacity-100"
			leave-active-class="transition ease-in duration-200 transform"
			leave-from-class="opacity-100"
			leave-to-class="opacity-0"
		>
			<div
				ref="modal-backdrop"
				v-show="showModal"
				class="fixed z-10 inset-0 overflow-y-auto bg-black bg-opacity-50"
			>
				<div class="flex items-start justify-center min-h-screen pt-24 text-center">
					<div
						class="bg-white rounded-lg text-left overflow-hidden shadow-xl p-8 w-1/2"
						role="dialog"
						ref="modal"
						aria-modal="true"
						aria-labelledby="modal-headline"
					>
						<div class="flex flex-col">
							<div class="flex justify-between items-center mb-2 md:mb-4 lg:mb-6">
								<slot name="header"> Provide Header </slot>

								<v-button-icon @btnOnClickEvent="closeModal">
									<svg
										xmlns="http://www.w3.org/2000/svg"
										class="h-10 w-10 text-indigo-500"
										fill="none"
										viewBox="0 0 24 24"
										stroke="currentColor"
									>
										<path
											stroke-linecap="round"
											stroke-linejoin="round"
											stroke-width="2"
											d="M6 18L18 6M6 6l12 12"
										/>
									</svg>
								</v-button-icon>
							</div>
							<div class="mb-2 md:mb-4 lg:mb-6">
								<slot name="content">
									<p>Provide modal content</p>
								</slot>
							</div>
							<div class="flex justify-center">
								<slot name="footer"></slot>
								<v-button-filled id="close-modal-btn" @btnOnClickEvent="closeModal"
									>Cancel</v-button-filled
								>
							</div>
						</div>
					</div>
				</div>
			</div>
		</transition>
	</teleport>
</template>

<script>
	// Vue
	import { ref } from '@vue/reactivity';
	import { watch } from '@vue/runtime-core';
	// Composables
	import useClickOutside from '@/Composables/useClickOutside';
	// Comoponents
	import VButtonIcon from '@/Components/Forms/VButtonIcon';
	import VButtonFilled from '@/Components/Forms/VButtonFilled';
	export default {
		components: {
			VButtonIcon,
			VButtonFilled
		},

		props: {
			show: {
				type: Boolean,
				default: false
			}
		},

		setup(props, { emit }) {
			const modal = ref(null);
			const showModal = ref(false);

			function closeModal() {
				showModal.value = false;
				emit('btnOnClickEvent');
			}
			const { onClickOutside } = useClickOutside();

			onClickOutside(modal, () => {
				if (showModal.value === true) {
					closeModal();
				}
			});

			watch(
				() => props.show,
				(show) => {
					showModal.value = show;
				}
			);

			return {
				closeModal,
				modal,
				showModal
			};
		}
	};
</script>
