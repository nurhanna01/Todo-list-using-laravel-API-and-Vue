<template>
  <div class="container">
    <strong>ToDo List Today</strong>
    <p></p>
    <button class="btn btn-primary float-end" v-on:click="addList">
      <font-awesome-icon icon="fa-solid fa-plus" /> Add new todo list
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
              type="button"
              class="btn btn-danger"
              v-on:click="destroy(list.id)"
              >Delete</a
            >
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

      lists: [],
    };
  },

  methods: {
    update(id) {
      axios
        .put("http://localhost:8000/api/todo", {
          id: id,
        })
        .then((response) => {
          axios.get("http://localhost:8000/api/todo", {}).then((response) => {
            console.log(response.data.data);
            this.lists = response.data.data;
          });
          this.$swal({
            icon: "success",
            title: response.data.message,
            showConfirmButton: false,
            timer: 1000,
          });
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
    destroy(id) {
      this.$swal({
        title: "Are you sure to delete this task ?",
        text: "You won't be able to revert this!",
        icon: "warning",
        showCancelButton: true,
        confirmButtonColor: "#3085d6",
        cancelButtonColor: "#d33",
        confirmButtonText: "Yes, delete it!",
      }).then((result) => {
        if (result.isConfirmed) {
          axios
            .delete("http://localhost:8000/api/todo/" + id, {})
            .then((response) => {
              this.$swal({
                icon: "success",
                title: response.data.data,
                showConfirmButton: false,
                timer: 1500,
              });
              axios
                .get("http://localhost:8000/api/todo/", {})
                .then((response) => {
                  this.lists = response.data.data;
                });
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
        }
      });
    },
    addList() {
      return this.$router.push({ name: "addList" });
    },
  },
  created() {
    axios
      .get("http://localhost:8000/api/todo", {})
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
.btn-danger {
  margin-right: 20px;
}
</style>
