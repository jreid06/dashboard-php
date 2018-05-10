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

<template>
<div class="login-form">
	<logo></logo>
	<form v-on:submit="createAdmin"
	      id="customForm">
		<div class="form-group">
			<br>
			<h3 class="text-center">Create Admin User</h3>
			<hr>
		</div>
		<div class="form-group">
			<label for="exampleInputEmail1">Email address</label>
			<input type="email"
			       class="form-control"
			       id="exampleInputEmail1"
			       aria-describedby="emailHelp"
			       placeholder="Enter email"
			       v-model="form.email">
			<small id="emailHelp"
			       class="form-text text-muted">We'll never share your email with anyone else.</small>
		</div>
		<div class="form-group">
			<label for="exampleInputPassword1">Password</label>
			<input type="password"
			       class="form-control"
			       id="exampleInputPassword1"
			       placeholder="Password"
			       v-model="form.password">
		</div>
		<button type="submit"
		        class="btn btn-primary">Submit</button>

		<button class="btn btn-warning"
		        @click.prevent="newFunc">DEBUG AJAX</button>

	</form>
</div>
</template>

<script>
import Logo from './../logo/Logo.vue'
const Joi = require('joi');

export default {
	components: {
		'logo': Logo
	},
	data: function() {
		return {
			form: {
				email: '',
				password: '',
				error: {
					status: false,
					message: ''
				}
			}
		}
	},
	methods: {
		newFunc() {
			console.log('new func');
		},
		createAdmin(event) {

			// event.preventDefault();
			console.log('createAdmin');
			const vm = this;

			const schema = Joi.object().keys({
				email: Joi.string().email(),

				// NOTE: regex Upper & lower A-Z - all digits -  min len 3 max 30
				password: Joi.string().regex(/^[a-zA-Z0-9]{3,30}$/)
			})

			// validate form data against the schema
			const result = Joi.validate({
				email: vm.form.email,
				password: vm.form.password
			}, schema);

			/*
				// NOTE:

				- validate email. make sure its correct
				- make sure password is longer than 4 and only contains correct letters (joi);

				- submit form event to php
					- check if user exists.
					- TRUE - REDIRECT user to login route FALSE - CREATE user account in
			*/

			if (result.error) {
				switch (result.error.details[0].context.key) {
					case "email":
						console.log("EMAIL ERROR");
						break;
					case "password":
						console.log("PASSWORD ERROR");
						break;
					default:
						console.log("generic form error");
				}
			} else {
				$.ajax({
					url: 'http://dashboard-build.vue/backend/controller/register.php',
					type: 'post',
					data: {
						form_data: vm.form
					},
					success: function(data) {
						let $data = JSON.parse(data);

						switch ($data.status.code) {
							case 200:

								break;
							case 400:

								break;
							default:

						}
					},
					error: function() {
						// IDEA:
						// - display error route when something doesnt load correctly

					}
				})

			}

		}
	}
}
</script>
