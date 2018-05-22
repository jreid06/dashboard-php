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
<div class="login-form text-center">
	<logo></logo>
	<form v-on:submit.prevent="createAdmin"
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

		<div class="form-group">
			<label for="exampleInputPassword1">User Permissions</label>
			<select class="custom-select"
			        id="inputGroupSelect01"
			        v-model="form.permissionLevel">
                <option disabled value="">Choose...</option>
                <option value="superuser">Superuser</option>
                <option value="editor">Editor</option>
            </select>
		</div>
		<button type="submit"
		        class="btn btn-primary">Submit</button>

		<!-- SUCCESS MESSAGE DIV -->
		<div class="form-group"
		     v-if="form.success.status">
			<hr>
			<p v-html="form.success.message"
			   class="text-success text-capitalize"></p>
		</div>

		<!-- ERROR MESSAGE DIV -->
		<div class="form-group"
		     v-if="form.error.status">
			<hr>
			<p v-html="form.error.message"
			   class="text-danger text-capitalize"></p>
		</div>

		<div class="form-group">
			<hr>
			<ul class="inline-list">
				<li><a href="#/admin/login">Login with different admin account?</a> </li>
			</ul>
		</div>

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
				permissionLevel: '',
				success: {
					status: false,
					message: ''
				},
				error: {
					status: false,
					message: ''
				}
			}
		}
	},
	watch: {
		'form.error.status': function(val) {
			const vm = this;

			if (val) {
				setTimeout(function() {
					vm.form.error.status = false;
				}, 4000)
			}
		},
		'form.success.status': function(val) {
			const vm = this;

			if (val) {
				setTimeout(function() {
					vm.form.success.status = false;
				}, 10000)
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
				email: Joi.string().trim().email(),

				// NOTE: regex Upper & lower A-Z - all digits -  min len 3 max 30
				password: Joi.string().trim().regex(/^[a-zA-Z0-9]{3,30}$/),
				permissions: Joi.string().min(2).required()
			})

			// validate form data against the schema
			const result = Joi.validate({
				email: vm.form.email.toLowerCase(),
				password: vm.form.password,
				permissions: vm.form.permissionLevel
			}, schema);

			if (result.error) {
				switch (result.error.details[0].context.key) {
					case "email":
						console.log("EMAIL ERROR");
						vm.form.error.status = true;
						vm.form.error.message = "Invalid email entered";
						break;
					case "password":
						console.log("PASSWORD ERROR");
						vm.form.error.status = true;
						vm.form.error.message = "Invalid password entered. Must be 3-30 characters long and contain no special characters";
						break;
					case "permissions":
						console.log("PERMISSIONS ERROR");
						vm.form.error.status = true;
						vm.form.error.message = "Please select the permissions level for the account being created";
						break;
					default:
						console.log("generic form error");
				}
			} else {
				console.log('SIGNUP USER AS NO ERRORS');
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
								// show user a success message about account created successfully

								vm.form.success.status = true;
								vm.form.success.message = $data.info.message;


								break;
							case 400:

								vm.form.error.status = true;
								vm.form.error.message = $data.info.message;

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
