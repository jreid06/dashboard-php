<template lang="html">
<div :class="'col-'+columns">
	<div class="card">
		<div class="card-header">
			Website Overview
		</div>
		<div class="card-body">
			<div class="row">
                <template v-for="n in 4">
                    <template v-if="screenWidth < 1200 && n === 4">
                        <div class="d-none d-xl-block col-xl-3">
                            <div class="card" style="width: 100%;">
                              <img class="card-img-top" src="src/dashboard_assets/aron-visuals-450294-unsplash.jpg" alt="Card image cap">
                              <div class="card-body">
                                <p class="card-text text-center">Some quick example text</p>
                              </div>
                            </div>
                        </div>
                    </template>
                    <template v-else>
                        <div class="col-4 col-xl-3">
                            <div class="card" style="width: 100%;">
                              <img class="card-img-top" src="src/dashboard_assets/aron-visuals-450294-unsplash.jpg" alt="Card image cap">
                              <div class="card-body">
                                <p class="card-text text-center">Some quick example text</p>
                              </div>
                            </div>
                        </div>
                    </template>

                </template>
            </div>
		</div>
	</div>
</div>
</template>

<script>
export default {
	data: function() {
		return {
			screenWidth: $(window).width()
		}
	},
	watch: {
		'screenWidth': function(val) {
			console.log(`width: ${val}`);
		}
	},
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
