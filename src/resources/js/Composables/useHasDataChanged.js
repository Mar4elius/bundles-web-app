//Object assign thing
// https://stackoverflow.com/questions/65732144/vue-js-3-replace-update-reactive-object-without-losing-reactivity
import { computed, reactive } from '@vue/runtime-core';

export default function useHasDataChanged(initial, mutable) {
	let initialData = reactive(initial);
	let mutableData = reactive(mutable);

	const hasDataChanged = computed(() => {
		return JSON.stringify(initialData) !== JSON.stringify(mutable);
	});

	function updateInitialData(data) {
		// can't use spread operator (even thought it supposes the creation of new object), because reactivity is lost
		// have to use Object.assign because Object.assign() modifies an object in place, and so it can trigger ES6 setters.
		//https://thecodebarbarian.com/object-assign-vs-object-spread.html
		initialData = Object.assign(initialData, data);
	}

	function updateMutableData(data) {
		mutableData = Object.assign(mutableData, data);
	}
	return {
		hasDataChanged,
		updateInitialData,
		updateMutableData
	};
}
