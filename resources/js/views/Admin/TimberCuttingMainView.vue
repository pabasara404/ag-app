<template>
    <PageHeader title="Timber Cutting Permit Services" />
    <div class="flex justify-evenly flex-wrap px-20">
        <n-card
            @click="handleCardClick('timberCuttingApplication')"
            title="Apply to a Timber Cutting Permit"
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
            @click="handleCardClick('timberCuttingPermitStatus')" title="View Timber Cutting Permit Status" hoverable>
            <div class="flex justify-center ">
                <img
                    width="125"
                    src="../../.././images/application status tracking black and white simple clipart.jpeg"
                />
            </div>
        </n-card>
        <n-card
            class="my-6"
            @click="handleCardClick('timberCuttingReviewApplication')" title="Review the Applications" hoverable>
            <div class="flex justify-center ">
                <img width="125" src="../../.././images/review.jpeg" />
            </div>
        </n-card>
        <n-card
            class="my-6"
            @click="handleCardClick('timberCuttingIssuePermits')" title="Issue Permits" hoverable>
            <div class="flex justify-center ">
                <img
                    width="125"
                    src="../../.././images/issue.jpeg"
                />
            </div>
        </n-card>
    </div>
</template>

<script setup>
import { ref } from "vue";
import { useRouter } from "vue-router";
import PageHeader from "@/components/PageHeader.vue";
import TimberCuttingReviewApplicationsView from "@/views/GuestUser/TimberCuttingReviewApplicationsView.vue";

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
