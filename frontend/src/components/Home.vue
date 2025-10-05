<template>
<div>
    <h1 class="text-center my-4">Welcome to Our Store</h1>
    <!-- <div v-if="productStore.isLoading" class="text-center">
        <p>Loading products...</p>
    </div> -->
    <Spinner  :store="productStore"/>
    <div >
        <ProductList />
    </div>
</div>
</template>

<script setup>
import Spinner from './layouts/Spinner.vue';
import ProductList from './products/ProductList.vue';
import { useProductStore } from '../stores/useProductStore'
import { onMounted } from 'vue';
import { setActivePinia } from 'pinia';

// define the store variable
const productStore = useProductStore()

// fetch products from the store
onMounted(() => {
  productStore.fetchAllProducts()
})  
</script>