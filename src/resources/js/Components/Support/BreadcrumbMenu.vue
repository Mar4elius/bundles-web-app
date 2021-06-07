<template>
	<div class="w-full flex mb-2 md:mb-4 lg:mb-6">
		<div v-for="(tab, index) in tabs" :key="tab.name">
			<span
				class="flex hover:text-indigo-600 cursor-pointer"
				:class="{
					'text-emerald-600': tab.is_completed,
					'text-indigo-600 font-bold': tab.is_active,
					'text-gray-600 pointer-events-none': !tab.is_active
				}"
				@click="handleOnClickEvent(tab)"
			>
				{{ tab.name }}
				<svg
					v-if="tabs.length - 1 !== index"
					xmlns="http://www.w3.org/2000/svg"
					class="h-6 w-6"
					fill="none"
					viewBox="0 0 24 24"
					stroke="currentColor"
				>
					<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
				</svg>
			</span>
		</div>
	</div>
</template>

<script>
	export default {
		props: {
			tabs: {
				type: Array,
				required: true
			}
		},
		setup(props, { emit }) {
			function handleOnClickEvent(tab) {
				emit('handleOnClickEvent', tab);
			}
			return {
				handleOnClickEvent
			};
		}
	};
</script>
