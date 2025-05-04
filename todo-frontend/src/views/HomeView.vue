<template>
  <div class="container">
    <h1>Todo List</h1>

    <!-- form to add new task -->
    <form @submit.prevent="addTask">
      <input v-model="newTask.title" placeholder="Title" required />
      <input v-model="newTask.description" placeholder="Description" />
      <label>
        <input type="checkbox" v-model="newTask.completed" />
        Completed
      </label>
      <button type="submit">Add Task</button>
    </form>

    <!-- قائمة المهام -->
    <ul>
      <li v-for="task in tasks" :key="task.id">
        <strong>{{ task.title }}</strong>: {{ task.description }} - 
        <em>{{ task.completed ? '✅' : '❌' }}</em>
        <button @click="deleteTask(task.id)">Delete</button>
        <button @click="toggleComplete(task)">Toggle Complete</button>
      </li>
    </ul>
  </div>
</template>

<script setup>
import { ref, onMounted } from 'vue'
import axios from 'axios'

const API_URL = import.meta.env.VITE_API_URL || 'http://127.0.0.1:8000/api'

const newTask = ref({
  title: '',
  description: '',
  completed: false
})

const tasks = ref([])

// Fetch tasks from the API
const fetchTasks = async () => {
  try {
    const res = await axios.get(`${API_URL}/tasks`)
    tasks.value = res.data
  } catch (err) {
    console.error('Error fetching tasks:', err)
  }
}

// Add a new task
const addTask = async () => {
  try {
    const res = await axios.post(`${API_URL}/tasks`, newTask.value)
    tasks.value.push(res.data)
    newTask.value = { title: '', description: '', completed: false }
  } catch (err) {
    console.error('Error adding task:', err)
  }
}

// Delete a task
const deleteTask = async (id) => {
  try {
    await axios.delete(`${API_URL}/tasks/${id}`)
    tasks.value = tasks.value.filter(task => task.id !== id)
  } catch (err) {
    console.error('Error deleting task:', err)
  }
}

// Toggle task completion
const toggleComplete = async (task) => {
  try {
    const updatedTask = { ...task, completed: !task.completed }
    const res = await axios.put(`${API_URL}/tasks/${task.id}`, updatedTask)
    const index = tasks.value.findIndex(t => t.id === task.id)
    tasks.value[index] = res.data
  } catch (err) {
    console.error('Error updating task:', err)
  }
}

onMounted(fetchTasks)
</script>

<style>
.container {
  max-width: 600px;
  margin: auto;
  padding: 20px;
}
</style>
