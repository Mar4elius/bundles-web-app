import { computed, reactive, ref } from '@vue/runtime-core';

export default function useHasDataChanged(initial, updatable) {
	let initialData = reactive({ data: initial });
	let updatedData = reactive({ data: updatable });
	const hasDataChanged = computed(() => {
		console.log('compute');
		return JSON.stringify(initialData.data) !== JSON.stringify(updatedData.data);
	});

	function updateData(initial, updatable) {
		console.log('initial', initial);
		console.log('updatable', updatable);
		console.log('initialString', JSON.stringify(initial));
		console.log('updatedString', JSON.stringify(updatable));
		console.log('hasDataChanged', JSON.stringify(initial) !== JSON.stringify(updatable));
		initialData.data = initial;
		updatedData.data = updatable;
		console.log('hasDataChanged', JSON.stringify(initialData.data) !== JSON.stringify(updatedData.data));
		console.log('reactiveinitial', JSON.stringify(initialData.data));
		console.log('reactiveupdated', JSON.stringify(updatedData.data));
		console.log('hasDataChanged', hasDataChanged.value);
	}
	return {
		hasDataChanged,
		updateData,
		initialData,
		updatedData
	};
}
