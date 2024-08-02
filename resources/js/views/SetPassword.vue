<!-- src/views/PasswordReset.vue -->
<template>
    <div>
        <h1>Reset Your Password</h1>
        <form @submit.prevent="submitReset">
            <input type="hidden" v-model="token" />
            <div>
                <label for="email">Email:</label>
                <input type="email" v-model="email" required />
            </div>
            <div>
                <label for="password">New Password:</label>
                <input type="password" v-model="password" required />
            </div>
            <div>
                <label for="password_confirmation">Confirm Password:</label>
                <input type="password" v-model="passwordConfirmation" required />
            </div>
            <button type="submit">Reset Password</button>
        </form>
    </div>
</template>

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
    }
};
</script>
