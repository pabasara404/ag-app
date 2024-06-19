<template>
  <n-page-header style="padding-left: 8px">
    <template #title>{{ pageTitle }} </template>
    <template #header>
        <dynamic-breadcrumb />
    </template>

    <n-divider />
  </n-page-header>
</template>

<script setup>
import { computed, defineProps } from "vue";
import DynamicBreadcrumb from "@/components/DynamicBreadcrumb.vue";

const propsData = defineProps({
  title: String,
});

const pageTitle = computed(() => propsData.title);
</script>

<style scoped></style>
