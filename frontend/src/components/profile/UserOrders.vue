<template>
  <div class="row my-5">
    <ProfileSidebar />
    <div class="col-md-8">
      <div class="card-body" v-if="authStore?.user?.orders?.length > 0">
        <table class="table">
          <thead>
            <tr>
              <th>Order ID</th>
              <th>Product Name</th>
              <th>Product Price</th>
              <th>Quentity</th>
              <th>Total</th>
              <th>Order Date</th>
              <th>Deliverd at</th>
            </tr>
          </thead>
          <tbody>
            <tr
              v-for="order in authStore?.user.orders.slice(0, data.orderToShow)"
              :key="order.id"
            >
              <td>{{ order.id }}</td>
              <td>
                <div class="d-flex flex-coloumn">
                  <span
                    class="badge bg-success my-1 rounded-0"
                    v-for="product in order.products"
                    :key="product.id"
                    >{{ product.name }}</span
                  >
                </div>
              </td>
              <td>
                <div class="d-flex flex-coloumn">
                  <span
                    class="badge bg-danger my-1 rounded-0"
                    v-for="product in order.products"
                    :key="product.id"
                    >${{ product.price }}</span
                  >
                </div>
              </td>
              <td>{{ order.qty }}</td>
              <td>$ {{ order.total }}</td>
              <td>{{ order.created_at }}</td>
              <td>
                <span
                  class="badge bg-success my-1 rounded-0"
                  v-if="order.delivered_at"
                >
                  {{ order.delivered_at }}
                </span>
                <span class="badge bg-warning my-1 rounded-0" v-else>
                  Pending..
                </span>
              </td>
            </tr>
          </tbody>
        </table>
      </div>
      <Alert v-else bgColor="primary" content="No orders found!" />

      <div class="d-flex justify-content-center">
        <button
          type="submit"
          class="btn btn-dark mt-2"
          @click="loadMoreOrders"
          v-if="data.orderToShow < authStore?.user?.orders.length"
        >
          <i class="bi bi-arrow-clockwise"></i>Loadmore
        </button>
      </div>
    </div>
  </div>
</template>

<script setup>
import ProfileSidebar from "./ProfileSidebar.vue";
import { useAuthStore } from "@/stores/useAuthStore";
import Alert from "@/components/layouts/Alert.vue";
import { reactive } from "vue";

// define the stores
const authStore = useAuthStore();

// define how many products to shw on home page
const data = reactive({
  orderToShow: 2,
});

// define the function to load more products
const loadMoreOrders = () => {
  if (data.orderToShow < authStore?.user?.orders?.length) {
    data.orderToShow = data.orderToShow + 4;
  } else {
    return;
  }
};
</script>

<style scoped></style>
