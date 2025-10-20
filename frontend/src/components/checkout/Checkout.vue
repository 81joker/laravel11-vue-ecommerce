<template>
  <div class="row my-3">
    <UpdateUserInfos :updatingProfileTitle="false" />
    <div class="col-md-4">
      <ul class="list-group">
        <li
          class="list-group-item d-flex"
          v-for="product in cartStore.cartItems"
          :key="product.ref"
        >
          <img
            :src="product.image"
            width="60"
            height="60"
            class="img-fluid rounded me-2"
            :alt="product.name"
          />
          <div class="d-flex flex-column">
            <h6 class="my-1">
              <strong>{{ product.name }}</strong>
            </h6>
            <span class="text-muted">
              <strong>Color: {{ product.color }}</strong>
            </span>
            <span class="text-muted">
              <strong>Size: {{ product.size }}</strong>
            </span>
          </div>

          <div class="d-flex flex-column ms-auto">
            <span class="text-muted">
              ${{ product.price }} <i>x</i> {{ product.qty }}
            </span>
            <span class="text-muted fw-bold">
              ${{ product.price * product.qty }}
            </span>
          </div>
        </li>
        <li class="list-group-item d-flex justify-content-between">
          <span class="fw-bold"> Discount (0)% </span>
          <span class="fw-normal text-danger">
            $0.00
            <i
              class="bi bi-trash"
              :style="{
                cursor: 'pointer',
              }"
            ></i>
          </span>
          <span class="fw-bold text-danger"> -$0.00 </span>
        </li>
        <li class="list-group-item d-flex justify-content-between">
          <span class="fw-bold"> Total </span>
          <span class="fw-bold text-danger"> $ finalTotal </span>
        </li>
      </ul>
      <div class="my-3">
        <button class="btn btn-lg btn-dark btn-block w-100"
        v-if="authStore.user?.profile_completed"
        > Pay Now </button>
        <!-- <button class="btn btn-dark btn-block d-block"> Proceed to Payment </button> -->
        <Alert v-else
        content="Add your billing details"
        bgColor="warning"
        />
      </div>
    </div>
  </div>
</template>

<script setup>
import { useAuthStore } from "@/stores/useAuthStore";
import { useCartStore } from "@/stores/useCartStore";
import { computed, onMounted } from "vue";
import { useRouter } from "vue-router";
import { useToast } from "vue-toastification";
import Alert from "../layouts/Alert.vue";
import UpdateUserInfos from "../profile/UpdateUserInfos.vue";

// define the store
const authStore = useAuthStore();
const cartStore = useCartStore();

// define the router
const router = useRouter();

// define the Toast
const toast = useToast();

// Calculate the cart total
const total = computed(() => {
  return cartStore.cartItems.reduce(
    (acc, item) => acc + item.price * item.qty,
    0
  );
});

// redirect if cart is empty
onMounted(() => {
  if (cartStore.cartItems.length === 0) {
    toast.info("Your cart is empty. Please add items to proceed to checkout.");
    router.push("/");
  }
});
</script>

<style scoped></style>
