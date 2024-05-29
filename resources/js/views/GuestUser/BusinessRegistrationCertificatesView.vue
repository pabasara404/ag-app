<template>
    <PageHeader title="Business Registration Management" />
    <div class="flex justify-evenly flex-wrap px-20">
        <n-card
            @click="handleCardClick('individualBusiness')"
            title="Apply to a Registration of a Business Owned by an Individual"
            hoverable
            class="my-6"
        >
            <div class="flex justify-center">
                <img
                    width="125"
                    src="../../.././images/Timber%20cutting%20permit%20req4.jpeg"
                />
            </div>
        </n-card>
        <n-card
            @click="handleCardClick('timberTransportationApplication')"
            title="Apply to a Registration by a Firm"
            hoverable
            class="my-6"
        >
            <div class="flex justify-center">
                <img
                    width="125"
                    src="../../.././images/Timber%20cutting%20permit%20req4.jpeg"
                />
            </div>
        </n-card>
        <n-card
            class="my-6"
            @click="handleCardClick('timberTransportationPermitStatus')" title="View Application Status" hoverable>
            <div class="flex justify-center ">
                <img
                    width="125"
                    src="../../.././images/application status tracking black and white simple clipart.jpeg"
                />
            </div>
        </n-card>
        <n-card
            class="my-6"
            @click="handleCardClick('timberTransportationPermitRenewal')" title="Submit a Notice of Cessation of Business" hoverable>
            <div class="flex justify-center ">
                <img width="125" src="../../.././images/img.png" />
            </div>
        </n-card>
        <n-card
            class="my-6"
            @click="handleCardClick('timberTransportationReviewApplication')" title="Review the Applications" hoverable>
            <div class="flex justify-center ">
                <img width="125" src="../../.././images/img_1.png" />
            </div>
        </n-card>
        <n-card
            class="my-6"
            @click="handleCardClick('timberTransportationIssuePermits')"
            title="Issue the Certificates" hoverable>
            <div class="flex justify-center ">
                <img
                    width="125"
                    src="../../.././images/img_2.png"
                />
            </div>
        </n-card>
    </div>
    <router-view />
</template>

<script setup>
import { useRouter } from "vue-router";
import PageHeader from "@/components/PageHeader.vue";

const router = useRouter();

const handleCardClick = (route) => {
    router.push(`/businessRegistrationCertificates/${route}`);
    console.log("Clicked");
};
</script>

<style scoped>
.n-card {
    max-width: 350px;
}
</style>
