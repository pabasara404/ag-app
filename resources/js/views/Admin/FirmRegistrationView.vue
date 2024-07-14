<template>
    <PageHeader title="Firm Registration Management" />
    <div class="flex justify-evenly flex-wrap px-20">
       <n-card
            @click="handleCardClick('firm')"
            title="Apply to a Registration by a Firm"
            hoverable
            class="my-6"
        >
            <div class="flex justify-center">
                <img
                    width="125"
                    src="../../.././images/registration.jpeg"
                />
            </div>
        </n-card>
        <n-card
            class="my-6"
            @click="handleCardClick('firmBusinessRegistrationStatus')" title="View Firm Application Status" hoverable>
            <div class="flex justify-center ">
                <img
                    width="125"
                    src="../../.././images/application status tracking black and white simple clipart.jpeg"
                />
            </div>
        </n-card>
        <n-card
            class="my-6"
            @click="handleCardClick('firmCessation')" title="Submit a Notice of Cessation of Business" hoverable>
            <div class="flex justify-center ">
                <img width="125" src="../../.././images/cessation.jpeg" />
            </div>
        </n-card>
        <n-card
            class="my-6"
            @click="handleCardClick('firmRegistrationReviewApplication')" title="Review the Applications" hoverable>
            <div class="flex justify-center ">
                <img width="125" src="../../.././images/review.jpeg" />
            </div>
        </n-card>
        <n-card
            class="my-6"
            @click="handleCardClick('firmRegistrationIssuePermits')"
            title="Issue the Certificates" hoverable>
            <div class="flex justify-center ">
                <img
                    width="125"
                    src="../../.././images/issue.jpeg"
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
    router.push(`${route}`);
    console.log("Clicked");
};
</script>

<style scoped>
.n-card {
    max-width: 350px;
}
</style>
