<template>
    <div class="card mb-2">
        <Spinner :store="productDetailsStore" />
        <div class="card-header bg-white">
            <h5 class="text-center text-title">Edit your Review</h5>
        </div>
        <div class="card-body">
            <form @submit.prevent="editReview" class="mt-5 col-md-10 mx-auto">
                <div class="form-group mb-3">
                    <label for="title">Title</label>
                    <input v-model="data.review.title" type="text" id="title" :required="true" class="form-control"
                        placeholder="Enter review title" />
                </div>
                <div class="mb-3">
                    <label for="rating">Text Review</label>
                    <textarea v-model="data.review.body" id="body" class="form-control" rows="3" :required="true"
                        placeholder="Enter your review here..."></textarea>
                </div>
                <div class="mb-3">
                    <label for="rating">Rating*</label>
                    <br />
                    <star-rating v-model:rating="data.review.rating" 
                    :star-size="25" :show-rating="false"></star-rating>
                </div>
                <div class="mb-3">
                    <button
                        type="submit"
                        class="btn btn-dark btn-sm"
                        :disabled="data.review.rating === 0"
                    >
                        Update
                    </button>
                    <button
                        type="button"
                        class="btn btn-danger mx-2 btn-sm"
                        @click="productDetailsStore.cancelUpdating"
                    >
                        Cancel
                    </button>
                </div>
            </form>
        </div>
    </div>
</template>

<script setup>
import { useProductDetailsStore } from "@/stores/useProductDetailsStore";
import { reactive } from "vue";
import StarRating from "vue-star-rating";
import Spinner from "../layouts/Spinner.vue";

const productDetailsStore = useProductDetailsStore();
const data = reactive({
    review: {
        title: productDetailsStore.reviewToUpdate.data.title,
        body: productDetailsStore.reviewToUpdate.data.body,
        rating: productDetailsStore.reviewToUpdate.data.rating,
        id: productDetailsStore.reviewToUpdate.data.id,
    }
});

// Submit Review
const editReview = () => {
    productDetailsStore.updateReview(data.review)
    data.review = {
        title: "",
        body: "",
        rating: 0,
    };
};
</script>

<style></style>
