<template>
    <n-layout class="pl-2">
        <PageHeader title="Upload a President Fund Request"/>
            <n-p>To president fund request please upload the scanned copy of the license with the details of the owner.</n-p>

            <div class="flex justify-center ... p-8">
                <n-button
                    @click="addNewApplication"
                    type="warning"
                    secondary
                    bordered
                >
                    Upload a President Fund Request
                </n-button>
            </div>
            <application-modal
                :application="selectedApplication"
                :is-showing="isShowingApplicationModal"
                @close="isShowingApplicationModal = $event"
            />
    </n-layout>
</template>

<script setup>
import PageHeader from "@/components/PageHeader.vue";
import { ref } from "vue";
import ApplicationModal from "@/components/PresidentFundModal.vue";

const selectedApplication = ref(false);
const isShowingApplicationModal = ref(false);


function addNewApplication() {
    selectedApplication.value = {
        id: "",
        name: "John Doe",
        address: "123 Main St, Colombo",
        nic: "123456789V",
        contact_number: "0712345678",
        gn_division: {
            id: "74",
            gn_code: "370",
            name: "Kotugoda",
            mpa_code: "204",
        },
        status: "Submitted",
        submission_timestamp: "2023-07-15 10:00:00",
        comment: "This is a test comment",
        application_code: "bsdgh454564",
    };

    isShowingApplicationModal.value = true
}

</script>

<style scoped></style>
