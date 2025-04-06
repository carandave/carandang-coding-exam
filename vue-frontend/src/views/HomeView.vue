<script setup lang="ts">
import NavBar from '@/components/Navbar.vue'

const user = JSON.parse(localStorage.getItem('user'));
// console.log(user)
</script>

<template>
  <NavBar />
  <div class="flex items-start justify-start h-screen bg-gray-100 p-10">
    <div class="">
      <h1 class="text-2xl font-bold text-gray-800">Welcome back, <span class="text-xl text-gray-500 mt-2">{{ user.full_name }}</span></h1>
    </div>
  </div>
</template>
