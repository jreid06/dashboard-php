<template lang="html">
    <div class="">
        <router-view></router-view>
    </div>
</template>

<script>
import Nav from './navigation/Nav.vue'
export default {
	components: {
		'nav-dashboard': Nav
	}
}
</script>

<style lang="css">

</style>
