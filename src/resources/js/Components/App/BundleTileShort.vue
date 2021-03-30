<template>
	<div class="mx-5 mb-5 sm:mx-6 sm:mb-6">
		<img :src="bundle.image_path" :alt="bundle.name" />
		<div>
			<h5>{{ bundle.name }}</h5>
			<p>{{ bundle.description }}</p>
		</div>
	</div>
</template>

<script>
	export default {
		props: {
			bundle: {
				type: Object,
				required: true
			}
		}
	};
</script>
