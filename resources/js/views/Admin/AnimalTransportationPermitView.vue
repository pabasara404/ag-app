<template>
    <PageHeader title="Animal Transportation Permit Management" />
    <div class="flex justify-evenly flex-wrap px-20">
        <n-card
            @click="handleCardClick('animalTransportationApplication')"
            title="Apply to a Animal Transportation Permit"
            hoverable
            class="my-6"
        >
            <div class="flex justify-center">
                <img
                    width="125"
                    src="../../.././images/animal transport.jpeg"
                />
            </div>
        </n-card>
        <n-card
            class="my-6"
            @click="handleCardClick('animalTransportationStatus')" title="View Animal Transportation Permit Status" hoverable>
            <div class="flex justify-center ">
                <img
                    width="125"
                    src="../../.././images/application status tracking black and white simple clipart.jpeg"
                />
            </div>
        </n-card>
        <n-card
            class="my-6"
            @click="handleCardClick('animalTransportationReview')" title="Review the Animal Transportation Permit" hoverable>
            <div class="flex justify-center ">
                <img width="125" src="../../.././images/review.jpeg" />
            </div>
        </n-card>
        <n-card
            class="my-6"
            @click="handleCardClick('animalTransportationIssue')"
            title="Issue the Permit" hoverable>
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
