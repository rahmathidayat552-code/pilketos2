<script setup>
import { ref } from 'vue'
import ApplicationLogo from '@/Components/ApplicationLogo.vue'
import { Link, usePage } from '@inertiajs/vue3'

// Heroicons (pastikan sudah install: npm install @heroicons/vue)
import {
  HomeIcon,
  UsersIcon,
  UserGroupIcon,
  ChartBarIcon,
  Cog6ToothIcon,
  ArrowLeftOnRectangleIcon,
  ChevronDownIcon,
} from '@heroicons/vue/24/outline'

const sidebarOpen = ref(true)
const pemilihOpen = ref(false)
const hasilSuaraOpen = ref(false)

const page = usePage()
</script>

<template>
  <div class="flex h-screen bg-gray-100">
    <aside
      :class="[
        'bg-gray-900 text-white transition-all duration-300',
        sidebarOpen ? 'w-64' : 'w-16'
      ]"
    >
      <div class="flex items-center justify-between px-4 py-4">
        <Link :href="route('admin.dashboard')" class="flex items-center gap-2">
            <template v-if="page.props.sekolah && page.props.sekolah.logo">
                <img :src="`/storage/${page.props.sekolah.logo}`" alt="Logo Sekolah" class="h-8 w-8 object-cover rounded-full" />
            </template>
            <ApplicationLogo v-else class="h-8 w-auto text-white" />
            <span v-if="sidebarOpen && page.props.sekolah"></span>
        </Link>
        <button
          @click="sidebarOpen = !sidebarOpen"
          class="text-gray-300 hover:text-white focus:outline-none"
        >
          <span v-if="sidebarOpen">☰</span>
          <span v-else>☰</span>
        </button>
      </div>

      <nav class="mt-4 space-y-1">
        <Link
          :href="route('admin.dashboard')"
          class="flex items-center px-4 py-2 hover:bg-gray-700"
          :class="{ 'bg-gray-800': route().current('admin.dashboard') }"
        >
          <HomeIcon class="h-5 w-5" />
          <span v-if="sidebarOpen" class="ml-3">Dashboard</span>
        </Link>
        <Link
          :href="route('sekolah.index')"
          class="flex items-center px-4 py-2 hover:bg-gray-700"
          :class="{ 'bg-gray-800': route().current('sekolah.index') }"
        >
          <UsersIcon class="h-5 w-5" />
          <span v-if="sidebarOpen" class="ml-3">Identitas Sekolah</span>
        </Link>
        
        <button
          @click="pemilihOpen = !pemilihOpen"
          class="flex w-full items-center px-4 py-2 hover:bg-gray-700 focus:outline-none"
        >
          <UsersIcon class="h-5 w-5" />
          <span v-if="sidebarOpen" class="ml-3 flex-1 text-left">Data Pemilih</span>
          <ChevronDownIcon v-if="sidebarOpen" class="h-4 w-4 transition-transform"
            :class="{ 'rotate-180': pemilihOpen }" />
        </button>
        <div v-if="pemilihOpen && sidebarOpen" class="ml-8 space-y-1">
          <Link
            :href="route('pemilih.index')"
            class="block px-2 py-1 hover:text-gray-300"
            :class="{ 'font-bold': route().current('pemilih.index') }"
          >
            Daftar Pemilih
          </Link>
          <Link
            :href="route('pemilih.import.form')"
            class="block px-2 py-1 hover:text-gray-300"
            :class="{ 'font-bold': route().current('pemilih.import.form') }"
          >
            Import Data
          </Link>
        </div>

        <Link
          :href="route('kandidat.index')"
          class="flex items-center px-4 py-2 hover:bg-gray-700"
          :class="{ 'bg-gray-800': route().current('kandidat.index') }"
        >
          <UserGroupIcon class="h-5 w-5" />
          <span v-if="sidebarOpen" class="ml-3">Data Kandidat</span>
        </Link>

        <button
          @click="hasilSuaraOpen = !hasilSuaraOpen"
          class="flex w-full items-center px-4 py-2 hover:bg-gray-700 focus:outline-none"
        >
          <ChartBarIcon class="h-5 w-5" />
          <span v-if="sidebarOpen" class="ml-3 flex-1 text-left">Hasil Suara</span>
          <ChevronDownIcon v-if="sidebarOpen" class="h-4 w-4 transition-transform"
            :class="{ 'rotate-180': hasilSuaraOpen }" />
        </button>
        <div v-if="hasilSuaraOpen && sidebarOpen" class="ml-8 space-y-1">
          <Link
            :href="route('rekap.index')"
            class="block px-2 py-1 hover:text-gray-300"
            :class="{ 'font-bold': route().current('rekap.index') }"
          >
            Rekap Suara
          </Link>
        </div>
        
        <Link
          :href="route('users.index')"
          class="flex items-center px-4 py-2 hover:bg-gray-700"
          :class="{ 'bg-gray-800': route().current('users.index') }"
        >
          <Cog6ToothIcon class="h-5 w-5" />
          <span v-if="sidebarOpen" class="ml-3">Manajemen Pengguna</span>
        </Link>
      </nav>
    </aside>

    <div class="flex flex-1 flex-col">
      <header class="flex items-center justify-between bg-white px-6 py-4 shadow">
        <h1 class="text-lg font-bold" v-if="page.props.sekolah && page.props.sekolah.nama_sekolah">
            PANEL ADMIN E-PILKETOS - {{ page.props.sekolah.nama_sekolah }}
        </h1>
        <h1 class="text-lg font-bold" v-else>E-Pilketos</h1>

        <form method="POST" :action="route('logout')">
          <input type="hidden" name="_token" :value="page.props.csrf_token" />
          <button type="submit" class="flex items-center text-red-600 hover:text-red-800">
            <ArrowLeftOnRectangleIcon class="h-5 w-5 mr-1" />
            Logout
          </button>
        </form>
      </header>

      <main class="flex-1 overflow-y-auto p-6">
        <slot />
      </main>
    </div>
  </div>
</template>