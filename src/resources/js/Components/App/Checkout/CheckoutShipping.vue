<template>
	<h1>I am Shipping</h1>
	<form @submit="onSubmit">
		<div class="w-full text-right">
			<v-button-filled id="continut-to-shipping" :is-disabled="isSubmitting"
				>Continue to payments</v-button-filled
			>
		</div>
	</form>
</template>

<script>
	// Components
	import VButtonFilled from '@/Components/Forms/VButtonFilled';
	// Vee-validation and Yup
	import { useForm } from 'vee-validate';
	import { string, required, email, object, shape } from 'yup';
	export default {
		components: {
			VButtonFilled
		},

		props: {
			activeTab: {
				type: Object,
				required: true
			}
		},

		setup(props, { emit }) {
			const { handleSubmit, setFieldValue, isSubmitting } = useForm({
				// initialValues: {
				// 	country_id: activeCountry.value,
				// 	province_id: activeProvince.value
				// },
				// validationSchema: schema
			});

			const onSubmit = handleSubmit((values) => {
				console.log('hello');
				emit('completeTab', props.activeTab);
			});

			return {
				onSubmit
			};
		}
	};
</script>
