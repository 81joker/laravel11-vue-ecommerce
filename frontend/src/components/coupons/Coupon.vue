<template>
    <div class="row mb-3">
        <div class="col-12">
            <div class="d-flex">
            <input type="text"
                   v-model="data.coupon.name"
                   class="form-control rounded-0"
                   placeholder="Enter coupon code">
                   <button class="btn btn-primary rounded-0" 
                   @click="applyCoupon"
                   :disabled="!data.coupon.name.trim()">
                    Apply
                   </button>
        </div>
        </div>
    </div>
</template>

<script setup>
import axios from 'axios'
import { API_BASE_URL, headersConfig } from '@/helpers/config'
import { useAuthStore } from '@/stores/useAuthStore'
import { useCartStore } from '@/stores/useCartStore'
import { reactive } from 'vue'
import { useToast } from 'vue-toastification'

// define stores
const authStore = useAuthStore()
const cartStore = useCartStore()

// define the data object
const data = reactive({
    coupon:{
        name: ''
    }
})

// define Toast
const toast = useToast()

// apply coupon function
const applyCoupon = async () => {
    try {
        const response = await axios.post(`${API_BASE_URL}/apply/coupon`, 
        data.coupon  , headersConfig(authStore.access_token))
        
        if (response.data.error) {
            toast.error(response.data.error, {
                position: "top-right",
                timeout: 2000,
            });
            data.coupon = { name: '' }
  
        } else {
            cartStore.setValidCoupon(response.data.coupon)
            cartStore.addCopouonToCartItem(response.data.coupon.id)

            toast.success(response.data.message, {
                timeout: 2000,
            });
            data.coupon = { name: '' }
        }
        // if(response.data.success){
        //     cartStore.setCoupon(response.data.coupon)
        //     toast.success('Coupon applied successfully!')
        // } else {
        //     toast.error(response.data.error || 'Failed to apply coupon. Please try again.')
        // }
    } catch (error) {        
         toast.error(error.response.data.error)
        console.error('Error applying coupon:', error.response.data.error)
    }
}

</script>

<style>

</style>