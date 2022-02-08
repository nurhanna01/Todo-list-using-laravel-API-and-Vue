<template>
  <div class="container">
    <form v-on:submit.prevent>
      <div class="mb-3">
        <label for="name" class="form-label">Name</label>
        <input
          type="text"
          class="form-control"
          id="name"
          aria-describedby="name"
          v-model="profile.name"
        />
      </div>
      <div class="mb-3">
        <label for="exampleInputEmail1" class="form-label">Email address</label>
        <input
          type="email"
          class="form-control"
          id="exampleInputEmail1"
          aria-describedby="emailHelp"
          v-model="profile.email"
          disabled
        />
      </div>
      <div class="mb-3">
        <label for="birth" class="form-label">Birthday</label>
        <input
          type="date"
          class="form-control"
          id="birth"
          v-model="profile.birth"
        />
      </div>
      <div class="mb-3">
        <label for="gender" class="form-label">Gender</label>
        <select id="" class="form-select" v-model="profile.gender">
          <option value="none">select gender</option>
          <option value="P">Women</option>
          <option value="L">Men</option>
        </select>
      </div>
      <button type="submit" class="btn btn-primary" v-on:click="updateProfile">
        Submit
      </button>
    </form>
  </div>
</template>

<script>
import axios from "axios";
axios.defaults.headers.common["Authorization"] =
  "Bearer " + localStorage.getItem("token");

export default {
  name: "editprofile",
  data() {
    return {
      profile: "",
      isloggedIn: localStorage.getItem("isloggedIn"),
    };
  },
  methods: {
    updateProfile() {
      axios
        .put("http://localhost:8000/api/user/profil", {
          name: this.profile.name,
          birth: this.profile.birth,
          gender: this.profile.gender,
        })
        .then((response) => {
          alert(response.data.message);
          return this.$router.push({ name: "profile" });
        })
        .catch((error) => {
          if (error.response) {
            alert(error.response.data.error);
          }
        });
    },
  },
  created() {
    axios
      .get("http://localhost:8000/api/user/profil", {})
      .then((response) => {
        console.log(response.data.data);
        this.profile = response.data.data;
      })
      .catch((error) => {
        console.log(error);
      });
  },
  mounted() {
    if (!this.isloggedIn) {
      return this.$router.push({ name: "login" });
    }
  },
};
</script>
