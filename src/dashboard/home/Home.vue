<style lang="scss" scoped>
.jumbotron {
    background-color: transparent !important;
}

.home-column {
    padding-bottom: 30px;
}
</style>

<template>
<div class="row h-100 align-items-center">
	<template v-if="loading">
        <transition name="fade">
            <div class="col-10 offset-1">
        		<div class="spinner"></div>
        	</div>
        </transition>
    </template>
	<template v-else>
        <!-- <transition name="fade"> -->
            <div class="col-10 offset-1 home-column">
                <div class="row">
                    <div class="col-7">
                        <h4 class="pt-8">Welcome to the Admin dashboard</h4>
                        <ul class="inline-list">
                            <li><a href="#/admin/login"
                                   class="btn btn-primary">Login</a></li>
                            <li><a href="#/admin/register"
                                   class="btn btn-primary">Register</a></li>
                            <li><a href="#"
                                   class="btn btn-danger"
                                   @click="logout">Logout</a> </li>
                        </ul>
                    </div>

                </div>
            </div>

            <div class="col-10 offset-1 home-column">
                <div class="row">
                    <disk-widget :columns="4"></disk-widget>
                    <project-stats :columns="8"></project-stats>
                </div>

                <div class="row">
                    <user-activity :columns="12"></user-activity>
                </div>

                <div class="row">
                    <recommended-widget :columns="4"></recommended-widget>
                    <active-widgets :columns="8"></active-widgets>
                </div>
            </div>

            <div class="col-10 offset-1 home-column">
                <div class="row">
                    <stats-list :columns="4"></stats-list>
                </div>
            </div>
        <!-- </transition> -->
    </template>



</div>
</template>

<script>
import Nav from './../navigation/Nav.vue'
import Statslist from './../widgets/Quickstatslist.vue'
import Projectstatcards from './../widgets/Projectstats.vue'
import Widgetsvisual from './../widgets/Widgetslist.vue'
import Recommendedwidget from './../widgets/Recommendedwidget.vue'
import Diskwidget from './../widgets/Disk_details.vue'
import Activeusers from './../widgets/Usersactivity.vue'
// import Toastr from 'toastr'

// const toastr = require('toastr');

export default {
	components: {
		'nav-dashboard': Nav,
		'stats-list': Statslist,
		'project-stats': Projectstatcards,
		'active-widgets': Widgetsvisual,
		'user-activity': Activeusers,
		'recommended-widget': Recommendedwidget,
		'disk-widget': Diskwidget
	},
	methods: {
		logout() {
			console.log('logging user out');

			$.ajax({
				url: '/backend/controller/logout.php',
				type: 'post',
				success(data) {
					console.log(data);
					window.location.reload();
				},
				error() {

				}
			})
		},
		hideLoadingscreen() {
			console.log('hide loading screen home');
			const vm = this;
			setTimeout(function() {
				vm.loading = false;
			}, 1500);
		}
	},
	data: function() {
		return {
			loading: true,
			items: []
		}
	},
	mounted() {
		this.hideLoadingscreen();
	}
}
</script>
