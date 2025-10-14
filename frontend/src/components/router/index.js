import { createRouter, createWebHistory } from 'vue-router'
import Home from '@/components/Home.vue'
import Login from '@/components/auth/Login.vue'
import Register from '@/components/auth/Register.vue'
import Product from '../products/Product.vue'
import Cart from '../cart/Cart.vue'
import { useAuthStore } from '../../stores/useAuthStore'


// add route guard 
function checkIfUserIsLoggedIn(){
    const authStore = useAuthStore();
    if (!authStore.isLoggedIn) return '/login';
}

function checkIfUserIsNotLoggedIn() {
    const authStore = useAuthStore();
    if (authStore.isLoggedIn) return '/';
}
// function checkIfUserIsLoggedIn(to, from, next) {
//     const user = localStorage.getItem('user');
//     if (!user) {
//         next('/login');
//     } else {
//         next();
//     }
// }

// function checkIfUserIsLoggedOut(to, from, next) {
//     const user = localStorage.getItem('user');
//     if (user) {
//         next('/');
//     } else {
//         next();
//     }


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
            component: Login,
            beforeEnter: [checkIfUserIsLoggedIn]
        },
        {
            path: '/register',
            name: 'Register',
            component: Register,
            beforeEnter: [checkIfUserIsNotLoggedIn]
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

