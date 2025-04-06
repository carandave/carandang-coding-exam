<script setup lang="ts">
import NavBar from '@/components/Navbar.vue'
import { RouterLink, useRoute } from 'vue-router'
import { onMounted, reactive, ref } from 'vue'
import { useToast } from 'vue-toastification'
import router from '/src/router/index.ts'
import axios from 'axios'

const toast = useToast()

const roles = ref([])

const user = ref(null)

const routes = useRoute()

const formData = reactive({
    'full_name': '',
    'email': '',
    'role_id': ''
})

const userId = routes.params.id

onMounted(async () => { //Fetch Single Users 
  try {
    const response = await axios.get(`/api/users/${userId}`, {
                      headers: {
                          'Authorization': `Bearer ${localStorage.getItem('token')}`
                      }
                  });
        user.value = response.data;
        

        formData.full_name = user.value.user.full_name
        formData.email = user.value.user.email
        formData.role_id = user.value.user.role.id
        
        // console.log(user.value)
    
  } catch (error) {
    console.log("Error getting user: ", error)
  }
})

onMounted(async () => { // Fetch All Roles to display in Select Option Role
  try {
    const response = await axios.get('/api/roles', {
                      headers: {
                          'Authorization': `Bearer ${localStorage.getItem('token')}`
                      }
                  });
    roles.value = response.data;
    
    
  } catch (error) {
    console.log("Error getting Role: ", error)
  }
})

const errorMessage = ref({});

const updateForm = async () => { // Update Users
    errorMessage.value = '';
    try {
        const response = await axios.put(`/api/users/${userId}`, formData, {
                      headers: {
                          'Authorization': `Bearer ${localStorage.getItem('token')}`
                      }
                  });
       
        toast.success("User Updated successfully")
        router.push('/user')
        // console.log(response.data.message)

    } catch (error) {
        if (error.response && error.response.data.errors) {
            errorMessage.value = error.response.data.errors;
            console.log('Validation Errors:', errorMessage.value);
        } 
    }
}







</script>

<template>
    <NavBar />

    <div class="flex items-start justify-start h-screen bg-gray-100 p-10 flex-col">
      <div class="w-full flex justify-between items-center mb-6">
        <h1 class="text-3xl font-bold text-gray-800">Edit User</h1>
      </div>
    
      <div class="w-1/2 mx-auto bg-white p-8 rounded-lg shadow-md">
        
        <!-- Form -->
        <form @submit.prevent="updateForm" class="w-full">

          <!-- Full Name -->
          <div class="mb-4">
            <label for="full_name" class="block text-sm font-medium text-gray-600">Full Name</label>
            <input 
                type="text" 
                v-model="formData.full_name"
                id="full_name" 
                name="full_name"
                class="mt-1 block w-full p-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-orange-500"
                placeholder="Enter full name" 
                required 
            />
            <p v-if="errorMessage.full_name" class="text-red-600 text-sm mb-4">{{ errorMessage.full_name[0] }}</p>
          </div>
  
          <!-- Email -->
          <div class="mb-4">
            <label for="email" class="block text-sm font-medium text-gray-600">Email</label>
            <input 
                type="email" 
                v-model="formData.email"
                id="email" 
                name="email"
                class="mt-1 block w-full p-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-orange-500"
                placeholder="Enter email" 
                required
            />
            <p v-if="errorMessage.email" class="text-red-600 text-sm mb-4">{{ errorMessage.email[0] }}</p>
          </div>
  
          <!-- Role -->
          <div class="mb-6">
            <label for="role_id" class="block text-sm font-medium text-gray-600">Role</label>
            <select 
                id="role_id" 
                v-model="formData.role_id"
                name="role_id" 
                class="mt-1 block w-full p-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-orange-500"
                required
            >
           
              <option value="">Select Role</option>
              <option v-for="role in roles" :key="role.id" :value="role.id">
                {{ role.role_name }}
                </option>
            </select>
          </div>
  
          <!-- Submit Button -->
          <div class="mb-4 text-right">
            <button 
                type="submit" 
                class="bg-orange-500 text-white px-4 py-2 rounded-md hover:bg-orange-600 focus:outline-none focus:ring-2 focus:ring-orange-500"
            >
                Update
            </button>
          </div>
        </form>
      </div>
    </div>
  </template>
  
