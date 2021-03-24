<template>
	<app-layout>
		<template v-slot:main>
			<div class="max-w-7xl mx-auto sm:px-6 lg:px-8 my-8">
				<h1>Bundles</h1>
				<p>
					Our Bundles are limited-time collections of games, books, software, and more. Simply pay what you
					want and choose where your money goes, including to charity. Most Bundles come in tiers starting at
					only $1 - the more you give, the more you get!
				</p>
				<div class="flex justify-start w-full">
					<button
						v-for="category in categories"
						class="bg-gray-700 inline-flex items-center justify-center p-2 rounded-md text-gray-400 hover:text-white focus:outline-none focus:ring-2 focus:ring-inset focus:ring-white"
					>
						{{ category.name }}
					</button>
				</div>
			</div>
		</template>
	</app-layout>
</template>

<script>
	import AppLayout from '@/Layouts/AppLayout';
	export default {
		components: {
			AppLayout
		},

		props: {
			categories: {
				type: Array,
				require: true
			}
		}
	};
</script>

AppLayout
