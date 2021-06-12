<template>
	<app-layout>
		<template v-slot:main>
			<user-profile />
			<user-update-password />
			<template v-for="address in addresses">
				<user-address
					v-show="address.is_show"
					:key="address.id"
					:title="address.title"
					:active-address="address.address"
					:type="address.type"
				/>
			</template>
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
					activeShippingAddress.pivot?.address_id === activeBillingAddress.pivot?.address_id;
				store.commit('address/setBillingAddressSameAsShipping', isAddressesSame);
			});
			const store = useStore();
			let activeUser = reactive({ ...store.state.users.active });
			const activeShippingAddress = reactive({
				...activeUser.addresses.find((a) => a.pivot.is_active && a.pivot.is_shipping)
			});
			const activeBillingAddress = reactive({
				...activeUser.addresses.find((a) => a.pivot.is_active && a.pivot.is_billing)
			});

			const isBillingSameAsShipping = computed(() => store.state.address.isBillingSameAsShipping);

			const addresses = computed(() => [
				{
					id: 1,
					type: 'shipping',
					title: {
						name: 'Shipping Address',
						description: 'Update your shipping information.'
					},
					address: activeShippingAddress,
					is_show: true
				},
				{
					id: 2,
					type: 'billing',
					title: {
						name: 'Billing Address',
						description: 'Update your billing information.'
					},
					address: activeBillingAddress,
					is_show: !isBillingSameAsShipping.value // don't show billing address form is addresses are the same
				}
			]);

			return {
				addresses,
				isBillingSameAsShipping
			};
		}
	};
</script>
