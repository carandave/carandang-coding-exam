<script setup lang="ts">

import { ref, reactive } from 'vue'
import axios from 'axios'
import router from '/src/router/index.ts'


const formData = reactive({
    email: '',
    password: ''
})

const errorMessage = ref('');

const loginForm = async () => {
    errorMessage.value = '';
    try {
        const response = await axios.post('/api/login', formData);

        if(response.data.message){
            errorMessage.value = response.data.message;
            return;
        }

        localStorage.setItem('token', response.data.token)
        localStorage.setItem('user', JSON.stringify(response.data.user))
        router.push('/home')

    } catch (error) {
        console.log('Error sa login', error)
    }
}


</script>

<template>
    <div class="min-h-screen flex items-center justify-center bg-orange-200">
      <div class="w-full max-w-sm bg-white p-8 rounded-lg shadow-md">
        <h2 class="text-2xl font-bold text-center text-gray-800 mb-6">Login</h2>
  
        <form @submit.prevent="loginForm">
          <div class="mb-4">
            <label for="email" class="block text-sm font-medium text-gray-700">Email</label>
            <input type="email" id="email" v-model="formData.email" class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-orange-500 focus:border-orange-500 sm:text-sm" required />
            <p v-if="errorMessage" class="text-red-600 text-sm mb-4">{{ errorMessage }}</p>
          </div>
  
          <div class="mb-6">
            <label for="password" class="block text-sm font-medium text-gray-700">Password</label>
            <input type="password" id="password" v-model="formData.password" class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-orange-500 focus:border-orange-500 sm:text-sm" required />
          </div>
  
          <button type="submit" class="w-full mt-4 bg-red-900 text-white py-2 px-4 rounded-lg hover:bg-red-800 focus:outline-none focus:ring-2 focus:ring-red-500 duration-200">
            Login
          </button>
        </form>
      </div>
    </div>
  </template>
  
  
