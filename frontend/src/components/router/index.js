import { createRouter, createWebHistory } from 'vue-router'
import Home from '@/components/Home.vue'
import Login from '@/components/auth/Login.vue'
import Register from '@/components/auth/Register.vue'
import Product from '@/components/products/Product.vue'
import Cart from '../cart/Cart.vue'
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
        {
            path: '/product/:slug',
            name: 'product',
            component: Product
        },
        {
            path: '/cart',
            name: 'cart',
            component: Cart
        },
    
        // { 
        //    path: '/:pathMatch(.*)*', 
        //    name: 'NotFound', 
        //    component: () => import('@/components/NotFound.vue') 
        // }

    ]
})

export default router

