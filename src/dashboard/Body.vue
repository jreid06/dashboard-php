<template lang="html">

    <div class="container-fluid h-100" :style="containerStyles">
        <div v-if="!loading" class="h-100">
            <transition name="fade">
                <div class="row h-100 align-items-center">

                    	<div class="col-10 offset-1">
                    		<div class="spinner"></div>
                    	</div>

                </div>
            </transition>

        </div>
        <div class="h-100" v-else>
            <template v-if="screenWidth > 768">
                <div class="d-flex flex-nowrap flex-row dashboard-body h-100">
                        <div class="p-2 dashboard-menu fixed-top" :style="layoutStyles.p1.style1" v-on="{mouseenter: openMenu, mouseleave: closeMenu}">
                            <div class="menu">
                                <nav-dashboard></nav-dashboard>
                            </div>
                        </div>
                        <div class="p-2" :style="layoutStyles.p2.style1">
                            <div class="top-bar">

                            </div>
                            <transition name="fade">
                                <router-view></router-view>
                            </transition>
                        </div>
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
    </div>
</template>

<script>
import Nav from './navigation/Nav.vue'
export default {
	components: {
		'nav-dashboard': Nav
	},
	beforeRouteEnter(to, from, next) {
		next(vm => vm.validateRoute());
	},
	data: function() {
		return {
			route: this.$route.path.split('/')[2],
			screenWidth: $(window).width(),
			containerStyles: {
				paddingLeft: '0px',
				paddingRight: '0px',
				minHeight: '100%'
			},
			welcomeBack: 0,
			loading: true,
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
			console.log("REFRESH ROUTE");
			// this.loading = !this.loading;
			console.log(val);

			if (this.welcomeBack <= 1) {
				this.welcomeBack += 1;
			}

			this.refreshRoute();
			this.validateRoute();
		}
	},
	beforeDestroy() {
		console.log('turn loading to true');
	},
	methods: {
		toggleLoadingscreen() {
			console.log('loading screen toggled');
			this.loading = !this.loading;
			// $('.adminuser-row').removeClass('h-100');
		},
		validateRoute() {
			const vm = this;
			// if (!vm.loading) {
			// 	vm.toggleLoadingscreen();
			// }
			console.log(vm.$route.path);
			vm.authenticateUser();

		},
		authenticateUser() {
			console.log('authenticated user run');
			console.log("---end");

			const vm = this;

			$.ajax({
				url: '/backend/model/sessions.php?q=check',
				type: 'get',
				success(data) {
					let $data = JSON.parse(data);
					switch ($data.status.code) {
						case 200:
							console.log('USER authenticated');

							vm.$route.meta['email'] = $data.info.email;

							// update routes data with user logged in status
							let user_info = $data.info.user_info;

							if (!vm.$route.meta.admin_user) {
								vm.$route.meta['admin_user'] = {};
							}

							vm.$route.meta['admin_user'].logged_in = true;
							vm.$route.meta['admin_user'].user_id = user_info.id;
							vm.$route.meta['admin_user'].user_email = user_info.email;
							vm.$route.meta['admin_user'].user_type = user_info.permissions;



							if (vm.welcomeBack <= 1) {
								setTimeout(function() {
									console.log('show toaster');
									toastr.info(`Welcome back ${$data.info.email}`);

									// vm.toggleLoadingscreen();
								}, 1500);
							}


							break;
						case 400:
							console.log('USER NOT authenticated');
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
		this.welcomeBack += 1;
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

.top-bar {
    height: 45px;
    background-color: #FDFDFE;
    width: 96%;
    position: fixed;
    z-index: 10000;
    top: 0;
    left: 4%;
}

.fade-enter-active,
.fade-leave-active {
    transition: opacity 0.5s;
}
/* .fade-leave-active below version 2.1.8 */
.fade-enter,
.fade-leave-to {
    opacity: 0;
}

.dashboard-menu {

    &:hover {
        width: 20%;
    }
}
</style>
