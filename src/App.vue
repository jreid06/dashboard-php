<template>
<v-app>
	<router-view></router-view>
</v-app>
</template>

<script>
export default {
	name: 'app',
	data() {
		return {
			msg: 'Welcome to Your Vue.js App',
			unloaded: false
		}
	},
	methods: {
		signUserOut() {
			let vm = this;

			if (!vm.unloaded) {
				$.ajax({
					type: 'post',
					url: '/backend/controller/logout.php',
					success: function() {
						vm.unloaded = true;
						window.location.reload();
					}
				});
			}
		}
	},
	beforeCreate() {
		this.$route.meta['user'] = {
			loggedIn: false,
			user_type: 'guest',
			user_name: '',
			user_id: ''
		};
	},
	beforeMount() {
		// this.testFunc();
	},
	mounted() {
		toastr.options.progressBar = true;

		// log user out and update the database if user closes browser or tab during a session
		// $(window).on('unload', this.signUserOut);
	}
}
</script>

<style lang="scss">
body,
html {
    height: 100%;
}

.inp-prepend-custom {
    // border: 1px solid red;
    padding: 5px;
}

#app {
    font-family: 'Avenir', Helvetica, Arial, sans-serif;
    -webkit-font-smoothing: antialiased;
    -moz-osx-font-smoothing: grayscale;
    // text-align: center;
    color: #2c3e50;
    // margin-top: 60px;
}

h1,
h2 {
    font-weight: normal;
}

.inline-list {
    list-style-type: none;
    padding: 0;

    li {
        display: inline-block;
        margin: 0 10px;
    }
}

a {
    color: #42b983;
}
</style>
