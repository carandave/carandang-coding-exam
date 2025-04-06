<script setup lang="ts">
import NavBar from '@/components/Navbar.vue'
import { RouterLink } from 'vue-router'
import { onMounted, reactive, ref } from 'vue'
import { useToast } from 'vue-toastification'
import router from '/src/router/index.ts'
import axios from 'axios'

const toast = useToast()

const roles = ref([])

const formData = reactive({
    'role_name': '',
    'description': '',
})

onMounted(async () => { // Fetch All Role to display in Select Option
  try {
    const response = await axios.get('/api/roles', {
                      headers: {
                          'Authorization': `Bearer ${localStorage.getItem('token')}`
                      }
                  });
    roles.value = response.data;
    
    
  } catch (error) {
    console.log("Error getting role: ", error)
  }
})

const errorMessage = ref({});

const storeForm = async () => { // Store Role in Database
    errorMessage.value = '';
    try {
        const response = await axios.post('/api/roles', formData, {
                      headers: {
                          'Authorization': `Bearer ${localStorage.getItem('token')}`
                      }
                  });
       
        toast.success("Role created successfully")
        router.push('/role')
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

    
    
    <div class="flex items-center justify-center h-screen bg-gray-100 p-10 flex-col">

        <div class="w-full flex justify-between items-center mb-6">
            <h1 class="text-3xl font-bold text-gray-800">Add Role</h1>
        </div>
        

      <div class="w-1/2 max-w-sm bg-white p-8 rounded-lg shadow-md">
    
        <form @submit.prevent="storeForm" class="w-full">

          <!-- Role Name -->
          <div class="mb-4">
            <label for="role_name" class="block text-sm font-medium text-gray-600">Role Name</label>
            <input 
                type="text" 
                v-model="formData.role_name"
                id="role_name" 
                name="role_name"
                class="mt-1 block w-full p-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-orange-500"
                placeholder="Enter role name" 
                required 
            />
            <p v-if="errorMessage.role_name" class="text-red-600 text-sm mb-4">{{ errorMessage.role_name[0] }}</p>
          </div>
  
          <!-- Description -->
          <div class="mb-4">
            <label for="email" class="block text-sm font-medium text-gray-600">Description</label>
            <textarea 
            v-model="formData.description"
            name="description" 
            id="description" 
            rows="4" cols="5" 
            class="mt-1 block w-full p-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-orange-500"
            placeholder="Enter description" 
            required
            >
            </textarea>
            <p v-if="errorMessage.email" class="text-red-600 text-sm mb-4">{{ errorMessage.email[0] }}</p>
          </div>
  
          <!-- Submit Button -->
          <div class="mb-4 text-right">
            <button 
                type="submit" 
                class="bg-orange-500 text-white px-4 py-2 rounded-md hover:bg-orange-600 focus:outline-none focus:ring-2 focus:ring-orange-500"
            >
                Save Role
            </button>
          </div>
        </form>
      </div>
    </div>
  </template>
  
