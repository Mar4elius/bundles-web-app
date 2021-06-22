<template>
	<app-layout>
		<template v-slot:main>
			<user-profile />
			<user-update-password />
			<div v-for="address in addresses" :key="address.id">
				<user-address
					v-if="address.is_show"
					:title="address.title"
					:address="address.address"
					:type="address.type"
				/>
			</div>
		</template>
	</app-layout>
</template>

<script>
	// Vue
	import { reactive, ref, computed } from '@vue/reactivity';
	import { useStore } from 'vuex';
	// Components
	import AppLayout from '@/Layouts/AppLayout';
	import UserProfile from '@/Components/App/User/UserProfile';
	import UserUpdatePassword from '@/Components/App/User/UserUpdatePassword';
	import UserAddress from '@/Components/App/User/UserAddress';
	import { onMounted } from '@vue/runtime-core';

	export default {
		components: {
			AppLayout,
			UserProfile,
			UserAddress,
			UserUpdatePassword
		},

		setup() {
			onMounted(() => {
				const isAddressesSame =
					activeShippingAddress.value?.pivot?.address_id === activeBillingAddress.value?.pivot?.address_id;
				store.commit('address/setBillingAddressSameAsShipping', isAddressesSame);
			});
			const store = useStore();
			let activeUser = computed(() => store.state.users.active);

			let activeShippingAddress = computed(() => {
				return activeUser.value.addresses.find((a) => a.pivot.is_active && a.pivot.is_shipping) || null;
			});

			let activeBillingAddress = computed(() => {
				return activeUser.value.addresses.find((a) => a.pivot.is_active && a.pivot.is_billing) || null;
			});

			let isBillingSameAsShipping = computed(() => store.state.address.isBillingSameAsShipping);

			let addresses = computed(() => {
				return [
					{
						id: 1,
						type: 'shipping',
						title: {
							name: 'Shipping Address',
							description: 'Update your shipping information.'
						},
						address: activeShippingAddress.value,
						is_show: true
					},
					{
						id: 2,
						type: 'billing',
						title: {
							name: 'Billing Address',
							description: 'Update your billing information.'
						},
						address: activeBillingAddress.value,
						is_show: !isBillingSameAsShipping.value // don't show billing address form is addresses are the same
					}
				];
			});

			return {
				addresses,
				activeUser,
				activeShippingAddress,
				activeBillingAddress,
				isBillingSameAsShipping
			};
		}
	};
</script>
