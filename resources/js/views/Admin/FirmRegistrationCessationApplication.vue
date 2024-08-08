<template>
    <PageHeader title="Submit a Notice of Cessation of Business" />
    <div class="flex justify-center w-full">
        <div class="w-2/5 flex">
            <n-input
                v-model:value="searchTerm"
                size="medium"
                placeholder="Search Application Reference Number"
                class="mr-2"
            />
            <n-button @click="handleSearch" strong secondary circle type="success">
                <template #icon>
                    <n-icon><search-icon/></n-icon>
                </template>
            </n-button>
        </div>
    </div>
</template>

<script setup>
import {
    Search as SearchIcon,
} from "@vicons/ionicons5";
import { ref } from 'vue';
import Http from "@/services/http.js";
import PageHeader from "@/components/PageHeader.vue";

const searchTerm = ref('');
const options = ref([]);

const searchApplication = async (value) => {
    console.log('searchApplication called with value:', value);
    if (!value) {
        options.value = [];
        return;
    }

    try {
        const [firmsResponse, individualBusinessesResponse] = await Promise.all([
            Http.get('firmApplication/searchByReferenceNo', { params: { application_code: value } }),
            Http.get('individualBusiness/searchByReferenceNo', { params: { application_code: value } })
        ]);

        const firms = Array.isArray(firmsResponse.data) ? firmsResponse.data : [];
        const individualBusinesses = Array.isArray(individualBusinessesResponse.data) ? individualBusinessesResponse.data : [];

        options.value = [
            ...firms.map(item => ({ label: item.application_code, value: item.id })),
            ...individualBusinesses.map(item => ({ label: item.application_code, value: item.id }))
        ];
    } catch (error) {
        console.error('Error fetching application data:', error);
        // alert('Error fetching application data. Please try again.');
    }
};

const handleSearch = () => {
    console.log('Search button clicked');
    searchApplication(searchTerm.value); // Call searchApplication when button is clicked
};
</script>

<style scoped>
</style>
