<template>
    <PageHeader title="Valuation Report Management" />
    <div class="flex justify-evenly flex-wrap px-20">
        <n-card
            @click="handleCardClick('valuationReportApplication')"
            title="Apply to a Valuation Report"
            hoverable
            class="my-6"
        >
            <div class="flex justify-center">
                <img
                    width="125"
                    src="../../.././images/valuation.jpeg"
                />
            </div>
        </n-card>
        <n-card
            class="my-6"
            @click="handleCardClick('valuationReportStatus')" title="View Valuation Report Status" hoverable>
            <div class="flex justify-center ">
                <img
                    width="125"
                    src="../../.././images/application status tracking black and white simple clipart.jpeg"
                />
            </div>
        </n-card>
        <n-card
            class="my-6"
            @click="handleCardClick('valuationReportReview')" title="Review the Valuation Report" hoverable>
            <div class="flex justify-center ">
                <img width="125" src="../../.././images/review.jpeg" />
            </div>
        </n-card>
        <n-card
            class="my-6"
            @click="handleCardClick('valuationReportIssue')"
            title="Issue the Report" hoverable>
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
