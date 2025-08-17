<script setup>
import { ref } from 'vue'
import { router } from '@inertiajs/vue3'

const form = ref({
  username: '',
  password: ''
})

function submit() {
  router.post('/admin/login', form.value)
}
</script>

<template>
  <div class="flex items-center justify-center min-h-screen bg-gray-100">
    <div class="w-full max-w-sm bg-white p-6 rounded shadow">
      <h1 class="text-xl font-bold mb-4">Login Admin</h1>

      <input v-model="form.username" placeholder="Username"
        class="border w-full p-2 mb-3 rounded" />
      <input type="password" v-model="form.password" placeholder="Password"
        class="border w-full p-2 mb-4 rounded" />

      <button @click="submit"
        class="bg-blue-500 text-white px-4 py-2 w-full rounded">
        Login
      </button>
    </div>
  </div>
</template>
