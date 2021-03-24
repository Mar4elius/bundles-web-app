<template>
	<app-layout>
		<template v-slot:main>
			<div class="max-w-7xl mx-auto sm:px-6 lg:px-8 my-8">
				<h1 class="ml-0">Bundles</h1>
				<p>
					Our Bundles are limited-time collections of games, books, software, and more. Simply pay what you
					want and choose where your money goes, including to charity. Most Bundles come in tiers starting at
					only $1 - the more you give, the more you get!
				</p>
				<div class="flex justify-start w-full mt-6">
					<v-button
						:is-rounded="true"
						size="small"
						:classes="`mr-4`"
						v-for="category in categories"
						:key="category.id"
						@btnOnClickEvent="filterBundles"
					>
						{{ category.name }}
					</v-button>
				</div>
			</div>
		</template>
	</app-layout>
</template>

<script>
	import AppLayout from '@/Layouts/AppLayout';
	import vButton from '@/Components/Forms/VButton';
	export default {
		components: {
			AppLayout,
			vButton
		},

		props: {
			categories: {
				type: Array,
				require: true
			}
		},

		setup() {
			function filterBundles() {
				console.log('filterBundles function');
			}

			return {
				filterBundles
			};
		}
	};
</script>

AppLayout
