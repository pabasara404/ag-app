<template>
  <n-layout class="pl-2">
    <PageHeader title="Timber Transportation Permit Request" />
      <n-p>Required documents to obtain the timber transportation permit:</n-p>
      <n-ul>
          <n-li>Duly Filled application</n-li>
          <n-li>Copy of the deed of the relevant land (Should've certified by the Grama Niladhari)</n-li>
          <n-li>Copy of the plan (Should've certified by the Grama Niladhari)</n-li>
          <n-li>Last extract for the relevant deed issued within a week.</n-li>
          <n-li>If the deed has life interest owner/owners, a letter of consent regarding timber transportation. (Should've certified by the Grama Niladhari) If the life interest owner/owners have died applicant should present certified copy of the death certificate.</n-li>
          <n-li>If you are presenting a deed of declaration, it should submit with a grama niladhari report stating the clear holding of the land.</n-li>
          <n-li>If you are purchasing timber you should present the sales receipt which is certified by the Grama Niladhari.</n-li>
          <n-li>If the timber set has transported in early state you should present the transportation permit.</n-li>
          <n-li>Grama Niladhari Report regarding tree planting.</n-li>
      </n-ul>
      <n-p>For Timber Purchasing:</n-p>
      <n-ul>
          <n-li>If you are purchasing timber from a saw mill you should represent the relevant bill and the registered certificate of the saw mill.</n-li>
          <n-li>If you are purchasing timber from a personal land you should represent the sales receipt which is certified by the Grama Niladhari.</n-li>
      </n-ul>
    <div class="flex justify-center ... p-8">
      <n-button
        @click="addNewApplication"
        type="warning"
        secondary
        bordered
      >
        Apply to Obtain a Timber Transportation Permit
      </n-button>
    </div>
    <timber-transporting-permit-application-modal
        :application="selectedApplication"
      :is-showing="isShowingTimberTransportingPermitApplicationModal"
      @close="isShowingTimberTransportingPermitApplicationModal = $event"
    />
  </n-layout>
</template>

<script setup>
import PageHeader from "@/components/PageHeader.vue";
import { ref } from "vue";
import TimberTransportingPermitApplicationModal from "@/components/TimberTransportingPermitApplicationModal.vue";


const isShowingTimberTransportingPermitApplicationModal = ref(false);
const selectedApplication = ref(false);

function addNewApplication() {
    selectedApplication.value = {
        id: "",
        name: "John Doe",
        address: "123 Main St, Anytown, USA",
        contact_number: "123-456-7890",
        gn_division: {
            id: "74",
            gn_code: "370",
            name: "Kotugoda",
            mpa_code: "204",
        },
        address_of_timber: "456 Oak St, Anytown, USA",
        is_timber_bought_checked_value: true,
        receipt_no: "ABC123",
        bought_date: "2022-01-01",
        road_to_timber_location: "Take the highway and exit at Main St.",
        is_timber_private_land_checked_value: false,
        private_land: {
            land_deed_number: "123456",
            registration_date: "2021-01-01",
            plan_plot_number: "789",
            registration_office: "Anytown Registry",
            plan_number: "01234",
            land_name: "John Doe's Land",
            land_size: "10 acres",
        },
        boundary: {
            north: "123 Main St",
            south: "456 Oak St",
            east: "789 Elm St",
            west: "321 Maple Ave",
        },
        end_location: "567 Pine St, Anytown, USA",
        route: "Take the highway and exit at Pine St.",
        timber_transport_date: "2022-02-01",
        plate_number: "XYZ123",
        timber_details: [
            {
                timber_type: "Oak",
                length: "10 ft",
                width: "1 ft",
                piece_count: "5",
            },
            {
                timber_type: "Maple",
                length: "8 ft",
                width: "0.75 ft",
                piece_count: "0",
            },
        ],
        total_pieces: "15",
        checked_date: "2024-07-01",
        comment: "",
        status: "Submitted",
        submission_timestamp:"",
        application_code:""
    };

    isShowingTimberTransportingPermitApplicationModal.value = true;
}

</script>

<style scoped></style>
