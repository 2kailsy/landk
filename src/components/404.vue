<template>
    <div id="svg_404" ref="404_svg"></div>
</template>
<script>
import bodyMoVin from '@/assets/js/bodyMoVin';
import animationData from '@/assets/img/404.json';
export default {
	name: '404Page',
	mounted(){
		bodyMoVin.loadAnimation({
			wrapper: this.$refs['404_svg'],
			animType: 'svg',
			loop: true,
			animationData: animationData
		});
	}
}
</script>
<style scoped>
html{
	margin: 0;
	padding: 0;
	background-color: white;
}
body,html{
	width: 100%;
	height: 100%;
	overflow: hidden;
}
#svg_404{
	width: 640px;
	height: 512px;
	background-color: white;
	position: absolute;
	top: 0;
	left: 0;
	right: 0;
	bottom: 0;
	margin: auto;
}
</style>