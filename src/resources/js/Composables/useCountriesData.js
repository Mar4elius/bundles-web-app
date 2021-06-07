// Vue
import { ref, reactive } from '@vue/reactivity';
import { useStore } from 'vuex';
// Composable functions
import useMultiselectDropDown from '@/Composables/useMultiselectDropDown';

export default function useCountriesData() {
	const store = useStore();
	let activeCountry = reactive({
		value: '',
		label: ''
	});
	let activeProvince = reactive({
		value: '',
		label: ''
	});
	const countries = ref([]);
	const provinces = ref([]);
	const { createMultiselectDdlObject } = useMultiselectDropDown();

	async function getCountries() {
		if (!countries.value.length) {
			const response = await store.dispatch('options/getCountries');
			if (response.status === 200) {
				countries.value = createMultiselectDdlObject(response.data.countries);
			}
		}
	}

	async function getProvinces() {
		// reset provinces before getting a new list
		activeProvince.value = '';
		if (activeCountry.value) {
			const response = await store.dispatch('options/getProvinces', activeCountry);
			if (response.status === 200) {
				provinces.value = createMultiselectDdlObject(response.data.provinces);
			}
		}
	}

	return {
		activeCountry,
		activeProvince,
		countries,
		getCountries,
		getProvinces,
		provinces
	};
}
