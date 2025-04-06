<script setup lang="ts">
import NavBar from '@/components/Navbar.vue'
import { RouterLink, useRoute } from 'vue-router'
import { onMounted, ref } from 'vue'
import axios from 'axios'


const role = ref(null)

const routes = useRoute()

const roleId = routes.params.id

onMounted(async () => { //Fetch Single Role
  try {
    const response = await axios.get(`/api/roles/${roleId}`, {
                      headers: {
                          'Authorization': `Bearer ${localStorage.getItem('token')}`
                      }
                  });
        role.value = response.data;

        console.log(role.value.role.role_name)
    
  } catch (error) {
    console.log("Error getting role: ", error)
  }
})

</script>

<template>
    <NavBar />
  
    <div class="flex items-start justify-start h-screen bg-gray-100 p-10 flex-col">
      <div class="w-full flex justify-between items-center mb-6">
        <h1 class="text-3xl font-bold text-gray-800">View Role</h1>
      </div>
  
     
      <div class="w-1/2 mx-auto bg-white p-8 rounded-lg shadow-md">
        <!-- Role Name -->
        <div class="mb-4">
          <label class="block text-sm font-medium text-gray-600">Role Name</label>
          <p class="text-lg text-gray-800">{{ role?.role.role_name }}</p>
        </div>
        
         <!-- Descriptions -->
        <div class="mb-4">
          <label class="block text-sm font-medium text-gray-600">Description</label>
          <p class="text-lg text-gray-800">{{ role?.role.description }}</p>
        </div>
  
        <!-- Back Button -->
        <div class="mb-4 text-right">
          <RouterLink to="/role" class="bg-orange-500 text-white px-4 py-2 rounded-md hover:bg-orange-600 focus:outline-none focus:ring-2 focus:ring-orange-500">
            Back to Role List
          </RouterLink>
        </div>
      </div>
    </div>
  </template>
  
