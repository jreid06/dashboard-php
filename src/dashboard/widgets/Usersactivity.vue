<template lang="html">
<div :class="'col-12 col-lg-'+columns">
    <br>
    <hr>
    <div class="header">
        <h4>Admin users login activity</h4>
    </div>
    <div v-if="!error">
        <ul class="list-group list-group-flush">
          <li class="list-group-item" v-for="user in active_users">
              <p class="font-weight-bold">{{user.email}} - ID: {{user.id}} - created {{user.createdAt}}</p>
              <p><i>Last Logged in: {{user.last_login_date}}</i></p>
              <p>
                  &nbsp;&nbsp;
                  <span class="badge badge-success">active</span>
                  <span class="badge badge-info" v-if="user.email == $route.meta.email">YOU</span>
              </p>
          </li>
        </ul>
    </div>
    <div v-else>
        <ul class="list-group list-group-flush">
            <li class="list-group-item"><h4>ERROR DISPLAYING ACTIVE USERS</h4></li>
        </ul>
    </div>

</div>
</template>

<script>
export default {
	props: {
		columns: {
			type: Number,
			required: true
		}

	},
	data: function() {
		return {
			active_users: [],
			error: false
		}
	},
	methods: {
		getActiveUsers() {
			let vm = this;

			$.ajax({
				url: '/backend/controller/stats.php',
				type: 'get',
				data: {
					stat_type: 'active users'
				},
				success(data) {
					let $data = JSON.parse(data);
					console.log('success active users');
					console.log($data);
					switch ($data.status.code) {
						case 200:
							for (var i = 0; i < $data.info.data.length; i++) {
								vm.active_users.push($data.info.data[i]);
							}
							break;
						case 400:
							vm.error = true;
							break;
						default:

					}


				},
				error() {

				}
			})
		}
	},
	mounted() {
		this.getActiveUsers();
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
