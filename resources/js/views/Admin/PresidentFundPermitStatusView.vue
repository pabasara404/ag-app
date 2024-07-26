<template>
    <PageHeader title="President Fund Request Status" />
    <n-card title="What is Status means?" content-style="padding: 0;">
        <n-tabs
            type="line"
            size="large"
            :tabs-padding="20"
            pane-style="padding: 20px;"
        >
            <n-tab-pane name="Submitted">
                The application has been successfully submitted and is under initial review.
            </n-tab-pane>
            <n-tab-pane name="Pending">
                The application is incomplete due to missing files and requires resubmission with the necessary documents.
            </n-tab-pane>
            <n-tab-pane name="Resubmitted">
                The application has been resubmitted with the previously missing documents and is awaiting further review.
            </n-tab-pane>
            <n-tab-pane name="Escalated">
                The application has been escalated for higher-level review due to special circumstances or complications.
            </n-tab-pane>
            <n-tab-pane name="Approved">
                The application has been reviewed and approved, meeting all the necessary criteria.
            </n-tab-pane>
            <n-tab-pane name="Rejected">
                The application has been reviewed and rejected, failing to meet the required standards or criteria.
            </n-tab-pane>
            <n-tab-pane name="Awaiting Payment">
                The application has been approved and is pending the completion of the payment process.
            </n-tab-pane>
            <n-tab-pane name="Issued">
                The application has been fully processed, and the requested documents or items have been issued.
            </n-tab-pane>
        </n-tabs>
    </n-card>
    <br/>
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
        @close="isShowingEditApplicationModal = $event"
        @save="fetchApplication"
        :initial-status="initialStatus"
    />
</template>

<script setup>
import PageHeader from "@/components/PageHeader.vue";
import { h, onMounted, ref } from "vue";
import { NButton } from "naive-ui";
import Http from "@/services/http.js";
import EditApplicationModal from "@/components/ExciseLicenseModal.vue";

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
        title: "Name of the business",
        key: "business_name",
    },
    {
        title: "Status",
        key: "status",
    },
    {
        title: "Issued date",
        key: "issued_date",
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
            return row.status === "Expired" ? h(
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
                { default: () => "Renew Permit" }
            ) : null;
        }
    }
];

onMounted(() => {
    fetchApplication();
});

async function fetchApplication() {
    isLoading.value = true;
    const {data} = await Http.get("exciseApplication");
    isLoading.value = false;
    applications.value = data.data;
}
</script>

<style scoped>
</style>
