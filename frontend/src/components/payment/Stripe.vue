<template>
    <div class="row">
        <div class="col-md-12">
            <button class="btn btn-lg btn-dark btn-block w-100" @click="fetchPaymentLink">
                Proced to Payment
            </button>
        </div>
    </div>
</template>

<script setup>
import axios from 'axios';
import { API_BASE_URL, headersConfig , makeUniqueId } from '@/helpers/config';
import { useCartStore } from '@/stores/useCartStore';
import { useAuthStore } from '@/stores/useAuthStore';

// define the stores
const authStore = useAuthStore();
const cartStore = useCartStore();


// define the unique hash
const hash = makeUniqueId(24);

// get the payment link
const fetchPaymentLink = async () => {
    const payload = {
    cartItems: cartStore.cartItems,
    success_url: `${window.location.origin}/success/payment/${hash}`,
  }


    // define the payment link
       try {
            // make the api call to get the payment link
            const response = await axios.post(`${API_BASE_URL}/pay/order`, payload
            , headersConfig(authStore.access_token));

            // return the payment link
            cartStore.setUniqueHash(hash);
            window.location.href = response.data.url;
       } catch (error) {
            console.error('Error fetching payment link:', error);
            throw error;
       }

};
</script>

<style scoped>

</style>

