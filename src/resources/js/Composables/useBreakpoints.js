import { computed, onMounted, onUnmounted, ref } from 'vue';

export default function useBreakpoint() {
	let windowWidth = ref(window.innerWidth);

	const onWidthChange = () => (windowWidth.value = window.innerWidth);

	onMounted(() => window.addEventListener('resize', onWidthChange));
	onUnmounted(() => window.removeEventListener('resize', onWidthChange));

	const type = computed(() => {
		if (windowWidth.value <= 640) {
			return 'xs';
		} else if (windowWidth.value > 640 && windowWidth.value <= 768) {
			return 'md';
		} else if (windowWidth.value > 768 && windowWidth.value <= 1024) {
			return 'lg';
		} else if (windowWidth.value > 1024 && windowWidth.value <= 1280) {
			return 'xl';
			// } else if (windowWidth.value > 1280 && windowWidth.value <= 1536) {
			// 	return '2xl';
			// }
		} else {
			return '2xl';
		}
	});

	const width = computed(() => windowWidth.value);

	return { width, type };
}
