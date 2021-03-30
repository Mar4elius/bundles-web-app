<template>
	<div class="md:col-span-1">
		<div class="px-4 sm:px-0">
			<h3>
				<slot name="title"></slot>
			</h3>

			<p class="mt-1 text-sm text-gray-600">
				<slot name="description"></slot>
			</p>
		</div>
	</div>
</template>
