import { computed, reactive } from 'vue';

export default function useMultiselectDropDown(activeDdl) {
	function setDdlValue(data) {
		activeDdl.value = data.value;
		activeDdl.label = data?.label || '';
	}

	function createMultiselectDdlObject(data) {
		return data.map((item) => {
			return {
				value: item.id,
				label: item.name
			};
		});
	}

	return {
		createMultiselectDdlObject,
		setDdlValue
	};
}
