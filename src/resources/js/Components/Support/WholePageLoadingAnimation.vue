<template>
	<div class="h-full w-full absolute top-0 left-0 bg-black bg-opacity-60 flex justify-center items-center z-20">
		<font-awesome-icon class="text-indigo-600 w-10 h-10 ml-6 animate-spin" prefix="fas" icon="circle-notch" />
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
