<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue'
import { ref, watch } from 'vue'
import { useForm, router, Link } from '@inertiajs/vue3'
import { PlusIcon, PencilSquareIcon, TrashIcon, MagnifyingGlassIcon, ArrowDownTrayIcon } from '@heroicons/vue/24/solid'

// props dari controller
const props = defineProps({
  pemilih: Object,
  filters: Object,
})

// search & per_page
const search = ref(props.filters.search || '')
const perPage = ref(props.filters.per_page || 15)

// debounce pencarian
let timeout = null
watch(search, (val) => {
  clearTimeout(timeout)
  timeout = setTimeout(() => {
    applyFilter()
  }, 400) // delay 400ms
})

// apply filter (search & per_page)
const applyFilter = () => {
  router.get(route('pemilih.index'), {
    search: search.value,
    per_page: perPage.value,
  }, { preserveState: true, replace: true })
}

// ---- Form Tambah ----
const showModalAdd = ref(false)
const formAdd = useForm({
  nama: '',
  jenis: 'siswa',
})
const submitAdd = () => {
  formAdd.post(route('pemilih.store'), {
    onSuccess: () => {
      showModalAdd.value = false
      formAdd.reset()
    }
  })
}

// ---- Form Edit ----
const showModalEdit = ref(false)
const formEdit = useForm({
  id: null,
  nama: '',
  jenis: 'siswa',
})
const openEdit = (item) => {
  formEdit.id = item.id
  formEdit.nama = item.nama
  formEdit.jenis = item.jenis
  showModalEdit.value = true
}
const submitEdit = () => {
  formEdit.put(route('pemilih.update', formEdit.id), {
    onSuccess: () => {
      showModalEdit.value = false
    }
  })
}

// ---- Hapus ----
const destroy = (id) => {
  if (confirm('Yakin hapus data ini?')) {
    router.delete(route('pemilih.destroy', id))
  }
}
</script>

<template>
  <AuthenticatedLayout>
    <div class="p-6 bg-white shadow rounded-lg">
      <!-- Header -->
      <div class="flex justify-between items-center mb-6">
        <h2 class="text-xl font-bold text-gray-700">📋 Daftar Pemilih</h2>
        <div class="flex space-x-2">
          <a
  :href="route('pemilih.export')"
  class="flex items-center gap-1 px-4 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700 transition"
>
  <ArrowDownTrayIcon class="w-5 h-5" /> Export
</a>
          <button
            @click="showModalAdd = true"
            class="flex items-center gap-1 px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition"
          >
            <PlusIcon class="w-5 h-5" /> Tambah
          </button>
        </div>
      </div>

      <!-- Filter -->
      <div class="flex justify-between items-center mb-4">
        <div class="relative w-1/3">
          <MagnifyingGlassIcon class="absolute left-2 top-2.5 h-5 w-5 text-gray-400" />
          <input
            type="text"
            v-model="search"
            placeholder="Cari nama atau token..."
            class="border pl-9 pr-3 py-2 rounded w-full focus:ring focus:ring-blue-200"
          />
        </div>

        <select v-model="perPage" @change="applyFilter"
          class="border p-2 rounded focus:ring focus:ring-blue-200">
          <option value="15">15 / halaman</option>
          <option value="20">20 / halaman</option>
          <option value="50">50 / halaman</option>
          <option value="all">Tampilkan semua</option>
        </select>
      </div>

      <!-- Tabel -->
      <div class="overflow-x-auto">
        <table class="w-full border text-sm">
          <thead class="bg-gray-100 text-gray-700">
            <tr>
              <th class="p-2 border">ID</th>
              <th class="p-2 border">Nama</th>
              <th class="p-2 border">Jenis</th>
              <th class="p-2 border">Token</th>
              <th class="p-2 border">Sudah Memilih</th>
              <th class="p-2 border">Aksi</th>
            </tr>
          </thead>
          <tbody>
            <tr v-for="item in pemilih.data || pemilih" :key="item.id" class="text-center hover:bg-gray-50">
              <td class="p-2 border">{{ item.id }}</td>
              <td class="p-2 border text-left">{{ item.nama }}</td>
              <td class="p-2 border capitalize">{{ item.jenis }}</td>
              <td class="p-2 border font-mono">{{ item.token }}</td>
              <td class="p-2 border">
                <span :class="item.sudah_memilih ? 'text-green-600 font-semibold' : 'text-red-600 font-semibold'">
                  {{ item.sudah_memilih ? '✔ Ya' : '✘ Belum' }}
                </span>
              </td>
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

      <!-- Pagination -->
      <div v-if="pemilih.links" class="mt-4 flex flex-wrap gap-2">
        <template v-for="link in pemilih.links" :key="link.label">
          <button
            v-if="link.url"
            @click="router.get(link.url, {}, { preserveState: true })"
            v-html="link.label"
            :class="[
              'px-3 py-1 border rounded',
              link.active ? 'bg-blue-500 text-white' : 'bg-white hover:bg-gray-100'
            ]"
          />
          <span v-else v-html="link.label" class="px-3 py-1 text-gray-400"></span>
        </template>
      </div>
    </div>

    <!-- Modal Tambah -->
    <div v-if="showModalAdd" class="fixed inset-0 flex items-center justify-center bg-black bg-opacity-50 z-50">
      <div class="bg-white rounded-lg p-6 w-1/3 shadow-lg">
        <h3 class="text-lg font-bold mb-4">Tambah Pemilih</h3>
        <form @submit.prevent="submitAdd" class="space-y-4">
          <input v-model="formAdd.nama" type="text" placeholder="Nama"
                 class="border p-2 rounded w-full" />
          <select v-model="formAdd.jenis" class="border p-2 rounded w-full">
            <option value="siswa">Siswa</option>
            <option value="guru">Guru</option>
          </select>
          <div class="flex justify-end space-x-2">
            <button type="button" @click="showModalAdd = false"
                    class="px-4 py-2 bg-gray-500 text-white rounded">Batal</button>
            <button type="submit"
                    class="px-4 py-2 bg-blue-600 text-white rounded">Simpan</button>
          </div>
        </form>
      </div>
    </div>

    <!-- Modal Edit -->
    <div v-if="showModalEdit" class="fixed inset-0 flex items-center justify-center bg-black bg-opacity-50 z-50">
      <div class="bg-white rounded-lg p-6 w-1/3 shadow-lg">
        <h3 class="text-lg font-bold mb-4">Edit Pemilih</h3>
        <form @submit.prevent="submitEdit" class="space-y-4">
          <input v-model="formEdit.nama" type="text" placeholder="Nama"
                 class="border p-2 rounded w-full" />
          <select v-model="formEdit.jenis" class="border p-2 rounded w-full">
            <option value="siswa">Siswa</option>
            <option value="guru">Guru</option>
          </select>
          <div class="flex justify-end space-x-2">
            <button type="button" @click="showModalEdit = false"
                    class="px-4 py-2 bg-gray-500 text-white rounded">Batal</button>
            <button type="submit"
                    class="px-4 py-2 bg-yellow-600 text-white rounded">Update</button>
          </div>
        </form>
      </div>
    </div>
  </AuthenticatedLayout>
</template>
