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
				<!-- <v-text-input
					name="country"
					type="text"
					label="Country"
					placeholder="Country"
					:value="activeUser.city"
					class="w-full md:w-1/2"
				/>
				<v-text-input
					name="province"
					type="text"
					label="Province"
					placeholder="Province"
					:value="activeUser.city"
					class="w-full md:w-1/2"
				/> -->
				<multiselect v-model="value" :options="['Batman', 'Robin', 'Joker']" label="Country" />
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
	import { computed } from '@vue/runtime-core';
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
			const activeUser = computed(() => store.state.users.active);
			return {
				activeUser
			};
		}
	};
</script>
