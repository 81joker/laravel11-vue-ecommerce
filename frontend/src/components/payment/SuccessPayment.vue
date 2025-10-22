<template>
  <div class="row my-5">
    <div class="col-md-6 mx-auto">
      <div class="card">
        <div class="card-body p-5">
          <h4 class="text-center">
            Your payment was successful! Thank you for your purchase.
          </h4>
        </div>
      </div>
    </div>
  </div>
</template>

<script setup>
import axios from "axios";
import { onMounted } from "vue";
import { API_BASE_URL, headersConfig, makeUniqueId } from "@/helpers/config";
import { useCartStore } from "@/stores/useCartStore";
import { useAuthStore } from "@/stores/useAuthStore";
import { useToast } from "vue-toastification";
import { useRoute, useRouter } from "vue-router";

// define the stores
const authStore = useAuthStore();
const cartStore = useCartStore();

// define the Toast
const toast = useToast();

// define route
const route = useRoute();
const router = useRouter();

// store the order
const storeUserOrders = async () => {
  try {
    // make the api call to get the payment link
    const response = await axios.post(
      `${API_BASE_URL}/store/order`,
      {
        cartItems: cartStore.cartItems,
        // amount: cartStore.cartTotalAmount,
      },
      headersConfig(authStore.access_token)
    );

    cartStore.clearCartItems();
    cartStore.setValidCoupon({
      name: '',
      discount: 0,
    });
    authStore.user = response.data.user

    toast.success("Order placed successfully!", {
      timeout: 2000,
    });
  } catch (error) {
    console.error("Error fetching payment link:", error);
    throw error;
  }
};

// once the component is mounted, store the order
onMounted(() => {
  if (cartStore.uniqueHash == route.params.hash) {
    storeUserOrders();
    cartStore.setUniqueHash("");
    // cartStore.setUniqueHash(makeUniqueId())
  } else {
    router.push("/");
  }
});
</script>

<style scoped>
</style>