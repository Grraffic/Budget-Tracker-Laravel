<template>
  <div class="min-h-screen bg-gray-50 text-gray-800 antialiased">
    <nav class="bg-gray-900 text-white shadow-md">
      <div
        class="max-w-5xl mx-auto px-4 flex justify-between items-center h-16"
      >
        <div class="flex items-center space-x-2">
          <span class="font-bold text-lg tracking-tight"
            > Budget Tracker</span
          >
        </div>

        <div class="flex space-x-1">
          <RouterLink
            to="/"
            class="px-4 py-2 rounded-lg text-sm font-medium transition duration-150"
            active-class="bg-gray-800 text-blue-400 font-semibold shadow-inner"
          >
            Dashboard
          </RouterLink>

          <RouterLink
            to="/transactions"
            class="px-4 py-2 rounded-lg text-sm font-medium transition duration-150"
            active-class="bg-gray-800 text-blue-400 font-semibold shadow-inner"
          >
            Transactions
          </RouterLink>
        </div>
      </div>
    </nav>

    <main class="py-4">
      <RouterView />
    </main>
  </div>
</template>

<script setup>
import { RouterLink, RouterView } from "vue-router";
</script>
