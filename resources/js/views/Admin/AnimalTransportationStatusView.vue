<template>
    <PageHeader title="Animal Transportation Permit Status Management" />
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
                The application has been approved and is pending the completion of the payment process. You can click "Download" button to do the payment and download the Permit/Certification.
            </n-tab-pane>
            <n-tab-pane name="Issued">
                The application has been fully processed, and the requested documents or items have been issued.
            </n-tab-pane>
            <n-tab-pane name="Ceased">
                This business have submitted a notice of cessation of business.
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
        @close="handleEditApplicationModalClose"
        :initial-status="initialStatus"
    />
    <edit-payment-modal
        :is-showing="isShowingEditPaymentModal"
        @close="handleEditPaymentModalClose"
        :application-code= "applicationCode"
        :user-name="userName"
        :payment-type="paymentType"
    />
</template>

<script setup>
import PageHeader from "@/components/PageHeader.vue";
import { h, onMounted, ref } from "vue";
import { NButton, useMessage } from "naive-ui";
import Http from "@/services/http.js";
import EditApplicationModal from "@/components/AnimalTranportationModal.vue";

import EditPaymentModal from "@/components/EditPaymentModal.vue";
import { generateApplicationPDF } from '@/utils/pdfUtils';
const message = useMessage();

const isLoading = ref(false);
const applications = ref([]);
const selectedApplication = ref(null);
const initialStatus = ref(null);
const applicationCode = ref(null);
const userName = ref(null);
const paymentType = ref(null);
const isShowingEditApplicationModal = ref(false);
const isShowingEditPaymentModal = ref(false);

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
            return row.status === "Pending" ? h(
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
                { default: () => "Edit Application" }
            ) : null;
        }
    },{
        title: "",
        key: "actions",
        render(row) {
            return row.status === "Awaiting Payment" ? h(
                NButton,
                {
                    round: true,
                    type: "info",
                    strong: true,
                    secondary: true,
                    size: "small",
                    onClick: () => {
                        selectedApplication.value = row;
                        isShowingEditPaymentModal.value = true;
                        applicationCode.value = row.application_code;
                        userName.value = row.user.name;
                        paymentType.value = "animal_transportations";
                    },
                },
                { default: () => "Download" }
            ) : null;
        }
    },
    {
        title: "",
        key: "actions",
        render(row) {
            return row.status === "Issued"|| row.status === "Ceased"? h(
                NButton,
                {
                    round: true,
                    type: "info",
                    strong: true,
                    secondary: true,
                    size: "small",
                    onClick: () => handleDownloadClick(row)
                },
                { default: () => "Download PDF" }
            ) : null;
        }
    }
];

async function downloadPDF(application) {
    try {
        const pdf = await generateApplicationPDF(application);
        pdf.save(`Application_${application.application_code}.pdf`);
        message.success('PDF will downloaded shortly');
    } catch (error) {
        console.error(error);
        message.error('Error downloading PDF');
    }
}

function handleDownloadClick(row) {
    downloadPDF(row);
}
function handleEditPaymentModalClose(){
    isShowingEditPaymentModal.value = false;
    fetchApplication();
}

function handleEditApplicationModalClose(){
    isShowingEditApplicationModal.value = false;
    fetchApplication();
}
onMounted(() => {
    fetchApplication();
});

async function fetchApplication() {
    isLoading.value = true;
    try {
    const {data} = await Http.get("animalTransportation");
    // const {data} = await Http.get("userAnimalTransportation");
    isLoading.value = false;

    // Add total_animal_count to each application
    applications.value = data.data.map(application => ({
        ...application,
        total_animal_count: application.animals.length
    })); } catch (error) {
        console.error("Failed to fetch applications", error);
    } finally {
        isLoading.value = false;
    }
}
</script>

<style scoped>
</style>
