<template>
    <div class="col-md-8">
        <div class="card shadow-sm">
            <div class="card-header bg-white">
                <h5 class="text-center my-2">
                  {{ updatingProfileTitle ? 'User Details' : 'Billing Details' }}
                </h5>
            </div>
            <div class="card-body">
         <form class="mt-5" @submit.prevent="updateUserInfos">
                    <div class="mb-3">
                        <label for="phone_number" class="form-label">Phone Number*</label>
                        <input
                            type="text"
                            class="form-control"
                            v-model="data.userCurrentInfo.phone_number"
                            name="phone_number"
                            id="phone_number"
                            :required="true"
                            aria-describedby="helpId"
                            placeholder="Phone Number*"
                        />
                    </div>
                    <div class="mb-3">
                        <label for="address" class="form-label">Address*</label>
                        <input
                            type="text"
                            class="form-control"
                            v-model="data.userCurrentInfo.address"
                            name="address"
                            id="address"
                            :required="true"
                            aria-describedby="helpId"
                            placeholder="Address*"
                        />
                    </div>
                    <div class="mb-3">
                        <label for="zip_code" class="form-label">Zip Code*</label>
                        <input
                            type="text"
                            class="form-control"
                            v-model="data.userCurrentInfo.zip_code"
                            name="zip_code"
                            id="zip_code"
                            :required="true"
                            aria-describedby="helpId"
                            placeholder="Zip Code*"
                        />
                    </div>
                    <div class="mb-3">
                        <label for="city" class="form-label">City*</label>
                        <input
                            type="text"
                            class="form-control"
                            v-model="data.userCurrentInfo.city"
                            name="city"
                            id="city"
                            :required="true"
                            aria-describedby="helpId"
                            placeholder="City*"
                        />
                    </div>
                    <div class="mb-3">
                        <label for="country" class="form-label">Country*</label>
                        <input
                            type="text"
                            class="form-control"
                            v-model="data.userCurrentInfo.country"
                            name="country"
                            id="country"
                            :required="true"
                            aria-describedby="helpId"
                            placeholder="Country*"
                        />
                    </div>
                    <div class="mb-3">
                        <button
                            v-if="!authStore.user?.profile_completed || updatingProfileTitle"                            type="submit"
                            class="btn btn-sm btn-dark rounded-0"
                        >
                            Submit
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</template>

<script setup>
import axios from "axios";
import { API_BASE_URL } from "@/helpers/config";
import { headersConfig } from "@/helpers/config";
import { useAuthStore } from "@/stores/useAuthStore";
import { onMounted, reactive } from "vue";
import { useToast } from "vue-toastification";

// define data
const data = reactive({
  userCurrentInfo: {
    phone_number: "",
    country: "",
    zip_code: "",
    city: "",
    address: "",
  },
});

const props = defineProps({
  updatingProfileTitle: {
    type: Boolean,
    default: false,
    required: false,
  },
});

// define toast
const toast = useToast();

// define the store
const authStore = useAuthStore();

// function to update user infos function
const updateUserInfos = async () => {
  authStore.isLoading = true;
  const userData = {
    phone_number: data.userCurrentInfo.phone_number,
    country: data.userCurrentInfo.country,
    zip_code: data.userCurrentInfo.zip_code,
    city: data.userCurrentInfo.city,
    country: data.userCurrentInfo.country,
    address: data.userCurrentInfo.address,
  };
  try {
    const response = await axios.put(
      `${API_BASE_URL}/user/update/profile`,
      userData,
      headersConfig(authStore.access_token)
    );
    authStore.user = response.data.user;
    authStore.isLoading = false;
    toast.success(response.data.message, {
      position: "top-right",
      timeout: 2000,
    });
  } catch (error) {
    authStore.isLoading = false;
    if (error?.response?.status === 422) {
      authStore.setValidationErrors(error.response.data.errors);
    }
    console.log(error);
  }
};

// fill the form with the user inforamation
onMounted(() => (data.userCurrentInfo = authStore.user));
</script>

<style>
</style>