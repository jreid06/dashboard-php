<template>
<div class="row h-100 justify-content-center align-items-center adminuser-row">
	<template v-if="!loading">
	<div class="container-fluid">
		<div class="row">
			<div class="col-11">
				<h4 class="pt-8">Admin Users</h4>
			</div>
		</div>
		<div class="row pl-4">
			<div class="col-8">
				<div v-if="error">

				</div>
				<div class="user-table-div"
				     v-else>

					<table class="table table-borderless">
						<thead>
							<tr class="text-capitalize">
								<th scope="col"
								    class="text-uppercase">id</th>
								<th scope="col">email</th>
								<th scope="col">created</th>
								<th scope="col">permissions</th>
								<th scope="col">last login</th>
								<th scope="col"
								    class="text-center">active</th>
							</tr>
						</thead>
						<tbody>
							<tr class="user-row"
							    v-for="(user, index) in admin_users">
								<th scope="row"
								    class="user-row-item">{{user.id}}</th>
								<td class="user-row-item">{{user.email}}</td>
								<td class="user-row-item">{{user.createdAt}}</td>
								<td class="user-row-item text-capitalize">{{user.permissions}}</td>
								<td class="user-row-item">{{user.last_login_date}}</td>
								<td class="user-row-item text-center justify-content-center">
									<p>
										<span class="badge badge-pill badge-success"
										      v-if="user.login_status === 'true'">&nbsp;</span>
										<span class="badge badge-pill badge-danger"
										      v-else>&nbsp;</span>
									</p>

									<template v-if="$route.meta.admin_user.user_type === 'superuser'">
								  <p>
		    						  <span><i class="material-icons">settings</i></span>
								</p>
								</template>

	</td>
	</tr>
	</tbody>
	</table>
</div>
</div>
<recommended-widget :columns="3"></recommended-widget>
</div>
</div>
</template>

<template v-else>
<loading-screen></loading-screen>
</template>
</div>
</template>


<script>
import Loader from './../../Loading.vue'
import Recommendedwidget from './../../widgets/Recommendedwidget.vue'

export default {
	components: {
		'loading-screen': Loader,
		'recommended-widget': Recommendedwidget
	},
	data: function() {
		return {
			admin_users: [],
			error: false,
			loading: true
		}
	},
	methods: {
		getAllUsers() {
			const vm = this;
			$.ajax({
				url: '/backend/controller/stats.php',
				type: 'get',
				data: {
					stat_type: 'all admin users'
				},
				success(data) {
					let $data = JSON.parse(data);

					console.log($data);
					switch ($data.status.code) {
						case 200:

							// push our users data into array to be rendered in template
							for (var i = 0; i < $data.info.data.length; i++) {
								vm.admin_users.push($data.info.data[i]);
							}
							break;
						case 400:
							vm.error = !vm.error;
							break;
						default:

					}

					setTimeout(function() {
						vm.hideLoadingscreen();
					}, 2000)
				},
				error() {

				}
			})
		},
		hideLoadingscreen() {
			this.loading = !this.loading;
			$('.adminuser-row').removeClass('h-100');
		}
	},
	mounted() {
		this.getAllUsers();
	}
}
</script>

<style lang="scss" scoped>
.adminuser-row {
    transition: all 0.4s;
}

.user-row {
    &:nth-child(2n+2) {
        background-color: lighten(#e5e5e5, 4%);
    }
}

.badge-success {
    box-shadow: 0 0 3px #28A745;
}

.badge-danger {
    box-shadow: 0 0 3px #DC3545;
}

.user-row-item {
    vertical-align: middle;

    &:nth-last-child(1) {
        display: inline-flex;
        border-top: 0 !important;
        width: 100%;
    }

    p {
        width: 100%;
        padding-top: 15px;

        &:nth-child(2) {
            cursor: pointer;
            transition: all 0.2s;

            &:hover {
                color: #007BFF;
            }
        }
        // border: 1px solid red;
    }

    // .badge {
    //     width: 30px;
    //     height: 30px;
    //     // padding: 5px;
    // }
}

.fade-leave-active,
.u .fade-enter-active {
    transition: opacity 0.5s;
}
/* .fade-leave-active below version 2.1.8 */
.fade-enter,
.fade-leave-to {
    opacity: 0;
}

.user-table-div {
    // margin-top: 40px;

    table {
        background-color: transparent !important;
    }

    thead {
        tr {
            th {
                padding-bottom: 20px;
            }
        }
    }
}
</style>
