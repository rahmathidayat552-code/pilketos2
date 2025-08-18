<script setup>
import { useForm, Head } from '@inertiajs/vue3';
import { ref } from 'vue';

defineProps({
    status: String,
    error: String,
});

const form = useForm({
    token: '',
});

const submit = () => {
    form.post(route('public.submit'));
};
</script>

<template>
    <Head title="Masukkan Token" />
    <div class="flex items-center justify-center min-h-screen bg-gray-100 p-4">
        <div class="w-full max-w-md bg-white p-6 rounded-lg shadow-lg text-center">
            <h1 class="text-2xl font-bold mb-4">🗳️ E-Voting PILKETOS</h1>
            <p class="text-gray-600 mb-6">Masukkan token yang Anda miliki untuk memulai pemilihan.</p>

            <div v-if="status" class="mb-4 text-green-600 font-medium bg-green-100 p-3 rounded">
                {{ status }}
            </div>
            <div v-if="error" class="mb-4 text-red-600 font-medium bg-red-100 p-3 rounded">
                {{ error }}
            </div>

            <form @submit.prevent="submit" class="space-y-4">
                <input
                    v-model="form.token"
                    type="text"
                    placeholder="Masukkan Token Anda"
                    maxlength="8"
                    class="border-2 border-gray-300 w-full p-3 rounded-lg focus:ring-blue-500 focus:border-blue-500 text-center uppercase text-xl"
                />
                <button
                    type="submit"
                    class="w-full bg-blue-600 text-white font-semibold py-3 rounded-lg hover:bg-blue-700 transition"
                    :disabled="form.processing"
                >
                    Mulai Memilih
                </button>
            </form>
        </div>
    </div>
</template>