<script setup>
    import {useRouter} from "vue-router";
    import {reactive, ref} from "vue";
    import http from "@/services/http.js";
    import {login} from "@/services/auth.js";

    const errors = ref()
    const router = useRouter();
    const form = reactive({
        email: '',
        password: '',
    })
    const handleLogin = async () => {
        try {
            await login(form);
            await router.push('/home');
        } catch (e) {
            if(e && e.response.data && e.response.data.errors) {
                errors.value = Object.values(e.response.data.errors)
            } else {
                errors.value = e.response.data.message || ""
            }
        }
    }
</script>
<template>
    <div class="bg-gradient-to-br from-yellow-400 to-white h-screen flex justify-center items-center">
        <n-card class="max-w-sm rounded-lg bg-opacity-75 backdrop-blur-md border border-white">
            <n-h2 class="text-center">Login</n-h2>
            <n-form class="font-medium" ref="formRef" >
                <n-form-item path="email" class="font-medium" label="Email :">
                    <n-input v-model:value="form.email" placeholder="Enter your email" required @keydown.enter.prevent />
                </n-form-item>
                <n-form-item path="password" class="font-medium" label="Password :">
                    <n-input v-model:value="form.password" placeholder="Enter your password" show-password-on="click" required type="password" />
                </n-form-item>
                <ul class="list-none text-red-400" v-for="(value, index) in errors" :key="index" v-if="typeof errors === 'object'">
                    <li>{{value[0]}}</li>
                </ul>
                <p class="font-medium list-none text-red-400" v-if="typeof errors === 'string'">{{errors}}</p>

                <n-row>
                    <n-col :span="24">
                        <div class="flex justify-end">
                            <n-button  class="font-normal hover:font-bold" round secondary type="warning"  @click="handleLogin">
                                Login
                            </n-button>
                        </div>

                        <h6 class="text-xs"
                        >Don't have an account?
                            <router-link class="text-blue-500" to="/register"
                            >Sign Up</router-link
                            ></h6
                        >
                    </n-col>
                </n-row>
            </n-form>
        </n-card>
    </div>
</template>


<style scoped>

</style>
