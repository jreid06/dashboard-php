<template lang="html">
<div :class="'col-'+columns">
    <hr>
	<div class="card">
		<div class="card-header">
			Plugins / Widgets
		</div>
		<div class="card-body">
			<div class="row">
                <div class="col-4" v-for="n in 3">
                    <div class="card" style="width: 100%;">
                      <img class="card-img-top" src="src/dashboard_assets/aron-visuals-450294-unsplash.jpg" alt="Card image cap">
                    </div>
                </div>
            </div>
		</div>
	</div>
</div>
</template>

<script>
export default {
	props: {
		columns: {
			type: Number,
			required: true
		}
	}
}
</script>

<style lang="scss" scoped>
.card {
    box-shadow: 0 0 !important;
}
</style>
