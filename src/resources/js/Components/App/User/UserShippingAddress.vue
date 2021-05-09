<template>
	<div class="md:flex md:justify-between w-full my-6 md:my-8">
		<div class="w-full md:w-2/5 mb-4 md:mb-6">
			<h3>Shipping Address</h3>
			<p>Update your shipping information.</p>
		</div>
		<div class="w-full md:w-3/5 rounded-md bg-white p-4 md:p-6 lg:p-8">
			<validate-form @submit="onSubmit" :validation-schema="schema">
				<v-text-input
					name="address"
					type="text"
					label="Address"
					placeholder="Address"
					:value="activeUser.address"
					class="w-full md:w-1/2 mr-2 md:mr-4 lg:mr-6"
				/>

				<v-text-input
					name="address"
					type="text"
					label="Aparetents, Suit, etc. (optional)"
					placeholder="Address"
					:value="activeUser.address"
					class="w-full md:w-1/2 mr-2 md:mr-4 lg:mr-6"
				/>

				<!-- Countries -->
				<label class="block mb-2 md:mb-3 w-full text-md font-medium text-gray-700" for="countries"
					>Country</label
				>

				<multiselect
					id="countries"
					v-model="selectedCountry"
					:options="countries"
					@open="getCountries"
					class="w-1/2 mb-6"
				/>
				<!-- // countries -->

				<!-- Provinces -->
				<label class="block mb-2 md:mb-3 w-full text-md font-medium text-gray-700" for="provinces"
					>Province</label
				>

				<multiselect
					id="provinces"
					v-model="selectedProvince"
					:options="provinces"
					@open="getProvinces"
					class="w-1/2 mb-6"
					:disabled="countries.length === 0"
				/>
				<!-- // provinces -->

				<v-text-input
					name="city"
					type="text"
					label="City"
					placeholder="City"
					:value="activeUser.city"
					class="w-full md:w-1/2"
				/>
				<v-text-input
					name="postal_code"
					type="text"
					label="Postal Code"
					placeholder="Postal Code"
					:value="activeUser.postal_code"
					class="w-full md:w-1/2"
				/>
				<v-text-input
					name="phone"
					type="text"
					label="Phone Number"
					placeholder="Phone Number"
					:value="activeUser.phone"
					class="w-full md:w-1/2 mr-2 md:mr-4 lg:mr-6"
				/>
				<div class="text-right">
					<v-button-filled id="update-user-data">Save</v-button-filled>
				</div>
			</validate-form>
		</div>
	</div>
</template>
<script>
	// Vue
	import { useStore } from 'vuex';
	import { computed, ref } from '@vue/runtime-core';
	// Components
	import VTextInput from '@/Components/Forms/VTextInput';
	import VButtonFilled from '@/Components/Forms/VButtonFilled';
	import Multiselect from '@vueform/multiselect';
	export default {
		components: {
			Multiselect,
			VButtonFilled,
			VTextInput
		},

		setup(props) {
			const store = useStore();
			const countries = ref([]);
			const provinces = ref([]);
			const activeCountry = ref(null);
			const activeProvince = ref(null);

			const activeUser = computed(() => store.state.users.active);

			const selectedCountry = computed({
				get() {
					return;
				},
				set(value) {
					activeCountry.value = countries.value.find((c) => c.value === value);
				}
			});

			const selectedProvince = computed({
				get() {
					return;
				},
				set(value) {
					activeProvince.value = provinces.value.find((c) => c.value === value);
				}
			});

			async function getCountries() {
				if (!countries.value.length) {
					const response = await store.dispatch('options/getCountries');
					if (response.status === 200) {
						countries.value = response.data.countries.map((item) => {
							return {
								value: item.id,
								label: item.name
							};
						});
					}
				}
			}

			async function getProvinces() {
				if (!provinces.value.length) {
					const response = await store.dispatch('options/getProvinces', activeCountry.value);

					if (response.status === 200) {
						provinces.value = response.data.provinces.map((item) => {
							return {
								value: item.id,
								label: item.name
							};
						});
					}
				}
			}

			return {
				activeUser,
				activeCountry,
				countries,
				getCountries,
				getProvinces,
				provinces,
				selectedCountry,
				selectedProvince
			};
		}
	};
</script>
