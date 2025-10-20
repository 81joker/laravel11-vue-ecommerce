import { createRouter, createWebHistory } from 'vue-router'
import Home from '@/components/Home.vue'
import Login from '@/components/auth/Login.vue'
import Register from '@/components/auth/Register.vue'
import Product from '../products/Product.vue'
import Cart from '../cart/Cart.vue'
import { useAuthStore } from '../../stores/useAuthStore'
import Profile from '../profile/Profile.vue'


// add route guard 
function checkIfUserIsLoggedIn(){
    const authStore = useAuthStore();
    if (!authStore.isLoggedIn) return '/login';
}

function checkIfUserIsNotLoggedIn() {
    const authStore = useAuthStore();
    if (authStore.isLoggedIn) return '/';
}

const router = createRouter({
    history: createWebHistory(),

    routes: [
        {
            path: '/',
            name: 'Home',
            component: Home
        },
        {
            path: '/register',
            name: 'register',
            component: Register,
            beforeEnter: [checkIfUserIsNotLoggedIn]
        },
        {
            path: '/login',
            name: 'login',
            component: Login,
            beforeEnter: [checkIfUserIsNotLoggedIn]
        },
        {
            path: '/product/:slug',
            name: 'product',
            component: Product
        },
        {
            path: '/profile',
            name: 'profile',
            component: Profile,
            beforeEnter: [checkIfUserIsLoggedIn]
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

