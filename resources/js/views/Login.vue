<script setup>
import { useRouter } from "vue-router";
import { ref } from "vue";
import { useForm, useField } from "vee-validate";
import * as yup from "yup";
import { login } from "@/services/auth.js";

// Validation schema
const schema = yup.object({
    email: yup.string().email("Enter a valid email address!").required("Email is required!"),
    password: yup.string().min(2, "Password must be at least 2 characters!").required("Password is required!"),
});

// Setup form and fields with vee-validate
const { handleSubmit, errors } = useForm({
    validationSchema: schema,
});

const { value: email } = useField("email");
const { value: password } = useField("password");

const router = useRouter();
const errorMessage = ref("");

const handleLogin = handleSubmit(async (values) => {
    try {
        await login(values);
        await router.push("/home");
    } catch (e) {
        if (e && e.response && e.response.data) {
            if (e.response.data.errors) {
                errorMessage.value = Object.values(e.response.data.errors).flat().join(", ");
            } else if (e.response.data.message === "Email & Password does not exist.") {
                errorMessage.value = "Email & Password does not exist.";
            } else {
                errorMessage.value = e.response.data.message || "An error occurred. Please try again.";
            }
        } else {
            errorMessage.value = "An unexpected error occurred.";
        }
    }
});
</script>

<template>
    <div class="bg-gradient-to-br from-yellow-400 to-white h-screen flex justify-center items-center">
        <n-card class="max-w-sm rounded-lg bg-opacity-75 backdrop-blur-md border border-white">
            <n-h2 class="text-center">Login</n-h2>
            <form @submit.prevent="handleLogin">
                <n-form-item path="email" label="Email :">
                    <n-input v-model:value="email" placeholder="Enter your email" />
                </n-form-item>
                <n-form-item path="password" label="Password :">
                    <n-input v-model:value="password" placeholder="Enter your password" show-password-on="click" type="password" />
                </n-form-item>
                <ul class="list-none text-red-400" v-if="Object.keys(errors).length > 0">
                    <li v-for="(error, index) in Object.values(errors)" :key="index">{{ error }}</li>
                </ul>
                <p class="font-medium list-none text-red-400" v-if="errorMessage">{{ errorMessage }}</p>

                <n-row>
                    <n-col :span="24">
                        <div class="flex justify-end">
                            <button type="submit" class="custom-button">
                                Login
                            </button>
                        </div>
                        <h6 class="text-xs">
                            Don't have an account?
                            <router-link class="text-blue-500" to="/register">Sign Up</router-link>
                        </h6>
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
