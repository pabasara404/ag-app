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
import EditApplicationModal from "@/components/AnimalTranportationModal.vue";
import PageHeader from "@/components/PageHeader.vue";
const isShowingEditApplicationModal = ref(false);
const selectedApplication = ref(false);
const applications = ref([]);
const initialStatus = ref(null);
const inverted = ref(false);
const isLoading = ref(false);



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
        title: "issued Date",
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
                {default: () => "Review"}
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
    const { data } = await Http.get("animalTransportationByStatus", {
        params: {
            statuses: 'Submitted,Resubmitted'
        }
    });
    isLoading.value = false;

    // Add total_animal_count to each application
    applications.value = data.data.map(application => ({
        ...application,
        total_animal_count: application.animals.length
    }));
}

async function deleteApplication(application) {
    isLoading.value = true;
    await Http.delete(`animalTransportation/${application.id}`);
    isLoading.value = false;
}
</script>
