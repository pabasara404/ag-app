<template>
    <n-layout style="height: 540px" has-sider>
        <n-layout style="padding-left: 8px" :inverted="inverted">
            <PageHeader title="Timber Cutting Application Management" />
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
import EditApplicationModal from "@/components/TimberCuttingPermitApplicationModal.vue";
import PageHeader from "@/components/PageHeader.vue";
const isShowingEditApplicationModal = ref(false);
const selectedApplication = ref(false);
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
const applications = ref([]);
const columns = [
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
        title: "Status",
        key: "status",
    },
    // {
    //   title: "Role",
    //   key: "role",
    // },
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
        },
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
    const { data } = await Http.get("timberCuttingPermitApplicationByStatus", {
        params: {
            status: 'Submitted,Resubmitted'
        }
    });
    isLoading.value = false;
    applications.value = data.data;
}


</script>
