<template>
    <n-layout class="pl-2">
        <PageHeader title="Application for Request an Animal Transportation Permit Divisional Secretariat Area."/>
        <n-h4 class="text-center"><i><u>ANIMAL'S ACT, No. 29 of 1958</u></i></n-h4>
            <n-p>To get a animal transportation permit please fill out the form below.The original copies of relevant documents must be submitted.</n-p>
            <n-p>Required documents to obtain an animal transportation permit:</n-p>
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
                    Apply to Obtain a Animal Transportation Permit
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
import ApplicationModal from "@/components/AnimalTranportationModal.vue";

const selectedApplication = ref(false);
const isShowingApplicationModal = ref(false);


function addNewApplication() {
    selectedApplication.value = {
        id: "",
        name: "",
        address: "",
        nic: "",
        contact_number:"",
        gn_division: {
            id: "74",
            gn_code: "370",
            name: "Kotugoda",
            mpa_code: "204",
        },
        purpose:"",
        submitting_institute:"",
        incomes: [
            {
                id:"",
                source_of_income: "",
                registration_no:"",
                name:"",size:"",
                monthly_income:"",
                annual_income:""
            }
        ],
        total_annual_income:"",
        income_tax_number:"",
        is_samurdhi_beneficiary:"",
        samurdhi_details: {
            id: "",
            subside_amount: "",
            is_subsidiaries_returned: "",
            recommendation: "",
            checked_date:""
        },
        checked_date: "2023-01-01",
        status: "",
        submission_timestamp:"",
        checked_time: "",
        comment:"",
        application_code:"",
    };

    isShowingApplicationModal.value = true
}

</script>

<style scoped></style>
