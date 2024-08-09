<template>
    <n-layout style="height: 540px" has-sider>
        <n-layout style="padding-left: 8px" :inverted="inverted">
            <PageHeader title="Application Review Management" />
            <div class="flex justify-end pb-6">
                <n-space>
                    <n-dropdown :options="options" placement="bottom-start">
                        <n-button :bordered="false" style="padding: 0 4px"> ··· </n-button>
                    </n-dropdown>
                </n-space>
            </div>

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
import {
    PencilSharp as PencilIcon,
    Add as AddIcon,
    TrashBin as TrashBinIcon,
    Eye as EyeIcon,
} from "@vicons/ionicons5";
import Http from "@/services/http";
import { NButton, NIcon } from "naive-ui";
import EditApplicationModal from "@/components/IncomeAssessmentFormModal.vue";
import PageHeader from "@/components/PageHeader.vue";
const isShowingEditApplicationModal = ref(false);
const selectedApplication = ref(false);
const applications = ref([]);
const inverted = ref(false);
const isLoading = ref(false);
const initialStatus = ref(null);

const options = [
    {
        label: "Sort By Recently Added",
        key: "1",
    },
    {
        label: "Sort By Oldest Added",
        key: "2",
    },
];

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
        title: "Total Annual Income",
        key: "total_annual_income",
    },
    {
        title: "Reason",
        key: "purpose",
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
    const { data } = await Http.get("incomeCertificateByStatus", {
        params: {
            status: 'Submitted,Resubmitted,Need to Reviewed By Samurdhi Officer,Need to Reviewed By GN Officer'
        }
    });
    isLoading.value = false;
    applications.value = data.data;
}

async function deleteApplication(application) {
    isLoading.value = true;
    await Http.delete(`incomeCertificate/${application.id}`);
    isLoading.value = false;
}
</script>
