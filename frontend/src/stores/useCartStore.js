import { defineStore } from "pinia";
import { useToast } from "vue-toastification";

import axios from "axios";

const toast = useToast();

export const useCartStore = defineStore("cart", {
  state: () => ({
    cartItems: [],
    // cartCount: 0,
    // cartTotal: 0,
    isLoading: false,
  }),
    persist: true,
  actions: {
    async addToCart(item) {
      let index = this.cartItems.findIndex(
        (product) =>
          product.id === item.id &&
          product.color === item.color &&
          product.size === item.size
      );
      // If the product exists in the cart, increase the quantity
      if (index !== -1) {
        toast.info("Product already in your cart", {
          timeout: 2000,
        });
      } else {
        this.cartItems.push(item);
        toast.success("Product added to cart", {
          timeout: 2000,
        });
      }
    },
    incrementQty(item) {
      let index = this.cartItems.findIndex(
        (product) =>
          product.id === item.id &&
          product.color === item.color &&
          product.size === item.size
      );
      if (index !== -1) {
        this.cartItems[index].qty === item.maxQty
          ? toast.error(`You can only add up to ${item.maxQty} items`, {
              timeout: 2000,
            })
          : (this.cartItems[index].qty += 1)
            toast.success("Product quantity increased", {
              timeout: 2000,
            });
      }
      // this.cartItems[index].qty += 1;
    },
    decrementQty(item) {
      let index = this.cartItems.findIndex(
        (product) =>
          product.id === item.id &&
          product.color === item.color &&
          product.size === item.size
      );
      if (index !== -1) {
        let index = this.cartItems.findIndex(
          (product) =>
            product.product_id === item.product_id &&
            product.color === item.color &&
            product.size === item.size
        );
        //if the product exists
        if (index !== -1) {
          toast.info("Product quantity decreased", {
            timeout: 2000,
          });
          this.cartItems[index].qty -= 1;
          if (this.cartItems[index].qty === 0) {
            this.cartItems = this.cartItems.filter(
              (product) => product.ref !== item.ref
            );
          }
        }
      }
    },
    removeFromCart(item) {
      
    //     this.cartItems = this.cartItems.filter(
    //           (product) => product.ref !== item.ref
    //         );
    //     toast.success("Product removed from cart", {
    //       timeout: 2000,
    //     });
    //   return;
      // Remove item based on id, color, and size
      this.cartItems = this.cartItems.filter(
        (product) =>
          !(
            product.id === item.id &&
            product.color === item.color &&
            product.size === item.size
          )
      );
      toast.success("Product removed from cart", {
        timeout: 2000,
      });
    },
    clearCartItems() {
      this.cartItems = [];
    },
  },
});
