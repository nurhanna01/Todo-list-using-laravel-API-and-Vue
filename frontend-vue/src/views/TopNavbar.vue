<template>
  <nav class="navbar navbar-dark fixed-top bg-dark">
    <ul class="nav nav-tabs">
      <li class="nav-item">
        <router-link :to="{ name: 'home' }" class="nav-link active"
          ><font-awesome-icon icon="fas fa-home" /> Home</router-link
        >
      </li>
    </ul>
    <ul class="nav nav-tabs m-2 mr-4">
      <li class="nav-item dropdown dropstart">
        <a
          class="dropdown-toggle nav-link active"
          data-bs-toggle="dropdown"
          href="#"
          role="button"
          aria-expanded="false"
          ><font-awesome-icon icon="fa-solid fa-user" /> Me</a
        >
        <ul class="dropdown-menu">
          <li>
            <router-link :to="{ name: 'profile' }" class="dropdown-item drop"
              ><font-awesome-icon icon="fa-solid fa-user-gear" /> My
              Profile</router-link
            >
          </li>
          <li>
            <button class="dropdown-item drop" v-on:click="logout">
              <font-awesome-icon icon="fa-solid fa-power-off" /> Logout
            </button>
          </li>
        </ul>
      </li>
    </ul>
  </nav>
</template>
<script>
import axios from "axios";
axios.defaults.headers.common["Authorization"] =
  "Bearer " + localStorage.getItem("token");

export default {
  name: "topnavbar",
  methods: {
    logout() {
      axios.get("http://localhost:8000/api/user/logout").then(() => {
        localStorage.removeItem("isloggedIn");

        return this.$router.push({ name: "login" });
      });
    },
  },
};
</script>
<style>
.drop:hover {
  background-color: #7267cb !important;
}

.dropdown,
.nav {
  background-color: white !important;
}
</style>
