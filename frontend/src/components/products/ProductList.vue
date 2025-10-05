<template>
    <div class="row">
    <ProductsListItem
    
        v-for="product in productStore.products"
        :key="product.id"
        :product="product"
    />
    </div>
</template>
<script setup>
import ProductsListItem from './ProductsListItem.vue';
import { useProductStore } from '../../stores/useProductStore'

// define the store variable
const productStore = useProductStore()  
</script>