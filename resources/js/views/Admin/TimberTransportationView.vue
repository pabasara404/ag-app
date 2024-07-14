<template>
    <PageHeader title="Timber Transportation Permit Services" />
    <div class="flex justify-evenly flex-wrap px-20">
        <n-card
            @click="handleCardClick('timberTransportationApplication')"
            title="Apply to a Timber Transportation Permit"
            hoverable
            class="my-6"
        >
            <div class="flex justify-center">
                <img
                    width="125"
                    src="../../.././images/timber trans.jpeg"
                />
            </div>
        </n-card>
        <n-card
            class="my-6"
            @click="handleCardClick('timberTransportationPermitStatus')" title="View Timber Transportation Permit Status" hoverable>
            <div class="flex justify-center ">
                <img
                    width="125"
                    src="../../.././images/application status tracking black and white simple clipart.jpeg"
                />
            </div>
        </n-card>
        <n-card
            class="my-6"
            @click="handleCardClick('timberTransportationPermitRenewal')" title="Permit Renewal Request" hoverable>
            <div class="flex justify-center ">
                <img width="125" src="../../.././images/apply.jpeg" />
            </div>
        </n-card>
        <n-card
            class="my-6"
            @click="handleCardClick('timberTransportationReviewApplication')" title="Review the Applications" hoverable>
            <div class="flex justify-center ">
                <img width="125" src="../../.././images/review.jpeg" />
            </div>
        </n-card>
        <n-card
            class="my-6"
            @click="handleCardClick('timberTransportationIssuePermits')" title="Issue Permits" hoverable>
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
