<template>
  <n-layout class="pl-2">
    <PageHeader title="Business Registration Firm Application"/>
      <n-h4><i><u>Business Names Statute Of Trade, Coporations and Non—incoporated Trade Institutions of the Western Province No. 05 of 2011</u></i></n-h4>
      <n-p>Required documents to obtain the registration of a firm:</n-p>
      <n-ul>
          <n-li>1. Duly filled application.</n-li>
          <n-li>2. If you are registering a firm every partner should sign in the application. If there is an agreement among partners it also should be represented.</n-li>
          <n-li> 3. Clearly state the nature of the business including all the activities of the business.</n-li>
      </n-ul>
    <div class="flex justify-center ... p-8">
      <n-button
          @click="addNewApplication"
        type="warning"
        secondary
        bordered
      >
        Apply to Obtain a Firm Registration Certificate
      </n-button>
    </div>
    <business-firm-application-modal
      :is-showing="isShowingApplicationModal"
      :application="selectedApplication"
      @close="isShowingApplicationModal = $event"
    />
  </n-layout>
</template>

<script setup>
import PageHeader from "@/components/PageHeader.vue";
import { ref } from "vue";
import BusinessFirmApplicationModal from "@/components/BusinessFirmApplicationModal.vue";

const selectedApplication = ref(false);
const isShowingApplicationModal = ref(false);

function addNewApplication() {
    selectedApplication.value = {
        id: "",
        business_name: "Tech Innovators",
        nature: "Technology",
        principal_place: "123 Tech Lane",
        initial_capital: "50000",
        addresses: [
            { id: "", name: "Main Office" },
            { id: "", name: "Branch Office" }
        ],
        start_date: "2024-01-01",
        partner_details: [
            {
                id: "",
                full_name: "John Doe",
                previous_name: "John Smith",
                government_officer_checked_value: "Yes",
                nationality: "American",
                nic: "A1234567",
                contact_number: "123-456-7890",
                residence: "456 Elm Street",
                is_other_occupation_value: "1",
                occupation: "Engineer",
                is_other_business_value: "1",
                other_partnered_businesses: [
                    { id: "", registration_no: "B123", business_name: "Tech Ventures", registered_date: "2022-05-15", nature: "Consulting" }
                ],
                is_director: "1",
                director_details: [
                    { id: "", business_name: "Tech Holdings", registration_no: "D123" }
                ]
            }
        ],
        checked_date: "2024-07-01",
        comment: "",
        status: "Submitted",
        ownership_of_land_checked_value: "Rent",
        submission_timestamp:"",
    };

    isShowingApplicationModal.value = true
}
</script>

<style scoped></style>
