<template>
    <PageHeader title="Mahapola Fund Request Review" />
    <n-space vertical>
        <n-data-table
            :loading="isLoading"
            :columns="columns"
            :data="applications"
            :bordered="false"
        />
    </n-space>
    <edit-application-modal
        :application="selectedApplication"
        :is-showing="isShowingEditApplicationModal"
        @close="handleModalClose"
        :initial-status="initialStatus"
    />
</template>

<script setup>
import PageHeader from "@/components/PageHeader.vue";
import { h, onMounted, ref } from "vue";
import { NButton } from "naive-ui";
import Http from "@/services/http.js";
import EditApplicationModal from "@/components/MahapolaModal.vue";

const isLoading = ref(false);
const applications = ref([]);
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
        title: "Status",
        key: "status",
    },
    {
        title: "Updated date",
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
    }
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
    const { data } = await Http.get("mahapolaByStatus", {
        params: {
            statuses: 'Submitted,Resubmitted'
        }
    });
    isLoading.value = false;
    applications.value = data.data;
}
</script>

<style scoped>
</style>
