import { defineStore } from "pinia";
import { useToast } from "vue-toastification";
import axios from "axios";

export const useCartStore = defineStore("cart",{
    state: () => ({
        cartItems: [],
        // cartCount: 0,
        // cartTotal: 0,
        isLoading: false,
    }),
    actions: {
        async addToCart(item){
            let index = this.cartItems.findIndex(product => product.id === item.id && product.color === item.color && product.size === item.size);
            // If the product exists in the cart, increase the quantity
            if(index !== -1){
                this.cartItems[index].qty += item.qty;
            } else {
                this.cartItems.push(item);
            }
        }
        }
})