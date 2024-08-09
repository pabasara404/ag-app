<template>
    <n-layout class="pl-2">
        <PageHeader title="Income Certificate Request Application"/>
            <n-p>To get a income certificate please fill out the form below.The original copies of relevant documents must be submitted.</n-p>
            <n-p>Required documents to obtain an income certificate:</n-p>
            <n-ul>
                <n-li>1. To confirm the source of income </n-li>
                <n-li>2. If the business is not located in the domain of residence, a report from the village officer of the division where it is located must also be submitted.</n-li>
            </n-ul>
            <div class="flex justify-center ... p-8">
                <n-button
                    @click="addNewApplication"
                    type="warning"
                    secondary
                    bordered
                >
                    Apply to Obtain a Income Certificate
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
import ApplicationModal from "@/components/IncomeAssessmentFormModal.vue";
import {getLocalAuthUser} from "@/services/auth.js";

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
        purpose: "Income Certificate Application",
        submitting_institute: "Sample Institute",
        incomes: [
            {
                id: "",
                source_of_income: "Salary",
                registration_no: "REG001",
                name: "Company A",
                size: "Large",
                monthly_income: "100000",
                annual_income: "1200000"
            }
        ],
        total_annual_income: "1800000",
        income_tax_number: "TAX123",
        is_samurdhi_beneficiary: "Yes",
        samurdhi_details: {
            id: "",
            subside_amount: "5000",
            is_subsidiaries_returned: "No",
            recommendation: "Approved",
            checked_date: "2023-05-15"
        },
        checked_date: "2023-01-01",
        status: "Pending",
        submission_timestamp: "2023-07-15 10:00:00",
        checked_time: "10:30:00",
        comment: "This is a test comment",
        application_code: "",
        user: getLocalAuthUser()
    };

    isShowingApplicationModal.value = true
}

</script>

<style scoped></style>
