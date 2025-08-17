<script setup>
import { computed } from 'vue'
import { usePage } from '@inertiajs/vue3'

const page = usePage()

const success = computed(() => page.props.flash?.success || null)
const error = computed(() => page.props.flash?.error || null)
</script>

<template>
  <div>
    <div v-if="success" class="mb-4 rounded bg-green-100 text-green-700 px-4 py-2">
      {{ success }}
    </div>
    <div v-if="error" class="mb-4 rounded bg-red-100 text-red-700 px-4 py-2">
      {{ error }}
    </div>
  </div>
</template>
