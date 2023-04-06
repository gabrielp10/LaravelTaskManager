import './bootstrap';
import {createApp} from 'vue'
import TaskList from './/components/TaskList.vue';

const app = createApp({})
app.component('task-list', TaskList)
app.mount('#app')
