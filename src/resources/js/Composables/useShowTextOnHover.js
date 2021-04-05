import { ref } from 'vue';

export function useShowTextOnHover() {
	let showHoverText = ref(false);

	function handleMouseEnterEvent() {
		showHoverText.value = true;
	}

	function handleMouseLeaveEvent() {
		showHoverText.value = false;
	}
	return {
		showHoverText,
		handleMouseEnterEvent,
		handleMouseLeaveEvent
	};
}
