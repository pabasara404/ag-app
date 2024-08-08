<template>
    <n-layout style="height: 540px" has-sider>
        <n-layout style="padding-left: 8px" :inverted="inverted">
            <PageHeader title="Application Details Management" />
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
import EditApplicationModal from "@/components/TimberTransportingPermitApplicationModal.vue";
import PageHeader from "@/components/PageHeader.vue";
const isShowingEditApplicationModal = ref(false);
const selectedApplication = ref(false);
const inverted = ref(false);
const isLoading = ref(false);
const initialStatus = ref(null);
const applications = ref([]);
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
    const { data } = await Http.get("timberTransportingPermitApplicationByStatus", {
        params: {
            status: 'Submitted,Resubmitted'
        }
    });
    isLoading.value = false;
    applications.value = data.data;
}

</script>
