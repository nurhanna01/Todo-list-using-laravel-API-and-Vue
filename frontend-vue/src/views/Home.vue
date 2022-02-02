<template>
  <div class="container">
    <strong>ToDo List Today</strong>
    <p></p>
    <button class="btn btn-primary float-end" v-on:click="addList">
      <i class="fa fa-plus"></i> Add new todo list
    </button>
    <table class="table table-success">
      <thead>
        <tr>
          <th>Date</th>
          <th>Task</th>
          <th>Status</th>
        </tr>
      </thead>
      <tbody>
        <tr v-for="list in lists" :key="list.id">
          <td>{{ list.date }}</td>
          <td>{{ list.task }}</td>
          <td>
            <a
              v-if="list.is_approved == 1"
              type="button"
              class="btn btn-secondary"
              >Approved</a
            >
            <a
              v-else-if="list.is_approved == 0"
              type="button"
              class="btn btn-info"
              v-on:click="update(list.id)"
              >Approve</a
            >
          </td>
        </tr>
      </tbody>
    </table>
  </div>
</template>

<script>
import axios from "axios";
axios.defaults.headers.common["Authorization"] =
  "Bearer " + localStorage.getItem("token");

export default {
  name: "Home",

  data() {
    return {
      isloggedIn: localStorage.getItem("isloggedIn"),

      token: localStorage.getItem("token"),

      lists: [],
    };
  },

  methods: {
    update(user_id) {
      axios
        .put("http://localhost:8000/api/todo/update", {
          id: user_id,
        })
        .then((response) => {
          alert(response.data.message);
          axios
            .get("http://localhost:8000/api/todo/index", {})
            .then((response) => {
              console.log(response.data.data);
              this.lists = response.data.data;
            });
        })
        .catch((error) => {
          if (error.response) {
            alert(error.response.data.error);
          }
        });
    },
    addList() {
      return this.$router.push({ name: "addList" });
    },
  },
  created() {
    axios
      .get("http://localhost:8000/api/todo/index", {})
      .then((response) => {
        console.log(response.data.data);
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
<style>
th,
td {
  text-align: center;
}
</style>
