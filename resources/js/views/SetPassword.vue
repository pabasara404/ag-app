<template>
    <div class="bg-gradient-to-br from-yellow-400 to-white h-screen flex justify-center items-center">
        <n-card class="max-w-sm rounded-lg bg-opacity-75 backdrop-blur-md border border-white">
            <n-h2 class="text-center">Reset Your Password</n-h2>
            <form @submit.prevent="submitReset">
                <input type="hidden" v-model="token" />
                <n-form-item path="email" label="Email :">
                    <n-input v-model:value="email" placeholder="Enter your email" />
                </n-form-item>
                <n-form-item path="password" label="New Password :">
                    <n-input v-model:value="password" placeholder="Enter your new password" show-password-on="click" type="password" />
                </n-form-item>
                <n-form-item path="password_confirmation" label="Confirm Password :">
                    <n-input v-model:value="passwordConfirmation" placeholder="Confirm your new password" show-password-on="click" type="password" />
                </n-form-item>
                <ul class="list-none text-red-400" v-if="Object.keys(errors).length > 0">
                    <li v-for="(error, index) in Object.values(errors)" :key="index">{{ error }}</li>
                </ul>
                <p class="font-medium list-none text-red-400" v-if="errorMessage">{{ errorMessage }}</p>

                <n-row>
                    <n-col :span="24">
                        <div class="flex justify-end">
                            <button type="submit" class="custom-button">
                                Reset Password
                            </button>
                        </div>
                    </n-col>
                </n-row>
            </form>
        </n-card>
    </div>
</template>

<style scoped>
.custom-button {
    font-weight: 400; /* font-normal */
    font-size: 14px;
    border-radius: 9999px; /* round */
    background-color: #fad339; /* bg-warning (yellow-500) */
    color: white;
    padding: 0.5rem 1rem;
    border: none;
    cursor: pointer;
    transition: background-color 0.2s, font-weight 0.2s;
}

.custom-button:hover {
    font-weight: 700; /* hover:font-bold */
    background-color: #facd18; /* darker shade of yellow (hover effect) */
}
</style>

<script setup>
import { ref } from 'vue';
import { useRouter, useRoute } from 'vue-router';
import axios from 'axios';

const route = useRoute();
const router = useRouter();

const token = ref(route.params.token || '');
const email = ref('');
const password = ref('');
const passwordConfirmation = ref('');
const errors = ref({});
const errorMessage = ref('');

const submitReset = async () => {
    try {
        await axios.post('/password/reset', {
            token: token.value,
            email: email.value,
            password: password.value,
            password_confirmation: passwordConfirmation.value,
        });
        router.push('/login'); // Redirect to login page after successful reset
    } catch (error) {
        console.error(error);
        // Handle error (e.g., show an error message)
        errorMessage.value = 'Failed to reset password. Please try again.';
    }
};
</script>
