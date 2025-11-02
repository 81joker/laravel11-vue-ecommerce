<template>
  <div class="mb-3">
          <h6 id="accordion-collapse-heading-brands">
        <button type="button" data-accordion-target="#accordion-collapse-brand" aria-expanded="true"
          aria-controls="accordion-collapse-brand">
          Brands
        </button>
      </h6>
            <div id="accordion-collapse-brand" aria-labelledby="accordion-collapse-heading-brands">
    <ul class="nav d-flex flex-column">
        <li class="nav-item mb-1" v-for="brand in productsStore.brands"
          :key="brand.id">
            <button class="btn btn-sm btn-link text-dark"
              @click="productsStore.filterProducts('brand',brand.slug)"
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
  const productsStore = useProductStore()
</script>

<style scoped>
</style>