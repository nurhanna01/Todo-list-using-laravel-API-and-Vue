<template>
  <div class="container">
    <p>Add new list</p>
    <div class="row g-3">
      <div class="col-sm-9">
        <input
          type="text"
          class="form-control"
          placeholder="Input Task"
          aria-label=""
          v-model="task"
          v-on:keyup.enter="create"
        />
      </div>
      <div class="col-sm">
        <button type="submit" class="btn btn-primary" v-on:click="create">
          Save
        </button>
      </div>
    </div>
    <br />
    <div class="row g-3">
      <div class="col-sm-9"></div>
      <div class="col-sm">
        <button type="submit" class="btn btn-success" v-on:click="done">
          Done
        </button>
      </div>
    </div>
    <ul v-for="list in lists" :key="list.id">
      <li>{{ list.task }}</li>
    </ul>
  </div>
</template>

<script>
import axios from "axios";
axios.defaults.headers.common["Authorization"] =
  "Bearer " + localStorage.getItem("token");
export default {
  name: "addList",

  data() {
    return {
      isloggedIn: localStorage.getItem("isloggedIn"),

      task: "",

      lists: [],
    };
  },

  methods: {
    create() {
      axios
        .post("http://localhost:8000/api/todo", {
          task: this.task,
        })
        .then((response) => {
          this.$swal({
            icon: "success",
            title: response.data.data,
            showConfirmButton: false,
            timer: 1000,
          });
          axios.get("http://localhost:8000/api/todo", {}).then((response) => {
            this.lists = response.data.data;
          });
          this.task = "";
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
    },

    done() {
      return this.$router.push({ name: "home" });
    },
  },

  created() {
    axios
      .get("http://localhost:8000/api/todo", {})
      .then((response) => {
        this.lists = response.data.data;
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
