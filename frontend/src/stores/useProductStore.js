

import { defineStore } from 'pinia'
import axios from 'axios'
import { API_BASE_URL } from '../helpers/config'
export const useProductStore = defineStore('products', {
  state: () => ({ 
    products: [],
    categories: [],
    colors: [],
    sizes: [],
    brands: [],
    isLoading: false,
    filter: null,
  }),
  actions: {
        async fetchAllProducts() {
        this.isLoading = true
        try {
            const response = await axios.get(API_BASE_URL+'/products')
            this.products = response.data.data 
            this.categories = response.data.categories
            this.colors = response.data.colors
            this.brands = response.data.brands
            this.sizes = response.data.sizes
            this.isLoading = false
        } catch (error) {
            this.isLoading = false
            console.log(error)
        }
      },
        async filterProducts(param,value,search=false) {
        this.isLoading = true
        try {
            const response = await axios.get(API_BASE_URL+`/products/${value}/${param}`)
            this.products = response.data.data 
            this.categories = response.data.categories
            this.colors = response.data.colors
            this.brands = response.data.brands
            this.sizes = response.data.sizes
            if(search){
              this.filter = {
                param: "term",
                value
              }
            } else {
              this.filter = {
                        param,
                        value: response.data.filter,
                      }
            }
            this.isLoading = false
        } catch (error) {
            this.isLoading = false
            console.log(error)
        }
      },
      clearFilter(){
        this.filter = null
        this.fetchAllProducts()
      }
    }
})