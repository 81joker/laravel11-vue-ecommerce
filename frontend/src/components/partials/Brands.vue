<template>
  <div class="mb-3">
    <h6 id="accordion-collapse-heading-brands">
      <a
        class="text-decoration-none link-dark link-opacity-50-hover"
        data-bs-toggle="collapse"
        href="#collapseBrands"
        role="button"
        aria-expanded="false"
        aria-controls="collapseBrands"
      >
        Brands
      </a>
    </h6>
    <div id="collapseBrands">
      <ul class="nav d-flex flex-column">
        <li
          class="nav-item mb-1"
          v-for="brand in productsStore.brands"
          :key="brand.id"
        >
          <button
            class="btn btn-sm btn-link text-dark"
            @click="productsStore.filterProducts('brand', brand.slug)"
          >
            {{ brand.name }}
          </button>
        </li>
      </ul>
    </div>
  </div>
</template>

<script setup>
import { useProductStore } from "../../stores/useProductStore";

//define the store variable
const productsStore = useProductStore();
</script>

<style scoped>
</style>