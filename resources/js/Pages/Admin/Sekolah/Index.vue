<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue'
import { Head, useForm, router } from '@inertiajs/vue3'
import { ref } from 'vue';

const props = defineProps({
    sekolah: Object,
});

const form = useForm({
    npsn: props.sekolah.npsn || '',
    nama_sekolah: props.sekolah.nama_sekolah || '',
    alamat: props.sekolah.alamat || '',
    nama_kepsek: props.sekolah.nama_kepsek || '',
    nama_pembos: props.sekolah.nama_pembos || '',
    logo: null,
});

const handleFileChange = (e) => {
    form.logo = e.target.files[0];
};

const submit = () => {
    form.post(route('sekolah.update'), {
        forceFormData: true, // Penting untuk mengirim file
        onSuccess: () => {
            // Setelah berhasil, reset logo agar tidak terkirim lagi
            form.logo = null;
        }
    });
};
</script>

<template>
    <AuthenticatedLayout>
        <Head title="Identitas Sekolah" />

        <div class="p-6 bg-white rounded-lg shadow">
            <h2 class="text-xl font-bold text-gray-700 mb-6">Sekolah</h2>
            
            <form @submit.prevent="submit" class="space-y-6">
                <div>
                    <label for="npsn" class="block text-sm font-medium text-gray-700">NPSN</label>
                    <input type="text" id="npsn" v-model="form.npsn"
                           class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50" />
                    <div v-if="form.errors.npsn" class="text-red-500 text-sm mt-1">{{ form.errors.npsn }}</div>
                </div>

                <div>
                    <label for="nama_sekolah" class="block text-sm font-medium text-gray-700">Nama Sekolah</label>
                    <input type="text" id="nama_sekolah" v-model="form.nama_sekolah"
                           class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50" />
                    <div v-if="form.errors.nama_sekolah" class="text-red-500 text-sm mt-1">{{ form.errors.nama_sekolah }}</div>
                </div>

                <div>
                    <label for="alamat" class="block text-sm font-medium text-gray-700">Alamat</label>
                    <textarea id="alamat" v-model="form.alamat" rows="3"
                              class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50"></textarea>
                    <div v-if="form.errors.alamat" class="text-red-500 text-sm mt-1">{{ form.errors.alamat }}</div>
                </div>

                <div>
                    <label for="nama_kepsek" class="block text-sm font-medium text-gray-700">Nama Kepala Sekolah</label>
                    <input type="text" id="nama_kepsek" v-model="form.nama_kepsek"
                           class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50" />
                    <div v-if="form.errors.nama_kepsek" class="text-red-500 text-sm mt-1">{{ form.errors.nama_kepsek }}</div>
                </div>

                <div>
                    <label for="nama_pembos" class="block text-sm font-medium text-gray-700">Nama Pembina OSIS</label>
                    <input type="text" id="nama_pembos" v-model="form.nama_pembos"
                           class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50" />
                    <div v-if="form.errors.nama_pembos" class="text-red-500 text-sm mt-1">{{ form.errors.nama_pembos }}</div>
                </div>

                <div>
                    <label for="logo" class="block text-sm font-medium text-gray-700">Logo</label>
                    <input type="file" id="logo" @change="handleFileChange"
                           class="mt-1 block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100" />
                    <div v-if="form.errors.logo" class="text-red-500 text-sm mt-1">{{ form.errors.logo }}</div>
                    <div v-if="props.sekolah.logo" class="mt-4">
                        <p class="text-sm text-gray-600">Logo saat ini:</p>
                        <img :src="`/storage/${props.sekolah.logo}`" class="mt-2 h-20" alt="Logo Sekolah" />
                    </div>
                </div>

                <div class="mt-6 flex justify-end">
                    <button type="submit"
                            class="px-4 py-2 bg-blue-600 text-white rounded-md shadow-sm hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500"
                            :disabled="form.processing">
                        Simpan Perubahan
                    </button>
                </div>
            </form>
        </div>
    </AuthenticatedLayout>
</template>