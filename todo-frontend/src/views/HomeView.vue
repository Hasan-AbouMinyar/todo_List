<template>
  <div class="container">
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
</script>

<style scoped>
.container {
  max-width: 600px;
  margin: auto;
  padding: 20px;
}
</style>
