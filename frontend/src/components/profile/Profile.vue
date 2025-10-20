<template>
 <div class="row py-5">

    <ProfileSidebar />

    <div class="col-md-8">
        <div class="card p-4">
            <h3>Profile Details</h3>
            <hr />
  
            <!-- Add more profile details as needed -->
        </div>
    </div>
 </div>
</template>

<script setup>
import { useAuthStore } from '@/stores/useAuthStore';
import ProfileSidebar from './ProfileSidebar.vue';

</script>

<style>

</style>