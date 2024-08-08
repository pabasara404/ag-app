<template>
  <n-layout class="pl-2">
    <PageHeader title="Timber Cutting Permit Request" />
      <n-p>According to the 1 of 2000. ACT TO PROVIDE FOR THE PROHIBITION, REGULATION OR CONTROL OF THE FELLING OF TREES citizens should obtain a permit to cut tree types such as Jackfruit,
      coconut, breadfruit, and palmyra. Required documents to obtain the timber
      cutting permit :</n-p
    >
    <n-ul>
      <n-li>Duly Filled application</n-li>
      <n-li>
        Copy of the deed of the relevant land (Should've certified by the Grama
        Niladhari)
      </n-li>
      <n-li
        >Copy of the plan (Should've certified by the Grama Niladhari )
      </n-li>
      <n-li> Extract for the relevant deed issued within a week. </n-li>
      <n-li>
        If the deed has life interest owner/ owners, a letter of consent
        regarding timber cutting ( Should've certified by the Grama Niladhari )
      </n-li>
      <n-li>
        If the life interest owner/owners have died applicant should present
        certified copy of the death certificate.
      </n-li>
      <n-li>
        If you are presenting a deed of declaration, it should submit with a
        grama niladhari report stating the clear holding of the land.
      </n-li>
    </n-ul>
    <div class="flex justify-center p-8">
      <n-button
        @click="addNewApplication"
        type="warning"
        secondary
        bordered
      >
        Apply to Obtain a Timber Cutting Permit
      </n-button>
    </div>
    <timber-cutting-permit-application-modal
        :application="selectedApplication"
      :is-showing="isShowingTimberCuttingPermitApplicationModal"
      @close="isShowingTimberCuttingPermitApplicationModal = $event"
    />
  </n-layout>
</template>

<script setup>
import PageHeader from "@/components/PageHeader.vue";
import { ref } from "vue";
import TimberCuttingPermitApplicationModal from "@/components/TimberCuttingPermitApplicationModal.vue";
import {getLocalAuthUser} from "@/services/auth.js";


const isShowingTimberCuttingPermitApplicationModal = ref(false);
const selectedApplication = ref(false);

function addNewApplication() {
    selectedApplication.value = {
        id: "",
        name: "John Doe",
        address: "123 Main St",
        contact_number: "555-1234",
        timber_seller_checked_value: "Yes",
        non_commercial_use_checked_value: "No",
        gn_division: {
            id: "74",
            gn_code: "370",
            name: "Kotugoda",
            mpa_code: "204",
        },
        deed_detail: {
            land_deed_number: "789",
            land_deed_date: "2022-04-11",
        },
        ownership_of_land_checked_value: "Co-owner",
        land_detail: {
            land_name: "Example Land",
            land_size: "10 acres",
            plan_number: "Plan123",
            plan_date: "2022-04-11",
            plan_plot_number: "Plot456",
        },
        boundary: {
            north: "North boundary",
            south: "South boundary",
            east: "East boundary",
            west: "West boundary",
        },
        tree_count: "2",
        tree_details: [
            {id:"",
                sub_no: "001",
                type: "Pine",
                height: "10 meters",
                girth: "2 meters",
                reproducibility: "Yes",
                age:"12"}
        ],
        tree_cutting_reasons: [
            {id: 2, label: "To build the house intended to be built", created_at: null, updated_at: null, value: 2},
            {id: 3, label: "Due to death due to natural causes", created_at: null, updated_at: null, value: 3}],
        trees_cut_before: "2",
        planted_tree_count: "20",
        road_to_land: "Paved road",
        status: "Submitted",
        submission_timestamp:"",
        checked_date:"",
        checked_time:"",
        comment:"",
        user: getLocalAuthUser()
    };

    isShowingTimberCuttingPermitApplicationModal.value = true
}
</script>

<style scoped></style>
