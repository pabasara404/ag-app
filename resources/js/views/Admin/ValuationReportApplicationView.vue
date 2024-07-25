<template>
    <n-layout class="pl-2">
        <PageHeader title="Valuation Certificate Request Application"/>
<!--        <n-h4><i><u>Business Names Statute Of Trade, Coporations and Non—incorporated Trade Institutions of the Western Province No. 05 of 2011</u></i></n-h4>-->
<!--            <n-p>To get a income certificate please fill out the form below.The original copies of relevant documents must be submitted.</n-p>-->
<!--            <n-p>Required documents to obtain an income certificate:</n-p>-->
<!--            <n-ul>-->
<!--                <n-li>1. To confirm the source of income </n-li>-->
<!--                <n-li>2. If the business is not located in the domain of residence, a report from the village officer of the division where it is located must also be submitted.</n-li>-->
<!--            </n-ul>-->
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
        comment: "Initial submission for review."
    };

    isShowingApplicationModal.value = true
}

</script>

<style scoped></style>
