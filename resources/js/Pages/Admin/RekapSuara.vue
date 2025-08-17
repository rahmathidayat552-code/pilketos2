<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue'
import { Head } from '@inertiajs/vue3'

defineProps({
    hasilSuara: Object,
    totalSuara: Number,
    jumlahPemilih: Number,
    sudahMemilih: Number,
    belumMemilih: Number,
})

const formatPercentage = (count, total) => {
    if (total === 0) return '0%';
    return `${((count / total) * 100).toFixed(2)}%`;
}
</script>

<template>
  <AuthenticatedLayout>
    <Head title="Hasil Suara" />
    <div class="p-6 bg-white rounded-lg shadow">
      <h2 class="text-xl font-bold text-gray-700 mb-6">📊 Hasil Suara</h2>

      <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
        <div class="bg-blue-100 p-6 rounded shadow text-center">
            <div class="text-gray-500">Total Pemilih</div>
            <div class="text-3xl font-bold text-blue-600">{{ jumlahPemilih }}</div>
        </div>
        <div class="bg-green-100 p-6 rounded shadow text-center">
            <div class="text-gray-500">Sudah Memilih</div>
            <div class="text-3xl font-bold text-green-600">{{ sudahMemilih }}</div>
        </div>
        <div class="bg-red-100 p-6 rounded shadow text-center">
            <div class="text-gray-500">Belum Memilih</div>
            <div class="text-3xl font-bold text-red-600">{{ belumMemilih }}</div>
        </div>
      </div>

      <div class="overflow-x-auto">
        <table class="w-full border text-sm">
          <thead class="bg-gray-100 text-gray-700">
            <tr>
              <th class="p-2 border text-center">#</th>
              <th class="p-2 border text-left">Nama Kandidat</th>
              <th class="p-2 border text-center">Jumlah Suara</th>
              <th class="p-2 border text-center">Persentase</th>
            </tr>
          </thead>
          <tbody>
            <tr v-for="(kandidat, index) in hasilSuara" :key="kandidat.id" class="hover:bg-gray-50">
              <td class="p-2 border text-center">{{ index + 1 }}</td>
              <td class="p-2 border font-semibold">
                <div class="flex items-center gap-2">
                  <img v-if="kandidat.foto" :src="`/storage/${kandidat.foto}`" class="h-10 w-10 rounded-full object-cover" />
                  <span>{{ kandidat.nama_ketua }} & {{ kandidat.nama_wakil }}</span>
                </div>
              </td>
              <td class="p-2 border text-center font-bold text-lg">{{ kandidat.suara_count }}</td>
              <td class="p-2 border text-center">{{ formatPercentage(kandidat.suara_count, totalSuara) }}</td>
            </tr>
          </tbody>
        </table>
      </div>
    </div>
  </AuthenticatedLayout>
</template>