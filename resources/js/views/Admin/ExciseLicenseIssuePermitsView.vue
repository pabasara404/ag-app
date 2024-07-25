<template>
    <PageHeader title="Issue Excise License" />
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
import EditApplicationModal from "@/components/BusinessIndividualApplicationModal.vue";
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
        title: "Name of the business",
        key: "business_name",
    },
    {
        title: "Nature of the Business",
        key: "nature",
    },
    {
        title: "Initial Capital",
        key: "initial_capital",
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
                    // renderIcon: EyeIcon,
                    size: "small",
                    onClick: () => {
                        selectedApplication.value = row;
                        isShowingEditApplicationModal.value = true;
                        initialStatus.value = row.status;
                    },
                },
                { default: () => "Review" }
            );
        }
        }
        ,
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
    const { data } = await Http.get("individualBusinessByStatus", {
        params: {
            status: 'Escalated'
        }
    });
    isLoading.value = false;
    applications.value = data.data;
}
async function deleteApplication(application) {
    isLoading.value = true;
    await Http.delete(`individualBusiness/${application.id}`);
    isLoading.value = false;
}
</script>

<style scoped>

</style>
