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
    <!-- Sidebar -->
    <aside
      :class="[
        'bg-gray-900 text-white transition-all duration-300',
        sidebarOpen ? 'w-64' : 'w-16'
      ]"
    >
      <div class="flex items-center justify-between px-4 py-4">
        <Link :href="route('admin.dashboard')">
          <ApplicationLogo class="h-8 w-auto text-white" />
        </Link>
        <button
          @click="sidebarOpen = !sidebarOpen"
          class="text-gray-300 hover:text-white focus:outline-none"
        >
          <span v-if="sidebarOpen">✖</span>
          <span v-else>☰</span>
        </button>
      </div>

      <nav class="mt-4 space-y-1">
        <!-- Dashboard -->
        <Link
          :href="route('admin.dashboard')"
          class="flex items-center px-4 py-2 hover:bg-gray-700"
          :class="{ 'bg-gray-800': route().current('dashboard') }"
        >
          <HomeIcon class="h-5 w-5" />
          <span v-if="sidebarOpen" class="ml-3">Dashboard</span>
        </Link>

        <!-- DATA PEMILIH -->
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

        <!-- DATA KANDIDAT -->
        <Link
          :href="route('kandidat.index')"
          class="flex items-center px-4 py-2 hover:bg-gray-700"
          :class="{ 'bg-gray-800': route().current('kandidat.index') }"
        >
          <UserGroupIcon class="h-5 w-5" />
          <span v-if="sidebarOpen" class="ml-3">Data Kandidat</span>
        </Link>

        <!-- HASIL SUARA -->
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

        <!-- MANAJEMEN PENGGUNA -->
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

    <!-- Main Content -->
    <div class="flex flex-1 flex-col">
      <!-- Navbar -->
      <header class="flex items-center justify-between bg-white px-6 py-4 shadow">
        <h1 class="text-lg font-bold">E-Pilketos SMKN 9 Bulukumba</h1>
        <form method="POST" :action="route('logout')">
          <input type="hidden" name="_token" :value="page.props.csrf_token" />
          <button type="submit" class="flex items-center text-red-600 hover:text-red-800">
            <ArrowLeftOnRectangleIcon class="h-5 w-5 mr-1" />
            Logout
          </button>
        </form>
      </header>

      <!-- Page content -->
      <main class="flex-1 overflow-y-auto p-6">
        <slot />
      </main>
    </div>
  </div>
</template>
