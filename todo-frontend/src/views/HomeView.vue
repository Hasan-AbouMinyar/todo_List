<template>
  <div class="container">
    <h1>Todo List</h1>
    
    <form @submit.prevent="addTask">
      <input v-model="newTask.title" placeholder="Title" required />
      <input v-model="newTask.description" placeholder="Description" />
      <label>
        <input type="checkbox" v-model="newTask.completed" />
        Completed
      </label>
      <button type="submit">Add Task</button>
    </form>

    <ul>
      <li v-for="task in tasks" :key="task.id">
        <strong>{{ task.title }}</strong>: {{ task.description }} - 
        <em>{{ task.completed ? '✅' : '❌' }}</em>
      </li>
    </ul>
  </div>
</template>

<script setup>
import { ref, onMounted } from 'vue'
import axios from 'axios'

const newTask = ref({
  title: '',
  description: '',
  completed: false
})

const tasks = ref([])

const addTask = async () => {
  try {
    const res = await axios.post('http://127.0.0.1:8000/api/tasks', newTask.value)
    tasks.value.push(res.data)
    newTask.value = { title: '', description: '', completed: false }
  } catch (err) {
    console.error('Error adding task:', err)
  }
}

onMounted(async () => {
  const res = await axios.get('http://127.0.0.1:8000/api/tasks')
  tasks.value = res.data
})
</script>

<style>
.container {
  max-width: 600px;
  margin: auto;
  padding: 20px;
}
</style>
 