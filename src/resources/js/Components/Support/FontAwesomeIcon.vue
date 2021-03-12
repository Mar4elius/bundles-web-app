<template>
	<svg xmlns="http://www.w3.org/2000/svg" :class="$props.class" :viewBox="`0 0 ${width} ${height}`">
		<path fill="currentColor" :d="svgPath" />
	</svg>
</template>

<script>
	import { computed } from 'vue';
	import { findIconDefinition } from '@fortawesome/fontawesome-svg-core';

	export default {
		name: 'FontAwesomeIcon',

		props: {
			icon: {
				type: String,
				required: true
			},

			class: String,

			prefix: {
				type: String,
				required: true
			}
		},

		setup(props) {
			const definition = computed(() =>
				findIconDefinition({
					prefix: props.prefix,
					iconName: props.icon
				})
			);

			const width = computed(() => definition.value.icon[0]);
			const height = computed(() => definition.value.icon[1]);
			const svgPath = computed(() => definition.value.icon[4]);

			return { width, height, svgPath };
		}
	};
</script>
