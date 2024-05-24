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
        @click="isShowingTimberTransportingPermitApplicationModal = true"
        type="warning"
        secondary
        bordered
      >
        Apply to Obtain a Timber Transportation Permit
      </n-button>
    </div>
    <timber-transporting-permit-application-modal
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

</script>

<style scoped></style>
