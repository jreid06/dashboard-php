<template lang="html">
 <div class="nav-list-div" v-on="{mouseenter: toggleNavNames, mouseleave: toggleNavNames}">
     <ul class="list-group nav-list">
         <li class="nav-group-list" v-for="(nav, index) in navigation" :style="nav.styles">
            <a :href="'#'+nav.route">
                 <p><i class="material-icons">{{nav.icon}}</i></p>
                 <transition name="fade">
                      <p class="text-capitalize" v-if="false">{{nav.name}}</p>
                 </transition>
            </a>
         </li>
     </ul>
 </div>
</template>

<script>
export default {
	data: function() {
		return {
			navActive: false,
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
	},
	methods: {
		toggleNavNames() {
			this.navActive = !this.navActive;
		}
	}
}
</script>

<style lang="scss" scoped>
.nav-list-div {
    // border: 2px solid gold;
    // position: absolute;
    // width: 200px;
    width: 100%;
    height: 100%;
}

.nav-list {
    width: 100%;
    list-style-type: none;
    padding: 0;
    // border: 1px solid green;

    i {
        font-size: 35px;
        color: #007BFF;
        padding-right: 30px;

        @media only screen and (min-width: 992px) {
            // font-size: 40px;
            .material-icons {
                padding-right: 15px !important;
            }
        }

        // @media only screen and (min-width: 1200px) {
        //     // font-size: 30px;
        //     position: relative;
        //     // left: 9px;
        // }
    }
}

.nav-group-list {

    padding-top: 15px;
    padding-bottom: 15px;
    border-bottom: 1.5px solid lighten(#e5e5e5, 7%);
    text-align: center;

    p {
        // border: 1px solid red;
        display: inline;
        text-align: center;

        &:nth-child(2) {
            position: relative;
            top: -7px;
            font-size: 18px;
        }
    }
}
</style>
