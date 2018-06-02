<template lang="html">
    <div :class="'col-12 col-lg-'+columns">
        <ul class="list-group">
            <li class="list-group-item list-group-item-light d-flex justify-content-between align-items-center ">
                Dashboard
            </li>
            <li class="list-group-item d-flex justify-content-between align-items-center" v-for="n in 5">
                Cras justo odio
                <span class="badge badge-primary badge-pill">14</span>
            </li>
        </ul>
    </div>
</template>

<script>
export default {
	props: {
		columns: {
			type: Number,
			required: true
		},
		items: []
	}
}
</script>

<style lang="scss">
.badge {
    flex: 0 !important;
}
</style>
