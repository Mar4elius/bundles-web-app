<template>
	<form enctype="multipart/form-data" novalidate v-if="isInitial || isSaving">
		<!-- https://www.digitalocean.com/community/tutorials/how-to-handle-file-uploads-in-vue-2 -->
		<!-- The form attribute enctype="multipart/form-data" is important. To enable file upload, this attribute must be set.  -->
		<div
			class="outline-black border-dashed ring-offset-2 bg-indigo-400 p-3 relative cursor-pointer hover:bg-indigo-300 h-52 text-gray-300"
		>
			<input
				v-if="isMultiple"
				class="opacity-0 w-full h-52 absolute cursor-pointer"
				type="file"
				multiple
				:name="uploadFieldName"
				:disabled="isSaving"
				@change="filesChange($event)"
				accept="image/*"
			/>

			<input
				v-else
				class="opacity-0 w-full h-52 absolute cursor-pointer"
				type="file"
				:name="uploadFieldName"
				:disabled="isSaving"
				@change="filesChange($event)"
				accept="image/*"
			/>

			<p v-if="isInitial" class="text-base text-center py-12 text-gray-600">
				Drag your file(s) here to begin<br />
				or click to browse
			</p>
			<p class="text-base text-center py-12 text-gray-600" v-if="isSaving">Uploading {{ fileCount }} files...</p>
		</div>
	</form>
</template>
<script>
	import { reactive } from '@vue/reactivity';
	import { computed, onMounted } from '@vue/runtime-core';
	export default {
		props: {
			isMultiple: {
				type: Boolean,
				default: false
			}
		},
		setup(props, { emit }) {
			const upload = reactive({
				files: [],
				error: null,
				currentStatus: null
			});

			const uploadStatuses = { initial: 0, saving: 1, success: 2, failed: 3 };

			const isInitial = computed(() => upload.currentStatus === uploadStatuses.initial);
			const isSaving = computed(() => upload.currentStatus === uploadStatuses.saving);
			const isSuccess = computed(() => upload.currentStatus === uploadStatuses.success);
			const isFailed = computed(() => upload.currentStatus === uploadStatuses.failed);

			function reset() {
				upload.currentStatus = uploadStatuses.initial;
				upload.files = [];
				upload.error = null;
			}

			async function filesChange(event) {
				if (props.isMultiple) {
					//TODO: add functionality for saving multiple files
				} else {
					emit('onImageChange', event.target.files[0]);
				}
				// console.log(fileList);
				// const formData = new FormData();

				// if (!fileList.length) return;

				// // append the files to FormData
				// Array.from(Array(fileList.length).keys()).map((x) => {
				// 	formData.append(fieldName, fileList[x], fileList[x].name);
				// });

				// console.log(formData);

				// // save it
				// save(formData);
			}

			onMounted(() => {
				reset();
			});

			return {
				isInitial,
				isSaving,
				filesChange
			};
		}
	};
</script>
