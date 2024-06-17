<template>
    <n-layout class="pl-2">
        <PageHeader title="Individual Business Registration Application"/>
        <n-h4><i><u>Business Names Statute Of Trade, Coporations and Non—incoporated Trade Institutions of the Western Province No. 05 of 2011</u></i></n-h4>
            <n-p>Required documents to obtain the registration of a individual business:</n-p>
            <n-ul>
                <n-li>1. Duly filled application.</n-li>
                <n-li>2. Clearly state the nature of the business including all the activities of the business.</n-li>
            </n-ul>
            <div class="flex justify-center ... p-8">
                <n-button
                    @click="isShowingApplicationModal = true"
                    type="warning"
                    secondary
                    bordered
                >
                    Apply to Obtain a Individual Business Registration Certificate
                </n-button>
            </div>
            <business-individual-application-modal
                :is-showing="isShowingApplicationModal"
                @close="isShowingApplicationModal = $event"
            />
    </n-layout>
</template>

<script setup>
import PageHeader from "@/components/PageHeader.vue";
import { ref } from "vue";
import TimberTransportingPermitApplicationModal from "@/components/TimberTransportingPermitApplicationModal.vue";
import BusinessIndividualApplicationModal from "@/components/BusinessIndividualApplicationModal.vue";


const isShowingApplicationModal = ref(false);

</script>

<style scoped></style>
