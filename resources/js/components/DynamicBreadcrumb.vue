<template>
    <n-breadcrumb>
        <n-breadcrumb-item v-for="(item, index) in breadcrumbItems" :key="index">
            <n-dropdown v-if="item.children" :options="item.children">
                <div class="trigger">
                    {{ item.title }}
                </div>
            </n-dropdown>
            <span v-else>{{ item.title }}</span>
        </n-breadcrumb-item>
    </n-breadcrumb>
</template>

<script>
import { ref, watch, computed } from 'vue';
import { useRoute } from 'vue-router';

export default {
    name: 'DynamicBreadcrumb',
    setup() {
        const route = useRoute();
        const breadcrumbItems = ref([]);

        const updateBreadcrumbItems = () => {
            const matchedRoutes = route.matched;
            breadcrumbItems.value = matchedRoutes.map(route => {
                return {
                    title: route.meta.title,
                    path: route.path,
                    children: route.meta.children || null,
                };
            });
        };

        watch(route, updateBreadcrumbItems, { immediate: true });

        return {
            breadcrumbItems,
        };
    },
};
</script>

<style scoped>
.trigger::before {
    content: '';
    position: absolute;
    left: 0;
    right: 0;
    top: 0;
    bottom: 0;
    border-radius: inherit;
}
</style>
