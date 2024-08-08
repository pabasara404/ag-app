<template>
    <n-layout class="h-[540px]" has-sider>
        <n-layout class="pl-2" :inverted="inverted">
            <div class="w-full">
                <PageHeader title="Search an Application" />
            </div>
            <div class="flex justify-center w-full mt-4">
                <div class="w-2/5 flex">
                    <n-input
                        v-model:value="searchTerm"
                        size="medium"
                        placeholder="Search Application Reference Number"
                        class="mr-2"
                    />
                    <n-button @click="handleSearch" strong secondary circle type="success">
                        <template #icon>
                            <n-icon><SearchIcon/></n-icon>
                        </template>
                    </n-button>
                </div>
            </div>
            <div class="flex mt-4">
                <div class="w-1/2 pr-2">
                    <n-data-table
                        :loading="isLoading"
                        :columns="columns"
                        :data="applications"
                        :bordered="true"
                    />
                </div>
                <div class="w-1/2 pl-2 mr-2">
                    <n-card
                        v-if="selectedApplication"
                        class="w-full"
                        size="huge"
                        role="dialog"
                        aria-modal="true"
                        placeholder="Your Application will be displayed here"
                    >
                        <div v-if="selectedApplicationTitle" class="text-center mb-4">
                            <h2 class="font-bold text-2xl">{{ selectedApplicationTitle }}</h2>
                        </div>
                        <div v-html="formatData(selectedApplication)"></div>
                    </n-card>
                </div>
            </div>
        </n-layout>
    </n-layout>
</template>

<script setup>
import { h, ref, computed } from 'vue';
import { Search as SearchIcon } from '@vicons/ionicons5';
import Http from '@/services/http';
import {NButton, NIcon, useMessage} from 'naive-ui';
import PageHeader from '@/components/PageHeader.vue';

const selectedApplication = ref({});
const selectedApplicationTitle = ref('');
const inverted = ref(false);
const isLoading = ref(false);
const searchTerm = ref('');
const applications = ref([]);
const message = useMessage();

const permitTypeOptions = [
    { label: "Timber Cutting Permit", key: "TCP", route: "timberCuttingPermitApplication", table: "timber_cutting_permit_applications" },
    { label: "Timber Transporting Permit", key: "TTP", route: "timberTransportingPermitApplication", table: "timber_transporting_applications" },
    { label: "Individual Business Registration Certificate", key: "IBR", route: "individualBusiness", table: "individual_businesses" },
    { label: "Firm Registration Certificate", key: "FR", route: "firmApplication", table: "firms" },
    { label: "Income Certificate", key: "IC", route: "incomeCertificate", table: "income_certificates" },
    { label: "Animal Transportation Permit", key: "ATP", route: "animalTransportation", table: "animal_transportations" },
    { label: "President Fund Certificate", key: "PFP", route: "presidentFundApplication", table: "president_funds" },
    { label: "Mahapola Certificate", key: "MP", route: "mahapolaApplication", table: "mahapolas" },
    { label: "Excise License Permit", key: "EL", route: "exciseApplication", table: "excises" },
    { label: "Valuation Report", key: "VC", route: "valuation", table: "valuations" }
];

const columns = [
    {
        title: "Reference No",
        key: "application_code",
    },
    {
        title: "Status",
        key: "status",
    },
    {
        title: "Submitted date",
        key: "submission_timestamp",
    },
    {
        title: "Last updated date",
        key: "updated_at",
    }
];

function getTypeFromCode(code) {
    const parts = code.split('/');
    if (parts.length < 3) {
        message.error('Invalid application code format!');
        return null;
    }
    return parts[2]; // Return the type code directly
}

function updateApplicationTitle(type) {
    const option = permitTypeOptions.find(o => o.table === type);
    selectedApplicationTitle.value = option ? option.label : 'Unknown Type';
}

async function handleSearch() {
    const typeCode = getTypeFromCode(searchTerm.value);
    const option = permitTypeOptions.find(o => o.key === typeCode);

    if (option) {
        isLoading.value = true;
        try {
            const { data } = await Http.get('/search-applications', {
                params: {
                    table_name: option.table,
                    application_code: searchTerm.value
                }
            });
            console.log('API Response:', data);

            if (data && data.data) {
                applications.value = [data.data];
                selectedApplication.value = data.data; // Set the selected application for display
                updateApplicationTitle(option.table); // Update the title based on the type
            } else {
                applications.value = [];
                selectedApplication.value = {};
                selectedApplicationTitle.value = ''; // Clear the title
            }
        } catch (error) {
            console.error('Error fetching applications:', error);
            applications.value = [];
            selectedApplication.value = {};
            selectedApplicationTitle.value = ''; // Clear the title
        } finally {
            isLoading.value = false;
        }
    } else {
        console.error('Unknown application type');
        applications.value = [];
        selectedApplication.value = {};
        selectedApplicationTitle.value = ''; // Clear the title
    }
}

function formatLabel(key) {
    return `<strong>${key.replace(/_/g, ' ').replace(/\b\w/g, char => char.toUpperCase())}</strong>`;
}

function formatObject(obj) {
    if (Array.isArray(obj)) {
        return obj.map(item => formatObject(item)).join('<br>');
    } else if (typeof obj === 'object' && obj !== null) {
        let formatted = '';
        Object.keys(obj).forEach(key => {
            if (!key.toLowerCase().includes('id') && key.toLowerCase() !== 'created_at' && obj[key] !== null) { // Exclude id fields, created_at columns, and null values
                formatted += `${formatLabel(key)}:${formatObject(obj[key])}<br><br>`;
            }
        });
        return formatted;
    } else {
        return obj || 'N/A';
    }
}

function formatData(data) {
    let formattedData = '';
    Object.keys(data).forEach(key => {
        if (!key.toLowerCase().includes('id') && key.toLowerCase() !== 'created_at' && data[key] !== null) { // Exclude id fields, created_at columns, and null values
            formattedData += `${formatLabel(key)}:${formatObject(data[key])}<br><br>`;
        }
    });
    return formattedData;
}
</script>
