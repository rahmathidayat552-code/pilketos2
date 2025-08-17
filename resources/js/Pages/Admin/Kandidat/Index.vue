<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue'
import { ref } from 'vue'
import { useForm, router } from '@inertiajs/vue3'
import { PlusIcon, PencilSquareIcon, TrashIcon } from '@heroicons/vue/24/solid'

const props = defineProps({
  kandidat: Object
})

// Modal Tambah
const showAdd = ref(false)
const formAdd = useForm({
  nama_ketua: '',
  nama_wakil: '',
  foto: null,
  visi: '',
  misi: ''
})
const submitAdd = () => {
  formAdd.post(route('kandidat.store'), {
    forceFormData: true,
    onSuccess: () => {
      showAdd.value = false
      formAdd.reset()
    }
  })
}

// Modal Edit
const showEdit = ref(false)
const formEdit = useForm({
  id: null,
  nama_ketua: '',
  nama_wakil: '',
  foto: null,
  visi: '',
  misi: ''
})
const openEdit = (item) => {
  formEdit.id = item.id
  formEdit.nama_ketua = item.nama_ketua
  formEdit.nama_wakil = item.nama_wakil
  formEdit.visi = item.visi
  formEdit.misi = item.misi
  showEdit.value = true
}

// PERBAIKAN DI BAGIAN INI
const submitEdit = () => {
  // Kita cek apakah ada foto baru yang diunggah.
  if (formEdit.foto instanceof File) {
    // Jika ada, kita kirim semua data termasuk foto baru.
    // Kita gunakan formEdit.post() dan tambahkan _method: 'put' secara eksplisit.
    formEdit.post(route('kandidat.update', formEdit.id), {
      _method: 'put',
      forceFormData: true,
      onSuccess: () => {
        showEdit.value = false
      },
      onError: (errors) => {
        console.error('Error:', errors)
      }
    })
  } else {
    // Jika tidak ada foto baru, kita hanya kirim data teks.
    // Kita gunakan formEdit.put() karena tidak ada file.
    formEdit.put(route('kandidat.update', formEdit.id), {
      onSuccess: () => {
        showEdit.value = false
      },
      onError: (errors) => {
        console.error('Error:', errors)
      }
    })
  }
}


// Hapus
const destroy = (id) => {
  if (confirm('Yakin hapus kandidat ini?')) {
    router.delete(route('kandidat.destroy', id))
  }
}
</script>

<template>
  <AuthenticatedLayout>
    <div class="p-6 bg-white rounded-lg shadow">
      <div class="flex justify-between items-center mb-6">
        <h2 class="text-xl font-bold text-gray-700">🗳️ Data Kandidat</h2>
        <button
          @click="showAdd = true"
          class="flex items-center gap-1 px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition"
        >
          <PlusIcon class="w-5 h-5" /> Tambah
        </button>
      </div>

      <div class="overflow-x-auto">
        <table class="w-full border text-sm">
          <thead class="bg-gray-100">
            <tr>
              <th class="p-2 border">ID</th>
              <th class="p-2 border">Foto</th>
              <th class="p-2 border">Ketua</th>
              <th class="p-2 border">Wakil</th>
              <th class="p-2 border">Visi</th>
              <th class="p-2 border">Misi</th>
              <th class="p-2 border">Aksi</th>
            </tr>
          </thead>
          <tbody>
            <tr v-for="item in kandidat" :key="item.id" class="text-center hover:bg-gray-50">
              <td class="p-2 border">{{ item.id }}</td>
              <td class="p-2 border">
                <img v-if="item.foto" :src="`/storage/${item.foto}`" class="h-12 mx-auto rounded" />
              </td>
              <td class="p-2 border font-semibold">{{ item.nama_ketua }}</td>
              <td class="p-2 border">{{ item.nama_wakil }}</td>
              <td class="p-2 border text-left">{{ item.visi }}</td>
              <td class="p-2 border text-left">{{ item.misi }}</td>
              <td class="p-2 border space-x-2">
                <button
                  @click="openEdit(item)"
                  class="inline-flex items-center gap-1 px-2 py-1 bg-yellow-500 text-white rounded hover:bg-yellow-600"
                >
                  <PencilSquareIcon class="w-4 h-4" /> Edit
                </button>
                <button
                  @click="destroy(item.id)"
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

    <div v-if="showAdd" class="fixed inset-0 flex items-center justify-center bg-black bg-opacity-50 z-50">
      <div class="bg-white p-6 rounded-lg w-1/3 shadow-lg">
        <h3 class="text-lg font-bold mb-4">Tambah Kandidat</h3>
        <form @submit.prevent="submitAdd" class="space-y-3">
          <input v-model="formAdd.nama_ketua" type="text" placeholder="Nama Ketua" class="border p-2 rounded w-full" />
          <input v-model="formAdd.nama_wakil" type="text" placeholder="Nama Wakil" class="border p-2 rounded w-full" />
          <input type="file" @change="e => formAdd.foto = e.target.files[0]" class="border p-2 rounded w-full" />
          <textarea v-model="formAdd.visi" placeholder="Visi" class="border p-2 rounded w-full"></textarea>
          <textarea v-model="formAdd.misi" placeholder="Misi" class="border p-2 rounded w-full"></textarea>
          <div class="flex justify-end gap-2">
            <button type="button" @click="showAdd = false" class="px-4 py-2 bg-gray-500 text-white rounded">Batal</button>
            <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded">Simpan</button>
          </div>
        </form>
      </div>
    </div>

    <div v-if="showEdit" class="fixed inset-0 flex items-center justify-center bg-black bg-opacity-50 z-50">
      <div class="bg-white p-6 rounded-lg w-1/3 shadow-lg">
        <h3 class="text-lg font-bold mb-4">Edit Kandidat</h3>
        <form @submit.prevent="submitEdit" class="space-y-3">
          <input v-model="formEdit.nama_ketua" type="text" placeholder="Nama Ketua" class="border p-2 rounded w-full" />
          <input v-model="formEdit.nama_wakil" type="text" placeholder="Nama Wakil" class="border p-2 rounded w-full" />
          <input type="file" @change="e => formEdit.foto = e.target.files[0]" class="border p-2 rounded w-full" />
          <textarea v-model="formEdit.visi" placeholder="Visi" class="border p-2 rounded w-full"></textarea>
          <textarea v-model="formEdit.misi" placeholder="Misi" class="border p-2 rounded w-full"></textarea>
          <div class="flex justify-end gap-2">
            <button type="button" @click="showEdit = false" class="px-4 py-2 bg-gray-500 text-white rounded">Batal</button>
            <button type="submit" class="px-4 py-2 bg-yellow-600 text-white rounded">Update</button>
          </div>
        </form>
      </div>
    </div>
  </AuthenticatedLayout>
</template>