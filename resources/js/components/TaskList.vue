<template>
  <div>
    <div class="input-group mb-3">
      <input type="text" class="form-control" placeholder="Search tasks" v-model="searchInput" @input="performSearch" />
      <a class="btn btn-light border" href="/task/create">New Task</a>
    </div>
    <div class="card card-body bg-light p-4">
      <div v-if="loading" class="text-center">
        <i class="fa fa-spinner fa-spin"></i> Loading...
      </div>
      <div v-else>
        <div v-if="tasks.length > 0" v-for="task in tasks" :key="task.id">
          <div class="card-header">
            <span class="fw-bolder">{{ task.title }}</span>
            <span class="badge bg-warning text-dark mx-1">{{ task.created_at_formatted }}</span>
            <small>Last updated - {{ task.updated_at_formatted }}</small>
          </div>
          <div class="row">
            <div class="col-9">
              <div class="card-body">
                <div class="card-text">{{ task.description }}</div>
                <br>
                <span v-if="task.status === 'To-do'" class="badge bg-info text-dark">To-do</span>
                <span v-else class="badge bg-success text-white">Done</span>
              </div>
            </div>
            <div class="col-3 d-flex align-items-center justify-content-end">
              <a :href="'/task/' + task.id + '/edit'" class="btn btn-sm btn-light border d-inline">✏️ Edit</a>
              <button type="button" class="btn btn-sm btn-light border mx-2" @click="deleteTask(task.id)">🗑️ Delete</button>
            </div>
          </div>
          <div class="clearfix"></div>
        </div>
        <div v-else>
          <div class="alert alert-danger p-2 text-center">No Tasks found</div>
          <div class="container">
          <div class="card-body d-flex justify-content-center">
            <a href="/task/create" class="btn btn-sm btn-info">Create Task</a>
          </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import axios from 'axios';

export default {
  searchInput: "",
  data() {
    return {
      loading: true,
      tasks: [],
      searchInput: '',
    }
  },
  created() {
    const query = new URLSearchParams(window.location.search).get('query');
    if (query) {
      this.searchTasks(query);
    } else {
      this.getTasks();
    }
  },
  methods: {
    getTasks() {
      this.loading = true;
      let url = '/api/task-index';
      axios.get(url, { params: { query: this.searchInput } })
        .then(response => {
          this.tasks = response.data.tasks;
          this.loading = false;
        })
        .catch(error => {
          console.log(error);
          this.loading = false;
        });
    },
    searchTasks(query) {
      this.loading = true
      axios.get('/api/task-index', { params: { query } })
        .then(response => {
          this.tasks = response.data.tasks
          this.loading = false
        })
        .catch(error => {
          console.log(error)
          this.loading = false
        })
    },
    performSearch() {
      if (this.searchInput) {
        this.searchTasks(this.searchInput);
      } else {
        this.getTasks();
      }
    },
    deleteTask(taskId) {
    if (confirm("Are you sure you want to delete this task?")) {
      axios.delete(`/task/${taskId}`, {
        headers: {
          "X-Requested-With": "XMLHttpRequest",
          "X-CSRF-TOKEN": document.querySelector('meta[name="csrf-token"]').getAttribute('content')
        }
      })
      .then(() => {
        this.tasks = this.tasks.filter(task => task.id !== taskId);
      })
      .catch(error => {
        console.error(error);
      });
    }
  }
  }

}
</script>
