<template>
  <div class="col-md-6 col-lg-4 mb-3">
    <div class="card mb-2">
      <!-- <div class="card mb-2" style="max-width: 320px"> -->
      <router-link :to="`/product/${product.slug}`" class="text-decoration-none text-dark">
      <img :src="product.thumbnail" class="card-img-top" :alt="product.name" height="279" />
        </router-link>

      <div class="card-body">
        <div class="d-flex justify-content-between">
          <div>
            <router-link :to="`/product/${product.slug}`" class="text-decoration-none text-dark">
          <h5 class="card-title">{{ product.name }}</h5>
        </router-link>
        <p class="card-text text-muted" v-dompurify-html="product.desc.substr(0, 50)"></p>
          </div>
            <h6 >${{ product.price.toFixed(2) }}</h6>
        </div>
          <div v-if="product.reviews.length > 0">
            <StarRating v-model:rating="reviewAvg" :show-rating="false" read-only :star-size="24" />
            <small class="text-muted">
              {{ product.reviews.length }}
              {{ product.reviews.length > 1 ? "reviews" : "review" }}
            </small>
          </div>
      
      </div>
      <div class="card-footer d-flex justify-content-between bg-light">
        <button class="btn btn-danger btn-sm">
          <i class="bi bi-cart-plus"></i> Add to Cart
        </button>
        <button class="btn btn-outline-secondary btn-sm">
          <i class="bi bi-heart"></i>
        </button>
      </div>
    </div>
  </div>
</template>
<script setup>
import { computed } from "vue";
import StarRating from "vue-star-rating";

const props = defineProps({
  product: {
    type: Object,
    required: true,
  },
});

//calculate the average reviews of the product
const reviewAvg = computed(() => props.product.reviews.reduce((acc, review) =>
  acc + review.rating / props.product.reviews.length, 0))

</script>
