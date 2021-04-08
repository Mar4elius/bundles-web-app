<template>
	<!-- This example requires Tailwind CSS v2.0+ -->
	<nav class="bg-gray-800">
		<div class="max-w-7xl mx-auto px-2 sm:px-6 lg:px-8">
			<div class="relative flex items-center justify-between h-16">
				<div class="absolute inset-y-0 left-0 flex items-center sm:hidden">
					<!-- Mobile menu button-->
					<button
						@click="displayMobileMenu"
						type="button"
						class="inline-flex items-center justify-center p-2 rounded-md text-gray-400 hover:text-white hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-white"
					>
						<span class="sr-only">Open main menu</span>
						<!--
                            Icon when menu is closed.
                            Heroicon name: outline/menu
                            Menu open: "hidden", Menu closed: "block"
                        -->
						<svg
							v-if="!isMobileMenuOpen"
							class="block h-6 w-6"
							xmlns="http://www.w3.org/2000/svg"
							fill="none"
							viewBox="0 0 24 24"
							stroke="currentColor"
							aria-hidden="true"
						>
							<path
								stroke-linecap="round"
								stroke-linejoin="round"
								stroke-width="2"
								d="M4 6h16M4 12h16M4 18h16"
							/>
						</svg>

						<!--
                            Icon when menu is open.
                            Heroicon name: outline/x
                            Menu open: "block", Menu closed: "hidden"
                        -->
						<svg
							v-else
							class="block h-6 w-6"
							xmlns="http://www.w3.org/2000/svg"
							fill="none"
							viewBox="0 0 24 24"
							stroke="currentColor"
							aria-hidden="true"
						>
							<path
								stroke-linecap="round"
								stroke-linejoin="round"
								stroke-width="2"
								d="M6 18L18 6M6 6l12 12"
							/>
						</svg>
					</button>
				</div>
				<div class="flex-1 flex items-center justify-center sm:items-stretch sm:justify-start">
					<div class="flex-shrink-0 flex items-center">
						<!-- icon for normal view -->
						<img
							class="block lg:hidden h-8 w-auto"
							src="https://tailwindui.com/img/logos/workflow-mark-indigo-500.svg"
							alt="Workflow"
						/>
						<!-- icon for mobile view -->
						<img
							class="hidden lg:block h-8 w-auto"
							src="https://tailwindui.com/img/logos/workflow-logo-indigo-500-mark-white-text.svg"
							alt="Workflow"
						/>
					</div>
					<div class="hidden sm:block sm:ml-6">
						<div class="flex space-x-4">
							<nav-link
								v-for="link in topNavigationLinks"
								:href="route(link.route)"
								:active="route().current(link.route)"
								:key="link.name"
							>
								{{ link.name }}
							</nav-link>
						</div>
					</div>
				</div>
				<div class="absolute inset-y-0 right-0 flex items-center pr-2 sm:static sm:inset-auto sm:ml-6 sm:pr-0">
					<button
						class="bg-gray-800 p-1 m-2 rounded-full text-gray-400 hover:text-white focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-offset-gray-800 focus:ring-white"
					>
						<span class="sr-only">View notifications</span>
						<!-- Heroicon name: outline/bell -->
						<svg
							class="h-6 w-6"
							xmlns="http://www.w3.org/2000/svg"
							fill="none"
							viewBox="0 0 24 24"
							stroke="currentColor"
							aria-hidden="true"
						>
							<path
								stroke-linecap="round"
								stroke-linejoin="round"
								stroke-width="2"
								d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"
							/>
						</svg>
					</button>

					<button
						@click="showShoppingCart"
						class="bg-gray-800 p-1 rounded-full text-gray-400 hover:text-white focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-offset-gray-800 focus:ring-white"
					>
						<span class="sr-only">Shopping Cart</span>
						<svg
							class="h-6 w-6"
							fill="none"
							stroke-linecap="round"
							stroke-linejoin="round"
							stroke-width="2"
							viewBox="0 0 24 24"
							stroke="currentColor"
						>
							<path
								d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"
							></path>
						</svg>
					</button>

					<!-- Profile dropdown. Show only on screens bigger then small -->
					<div class="ml-3 relative hidden sm:block">
						<div>
							<button
								type="button"
								class="bg-gray-800 flex text-sm rounded-full focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-offset-gray-800 focus:ring-white"
								id="user-menu"
								@click="displayProfileMenu"
							>
								<span class="sr-only">Open user menu</span>
								<img
									class="h-8 w-8 rounded-full"
									src="https://images.unsplash.com/photo-1472099645785-5658abf4ff4e?ixlib=rb-1.2.1&ixid=eyJhcHBfaWQiOjEyMDd9&auto=format&fit=facearea&facepad=2&w=256&h=256&q=80"
									alt=""
								/>
							</button>
						</div>

						<!--
            Dropdown menu, show/hide based on menu state.

            Entering: "transition ease-out duration-100"
              From: "transform opacity-0 scale-95"
              To: "transform opacity-100 scale-100"
            Leaving: "transition ease-in duration-75"
              From: "transform opacity-100 scale-100"
              To: "transform opacity-0 scale-95"
          -->
						<div
							class="origin-top-right absolute right-0 z-20 mt-2 w-48 rounded-md shadow-lg py-1 bg-white ring-1 ring-black ring-opacity-5 focus:outline-none"
							role="menu"
							v-if="isProfileMenuOpen"
						>
							<profile-link
								v-for="link in userProfileLinks"
								:href="route(link.route)"
								classes="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100"
								:key="link.name"
							>
								{{ link.name }}
							</profile-link>
						</div>
					</div>
				</div>
			</div>
		</div>

		<!-- Mobile menu, show/hide based on menu state. -->
		<div class="sm:hidden" id="mobile-menu" v-if="isMobileMenuOpen">
			<div class="px-2 pt-2 pb-3 space-y-1">
				<nav-link
					v-for="link in topNavigationLinks"
					:href="route(link.route)"
					:active="route().current(link.route)"
					:key="link.name"
				>
					{{ link.name }}
				</nav-link>
				<hr class="py-3" />
				<div class="flex items-center">
					<img
						class="h-10 w-10 rounded-full mx-3"
						src="https://images.unsplash.com/photo-1472099645785-5658abf4ff4e?ixlib=rb-1.2.1&ixid=eyJhcHBfaWQiOjEyMDd9&auto=format&fit=facearea&facepad=2&w=256&h=256&q=80"
						alt=""
					/>
					<p class="text-white">Sam Green</p>
				</div>
				<nav-link v-for="link in userProfileLinks" :href="route(link.route)" :key="link.name">
					{{ link.name }}
				</nav-link>
			</div>
		</div>
	</nav>
</template>

<script>
	// Vue
	import { ref } from '@vue/reactivity';
	import { useStore } from 'vuex';
	import { computed } from '@vue/runtime-core';
	// Components
	import NavLink from '@/Components/Forms/NavLink';
	import ProfileLink from '@/Components/Forms/ProfileLink';
	// Data
	import { topNavigationLinks } from '@/Data/TopNavigationLinks';
	import { userProfileLinks } from '@/Data/UserProfileLinks';
	export default {
		components: {
			NavLink,
			ProfileLink
		},

		setup() {
			const store = useStore();
			let isMobileMenuOpen = ref(false);
			let isProfileMenuOpen = ref(false);
			let cartOpen = computed(() => store.state.cart.isOpen);

			function displayMobileMenu() {
				isMobileMenuOpen.value = !isMobileMenuOpen.value;
			}

			function displayProfileMenu() {
				isProfileMenuOpen.value = !isProfileMenuOpen.value;
			}

			function showShoppingCart() {
				if (!cartOpen.value) {
					store.commit('cart/setIsOpen', true);
				} else {
					store.commit('cart/setIsOpen', false);
				}
			}

			return {
				isMobileMenuOpen,
				isProfileMenuOpen,
				displayMobileMenu,
				displayProfileMenu,
				showShoppingCart,
				topNavigationLinks,
				userProfileLinks
			};
		}
	};
</script>
