<template>
  <div class="container">
    <form @submit.prevent="addTask">
  <input v-model="newTask.title" type="text" placeholder="عنوان المهمة" required />
  <input v-model="newTask.description" type="text" placeholder="الوصف" />
  <label>
    <input v-model="newTask.completed" type="checkbox" /> مكتملة
  </label>
  <button type="submit">إضافة</button>
</form>

    <h1>📋 قائمة المهام</h1>

    <ul v-if="tasks.length">
      <li v-for="task in tasks" :key="task.id">
        <strong>{{ task.title }}</strong> - {{ task.description }}
        <span v-if="task.completed">✅</span>
        <span v-else>❌</span>
      </li>
    </ul>

    <p v-else>لا توجد مهام بعد.</p>
  </div>
</template>

<script setup>
import { ref, onMounted } from 'vue'
import axios from 'axios'

const tasks = ref([])

onMounted(async () => {
  try {
    const response = await axios.get('http://127.0.0.1:8000/api/tasks')
    tasks.value = response.data
  } catch (error) {
    console.error("فشل تحميل المهام:", error)
  }
})
const newTask = ref({
  title: '',
  description: '',
  completed: false,
})

const addTask = async () => {
  try {
    const response = await axios.post('http://127.0.0.1:8000/api/tasks', newTask.value)
    tasks.value.push(response.data)
    newTask.value = { title: '', description: '', completed: false } // Reset
  } catch (error) {
    console.error("فشل في الإضافة:", error)
  }
}

</script>

<style scoped>
.container {
  max-width: 600px;
  margin: auto;
  padding: 20px;
}
</style>
