<template>
 <div class="row py-5">

    <ProfileSidebar />
    <UpdateUserInfos  :updatingProfileTitle="true"/>
 </div>
</template>

<script setup>
import { useAuthStore } from '@/stores/useAuthStore';
import UpdateUserInfos from './UpdateUserInfos.vue';

import ProfileSidebar from './ProfileSidebar.vue';

</script>

<style>

</style>