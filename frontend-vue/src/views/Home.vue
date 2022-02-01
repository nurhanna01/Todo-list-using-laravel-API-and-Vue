<template>
  <div class="container">
    <strong>ToDo List Today</strong>
    <p v-bind="h"></p>
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
export default {
  name: "Home",

  data() {
    return {
      isloggedIn: localStorage.getItem("isloggedIn"),

      token: localStorage.getItem("token"),

      lists: [],

      h: "",
    };
  },

  methods: {},
  created() {
    axios
      .get("http://localhost:8000/api/todo/index", {
        headers: { Authorization: "Bearer " + this.token },
      })
      .then((response) => {
        console.log(response.data.data);
        this.lists = response.data.data;
        this.h = Object.keys(this.lists.data.date[0])[0];
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
