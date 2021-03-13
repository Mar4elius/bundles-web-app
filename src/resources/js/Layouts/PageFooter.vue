<template>
	<div class="bg-gray-800">
		<div class="max-w-7xl mx-auto px-2 sm:px-6 lg:px-8">
			<div
				class="flex flex-col items-center justify-center sm:flex-row sm:justify-between sm:py-16 md:py-20 lg:text-left"
			>
				<img
					class="m-auto sm:mx-0 h-8 my-8 sm:my-4"
					src="https://tailwindui.com/img/logos/workflow-logo-indigo-500-mark-white-text.svg"
					alt="Workflow"
				/>
				<p class="text-white m-auto mb-8 sm:m-0 sm:mb-4 text-center sm:my-4">
					Some inspering phrase about how cool we are
				</p>
				<div class="mb-8 flex justify-center items-center sm:my-4">
					<font-awesome-icon
						v-for="link in footerSocialLinks"
						:key="link.name"
						class="text-white w-6 h-6 ml-6"
						:prefix="link.icon.prefix"
						:icon="link.icon.name"
					/>
				</div>
			</div>
		</div>
	</div>
</template>

<script>
	import { footerSocialLinks } from '@/Data/FooterLinks';
	export default {
		setup() {
			return {
				footerSocialLinks
			};
		}
	};
</script>
