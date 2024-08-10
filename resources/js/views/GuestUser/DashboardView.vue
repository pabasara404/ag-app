<template>
    <PageHeader title="Welcome to Divisional Secretariat - Katana" />
    <n-grid x-gap="12" :cols="3" class="white-background">
        <n-gi>
            <router-link :to="{ name: 'timberCutting' }" class="light-green p-2 hover-card h-32 flex items-center justify-center">
                <n-h5>Timber Cutting Process Management</n-h5>
            </router-link>
        </n-gi>
        <n-gi>
            <router-link :to="{ name: 'timberTransportation' }" class="green p-2 hover-card h-32 flex items-center justify-center">
                <n-h5>Timber Transportation Process and Permits</n-h5>
            </router-link>
        </n-gi>
        <n-gi>
            <router-link :to="{ name: 'individualView' }" class="light-green p-2 hover-card h-32 flex items-center justify-center">
                <n-h5>Individual Business Registration</n-h5>
            </router-link>
        </n-gi>
    </n-grid>
    <n-grid x-gap="12" :cols="3" class="white-background">
        <n-gi>
            <router-link :to="{ name: 'firmView' }" class="light-green p-2 hover-card h-32 flex items-center justify-center">
                <n-h5>Firm Registration</n-h5>
            </router-link>
        </n-gi>
        <n-gi>
            <router-link :to="{ name: 'requestingAndIssuingIncomeCertificates' }" class="green p-2 hover-card h-32 flex items-center justify-center">
                <n-h5>Requesting & Issuing Income Certificates</n-h5>
            </router-link>
        </n-gi>
        <n-gi>
            <router-link :to="{ name: 'presidentFund' }" class="light-green p-2 hover-card h-32 flex items-center justify-center">
                <n-h5>President Fund Information Verification</n-h5>
            </router-link>
        </n-gi>
        <n-gi class="py-4">
            <router-link :to="{ name: 'mahapola' }" class="light-green p-2 hover-card h-32 flex items-center justify-center">
                <n-h5>Mahapola Application Processing</n-h5>
            </router-link>
        </n-gi>
    </n-grid>
</template>

<script setup>
import { ref } from "vue";
import PageHeader from "@/components/PageHeader.vue";
</script>

<style scoped>
.white-background {
    background-color: white;
    padding: 10px;
    border-radius: 10px;
}

.light-green {
    height: 90px;
    border: 2px solid #e5e7eb;
    border-radius: 10px;
}

.green {
    height: 90px;
    border: 2px solid #e5e7eb;
    border-radius: 10px;
}

.hover-card {
    transition: box-shadow 0.3s ease-in-out;
}

.hover-card:hover {
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
}
</style>
