<template>
	<modal-dialog :show="showModal" @btnOnClickEvent="showModal = !showModal">
		<template v-slot:header>
			<div class="flex">
				<svg-hero-icon>
					<svg
						xmlns="http://www.w3.org/2000/svg"
						class="h-6 w-6"
						fill="none"
						viewBox="0 0 24 24"
						stroke="currentColor"
					>
						<path
							stroke-linecap="round"
							stroke-linejoin="round"
							stroke-width="2"
							d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"
						/>
					</svg>
				</svg-hero-icon>
				<h4>{{ header }}</h4>
			</div>
		</template>
		<template v-slot:content
			><p>{{ content }}</p></template
		>
		<template v-slot:footer>
			<div class="w-full flex justify-center">
				<v-button-filled
					id="remove-cart-bundle"
					classes="flex items-center justify-center mt-4 mr-5"
					@btnOnClickEvent="handleOnClickEvent"
					>Yes, remove bundle</v-button-filled
				>
				<v-button-filled
					id="checkout-button"
					classes="flex items-center justify-center mt-4"
					@btnOnClickEvent="showModal = !showModal"
				>
					<span>No, let me fix that</span>
				</v-button-filled>
			</div>
		</template>
	</modal-dialog>
</template>

<script>
	// Components
	import ModalDialog from '@/Components/Support/ModalDialog';
	import SvgHeroIcon from '@/Components/Support/SvgHeroIcon';
	import VButtonFilled from '@/Components/Forms/VButtonFilled';

	export default {
		props: {
			content: {
				type: String,
				required: true
			},

			header: {
				type: String,
				default: 'Important!'
			},

			showModal: {
				type: Boolean,
				default: false
			}
		},

		components: {
			ModalDialog,
			SvgHeroIcon,
			VButtonFilled
		},

		setup(props, { emit }) {
			function handleOnClickEvent() {
				emit('handelOnClickEvent');
			}

			return {
				handleOnClickEvent
			};
		}
	};
</script>
