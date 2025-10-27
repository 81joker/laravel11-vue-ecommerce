<template>
    <div class="row">
      <div class="d-flex">
        <div class="mb-3" v-if="productStore.products.length > 0">
          Found 
          <span class="fw-bold">{{ productStore.products.length }}</span>
          {{ productStore.products.length === 1 ? 'product' : 'products' }}
        </div>
        <div class="ms-1" v-if="productStore.filter">
          for <span class="fw-bold">{{productStore.filter.param}} {{ productStore.filter.value }}</span>
        </div>
      </div>
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
</template>
<script setup>
import ProductsListItem from "./ProductsListItem.vue";
import { useProductStore } from "../../stores/useProductStore";
import {reactive} from 'vue'

// define the store variable
const productStore = useProductStore();

// define how many products to shw on home page 
const data = reactive({
    productToShow: 8
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
