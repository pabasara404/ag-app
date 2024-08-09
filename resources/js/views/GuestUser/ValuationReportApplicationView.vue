<template>
    <n-layout class="pl-2">
        <PageHeader title="Valuation Certificate Request Application"/>
            <div class="flex justify-center ... p-8">
                <n-button
                    @click="addNewApplication"
                    type="warning"
                    secondary
                    bordered
                >
                    Apply to Obtain a Valuation Certificate
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
import ApplicationModal from "@/components/ValuationReportModal.vue";
const selectedApplication = ref(false);
const isShowingApplicationModal = ref(false);
import {getLocalAuthUser} from "@/services/auth.js";


function addNewApplication() {
    selectedApplication.value = {
        id: "",
        application_code: "",
        name: "John Doe",
        address: "123 Main St, Colombo",
        valuation_amount: "5000000",
        reason: "Property Sale",
        land_deed_number: "LDN456789",
        to_north: "Neighbor A",
        to_south: "Road",
        to_east: "River",
        to_west: "Empty Land",
        size: "2000 sqft",
        length: "50 ft",
        width: "40 ft",
        notary_officer_name: "Notary Public John",
        plan_number: "PN789456",
        plan_date: "2023-05-15",
        land_name: "Green Acres",
        gn_division: {
            id: "74",
            gn_code: "370",
            name: "Kotugoda",
            mpa_code: "204",
        },
        status: "",
        submission_timestamp: "2023-07-15 10:00:00",
        checked_date: "2023-07-20",
        comment: "Initial submission for review.",
        user: getLocalAuthUser()
    };

    isShowingApplicationModal.value = true
}

</script>

<style scoped></style>
