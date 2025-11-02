<template>
  <div class="mb-3">
      <h6 id="accordion-collapse-heading-category">
        <button type="button" data-accordion-target="#accordion-collapse-body-category" aria-expanded="true"
          aria-controls="accordion-collapse-body-category">
          Category
        </button>
      </h6>
      <div id="accordion-collapse-body-category"  aria-labelledby="accordion-collapse-heading-category">
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