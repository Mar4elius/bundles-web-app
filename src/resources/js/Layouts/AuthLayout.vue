<template>
	<div class="bg-gray-100 min-h-screen flex">
		<div class="w-full lg:w-1/2">
			<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
				<div class="flex flex-col md:flex-row justify-center items-center min-h-screen">
					<div class="w-full sm:w-4/5 md:w-3/5 lg:w-4/5 xl:w-3/5 bg-white rounded-md p-4 md:p-6">
						<slot></slot>
					</div>
				</div>
			</div>
		</div>
		<div class="hidden lg:block lg:w-1/2 bg-signup-image h-auto bg-no-repeat bg-cover bg-center" />
	</div>
</template>
