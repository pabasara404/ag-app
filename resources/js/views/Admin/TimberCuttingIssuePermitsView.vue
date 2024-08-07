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
        @close="handleModalClose"
        :initial-status="initialStatus"
    />
</template>

<script setup>
import PageHeader from "@/components/PageHeader.vue";
import {h, onMounted, ref} from "vue";
import {NButton} from "naive-ui";
import EditApplicationModal from "@/components/TimberCuttingPermitApplicationModal.vue";
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
    },
    {
        title: "Name of Applicant",
        key: "name",
    },
    {
        title: "Tree count",
        key: "tree_count",
    },
    {
        title: "Address",
        key: "address",
    },
    {
        title: "Comment",
        key: "comment",
    },
    {
        title: "Submitted date",
        key: "submission_timestamp",
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
    const { data } = await Http.get("timberCuttingPermitApplicationByStatus", {
        params: {
            status: 'Escalated'
        }
    });
    isLoading.value = false;
    applications.value = data.data;
}
async function deleteApplication(application) {
    isLoading.value = true;
    await Http.delete(`timberCuttingPermitApplication/${application.id}`);
    isLoading.value = false;
}
</script>

<style scoped>

</style>
