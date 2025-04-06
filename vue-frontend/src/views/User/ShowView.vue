<script setup lang="ts">
import NavBar from '@/components/Navbar.vue'
import { RouterLink, useRoute } from 'vue-router'
import { onMounted, ref } from 'vue'
import axios from 'axios'


const user = ref(null)

const routes = useRoute()

const userId = routes.params.id

onMounted(async () => { // Fetch Single User
  try {
    const response = await axios.get(`/api/users/${userId}`, {
                      headers: {
                          'Authorization': `Bearer ${localStorage.getItem('token')}`
                      }
                  });
        user.value = response.data;
        
        // console.log(user.value)
    
  } catch (error) {
    console.log("Error getting user: ", error)
  }
})

</script>

<template>
    <NavBar />
  
    <div class="flex items-start justify-start h-screen bg-gray-100 p-10 flex-col">
      <div class="w-full flex justify-between items-center mb-6">
        <h1 class="text-3xl font-bold text-gray-800">View User</h1>
      </div>
  
      <div class="w-1/2 mx-auto bg-white p-8 rounded-lg shadow-md">

        <!--Full Name -->
        <div class="mb-4">
          <label class="block text-sm font-medium text-gray-600">Full Name</label>
          <p class="text-lg text-gray-800">{{ user?.user.full_name }}</p>
        </div>
        
         <!--Email -->
        <div class="mb-4">
          <label class="block text-sm font-medium text-gray-600">Email</label>
          <p class="text-lg text-gray-800">{{ user?.user.email }}</p>
        </div>
        
         <!--Role -->
        <div class="mb-4">
          <label class="block text-sm font-medium text-gray-600">Role</label>
          <p class="text-lg text-gray-800">{{ user?.user.role.role_name }}</p>
        </div>
  
        <!-- Back Button -->
        <div class="mb-4 text-right">
          <RouterLink to="/user" class="bg-orange-500 text-white px-4 py-2 rounded-md hover:bg-orange-600 focus:outline-none focus:ring-2 focus:ring-orange-500">
            Back to User List
          </RouterLink>
        </div>
      </div>
    </div>
  </template>
  
