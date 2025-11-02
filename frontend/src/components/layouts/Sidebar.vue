<template>
    <div class="col-md-2">
        <div class="d-flex align-items-center justify-content-between mb-3">
            <h5>Filters</h5>
            <button class="btn btn-link text-dark"
            @click="productStore.clearFilter()"
                >Clear all</button>
        </div>
        <SearchForm />
        <div id="accordion-collapse" data-accordion="collapse">
        <Categories />
        <Brands />
        <Sizes />
        <Colors />
    </div>
    </div>
</template>

<script setup>
import SearchForm from "../partials/SearchForm.vue"
import Brands from "../partials/Brands.vue"
import Categories from "../partials/Categories.vue";
import Colors from "../partials/Colors.vue";
import Sizes from "../partials/Sizes.vue";
import { useProductStore } from '../../stores/useProductStore'

    //define the store
const productStore = useProductStore()
</script>

<style scoped>
</style>