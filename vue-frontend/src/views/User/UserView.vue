<script setup lang="ts">
import NavBar from '@/components/Navbar.vue'
import { RouterLink } from 'vue-router'
import { onMounted, ref } from 'vue'
import { useToast } from 'vue-toastification'
import router from '/src/router/index.ts'
import axios from 'axios'

const users = ref([])

const toast = useToast()


const fetchUsers = async () => { // Fetch all Users
  try {
    const response = await axios.get('/api/users', {
                      headers: {
                          'Authorization': `Bearer ${localStorage.getItem('token')}`
                      }
                  });
    users.value = response.data;
    console.log("Users", users)
    
  } catch (error) {
    console.log("Error fetching Users", error)
  }
}

onMounted(fetchUsers) // Call automatically the fetchUsers method

const deleteUser = async (id) =>{ // Delete User

  const isConfirmed = window.confirm("Are you sure you want to delete this user?");

  if(isConfirmed){
    try {
        const response = await axios.delete(`/api/users/${id}`, {
                      headers: {
                          'Authorization': `Bearer ${localStorage.getItem('token')}`
                      }
                  });
        await fetchUsers();
        toast.success("User deleted successfully")
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
        <h1 class="text-3xl font-bold text-gray-800">User List</h1>
        <RouterLink to="/user/add" class="bg-orange-500 text-white px-4 py-2 rounded-md hover:bg-orange-600 focus:outline-none">
            Add User
        </RouterLink>
      </div>

      <table class="min-w-full table-auto mt-5">
        <thead class="bg-gray-800 text-white ">
          <tr>
            <th class="px-4 py-3 text-left">Full Name</th>
            <th class="px-4 py-3 text-left">Email</th>
            <th class="px-4 py-3 text-left">Role</th>
            <th class="px-4 py-3 text-left">Actions</th>
          </tr>
        </thead>
        <tbody class="text-gray-800">
          <tr v-for="user in users" :key="user.id" class="border-b">
            <td class="px-4 py-2"> {{ user.full_name }}</td>
            <td class="px-4 py-2"> {{ user.email }}</td>
            <td class="px-4 py-2"> {{ user.role.role_name }}</td>
            <td class="p-2 text-left flex">
                <RouterLink :to="`/user/edit/${user.id}`" class="mr-1 bg-gray-400 px-3 py-2 rounded-lg text-white hover:bg-gray-500 duration-300">Edit</RouterLink>
                <RouterLink :to="`/user/view/${user.id}`" class="mr-1 bg-blue-400 px-3 py-2 rounded-lg text-white hover:bg-blue-500 duration-300">View</RouterLink>
                <button @click="deleteUser(user.id)" class="ml-1 bg-red-400 px-3 py-2 rounded-lg text-white hover:bg-red-500 duration-300">Delete</button>
            </td>
          </tr>
          
        </tbody>
      </table>

      
    </div>

    
  </main>
</template>
