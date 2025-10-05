<template>
<div>
  <Navbar />
    <h1>You did it!XXXX</h1>
  <router-link :to="{ name: 'Home' }">Go Home</router-link>
  <router-view></router-view>
</div>
</template>

<script setup>
import Navbar from './components/layouts/Navbar.vue';
</script>

<style scoped></style>
