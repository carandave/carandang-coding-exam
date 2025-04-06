<script setup lang="ts">
    import { RouterLink, useRoute } from 'vue-router'
    import axios from 'axios'
    import router from '/src/router/index.ts'
    
    const route = useRoute();

    const isActiveLink = (routePath) =>{
    return route.path === routePath
    }

    const logout = async () =>{
        if(localStorage.getItem('token')){
            try{
                const response = await axios.post('/api/logout', {}, {
                    headers: {
                        'Authorization': `Bearer ${localStorage.getItem('token')}`
                    }
                })

            localStorage.removeItem('token');
            localStorage.removeItem('user');
            router.push('/');

            }
            catch(error){

            }
        }
    }



    

</script>

<template>
    <nav class="p-6 shadow-md ">
      <div class="max-w-7xl mx-auto flex justify-between items-center">
  
        <div class=""></div>
  
        <!-- Navigation Links -->
        <div class="space-x-1 flex">
          <RouterLink to="/home" :class="[isActiveLink('/home') ? 'bg-orange-400 text-white ' : 'hover:bg-orange-500 ', 'text-gray-600 hover:text-white transition duration-200 px-4 py-2 rounded']">Home</RouterLink>
          <RouterLink to="/user" :class="[isActiveLink('/user') ? 'bg-orange-400 text-white ' : 'hover:bg-orange-500 ', 'text-gray-600 hover:text-white transition duration-200 px-4 py-2 rounded']">User</RouterLink>
          <RouterLink to="/role" :class="[isActiveLink('/role') ? 'bg-orange-400 text-white ' : 'hover:bg-orange-500 ', 'text-gray-600 hover:text-white transition duration-200 px-4 py-2 rounded']">Role</RouterLink>

          <form @submit.prevent="logout">
            <button class="text-gray-600 hover:text-white hover:bg-orange-400 transition duration-200 px-3 py-2 rounded">Logout</button>
          </form>
         
        </div>
      </div>
    </nav>
  </template>