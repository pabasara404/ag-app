<template>
    <n-layout style="height: 540px" has-sider>
        <n-layout style="padding-left: 8px" :inverted="inverted">
            <PageHeader title="Application Review Management" />
            <n-space vertical>
                <n-data-table
                    :loading="isLoading"
                    :columns="columns"
                    :data="applications"
                    :bordered="false"
                />
            </n-space>
        </n-layout>
        <edit-application-modal
            :application="selectedApplication"
            :is-showing="isShowingEditApplicationModal"
            @close="handleModalClose"
            :initial-status="initialStatus"
        />
    </n-layout>
</template>

<script setup>
import { h, onMounted, ref } from "vue";
import Http from "@/services/http";
import { NButton, NIcon } from "naive-ui";
import EditApplicationModal from "@/components/BusinessFirmApplicationModal.vue";
import PageHeader from "@/components/PageHeader.vue";
const isShowingEditApplicationModal = ref(false);
const selectedApplication = ref(false);
const applications = ref([]);
const inverted = ref(false);
const isLoading = ref(false);
const initialStatus = ref(null);

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
                    size: "small",
                    onClick: () => {
                        selectedApplication.value = row;
                        isShowingEditApplicationModal.value = true;
                        initialStatus.value = row.status;
                    },
                },
                {default: () => "Review"}
            );
        },
        // },
        // {
        //     title: "",
        //     key: "actions",
        //     render(row) {
        //         return h(
        //             NButton,
        //             {
        //                 round: true,
        //                 type: "info",
        //                 strong: true,
        //                 secondary: true,
        //                 size: "small",
        //                 onClick: async () => {
        //                     await deleteApplication(row);
        //                     await fetchApplication();
        //                 },
        //             },
        //             { default: () => "Reject" }
        //         );
        //     },
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
    const { data } = await Http.get("firmByStatus", {
        params: {
            status: 'Submitted,Resubmitted'
        }
    });
    isLoading.value = false;
    applications.value = data.data;
}

async function deleteApplication(application) {
    isLoading.value = true;
    await Http.delete(`firmApplication/${application.id}`);
    isLoading.value = false;
}
</script>
