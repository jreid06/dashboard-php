<template lang="html">
    <div class="container-fluid h-100">
        <div class="row h-100 align-items-center">
            <div class="col-10 offset-1">
                <div class="spinner"></div>
            </div>
        </div>
    </div>
</template>

<script>
export default {
	props: [],
	data: function() {
		return {

		}
	},
	methods: {
		directUser(pm) {
			const vm = this;
			console.log('LOADING COMPONENT');
			console.log(this.$route);

			console.log('from');
			console.log(pm);

			// setTimeout(function() {
			// 	vm.$router.push({
			// 		path: vm.$route.query.path
			// 	});
			// }, 1500);

		}
	},
	mounted() {
		// this.directUser();
	}
}
</script>

<style lang="css">
</style>
