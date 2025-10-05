<template>
  <div class="container">
    <div class="row">
      <ProductsListItem
        v-for="product in productStore.products.slice(0,data.productToShow)"
        :key="product.id"
        :product="product"
      />
      <div class="col-md-6 col-lg-4">
        <p v-if="productStore.products.length === 0" class="text-center">
          No products found
        </p>
      </div>
      
      <div class="d-flex justify-content-center">
        <button type="submit" class="btn btn-dark mt-2" 
        @click="loadMoreProducts"
        v-if="data.productToShow < productStore.products.length">
            <i class="bi bi-arrow-clockwise"></i>Loadmore
        </button>
      </div>

    </div>
  </div>
</template>
<script setup>
import ProductsListItem from "./ProductsListItem.vue";
import { useProductStore } from "../../stores/useProductStore";
import {reactive} from 'vue'

// define the store variable
const productStore = useProductStore();

// define how many products to shw on home page 
const data = reactive({
    productToShow: 2
})


// define the function to load more products
const loadMoreProducts = ()  => {
    if (data.productToShow < productStore.products.length) {
        data.productToShow = data.productToShow + 4
    } else {
        return;
    }
}
</script>
