<template lang="html">

    <div class="container-fluid h-100" :style="containerStyles">
        <template v-if="screenWidth > 768">
            <div class="d-flex flex-nowrap flex-row dashboard-body h-100">
                <template v-if="route === 'login' || route === 'register'">
                    <div class="p-2" :style="layoutStyles.p1.style2">
                        <div class="menu">

                        </div>
                    </div>
                    <div class="p-2" :style="layoutStyles.p2.style2">
                        <router-view></router-view>
                    </div>

                </template>
                <template v-else>
                    <div class="p-2 dashboard-menu fixed-top" :style="layoutStyles.p1.style1" v-on="{mouseenter: openMenu, mouseleave: closeMenu}">
                        <div class="menu">
                            <nav-dashboard></nav-dashboard>
                        </div>
                    </div>
                    <div class="p-2" :style="layoutStyles.p2.style1">
                        <router-view></router-view>
                    </div>

                </template>
            </div>
        </template>
        <template v-else>
            <div class="row h-100 justify-content-center align-items-center">
                <div class="col-10 offset-1">
                    <h4>Please view dashboard on a Tablet, Laptop or Desktop device</h4>
                </div>
            </div>
        </template>
    </div>
</template>

<script>
import Nav from './navigation/Nav.vue'
export default {
	components: {
		'nav-dashboard': Nav
	},
	// beforeRouteEnter(to, from, next) {
	// 	// next(vm => vm.validateRoute())
	// },
	data: function() {
		return {
			route: this.$route.path.split('/')[2],
			screenWidth: $(window).width(),
			containerStyles: {
				paddingLeft: '0px',
				paddingRight: '0px',
				minHeight: '100%'
			},
			layoutStyles: {
				p1: {
					style1: {
						width: '4%',
						backgroundColor: '#FDFDFE',
						overflowY: 'hidden',
						height: '100%'
					},
					style2: {
						width: '0%',
						display: 'none'
					}
				},
				p2: {
					style1: {
						width: '96%',
						marginBottom: '50px'
					},
					style2: {
						width: '100%'
					}
				}
			}
		}
	},
	watch: {
		'$route': function(val) {
			this.refreshRoute();
			// this.validateRoute();
		}
	},
	methods: {
		validateRoute() {
			const vm = this;
			console.log("---");
			console.log("");
			console.log("ROUTE: " + this.route ? this.route : 'false route');
			if (this.route === 'login' || this.route === "register") {


			} else {
				// check if user is authenticated to access this page
				console.log(vm.$route.path);
				vm.authenticateUser();
			}
		},
		authenticateUser() {
			console.log('authenticated user run');
			console.log("---end");

			$.ajax({
				url: '/backend/model/sessions.php?q=check',
				type: 'get',
				success(data) {
					let $data = JSON.parse(data);
					switch ($data.status.code) {
						case 200:



							break;
						case 400:

							// redirect user to login page
							window.location = '#/admin/login';
							break;
						default:
					}
				},
				error() {

				}
			})
		},
		openMenu() {
			this.layoutStyles.p1.style1.width = '20%';
			this.layoutStyles.p2.style1.width = '110%';
			this.layoutStyles.p1.style1['boxShadow'] = '1px 0px 20px #007BFF';
		},
		closeMenu() {
			this.layoutStyles.p1.style1.width = '4%';
			this.layoutStyles.p2.style1.width = '96%';
			this.layoutStyles.p1.style1['boxShadow'] = '0px 0px 0px transparent';
		},
		checkScreenWidth() {
			const vm = this;
			$(window).resize(function() {
				console.log($(window).width());
				vm.screenWidth = $(window).width();

			})
		},
		refreshRoute() {
			console.log('refreshRoute');
			this.route = this.$route.path.split('/')[2];
		}
	},
	mounted() {
		this.checkScreenWidth();
	}
}
</script>

<style lang="scss" scoped>
.dashboard-body {
    // border: 1px solid red;
    a {
        color: #007BFF;
    }

    .p-2 {
        transition: all 0.4s ease;
    }

}

.dashboard-menu {

    &:hover {
        width: 20%;
    }
}
</style>
