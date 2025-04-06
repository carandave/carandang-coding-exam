<script setup lang="ts">
import NavBar from '@/components/Navbar.vue'
import { RouterLink } from 'vue-router'
import { onMounted, ref } from 'vue'
import { useToast } from 'vue-toastification'
import router from '/src/router/index.ts'
import axios from 'axios'

const roles = ref([])

const toast = useToast()


const fetchRole = async () => { // Fetch All Role
  try {
    const response = await axios.get('/api/roles', {
                      headers: {
                          'Authorization': `Bearer ${localStorage.getItem('token')}`
                      }
                  });
    roles.value = response.data;
    console.log("Roles", users)
    
  } catch (error) {
    console.log("Error fetching roles", error)
  }
}

onMounted(fetchRole) // Call the fetchRole method to fetch all the Role

const deleteRole = async (id) =>{ // Delete Role

  const isConfirmed = window.confirm("Are you sure you want to delete this role?");

  if(isConfirmed){
    try {
        const response = await axios.delete(`/api/roles/${id}`, {
                      headers: {
                          'Authorization': `Bearer ${localStorage.getItem('token')}`
                      }
                  });
        await fetchRole();
        toast.success("Role deleted successfully")
        // router.push('/user')
        
      } catch (error) {
        console.log('Error fetching api', error)
      }
  }
  
  
}



</script>

<template>
  <main>
    <NavBar />
    <div class="flex items-start justify-start h-screen bg-gray-100 p-10 flex-col">
      <div class="w-full flex justify-between items-center mb-6">
        <h1 class="text-3xl font-bold text-gray-800">Role List</h1>
        <RouterLink to="/role/add" class="bg-orange-500 text-white px-4 py-2 rounded-md hover:bg-orange-600 focus:outline-none">
            Add Role
        </RouterLink>
      </div>

      <table class="min-w-full table-auto mt-5">
        <thead class="bg-gray-800 text-white ">
          <tr>
            <th class="px-4 py-3 text-left">Role Name</th>
            <th class="px-4 py-3 text-left">Description</th>
            <th class="px-4 py-3 text-left">Actions</th>
          </tr>
        </thead>
        <tbody class="text-gray-800">
          <tr v-for="role in roles" :key="role.id" class="border-b">
            <td class="px-4 py-2"> {{ role.role_name }}</td>
            <td class="px-4 py-2"> {{ role.description }}</td>
            <td class="p-2 text-left flex">
                <RouterLink :to="`/role/edit/${role.id}`" class="mr-1 bg-gray-400 px-3 py-2 rounded-lg text-white hover:bg-gray-500 duration-300">Edit</RouterLink>
                <RouterLink :to="`/role/view/${role.id}`" class="mr-1 bg-blue-400 px-3 py-2 rounded-lg text-white hover:bg-blue-500 duration-300">View</RouterLink>
                <button @click="deleteRole(role.id)" class="ml-1 bg-red-400 px-3 py-2 rounded-lg text-white hover:bg-red-500 duration-300">Delete</button>
            </td>
          </tr>
          
        </tbody>
      </table>

      
    </div>

    
  </main>
</template>
