import { ref } from 'vue';
export default function useLocalLoadingFlag() {
	const loading = ref(false);

	function setLocalLoadingFlag(value = false) {
		loading.value = value;
	}

	return {
		loading,
		setLocalLoadingFlag
	};
}
