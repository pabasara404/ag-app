<template>
  <n-page-header style="padding-left: 8px">
    <template #title> {{ pageTitle }} </template>
    <template #header>
      <n-breadcrumb>
        <n-breadcrumb-item>Podcast</n-breadcrumb-item>
        <n-breadcrumb-item>Best Collection</n-breadcrumb-item>
        <n-breadcrumb-item>Ultimate Best Collection</n-breadcrumb-item>
        <n-breadcrumb-item>Anyway.FM</n-breadcrumb-item>
      </n-breadcrumb>
    </template>

    <n-divider />
  </n-page-header>
</template>

<script setup>
import { computed, defineProps } from "vue";

const propsData = defineProps({
  title: String,
});

const pageTitle = computed(() => propsData.title);
</script>

<style scoped></style>
