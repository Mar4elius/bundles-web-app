<template>
	<div class="flex flex-wrap -mx-2 mt-4">
		<div class="p-2 w-full">
			<div class="relative">
				<label for="card_element" class="leading-7 text-sm text-gray-600">Credit Card Infromation</label>
				<form id="payment-form">
					<div id="card-element"><!--Stripe.js injects the Card Element--></div>
					<button id="submit" @submit.prevent="processPayment">
						<div class="spinner hidden" id="spinner"></div>
						<span id="button-text">Pay now</span>
					</button>
					<p id="card-error" role="alert"></p>
					<p class="result-message hidden">
						Payment succeeded, see the result in your
						<a href="" target="_blank">Stripe dashboard.</a> Refresh the page to pay again.
					</p>
				</form>
			</div>
		</div>
	</div>
</template>

<script>
	// Vue
	import { computed, onMounted, reactive, ref, watch } from '@vue/runtime-core';
	import { useStore } from 'vuex';
	// Components
	import VButtonFilled from '@/Components/Forms/VButtonFilled';
	export default {
		components: {
			VButtonFilled
		},

		setup(props) {
			const stripe = Stripe(process.env.MIX_STRIPE_KEY);
			const store = useStore();

			let cartBundles = computed(() => store.state.cart.items);
			let clientSecret = ref(null);
			let card = ref(null);

			const processPayment = async () => {
				// Calls stripe.confirmCardPayment
				// If the card requires authentication Stripe shows a pop-up modal to
				// prompt the user to enter authentication details without leaving your page.
				const response = await stripe.confirmCardPayment(clientSecret.value, {
					payment_method: {
						card: card.value
					}
				});
				if (response.error) {
					// Show error to your customer
					showError(result.error.message);
				} else {
					// The payment succeeded!
					orderComplete(result.paymentIntent.id);
				}
			};

			watch(cartBundles, async (curr, prev) => {
				const payload = {
					cart_id: curr[0].cart_id
				};
				const response = await store.dispatch('stripe/create', payload);
				clientSecret.value = response.data.client_secret;

				const elements = stripe.elements();
				const style = {
					base: {
						color: '#32325d',
						fontFamily: 'Arial, sans-serif',
						fontSmoothing: 'antialiased',
						fontSize: '16px',
						'::placeholder': {
							color: '#32325d'
						}
					},
					invalid: {
						fontFamily: 'Arial, sans-serif',
						color: '#fa755a',
						iconColor: '#fa755a'
					}
				};

				card.value = elements.create('card', { style: style });
				// Stripe injects an iframe into the DOM
				card.value.mount('#card-element');

				card.value.on('change', function (event) {
					// Disable the Pay button if there are no card details in the Element
					document.querySelector('button').disabled = event.empty;
					document.querySelector('#card-error').textContent = event.error ? event.error.message : '';
				});

				// var form = document.getElementById('payment-form');
				// form.addEventListener('submit', function (event) {
				// 	event.preventDefault();
				// 	// Complete payment when the submit button is clicked
				// 	payWithCard(stripe, card, data.clientSecret);
				// });
			});

			return {
				cartBundles,
				processPayment
			};
		}
	};
</script>

<style scoped>
	/* Variables */
	* {
		box-sizing: border-box;
	}

	body {
		font-family: -apple-system, BlinkMacSystemFont, sans-serif;
		font-size: 16px;
		-webkit-font-smoothing: antialiased;
		display: flex;
		justify-content: center;
		align-content: center;
		height: 100vh;
		width: 100vw;
	}

	form {
		width: 30vw;
		min-width: 500px;
		align-self: center;
		box-shadow: 0px 0px 0px 0.5px rgba(50, 50, 93, 0.1), 0px 2px 5px 0px rgba(50, 50, 93, 0.1),
			0px 1px 1.5px 0px rgba(0, 0, 0, 0.07);
		border-radius: 7px;
		padding: 40px;
	}

	input {
		border-radius: 6px;
		margin-bottom: 6px;
		padding: 12px;
		border: 1px solid rgba(50, 50, 93, 0.1);
		height: 44px;
		font-size: 16px;
		width: 100%;
		background: white;
	}

	.result-message {
		line-height: 22px;
		font-size: 16px;
	}

	.result-message a {
		color: rgb(89, 111, 214);
		font-weight: 600;
		text-decoration: none;
	}

	.hidden {
		display: none;
	}

	#card-error {
		color: rgb(105, 115, 134);
		text-align: left;
		font-size: 13px;
		line-height: 17px;
		margin-top: 12px;
	}

	#card-element {
		border-radius: 4px 4px 0 0;
		padding: 12px;
		border: 1px solid rgba(50, 50, 93, 0.1);
		height: 44px;
		width: 100%;
		background: white;
	}

	#payment-request-button {
		margin-bottom: 32px;
	}

	/* Buttons and links */
	button {
		background: #5469d4;
		color: #ffffff;
		font-family: Arial, sans-serif;
		border-radius: 0 0 4px 4px;
		border: 0;
		padding: 12px 16px;
		font-size: 16px;
		font-weight: 600;
		cursor: pointer;
		display: block;
		transition: all 0.2s ease;
		box-shadow: 0px 4px 5.5px 0px rgba(0, 0, 0, 0.07);
		width: 100%;
	}
	button:hover {
		filter: contrast(115%);
	}
	button:disabled {
		opacity: 0.5;
		cursor: default;
	}

	/* spinner/processing state, errors */
	.spinner,
	.spinner:before,
	.spinner:after {
		border-radius: 50%;
	}
	.spinner {
		color: #ffffff;
		font-size: 22px;
		text-indent: -99999px;
		margin: 0px auto;
		position: relative;
		width: 20px;
		height: 20px;
		box-shadow: inset 0 0 0 2px;
		-webkit-transform: translateZ(0);
		-ms-transform: translateZ(0);
		transform: translateZ(0);
	}
	.spinner:before,
	.spinner:after {
		position: absolute;
		content: '';
	}
	.spinner:before {
		width: 10.4px;
		height: 20.4px;
		background: #5469d4;
		border-radius: 20.4px 0 0 20.4px;
		top: -0.2px;
		left: -0.2px;
		-webkit-transform-origin: 10.4px 10.2px;
		transform-origin: 10.4px 10.2px;
		-webkit-animation: loading 2s infinite ease 1.5s;
		animation: loading 2s infinite ease 1.5s;
	}
	.spinner:after {
		width: 10.4px;
		height: 10.2px;
		background: #5469d4;
		border-radius: 0 10.2px 10.2px 0;
		top: -0.1px;
		left: 10.2px;
		-webkit-transform-origin: 0px 10.2px;
		transform-origin: 0px 10.2px;
		-webkit-animation: loading 2s infinite ease;
		animation: loading 2s infinite ease;
	}

	@-webkit-keyframes loading {
		0% {
			-webkit-transform: rotate(0deg);
			transform: rotate(0deg);
		}
		100% {
			-webkit-transform: rotate(360deg);
			transform: rotate(360deg);
		}
	}
	@keyframes loading {
		0% {
			-webkit-transform: rotate(0deg);
			transform: rotate(0deg);
		}
		100% {
			-webkit-transform: rotate(360deg);
			transform: rotate(360deg);
		}
	}

	@media only screen and (max-width: 600px) {
		form {
			width: 80vw;
		}
	}
</style>
