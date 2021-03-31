<template>
	<div class="flex my-5 sm:my-6">
		<p class="mr-4">Tags:</p>
		<v-button-outlined
			v-for="tag in tags"
			:key="tag.slug"
			size="x-small"
			:is-rounded="true"
			classes="mr-4"
			:id="tag.slug"
			>{{ tag.name }}</v-button-outlined
		>
	</div>
</template>
<script>
	import VButtonOutlined from '@/Components/Forms/VButtonOutlined';
	export default {
		components: {
			VButtonOutlined
		},

		props: {
			tags: {
				type: Array,
				required: true
			}
		}
	};
</script>
