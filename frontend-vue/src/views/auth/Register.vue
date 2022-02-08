<template>
  <div class="container-md">
<<<<<<< HEAD
    <p>hanna</p>
=======
    <b>Register</b>
>>>>>>> 9780ec61e8e4422c8ca99ba9779886691a98fc5b
    <form v-on:submit.prevent>
      <div class="mb-3">
        <label for="name" class="form-label">Name</label>
        <input
          type="text"
          class="form-control"
          id="name"
          aria-describedby="name"
          v-model="user.name"
        />
      </div>
      <div class="mb-3">
        <label for="exampleInputEmail1" class="form-label">Email address</label>
        <input
          type="email"
          class="form-control"
          id="exampleInputEmail1"
          aria-describedby="emailHelp"
          v-model="user.email"
        />
        <div id="emailHelp" class="form-text">
          We'll never share your email with anyone else.
        </div>
        <div v-if="validation.email" class="mt-2 alert alert-danger">
          Email Required
        </div>
        <div v-if="isError.email" class="mt-2 alert alert-danger">
          {{ error.email[0] }}
        </div>
      </div>
      <div class="mb-3">
        <label for="exampleInputPassword1" class="form-label">Password</label>
        <input
          type="password"
          class="form-control"
          id="exampleInputPassword1"
          v-model="user.password"
        />
        <div v-if="validation.email" class="mt-2 alert alert-danger">
          Password Required
        </div>
        <div v-if="isError.password" class="mt-2 alert alert-danger">
          {{ error.password[0] }}
        </div>
      </div>
      <div class="mb-3">
        <label for="birth" class="form-label">Birthday</label>
        <input
          type="date"
          class="form-control"
          id="birth"
          v-model="user.birth"
        />
      </div>
      <div class="mb-3">
        <label for="gender" class="form-label">Gender</label>
        <select id="" class="form-select" v-model="user.gender">
          <option value="none">select gender</option>
          <option value="P">Women</option>
          <option value="L">Men</option>
        </select>
      </div>
      <button type="submit" class="btn btn-primary" v-on:click="register">
        Submit
      </button>
    </form>
  </div>
</template>

<script>
import axios from "axios";

export default {
  name: "Register",

  data() {
    return {
      validation: { email: false, password: false },

      user: {},

      isError: { email: false, password: false },

      error: {},
    };
  },

  methods: {
    register() {
      if (this.user.email && this.user.password) {
        console.log(this.user);
        axios.get("http://localhost:8000/sanctum/csrf-cookie").then(() => {
          axios
            .post("http://localhost:8000/api/user/register", {
              name: this.user.name,
              email: this.user.email,
              password: this.user.password,
              birth: this.user.birth,
              gender: this.user.gender,
            })
            .then((response) => {
              alert(response.data.message);
              this.user = "";
              return this.$router.push({ name: "login" });
            })
            .catch((error) => {
              if (error.response) {
                if (error.response.data.errorDetail.email) {
                  this.isError.email = true;
                  this.error.email = error.response.data.errorDetail.email;
                }
                if (error.response.data.errorDetail.password) {
                  this.isError.password = true;
                  this.error.password =
                    error.response.data.errorDetail.password;
                }
                alert(error.response.data.error);
              }
            });
        });
      }
      // update when form resubmit
      this.isError.email = false;
      this.isError.password = false;

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
  },
};
</script>
