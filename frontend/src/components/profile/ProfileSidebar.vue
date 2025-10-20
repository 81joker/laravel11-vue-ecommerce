<template>
  <div class="col-md-4">
    <!-- here the Spinner -->
    <Spinner :store="authStore" />
    <!-- render the validation errors -->
    <RenderValidationErrors :formValidationErrors="authStore.validationErrors" />

    <div class="card p-2">
        <div class="d-flex justify-content-center align-items-center flex-column">
            <img 
                :src="authStore.user?.profile_image" 
                :alt="`Profile image of ${authStore.user.name}`" 
                width="150"
                height="150"
                class="rounded-circle object-fit-cover border border-2 border-secondary mt-1"
            />
            <div class="input-group pb-5 pt-4 w-75">
                <input 
                    type="file" 
                    class="form-control" 
                    id="inputGroupFile04" 
                    aria-describedby="inputGroupFileAddon04" 
                    aria-label="Upload"
                    @change="handleFileInputChange"
                    :key="data.fileInputKey"
                
                >
                <button class="btn btn-outline-dark" type="button" id="inputGroupFileAddon04"
                @click="updateUserProfileImage"
                >
                    Upload
                </button>
            </div>
            
            <ul class="list-group w-100 test-center mt-2">
                <li class="list-group-item d-flex justify-content-between align-items-center">
                    <i class="bi bi-person">Name</i> 
                    <span class="badge bg-dark rounded-pill">  {{ authStore.user?.name }}</span>
                </li>
                <li class="list-group-item d-flex justify-content-between align-items-center">
                    <i class="bi bi-envelope-at-fill">Email</i>
                    <span class="badge bg-dark rounded-pill">{{ authStore.user?.email }}</span>
                </li>
                <li class="list-group-item d-flex justify-content-between align-items-center">
                    <i class="bi bi-telephone-fill">Phone Number</i> 
                    <span class="badge bg-dark rounded-pill">{{ authStore.user?.phone_number || 'N/A' }}</span>
                </li>
                <li class="list-group-item d-flex justify-content-between align-items-center">
                    <i class="bi bi-house-door-fill">Address</i>
                    <span class="badge bg-dark rounded-pill">{{ authStore.user?.address || 'N/A' }}</span>
                </li>
                <li class="list-group-item d-flex justify-content-between align-items-center">
                    <i class="bi bi-geo-alt-fill">City</i>
                    <span class="badge bg-dark rounded-pill">{{ authStore.user?.city || 'N/A' }}</span>
                </li>
                <li class="list-group-item d-flex justify-content-between align-items-center">
                    <i class="bi bi-geo-alt-fill">Zip Code</i>
                    <span class="badge bg-dark rounded-pill">{{ authStore.user?.zip_code || 'N/A' }}</span>
                </li>
            </ul>
        </div>
    </div>
  </div>
</template>

<script setup>
import axios from 'axios'
import { onMounted, reactive } from 'vue'
import { useToast } from 'vue-toastification'
import { API_BASE_URL } from '@/helpers/config'
import { headersConfig } from '@/helpers/config'
import { useAuthStore } from '@/stores/useAuthStore'
import Spinner from '../layouts/Spinner.vue'
import RenderValidationErrors from '../layouts/RenderValidationErrors.vue'

const authStore = useAuthStore()
const toast = useToast();

// define the data
const data = reactive({
    image: null,
    fileInputKey: Date.now()|| 0, 
});

// add the function to handle file input change
const handleFileInputChange = (event) => {
    const file = event.target.files[0];
    data.image = file;
    // data.image = event.target.files[0];
};


// update the profile image function
const updateUserProfileImage = async () => {
    authStore.clearValidationErrors();
    authStore.isLoading = true;

    if (!data.image) {
        authStore.isLoading = false;
        toast.error("Please select an image to upload.", {
            position: "top-right",
            timeout: 2000,
        });
        return;
    }
    
    // send the file
    const formData = new FormData();
    formData.append('profile_image', data.image);
    formData.append('_method', 'PUT'); // Laravel requires this for PUT requests with FormData


       try {
            const response = await axios.post(`${API_BASE_URL}/user/update/profile`,
                formData,headersConfig(authStore.access_token,'multipart/form-data')
            )
            authStore.user=response.data.user;
            authStore.isLoading = false;
            toast.success(response.data.message, {
                position: "top-right",
                timeout: 2000,
            });
            clearFileInput();
        } catch (error) {
            authStore.isLoading = false
            if(error?.response?.status === 422) {
                authStore.setValidationErrors(error.response.data.errors)
            }
            console.log(error)
        }



    // if (!data.image) return;
    // const formData = new FormData();
    // formData.append('profile_image', data.image);
    // try {
    //     await authStore.updateProfileImage(formData);
    //     // Reset the file input
    //     data.fileInputKey = Date.now();
    //     data.image = null;
    // } catch (error) {
    //     console.error('Error updating profile image:', error);
    // }
};


// clear input file
const clearFileInput = () => {
    data.fileInputKey++;
    // data.fileInputKey = Date.now();
    data.image = null;
};

//once the component is loaded we clear the validation errors
onMounted(() => authStore.clearValidationErrors())

</script>

<style>

</style>