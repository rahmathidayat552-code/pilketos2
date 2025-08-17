<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue'
import FlashMessage from '@/Components/FlashMessage.vue'
import { useForm } from '@inertiajs/vue3'

const form = useForm({ file: null })

const submit = () => {
  form.post(route('pemilih.import'), {
    forceFormData: true,
    onSuccess: () => form.reset('file'),
  })
}
</script>

<template>
  <AuthenticatedLayout>
    <div class="p-6 bg-white rounded-lg shadow">
      <h2 class="text-xl font-bold mb-4">Import Data Pemilih</h2>

      <!-- Flash Message -->
      <FlashMessage />

      <!-- Tombol download template -->
      <a 
        href="/templates/pemilih_template.xlsx" 
        class="inline-block mb-4 px-4 py-2 bg-green-600 text-white rounded hover:bg-green-700"
        download
      >
        Download Template
      </a>

      <form @submit.prevent="submit" class="space-y-4">
        <input
          type="file"
          @change="e => form.file = e.target.files[0]"
          class="border p-2 rounded w-full"
        />

        <button
          type="submit"
          class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700"
          :disabled="form.processing"
        >
          Upload
        </button>
      </form>

      <div v-if="form.errors.file" class="text-red-500 mt-2">
        {{ form.errors.file }}
      </div>
    </div>
  </AuthenticatedLayout>
</template>
