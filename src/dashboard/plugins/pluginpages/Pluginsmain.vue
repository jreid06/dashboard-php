<template lang="html">
<div class="row">
    <div class="col-10 offset-1">
		<!-- <h4 class="pt-8">Plugins Center</h4> -->
	</div>
	<div class="col-10 offset-1 pt-5">
		<div class="row">
			<div class="col-4 col-lg-3"
			     v-for="(plugin, index) in plugins">
				<div class="card"
				     style="width: 100%;">
					<img class="card-img-top"
					     src="src/dashboard_assets/app1.png"
					     alt="Card image cap">
					<div class="card-body">
						<p class="card-text text-capitalize text-center"><a :href="'#/dashboard/plugins'+plugin.plugin_link">{{plugin.plugin_name}}</a> </p>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
</template>

<script>
export default {
	data: function() {
		return {
			plugins: [
				{
					plugin_name: 'admin users',
					plugin_id: 'plugin_0001',
					plugin_link: '/adminusers',
					plugin_image: ''
                },
				{
					plugin_name: 'navigation',
					plugin_id: 'plugin_0002',
					plugin_link: '/navigation',
					plugin_image: ''
                },
				{
					plugin_name: 'users',
					plugin_id: 'plugin_0003',
					plugin_link: '/users',
					plugin_image: ''
                }
            ]
		}
	}
}
</script>

<style lang="scss" scoped>
.card {
    box-shadow: 0 0 !important;
    border: 0;
}
</style>
