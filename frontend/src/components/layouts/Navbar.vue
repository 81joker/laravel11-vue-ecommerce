<template>
  <nav class="navbar navbar-expand-lg bg-body-tertiary">
    <div class="container-fluid">
      <router-link class="navbar-brand" to="/">
        <img
          src="https://cdn.pixabay.com/photo/2014/04/02/11/16/shopping-305728_1280.png"
          alt="Logo"
          width="60"
          height="60"
        />
      </router-link>
      <button
        class="navbar-toggler"
        type="button"
        data-bs-toggle="collapse"
        data-bs-target="#navbarSupportedContent"
        aria-controls="navbarSupportedContent"
        aria-expanded="false"
        aria-label="Toggle navigation"
      >
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse" id="navbarSupportedContent">
        <ul class="navbar-nav mb-2 mb-lg-0 mx-auto">
          <li class="nav-item">
            <router-link class="nav-link" aria-current="page" to="/">
              <i class="bi bi-house-door-fill"></i> Home
            </router-link>
          </li>
          <ul class="navbar-nav" v-if="!authStore.isLoggedIn">
            <li class="nav-item">
              <router-link class="nav-link" aria-current="page" to="/register">
                <i class="bi bi-person-add"></i> Register
              </router-link>
            </li>
            <li class="nav-item">
              <router-link class="nav-link" aria-current="page" to="/login">
                <i class="bi bi-box-arrow-right"></i> Login
              </router-link>
            </li>
          </ul>
          <ul class="navbar-nav" v-else>
            <li class="nav-item">
              <router-link class="nav-link" aria-current="page" to="/profile">
                <i class="bi bi-person-check-fill"></i>
                {{ authStore.user.name }}
              </router-link>
            </li>
            <li class="nav-item">
              <router-link class="nav-link" @click="userLogout" to="#">
                <i class="bi bi-box-arrow-left"></i> Logout
              </router-link>
            </li>
          </ul>
          <li class="nav-item" v-if="authStore.isLoggedIn">
            <router-link class="nav-link" aria-current="page" to="/cart">
              <i class="bi bi-cart-plus"></i> Cart ({{
                cartStore.cartItems.length
              }})
            </router-link>
          </li>
          <li class="nav-item" v-if="authStore.isLoggedIn">
            <router-link class="nav-link" aria-current="page" to="/favorites">
              <i class="bi bi-heart"></i> Favorites ({{
                favoritesStore.favorites.length
              }})
            </router-link>
          </li>
        </ul>
      </div>
    </div>
  </nav>
</template>

<script setup>
import axios from "axios";
import { useCartStore } from "@/stores/useCartStore";
import { useAuthStore } from "@/stores/useAuthStore";
import { API_BASE_URL, headersConfig } from "@/helpers/config";
import { useToast } from "vue-toastification";
import { useRouter } from "vue-router";
import { onMounted } from "vue";
import { useFavoritesStore } from "@/stores/useFavoritesStore";
const cartStore = useCartStore();
const authStore = useAuthStore();

// define the toast
const toast = useToast();

// define router
const router = useRouter();

const favoritesStore = useFavoritesStore()

// Logout function
const userLogout = async () => {
  try {
    const response = await axios.post(
      `${API_BASE_URL}/user/logout`,
      null,
      headersConfig(authStore.access_token)
    );
    authStore.clearAuthData();
    toast.success(response.data.message, { timeout: 2000 });
    await router.push("/login");
    // if (response.status === 200) {
    //   authStore.logout()
    //   toast.success('Logged out successfully')
    // }
  } catch (error) {
    console.error("Logout failed:", error);
  }
};

// fetch the currently logged in user function
// and check if the access token is valid
const fetchCurrentUser = async () => {
  try {
    const response = await axios.get(
      `${API_BASE_URL}/user`,
      headersConfig(authStore.access_token)
    );
    authStore.setIsLoggedIn();
    authStore.setUser(response.data.user);
    authStore.setToken(response.data.access_token);
  } catch (error) {
    if (error.response && error.response.status === 401) {
      // Token is invalid or expired
      authStore.clearAuthData();
      toast.error("Session expired. Please log in again.", { timeout: 3000 });
      await router.push("/login");
    } else {
      console.error("Failed to fetch current user:", error);
    }
    console.error("Logout failed:", error);
  }
};
// once the component is loaded we get the currently logged in user
onMounted(() => (authStore.access_token ? fetchCurrentUser() : null));
</script>

<style scoped>
.navbar a {
  font-size: 1.1rem;
  font-weight: 700;
}
</style>
<!-- 
The fetchCurrentUser function ensures user authentication,
  retrieves personalized data,
  manages sessions, handles errors, updates application state,
  fetches data on demand, and enhances security.
-->