<template>
	<button
		@click="(event) => $emit('btnOnClickEvent', event)"
		class="text-gray-500 focus:outline-none focus:text-gray-600 hover:text-indigo-600"
	>
		<slot></slot>
	</button>
</template>
