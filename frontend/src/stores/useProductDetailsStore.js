

import { defineStore } from 'pinia'
import axios from 'axios'
import { API_BASE_URL, headersConfig } from '../helpers/config'
import { useAuthStore } from './useAuthStore'
import { useToast } from 'vue-toastification'



export const useProductDetailsStore = defineStore('product', {
  state: () => ({
    product: null,
    productThumbnail: '',
    productImages: [],
    isLoading: false,
    error: null,
    reviewToUpdate: {
      updating: false,
      data: null
    }


  }),
  persist: true,
  actions: {
    async fetchProduct(slug) {
      this.productImages = []
      this.isLoading = true
      try {
        const response = await axios.get(API_BASE_URL + `/products/${slug}/show`)
        this.product = response.data.data
        this.productThumbnail = response.data.data.thumbnail

        // Add product images to the array
        if (response.data.data.first_image) {
          this.productImages.push({
            id: 1,
            src: response.data.data.first_image
          })
          // this.productImages.push(response.data.data.first_image)
        }
        if (response.data.data.second_image) {
          this.productImages.push({
            id: 2,
            src: response.data.data.second_image
          })
        }
        if (response.data.data.third_image) {
          this.productImages.push({
            id: 3,
            src: response.data.data.third_image
          })
        }

        this.isLoading = false
      } catch (error) {
        this.isLoading = false
        console.log(error)
      }
    },
    editReview(review) {
      this.reviewToUpdate = {
        updating: true,
        data: review
      }
    },
    cancelUpdating() {
      this.reviewToUpdate = {
        updating: false,
        data: null
      }
    },
    async storeReview(reviewData) {
      const authStore = useAuthStore()
      const toast = useToast()
      this.isLoading = true
      try {
        const response = await axios.post(`${API_BASE_URL}/store/review`, {
          title: reviewData.title,
          body: reviewData.body,
          rating: reviewData.rating,
          product_id: this.product.id
        }, headersConfig(authStore.access_token))
        if (response.data.error) {
          toast.error(response.data.error, {
            timeout: 2000,
          })
        } else {
          toast.success(response.data.message, {
            timeout: 2000,
          })
        }
        this.isLoading = false
      } catch (error) {
        console.log(error)
        this.isLoading = false
        // throw error
      }
    },

    async updateReview(reviewData) {
      const authStore = useAuthStore()
      const toast = useToast()
      try {
        const response = await axios.put(API_BASE_URL + `/products/${reviewData.product_id}/reviews/${reviewData.review_id}`, reviewData)
        return response.data
      } catch (error) {
        console.log(error)
        throw error
      }
    },
    // resetReviewToUpdate(){
    //   this.reviewToUpdate.updating = false
    //   this.reviewToUpdate.data = null
    // }


  }
})