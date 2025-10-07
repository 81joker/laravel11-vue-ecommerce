

import { defineStore } from 'pinia'
import axios from 'axios'
import { API_BASE_URL } from '../helpers/config'
export const useProductStore = defineStore('products', {
  state: () => ({ 
    product: null,
    productThumbnail: '',
    productImages: [],
    isLoading: false,
    error: null,


  }),
  actions: {
        async fetchProduct(slug) {
        this.productImages = []
        this.isLoading = true
        try {
            const response = await axios.get(API_BASE_URL+`/products/${slug}/show`)
            this.product = response.data.data 
            this.productThumbnail = response.data.data.thumbnail

            // Add product images to the array
            if (response.data.data.first_image) {
              this.productImages.push({
                id:1,
                src: response.data.data.first_image
              })
              // this.productImages.push(response.data.data.first_image)
            }
            if (response.data.data.second_image) {
              this.productImages.push({
                id:2,
                src: response.data.data.second_image
              })
            }
            if (response.data.data.third_image) {
              this.productImages.push({
                id:3,
                src: response.data.data.third_image
              })
            }

            this.isLoading = false
        } catch (error) {
            this.isLoading = false
            console.log(error)
        }
      },
    
      
    }
})