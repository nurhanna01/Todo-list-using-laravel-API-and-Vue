<template>
  <div class="container">
    <div class="card">
      <div class="card-body">
        <img
          src="../../public/icon_profile.png"
          class="mx-auto d-block"
          width="300"
        />

        <div class="row border-top">
          <div class="col"><p>Name</p></div>
          <div class="col">
            <p>{{ myProfile.name }}</p>
          </div>
        </div>
        <div class="row border-top">
          <div class="col"><p>Email</p></div>
          <div class="col">
            <p>{{ myProfile.email }}</p>
          </div>
        </div>
        <div class="row border-top">
          <div class="col"><p>Jenis Kelamin</p></div>
          <div class="col">
            <p v-if="myProfile.gender == 'P'">Perempuan</p>
            <p v-if="myProfile.gender == 'L'">Laki-laki</p>
          </div>
        </div>

        <div class="row border-top">
          <div class="col"><p>Tanggal Lahir</p></div>
          <div class="col">
            <p>{{ myProfile.birth }}</p>
          </div>
        </div>
        <router-link
          :to="{ name: 'editprofile' }"
          class="btn btn-primary mx-auto d-block"
          >Edit Profile</router-link
        >
      </div>
    </div>
  </div>
</template>

<script>
import axios from "axios";
axios.defaults.headers.common["Authorization"] =
  "Bearer " + localStorage.getItem("token");

export default {
  name: "Profile",

  data() {
    return {
      isloggedIn: localStorage.getItem("isloggedIn"),

      myProfile: [],
    };
  },
  created() {
    axios
      .get("http://localhost:8000/api/user/profil", {})
      .then((response) => {
        console.log(response.data.data);
        this.myProfile = response.data.data;
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
<style>
img {
  position: center;
}
</style>
