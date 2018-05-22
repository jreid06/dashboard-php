<template lang="html">
<div :class="'col-'+columns">
    <br>
    <hr>
    <div class="header">
        <h4>Admin users login activity</h4>
    </div>
    <ul class="list-group list-group-flush">
      <li class="list-group-item" v-for="n in 3">
          <p class="font-weight-bold">Jason Reid - ADM_a2e724bc6a0a2f - created 2018-05-10</p>
          <p><i>Last Logged in: 2018-05-10 20:18:01</i></p>
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

<style lang="scss" scoped>
.header {
    background-color: #F7F7F7;
    padding: 12px 5px;
}

.list-group-item {
    p {
        display: inline;
        font-size: 12px;

        &:nth-child(1) {
            padding-right: 170px;
            text-align: right;
        }
    }
}
</style>
