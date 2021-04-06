<template>
	<div
		class="h-full w-full rounded-md bg-black bg-opacity-60 flex justify-center items-center z-50 absolute top-0 left-0"
	>
		<font-awesome-icon class="text-indigo-600 w-8 h-8 animate-spin" prefix="fas" icon="circle-notch" />
	</div>
</template>
<script>
	import FontAwesomeIcon from '@/Components/Support/FontAwesomeIcon';
	export default {
		components: {
			FontAwesomeIcon
		}
	};
</script>
