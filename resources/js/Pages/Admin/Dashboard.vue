<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue'
import { Head } from '@inertiajs/vue3'

defineProps({
  jumlahPemilih: Number,
  sudahMemilih: Number,
  belumMemilih: Number,
})
</script>

<template>
  <AuthenticatedLayout>
    <Head title="Dashboard" />

    <h1 class="text-2xl font-bold mb-6">E-Pilketos SMKN 9 Bulukumba</h1>

    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
      <div class="bg-white p-6 rounded shadow text-center">
        <div class="text-gray-500">Jumlah Pemilih</div>
        <div class="text-3xl font-bold">{{ jumlahPemilih }}</div>
      </div>
      <div class="bg-white p-6 rounded shadow text-center">
        <div class="text-gray-500">Sudah Memilih</div>
        <div class="text-3xl font-bold text-green-600">{{ sudahMemilih }}</div>
      </div>
      <div class="bg-white p-6 rounded shadow text-center">
        <div class="text-gray-500">Belum Memilih</div>
        <div class="text-3xl font-bold text-red-600">{{ belumMemilih }}</div>
      </div>
    </div>
  </AuthenticatedLayout>
</template>
