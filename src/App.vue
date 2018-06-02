<template>
<router-view></router-view>
</template>

<script>
export default {
	name: 'app',
	data() {
		return {
			msg: 'Welcome to Your Vue.js App',
			unloaded: false,
			count: 0
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
	watch: {
		count(val) {
			if (val <= 1) {
				this.$route.meta['admin_user'] = {
					logged_in: false,
					user_type: '',
					user_email: '',
					user_id: ''
				};
			}
		}
	},
	beforeCreate() {

	},
	beforeMount() {
		// this.testFunc();
	},
	mounted() {
		toastr.options.progressBar = true;
		if (this.count < 1) {
			this.count += 1;
		}



		// log user out and update the database if user closes browser or tab during a session
		// $(window).on('unload', this.signUserOut);
	}
}
</script>

<style lang="scss">
@import '../node_modules/spinkit/scss/spinners/1-rotating-plane';

.spinner {
    width: 40px;
    height: 40px;
    background-color: #007BFF;

    margin: 100px auto;
    -webkit-animation: sk-rotatePlane 1.2s infinite ease-in-out;
    animation: sk-rotatePlane 1.2s infinite ease-in-out;
}

body,
html {
    height: 100%;
}

.inp-prepend-custom {
    // border: 1px solid red;
    padding: 5px;
}

.material-icons {
    padding-right: 0 !important;
}

#app {
    font-family: 'Avenir', Helvetica, Arial, sans-serif;
    -webkit-font-smoothing: antialiased;
    -moz-osx-font-smoothing: grayscale;
    // text-align: center;
    color: #2c3e50;
    // margin-top: 60px;
}

.pt-8 {
    padding-top: 80px;
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
