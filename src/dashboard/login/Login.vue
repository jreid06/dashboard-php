<template>
<div class="login-form">
	<logo></logo>
	<form>
		<div class="form-group">
			<br>
			<h3 class="text-center">Admin Login</h3>
			<hr>
		</div>
		<div class="form-group">
			<label for="exampleInputEmail1">Email address</label>
			<input type="email"
			       class="form-control"
			       id="exampleInputEmail1"
			       aria-describedby="emailHelp"
			       placeholder="Enter email"
			       v-model="login.email">
			<small id="emailHelp"
			       class="form-text text-muted">We'll never share your email with anyone else.</small>
		</div>
		<div class="form-group">
			<label for="exampleInputPassword1">Password</label>
			<input type="password"
			       class="form-control"
			       id="exampleInputPassword1"
			       placeholder="Password"
			       v-model="login.password">
		</div>
		<button type="submit"
		        class="btn btn-primary">Submit</button>
	</form>
</div>
</template>

<script>
import Logo from './../logo/Logo.vue'

export default {
	components: {
		'logo': Logo
	},
	data: function() {
		return {
			login: {
				email: '',
				password: ''
			}
		}
	},
	methods: {
		loginUser() {
			/*
				// NOTE:

				- validate email. make sure its correct
				- make sure password is longer than 4 and only contains correct letters (joi);

				- submit form event to php
					- check if user exists.
					- TRUE - LOG user in FALSE - show error

			*/
		}
	}
}
</script>

<style lang="scss" scoped>
.login-form {
    width: 80%;
    padding: 20px;
    box-shadow: 0 0 2px #d2d2d2;
    margin: 150px auto;
    transition: all 0.5s ease;

    @media only screen and (min-width: 568px) {
        max-width: 350px;
    }

    @media only screen and (min-width: 768px) {
        max-width: 400px;
    }

    @media only screen and (min-width: 1200px) {
        max-width: 350px;
    }
}
</style>
