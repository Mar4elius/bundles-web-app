import { ref } from 'vue';

export function useChangeBundleQuantity(countVariable) {
	const count = ref(countVariable);

	function incrementCount() {
		count.value++;
	}

	function decrementCount() {
		if (count.value > 1) {
			count.value--;
		}
	}
	return {
		count,
		incrementCount,
		decrementCount
	};
}
