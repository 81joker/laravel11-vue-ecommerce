<template>
  <div class="product">
    <Spinner :store="productStore" />
    <div v-if="productStore.product">
      <div class="row">
        <div class="col-md-6">
          <div>
            <!-- product images -->
            <vue-image-zoomer
              img-class="img-fluid rounded"
              :regular="productStore.product?.thumbnail"
              :zoom="productStore.product?.thumbnail"
            >
            </vue-image-zoomer>
          </div>
          <div class="row my-2">
                    <div class="col-md-6"
                        v-for="productImage in productStore.productImages"
                        :key="productImage.id"
                    >
                        <vue-image-zoomer 
                            img-class="img-fluid rounded" 
                            :regular="productImage.src"
                            :zoom="productImage.src"
                        />
                    </div>
                </div>
        </div>
        

        <!-- <pre>
                {{ productStore.product }}
            </pre> -->

        <div class="col-md-5 mx-auto">
          <h5 class="my-3">{{ productStore.product.name }}</h5>
          <div class="d-inline-flex">
            <span class="badge text-bg-light">
              <i class="bi bi-tag"></i>
              {{ productStore.product.category.name }}
            </span>
            <span class="badge text-bg-light ms-3">
              <i class="bi bi-c-circle"></i>
              {{ productStore.product.brand.name }}
            </span>
          </div>
          <p
            class="my-3"
            v-dompurify-html="productStore.product?.desc.substr(0, 50)"
          ></p>
          <div class="mb-2">
            <span class="h5"> ${{ productStore.product.price }} </span>
          </div>
          <div class="d-flex flex-wrap justify-content-start">
            <div
              class="border border-light-subtle shadow-sm border-2 rounded mb-1 me-1"
              v-for="color in productStore.product.colors"
              :key="color.id"
              :style="{
                backgroundColor: color.name,
                width: '30px',
                height: '30px',
                cursor: 'pointer',
              }"
            ></div>
          </div>

          <div
            class="d-flex flex-wrap justify-content-start align-items-center mb-4"
          >
            <button
              class="btn btn-sm btn-outline-secondary mb-3 mx-1"
              v-for="size in productStore.product.sizes"
              :key="size.id"
            >
              {{ size.name }}
            </button>
          </div>

          <div class="my-3 d-inline-flex">
            <div>
              <input
                type="number"
                v-model="data.qty"
                min="1"
                :max="productStore.product?.qty"
                class="form-control"
              />
            </div>
            <div class="ms-2">
              <button class="btn btn-danger btn-block">
                <i class="bi bi-cart-plus"></i> Buy Now
              </button>
            </div>
            <!-- <div class="ms-2">
                        <button class="btn btn-danger btn-block"
                            :disabled="!data.chosenColor || !data.chosenSize || !productDetailsStore.product?.status"
                            @click="cartStore.addToCart({
                                ref: makeUniqueId(10),
                                product_id: productDetailsStore.product?.id,
                                name: productDetailsStore.product?.name,
                                slug: productDetailsStore.product?.slug,
                                qty: data.qty,
                                price: productDetailsStore.product?.price,
                                color: data.chosenColor?.name,
                                size: data.chosenSize?.name,
                                maxQty: productDetailsStore.product?.qty,
                                image: productDetailsStore.product?.thumbnail,
                                coupon_id: null,
                            })"
                            >
                            <i class="bi bi-cart-plus"></i> Add to cart
                        </button>
                    </div> -->
          </div>
        </div>
      </div>
    </div>
  </div>
</template>
<script setup>
import { useRoute } from "vue-router";
import { onMounted, reactive } from "vue";
import { useProductStore } from "@/stores/useProductDetailsStore";
import Spinner from "@/components/layouts/Spinner.vue";
const productStore = useProductStore();
const route = useRoute();

const data = reactive({
  qty: 1,
  chosenColor: null,
  chosenSize: null,
});
const product = productStore.product;
onMounted(() => {
  productStore.fetchProduct(route.params.slug);
});
</script>

           <!-- <vue-image-zoomer 
                img-class="img-fluid rounded" 
	         :regular="productStore.product?.thumbnail"
        :zoom="productStore.product?.thumbnail"
        zoom-width="500"
        zoom-height="500"
        zoom-style="border: 1px solid #ccc;"
        lens-style="border: 1px solid #ccc; background-color: rgba(255, 255, 255, 0.4);"
        zoom-position="right"
        zoom-level="2"
        :enable-scroll-zoom="true"
        :enable-mouse-wheel="true"
        :enable-click-zoom="true"
        :enable-touch-zoom="true"
        :enable-lens="true"
        :enable-zoom="true"
        :enable-fullscreen="true"
        :fullscreen-icon="true"
        :fullscreen-style="{width: '100%', height: '100%'}"
        :lens-width="100"
        :lens-height="100"
        :cursor="'crosshair'"
        
        >
</vue-image-zoomer> -->