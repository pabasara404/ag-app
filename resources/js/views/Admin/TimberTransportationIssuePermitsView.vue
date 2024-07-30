<template>
    <PageHeader title="Issue Timber Cutting Applications" />
    <n-data-table
        :loading="isLoading"
        :columns="columns"
        :data="applications"
        :bordered="false"
    />
    <edit-application-modal
        :application="selectedApplication"
        :is-showing="isShowingEditApplicationModal"
        @close="isShowingEditApplicationModal = $event"
        @save="fetchApplication"
        :initial-status="initialStatus"
    />
</template>

<script setup>
import PageHeader from "@/components/PageHeader.vue";
import {h, onMounted, ref} from "vue";
import {NButton} from "naive-ui";
import EditApplicationModal from "@/components/TimberTransportingPermitApplicationModal.vue";
import Http from "@/services/http.js";

const applications = ref([]);
const isLoading = ref(false);
const selectedApplication = ref(null);
const initialStatus = ref(null);
const isShowingEditApplicationModal = ref(false);


const columns = [
    {
        title: "Reference Number",
        key: "application_code",
    },{
        title: "Name of Applicant",
        key: "name",
    },
    {
        title: "Total Pieces",
        key: "total_pieces",
    },
    {
        title: "Address",
        key: "address",
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
    },
    {
        title: "",
        key: "actions",
        render(row) {
            return h(
                NButton,
                {
                    round: true,
                    type: "info",
                    strong: true,
                    secondary: true,
                    size: "small",
                    onClick: () => {
                        selectedApplication.value = row;
                        isShowingEditApplicationModal.value = true;
                        initialStatus.value = row.status;
                    },
                },
                { default: () => "View Application" }
            );
        }
    },{
        title: "",
        key: "actions",
        render(row) {
            return h(
                NButton,
                {
                    round: true,
                    type: "info",
                    strong: true,
                    secondary: true,
                    size: "small",
                    onClick: async () => {
                        await deleteApplication(row);
                        await fetchApplication();
                    },
                },
                { default: () => "Delete" }
            );
        },
    },
];
onMounted(() => {
    fetchApplication();
});

async function fetchApplication() {
    isLoading.value = true;
    const { data } = await Http.get("timberTransportingPermitApplicationByStatus", {
        params: {
            status: 'Escalated'
        }
    });
    isLoading.value = false;
    applications.value = data.data; // Ensure the response is handled correctly
}
async function deleteApplication(application) {
    isLoading.value = true;
    await Http.delete(`timberTransportingPermitApplication/${application.id}`);
    isLoading.value = false;
}
</script>

<style scoped>

</style>
