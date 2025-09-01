<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue'
import { Head, useForm, router, Link } from '@inertiajs/vue3'
import { PlusIcon, PencilSquareIcon, TrashIcon } from '@heroicons/vue/24/solid'
import { ref } from 'vue'

const props = defineProps({
  users: Object,
})

// Modal Tambah
const showAddModal = ref(false)
const formAdd = useForm({
  nama: '',
  username: '',
  password: '',
  password_confirmation: '',
})
const submitAdd = () => {
  formAdd.post(route('users.store'), {
    onSuccess: () => {
      showAddModal.value = false
      formAdd.reset()
    }
  })
}

// Modal Edit
const showEditModal = ref(false)
const formEdit = useForm({
  id: null,
  nama: '',
  username: '',
  password: '',
  password_confirmation: '',
})
const openEdit = (user) => {
  formEdit.id = user.id
  formEdit.nama = user.nama
  formEdit.username = user.username
  showEditModal.value = true
}
const submitEdit = () => {
  formEdit.put(route('users.update', formEdit.id), {
    onSuccess: () => {
      showEditModal.value = false
      formEdit.reset()
    }
  })
}

// Hapus Pengguna
const destroy = (id) => {
  if (confirm('Yakin hapus pengguna ini?')) {
    router.delete(route('users.destroy', id))
  }
}
</script>

<template>
  <AuthenticatedLayout>
    <Head title="Manajemen Pengguna" />

    <div class="p-6 bg-white shadow rounded-lg">
      <div class="flex justify-between items-center mb-6">
        <h2 class="text-xl font-bold text-gray-700">Manajemen Pengguna</h2>
        <button
          @click="showAddModal = true"
          class="flex items-center gap-1 px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition"
        >
          <PlusIcon class="w-5 h-5" /> Tambah
        </button>
      </div>

      <div class="overflow-x-auto">
        <table class="w-full border text-sm">
          <thead class="bg-gray-100 text-gray-700">
            <tr>
              <th class="p-2 border">ID</th>
              <th class="p-2 border">Nama</th>
              <th class="p-2 border">Username</th>
              <th class="p-2 border">Aksi</th>
            </tr>
          </thead>
          <tbody>
            <tr v-for="user in users" :key="user.id" class="text-center hover:bg-gray-50">
              <td class="p-2 border">{{ user.id }}</td>
              <td class="p-2 border text-left">{{ user.nama }}</td>
              <td class="p-2 border text-left">{{ user.username }}</td>
              <td class="p-2 border space-x-2">
                <button
                  @click="openEdit(user)"
                  class="inline-flex items-center gap-1 px-2 py-1 bg-yellow-500 text-white rounded hover:bg-yellow-600"
                >
                  <PencilSquareIcon class="w-4 h-4" /> Edit
                </button>
                <button
                  @click="destroy(user.id)"
                  class="inline-flex items-center gap-1 px-2 py-1 bg-red-600 text-white rounded hover:bg-red-700"
                >
                  <TrashIcon class="w-4 h-4" /> Hapus
                </button>
              </td>
            </tr>
          </tbody>
        </table>
      </div>
    </div>

    <div v-if="showAddModal" class="fixed inset-0 flex items-center justify-center bg-black bg-opacity-50 z-50">
      <div class="bg-white rounded-lg p-6 w-1/3 shadow-lg">
        <h3 class="text-lg font-bold mb-4">Tambah Pengguna Baru</h3>
        <form @submit.prevent="submitAdd" class="space-y-4">
          <input v-model="formAdd.nama" type="text" placeholder="Nama"
                 class="border p-2 rounded w-full" />
          <input v-model="formAdd.username" type="text" placeholder="Username"
                 class="border p-2 rounded w-full" />
          <input v-model="formAdd.password" type="password" placeholder="Password"
                 class="border p-2 rounded w-full" />
          <input v-model="formAdd.password_confirmation" type="password" placeholder="Konfirmasi Password"
                 class="border p-2 rounded w-full" />
          
          <div class="flex justify-end space-x-2">
            <button type="button" @click="showAddModal = false"
                    class="px-4 py-2 bg-gray-500 text-white rounded">Batal</button>
            <button type="submit"
                    class="px-4 py-2 bg-blue-600 text-white rounded">Simpan</button>
          </div>
        </form>
      </div>
    </div>

    <div v-if="showEditModal" class="fixed inset-0 flex items-center justify-center bg-black bg-opacity-50 z-50">
      <div class="bg-white rounded-lg p-6 w-1/3 shadow-lg">
        <h3 class="text-lg font-bold mb-4">Edit Pengguna</h3>
        <form @submit.prevent="submitEdit" class="space-y-4">
          <input v-model="formEdit.nama" type="text" placeholder="Nama"
                 class="border p-2 rounded w-full" />
          <input v-model="formEdit.username" type="text" placeholder="Username"
                 class="border p-2 rounded w-full" />
          <input v-model="formEdit.password" type="password" placeholder="Password Baru (kosongkan jika tidak diubah)"
                 class="border p-2 rounded w-full" />
          <input v-model="formEdit.password_confirmation" type="password" placeholder="Konfirmasi Password Baru"
                 class="border p-2 rounded w-full" />
          
          <div class="flex justify-end space-x-2">
            <button type="button" @click="showEditModal = false"
                    class="px-4 py-2 bg-gray-500 text-white rounded">Batal</button>
            <button type="submit"
                    class="px-4 py-2 bg-yellow-600 text-white rounded">Update</button>
          </div>
        </form>
      </div>
    </div>
  </AuthenticatedLayout>
</template>