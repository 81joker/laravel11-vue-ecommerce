<template>
  <div class="mb-3">
    <h6 id="accordion-collapse-heading-category">
      <a class="text-decoration-none link-dark link-opacity-50-hover" data-bs-toggle="collapse" href="#collapseCategory"
        role="button" aria-expanded="false" aria-controls="collapseCategory">
        Category
      </a>
    </h6>
    <div id="collapseCategory">
      <ul class="nav d-flex flex-column ">
        <li class="nav-item mb-1" v-for="category in productsStore.categories" :key="category.id">
          <button class="btn btn-sm btn-link text-dark"
            @click="productsStore.filterProducts('category', category.slug)">
            {{ category.name }}
          </button>
        </li>
      </ul>
    </div>

  </div>
</template>

<script setup>
import { useProductStore } from "../../stores/useProductStore";

//define the store variable
const productsStore = useProductStore()
</script>

<style scoped></style>