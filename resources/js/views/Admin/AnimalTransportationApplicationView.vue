<template>
    <n-layout class="pl-2">
        <PageHeader title="Application for Request an Animal Transportation Permit Divisional Secretariat Area."/>
        <n-h4 class="text-center"><i><u>ANIMAL'S ACT, No. 29 of 1958</u></i></n-h4>
            <n-p>To get a animal transportation permit please fill out the form below.The original copies of relevant documents must be submitted.</n-p>
            <n-p>Required documents to obtain an animal transportation permit:</n-p>
            <n-ul>
                <n-li>1. Cattle Voucher</n-li>
                <n-li>2. Health Certificate from the Government Veterinary Surgeon</n-li>
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
import {getLocalAuthUser} from "@/services/auth.js";

function addNewApplication() {
    selectedApplication.value = {
        id: "",
        application_code: "",
        name: "John Doe",
        address: "123 Main St, Colombo",
        contact_number: "0712345678",
        reason_to_transport: "Transporting animals for sale",
        start_point: "Colombo",
        destination: "Kandy",
        animals: [{
            id:"",
            serial_no: "AN001",
            identification_no: "ID001",
            species: "Cow",
            breed: "Angus",
            age: "2 years",
            sex: "Male",
            color: "Black",
            specific_marks: "White patch on forehead",
            health_certificate_no: "HC001",
            vehicle_registration_no: "WP ABC 1234"
        },{
            id:"",
            serial_no: "AN002",
            identification_no: "ID002",
            species: "Goat",
            breed: "Boer",
            age: "1 year",
            sex: "Female",
            color: "Brown",
            specific_marks: "White spot on nose",
            health_certificate_no: "HC002",
            vehicle_registration_no: "WP DEF 5678"
        }],
        cost_per_animal: "5000",
        total_animal_count: "",
        issued_date: "2023-01-01",
        expire_date: "2023-01-31",
        checked_date: "2023-01-01",
        status: "",
        submission_timestamp: "",
        comment: "This is a test comment",
        user: getLocalAuthUser()
    };

    isShowingApplicationModal.value = true
}

</script>

<style scoped></style>
