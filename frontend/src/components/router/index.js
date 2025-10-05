import { createRouter, createWebHistory } from 'vue-router'
import Home from '@/components/Home.vue'
import Login from '@/components/auth/Login.vue'
import Register from '@/components/auth/Register.vue'

const router = createRouter({
    // history: createWebHistory(),  
    history: createWebHistory(import.meta.env.BASE_URL),
    routes: [
        {
            path: '/',
            name: 'Home',
            component: Home
        },
        {
            path: '/login',
            name: 'Login',
            component: Login
        },
        {
            path: '/register',
            name: 'Register',
            component: Register
        },

    ]
})

export default router

