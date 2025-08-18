<script setup>
import { useForm, Head, router } from '@inertiajs/vue3';
import { ref } from 'vue';

const props = defineProps({
    kandidat: Object,
});

const form = useForm({
    kandidat_id: null,
});

const konfirmasiPilih = (kandidat) => {
    if (confirm(`Apakah Anda yakin memilih kandidat "${kandidat.nama_ketua} & ${kandidat.nama_wakil}"? Pilihan tidak bisa diubah.`)) {
        form.kandidat_id = kandidat.id;
        form.post(route('public.store-suara'), {
            onSuccess: () => {
                // Redirect otomatis ditangani oleh controller setelah sukses
            },
        });
    }
};
</script>

<template>
    <Head title="Pilih Kandidat" />
    <div class="min-h-screen bg-gray-100 p-6 flex flex-col items-center">
        <div class="text-center w-full max-w-6xl">
            <h1 class="text-3xl font-extrabold text-gray-800 mb-2">Pilih Ketua dan Wakil Ketua</h1>
            <p class="text-lg text-gray-600 mb-8">Pilih satu kandidat terbaik Anda. Pilihan yang sudah dibuat tidak dapat diubah.</p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8 w-full max-w-6xl">
            <div
                v-for="kandidatItem in kandidat"
                :key="kandidatItem.id"
                class="bg-white rounded-xl shadow-lg p-6 flex flex-col items-center text-center hover:shadow-2xl transition-shadow duration-300 transform hover:scale-105"
            >
                <div class="flex-shrink-0 mb-4">
                  <img
                    :src="`/storage/${kandidatItem.foto}`"
                    alt="Foto Kandidat"
                    class="w-48 h-48 object-cover rounded-full border-4 border-gray-200"
                    v-if="kandidatItem.foto"
                  />
                  <div v-else class="w-48 h-48 bg-gray-300 rounded-full flex items-center justify-center text-gray-500 font-bold text-lg">
                      Tidak ada foto
                  </div>
                </div>

                <h2 class="text-2xl font-bold text-gray-800">{{ kandidatItem.nama_ketua }} & {{ kandidatItem.nama_wakil }}</h2>

                

                <button
                    @click="konfirmasiPilih(kandidatItem)"
                    class="mt-6 w-full px-6 py-3 bg-green-600 text-white font-bold rounded-lg hover:bg-green-700 transition"
                >
                    Pilih Kandidat Ini
                </button>
            </div>
        </div>
    </div>
</template>