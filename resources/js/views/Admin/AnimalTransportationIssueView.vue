<template>
    <PageHeader title="Issue Animal Transportation Applications" />
    <n-data-table
        :loading="isLoading"
        :columns="columns"
        :data="applications"
        :bordered="false"
    />
    <edit-application-modal
        :application="selectedApplication"
        :is-showing="isShowingEditApplicationModal"
        @close="handleModalClose"
        :initial-status="initialStatus"
    />
</template>

<script setup>
import PageHeader from "@/components/PageHeader.vue";
import {h, onMounted, ref} from "vue";
import {NButton} from "naive-ui";
import EditApplicationModal from "@/components/AnimalTranportationModal.vue";
import Http from "@/services/http.js";

const applications = ref([]);
const isLoading = ref(false);
const selectedApplication = ref(null);
const initialStatus = ref(null);
const isShowingEditApplicationModal = ref(false);


const columns = [
    {
        title: "Reference No.",
        key: "application_code",
    },
    {
        title: "Name of the Applicant",
        key: "name",
    },
    {
        title: "Total Animals",
        key: "total_animal_count",
    },
    {
        title: "Reason",
        key: "reason_to_transport",
    },
    {
        title: "Status",
        key: "status",
    },
    {
        title: "Submitted Date",
        key: "submission_timestamp",
    },
    {
        title: "Issued Date",
        key: "issued_date",
    },
    {
        title: "Last updated Date",
        key: "updated_at",
    },
    {
        title: "Expire Date",
        key: "expire_date",
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


function handleModalClose(){
    isShowingEditApplicationModal.value = false;
    fetchApplication();
}


onMounted(() => {
    fetchApplication();
});

async function fetchApplication() {
    isLoading.value = true;
    const { data } = await Http.get("animalTransportationByStatus", {
        params: {
            statuses: 'Escalated'
        }
    });
    isLoading.value = false;
    applications.value = data.data;
}
async function deleteApplication(application) {
    isLoading.value = true;
    await Http.delete(`animalTransportation/${application.id}`);
    isLoading.value = false;
}
</script>

<style scoped>

</style>
