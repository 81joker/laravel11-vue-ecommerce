<template>
    <div class="col-md-4">
        <div class="d-flex align-items-center justify-content-between mb-3">
            <h5>Filters</h5>
            <button class="btn btn-link text-dark"
                >Clear all</button>
        </div>
        <Brands />
    </div>
</template>

<script setup>
import Brands from "../partials/Brands.vue"
import { useProductStore } from '../../stores/useProductStore'

    //define the store
const productStore = useProductStore()
</script>

<style scoped>
</style>