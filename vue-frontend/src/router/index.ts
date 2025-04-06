import { createRouter, createWebHistory } from 'vue-router'

import LoginView from '@/views/Auth/LoginView.vue'
import HomeView from '@/views/HomeView.vue'
import UserView from '@/views/User/UserView.vue'
import UserStoreView from '@/views/User/StoreView.vue'
import UserShowView from '@/views/User/ShowView.vue'
import UserEditView from '@/views/User/EditView.vue'


import RoleView from '@/views/Role/RoleView.vue'
import RoleStoreView from '@/views/Role/StoreView.vue'
import RoleEditView from '@/views/Role/EditView.vue'
import RoleShowView from '@/views/Role/ShowView.vue'

const router = createRouter({
  history: createWebHistory(import.meta.env.BASE_URL),
  routes: [
    {
      path: '/',
      name: 'login-view',
      component: LoginView,
      meta: {
          guest: true
      }
    },

    {
      path: '/home',
      name: 'home-view',
      component: HomeView,
      meta: {
          auth: true
      }
    },

    // For User Routes

    {
      path: '/user',
      name: 'user-view',
      component: UserView,
      meta: {
          auth: true
      }
    },

    {
      path: "/user/add",
      name: "add-user",
      component: UserStoreView,
      meta: {
          auth: true
      }
    },

    {
      path: "/user/view/:id",
      name: "view-user",
      component: UserShowView,
      meta: {
          auth: true
      }
    },

    {
      path: "/user/edit/:id",
      name: "edit-user",
      component: UserEditView,
      meta: {
          auth: true
      }
    },
    
    
    // For Role Routes

    {
      path: '/role',
      name: 'role-view',
      component: RoleView,
      meta: {
          auth: true
      }
    },

    {
      path: "/role/add",
      name: "add-role",
      component: RoleStoreView,
      meta: {
          auth: true
      }
    },

    {
      path: '/role/view/:id',
      name: 'view-role',
      component: RoleShowView,
      meta: {
          auth: true
      }
    },

    {
      path: "/role/edit/:id",
      name: "edit-role",
      component: RoleEditView,
      meta: {
          auth: true
      }
    },
    
  ],
})

router.beforeEach(async (to, from) => {
  const token = localStorage.getItem('token');
  const isAuthenticated = token ? true : false;

  if (to.meta.auth && !isAuthenticated) {
    // Trying to access protected route but not authenticated
    return '/';
  } else if (to.meta.guest && isAuthenticated) {
    // Trying to access login while authenticated
    return '/home';
  }

  
})

export default router
