<template>
    <div class="container">
        <div class="row">
    <ProductsListItem
    
        v-for="product in productStore.products"
        :key="product.id"
        :product="product"
    />
    <div class="col-md-6 col-lg-4">
        <p v-if="productStore.products.length === 0" class="text-center">No products found</p> 
    </div>
    </div>
    </div>
</template>
<script setup>
import ProductsListItem from './ProductsListItem.vue';
import { useProductStore } from '../../stores/useProductStore'

// define the store variable
const productStore = useProductStore()  
</script>