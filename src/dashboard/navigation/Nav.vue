<template lang="html">
 <div class="nav-list-div">
     <ul class="list-group nav-list">
         <li class="nav-group-list" v-for="(nav, index) in navigation" :style="nav.styles">
             <a :href="'#'+nav.route">
                 <p><i class="material-icons">{{nav.icon}}</i></p>
                 <p class="text-capitalize">{{nav.name}}</p>
            </a>
         </li>
     </ul>
 </div>
</template>

<script>
export default {
	data: function() {
		return {
			navigation: [
				{
					name: '',
					icon: 'donut_large',
					route: '/dashboard/home',
					submenu: false,
					sublinks: [],
					styles: {
						paddingBottom: '150px'
					}
                },
				{
					name: 'home',
					icon: 'dashboard',
					route: '/dashboard/home',
					submenu: false,
					sublinks: [],
					styles: {

					}
                },
				{
					name: 'plugins',
					icon: 'apps',
					route: '/dashboard/plugins',
					submenu: false,
					sublinks: [],
					styles: {

					}
                },
				{
					name: 'settings',
					icon: 'settings',
					route: '/dashboard/settings',
					submenu: false,
					sublinks: [],
					styles: {

					}
                }
            ]
		}
	}
}
</script>

<style lang="scss" scoped>
.nav-list-div {
    // border: 2px solid gold;
    position: absolute;
    width: 200px;
}

.nav-list {
    width: 100%;
    list-style-type: none;
    padding: 0;
    // border: 1px solid green;

    i {
        font-size: 22px;
        color: #007BFF;
        padding-right: 30px;

        @media only screen and (min-width: 992px) {
            font-size: 30px;
        }

        @media only screen and (min-width: 1200px) {
            // font-size: 30px;
            position: relative;
            left: 9px;
        }
    }
}

.nav-group-list {

    padding-bottom: 15px;

    p {
        // border: 1px solid red;
        display: inline;

        &:nth-child(2) {
            position: relative;
            top: -7px;
            font-size: 18px;
        }
    }
}
</style>
