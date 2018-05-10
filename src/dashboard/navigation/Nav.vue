<template lang="html">
 <div class="">
     <h4>NAV HERE</h4>
     <ul>
         <li v-for="(nav, index) in navigation">{{nav.name}} | {{nav.roudte}}</li>
     </ul>
 </div>
</template>

<script>
export default {
	data: function() {
		return {
			navigation: [
				{
					name: 'home',
					roudte: 'admin/'
                },
				{
					name: 'test',
					roudte: '/test'
                }
            ]
		}
	}
}
</script>

<style lang="css">
</style>
