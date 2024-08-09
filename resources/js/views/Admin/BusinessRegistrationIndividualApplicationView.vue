<template>
    <n-layout class="pl-2">
        <PageHeader title="Individual Business Registration Application"/>
        <n-h4><i><u>Business Names Statute Of Trade, Coporations and Non—incorporated Trade Institutions of the Western Province No. 05 of 2011</u></i></n-h4>
            <n-p>Required documents to obtain the registration of a individual business:</n-p>
            <n-ul>
                <n-li>1. Duly filled application.</n-li>
                <n-li>2. Clearly state the nature of the business including all the activities of the business.</n-li>
            </n-ul>
            <div class="flex justify-center ... p-8">
                <n-button
                    @click="addNewApplication"
                    type="warning"
                    secondary
                    bordered
                >
                    Apply to Obtain a Individual Business Registration Certificate
                </n-button>
            </div>
            <business-individual-application-modal
                :application="selectedApplication"
                :is-showing="isShowingApplicationModal"
                @close="isShowingApplicationModal = $event"
            />
    </n-layout>
</template>

<script setup>
import PageHeader from "@/components/PageHeader.vue";
import { ref } from "vue";
import BusinessIndividualApplicationModal from "@/components/BusinessIndividualApplicationModal.vue";

const selectedApplication = ref(false);
const isShowingApplicationModal = ref(false);
import {getLocalAuthUser} from "@/services/auth.js";


function addNewApplication() {
    selectedApplication.value = {
        id: "",
        business_name: "Tech Innovators Ltd.",
        nature: "Software Development",
        principal_place: "123 Silicon Valley, Tech City",
        initial_capital: "500000 USD",
        addresses: [
            {id:"", name: "123 Silicon Valley, Tech City"},
            {id:"", name: "456 Innovation Drive, Tech City"}
        ],
        start_date: "2023-01-01",
        owner_detail: {
            name: "John Doe",
            previous_name: "Jonathan Doe",
            nationality: "American",
            nic: "A1234567",
            residence: "789 Main Street, Hometown, USA"
        },
        is_other_business_value: "Yes",
        other_businesses: [{
            registration_no: "987654",
            business_name: "Future Enterprises"
        }],
        is_director: "Yes",
        director_details: [{
            registration_no: "555333",
            business_name: "John Doe"
        }],
        gn_division: {
            id: "74",
            gn_code: "370",
            name: "Kotugoda",
            mpa_code: "204",
        },
        other_business_name: "Innovative Solutions Inc.",
        government_officer_checked_value: "No",
        contact_number: "+1234567890",
        ownership_of_land_checked_value: "Yes",
        checked_date: "2023-01-01",
        status: "Submitted",
        submission_timestamp:"",
        checked_time: "",
        comment:"",
        application_code:"",
        user: getLocalAuthUser()
    };

    isShowingApplicationModal.value = true
}

</script>

<style scoped></style>
