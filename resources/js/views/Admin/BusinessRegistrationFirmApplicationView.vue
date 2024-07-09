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
        @click="isShowingApplicationModal = true"
        type="warning"
        secondary
        bordered
      >
        Apply to Obtain a Firm Registration Certificate
      </n-button>
    </div>
    <business-firm-application-modal
      :is-showing="isShowingApplicationModal"
      @close="isShowingApplicationModal = $event"
    />
  </n-layout>
</template>

<script setup>
import PageHeader from "@/components/PageHeader.vue";
import { ref } from "vue";
import BusinessFirmApplicationModal from "@/components/BusinessFirmApplicationModal.vue";


const isShowingApplicationModal = ref(false);

</script>

<style scoped></style>
