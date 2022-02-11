<template>
  <div class="container-md">
    <div class="card">
      <div class="card-body">
        <form @submit.prevent="login">
          <div class="mb-3">
            <div v-if="loginFailed" class="mt-2 alert alert-danger">
              Password Required
            </div>
            <label for="email" class="form-label">Email address</label>
            <input
              type="email"
              class="form-control"
              id="email"
              placeholder="name@gmail.com"
              v-model="user.email"
            />
            <div v-if="validation.email" class="mt-2 alert alert-danger">
              Email Required
            </div>
          </div>

          <div class="mb-3">
            <label for="password" class="form-label">Password</label>
            <input
              type="password"
              class="form-control"
              id="password"
              placeholder="type your password"
              v-model="user.password"
            />
            <div v-if="validation.password" class="mt-2 alert alert-danger">
              Password Required
            </div>
          </div>
          <button type="submit" class="btn btn-primary float-end">LOGIN</button>
        </form>
        <p>
          Don't have an account yet?
          <router-link to="register">Click here!</router-link>
        </p>
      </div>
    </div>
  </div>
</template>

<script>
import axios from "axios";

export default {
  name: "Login",

  data() {
    return {
      isloggedIn: localStorage.getItem("isloggedIn"),

      token: localStorage.getItem("token"),

      user: { email: "", password: "" },

      validation: { email: false, password: false },

      loginFailed: null,
    };
  },

  methods: {
    login() {
      if (this.user.email && this.user.password) {
        axios
          .get("http://localhost:8000/sanctum/csrf-cookie")
          .then((response) => {
            console.log(response);
            axios
              .post("http://127.0.0.1:8000/api/user/login", {
                email: this.user.email,
                password: this.user.password,
              })
              .then((res) => {
                console.log(res);

                if (res.data.code == 200) {
                  localStorage.setItem("isloggedIn", "true");

                  localStorage.setItem("token", res.data.data.token);

                  this.isloggedIn = true;
                  return this.$router.push({ name: "home" });
                }
              })
              .catch((error) => {
                if (error.response) {
                  this.$swal({
                    icon: "error",
                    title: error.response.data.error,
                    showConfirmButton: true,
                  });
                }
              });
          });
      }
      // update when form resubmit
      this.validation.email = false;
      this.validation.password = false;

      if (!this.user.email || !this.user.password) {
        if (!this.user.email && !this.user.password) {
          this.validation.email = true;
          this.validation.password = true;
        }
        if (!this.user.email) {
          this.validation.email = true;
        }
        if (!this.user.password) {
          this.validation.password = true;
        }
      }
    },

    mounted() {
      if (this.isloggedIn) {
        return this.$router.push({ name: "home" });
      }
    },
  },
};
</script>
