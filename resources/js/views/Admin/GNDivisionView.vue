<template>
    <n-layout style="height: 540px" has-sider>
        <n-layout style="padding-left: 8px" :inverted="inverted">
            <PageHeader title="GNDivision Details Management" />
            <div class="flex justify-end pb-6">
                <n-space>
                    <n-button @click="addNewGNDivision">
                        <template #icon
                        ><n-icon><add-icon /></n-icon></template
                        >Add New GN Division</n-button
                    >
                    <n-dropdown :options="options" placement="bottom-start">
                        <n-button :bordered="false" style="padding: 0 4px"> ··· </n-button>
                    </n-dropdown>
                </n-space>
            </div>

            <n-space vertical>
                <n-data-table
                    :loading="isLoading"
                    :columns="columns"
                    :data="gnDivisions"
                    :bordered="false"
                />
            </n-space>
        </n-layout>
        <EditGNDivisionModal
            :gnDivision="selectedGNDivision"
            :is-showing="isShowingEditGNDivisionModal"
            @close="handleEditGNDivisionModalClose"
        />
    </n-layout>
</template>

<script setup>
import { h, onMounted, ref } from "vue";
import {
    PencilSharp as PencilIcon,
    Add as AddIcon,
    TrashBin as TrashBinIcon,
    Eye as EyeIcon,
} from "@vicons/ionicons5";
import Http from "@/services/http";
import { NButton, NIcon } from "naive-ui";
import EditGNDivisionModal from "@/components/Admin/EditGNDivisionModal.vue";
import PageHeader from "@/components/PageHeader.vue";
const isShowingEditGNDivisionModal = ref(false);
const selectedGNDivision = ref(false);
const inverted = ref(false);
const isLoading = ref(false);
const options = [
    {
        label: "Sort By Recently Added",
        key: "1",
    },
    {
        label: "Sort By Oldest Added",
        key: "2",
    },
];
const gnDivisions = ref([]);
const columns = [
    {
        title: "Name",
        key: "name",
    },
    {
        title: "Gn Code",
        key: "gn_code",
    },
    {
        title: "MPA Code",
        key: "mpa_code",
    },
    {
        title: "GN Officer",
        key: "gn_officer.name",
    },
    {
        title: "",
        key: "actions",
        render(row) {
            return h(
                NButton,
                {
                    round: true,
                    type: "info",
                    strong: true,
                    secondary: true,
                    // renderIcon: EyeIcon,
                    size: "small",
                    onClick: () => {
                        selectedGNDivision.value = row;
                        isShowingEditGNDivisionModal.value = true;
                    },
                },
                { default: () => "View" }
            );
        },
    },
    {
        title: "",
        key: "actions",
        render(row) {
            return h(
                NButton,
                {
                    round: true,
                    type: "info",
                    strong: true,
                    secondary: true,
                    size: "small",
                    onClick: async () => {
                        await deleteGNDivision(row);
                        await fetchGNDivision();
                    },
                },
                { default: () => "Delete" }
            );
        },
    },
];

function handleEditGNDivisionModalClose(){
    isShowingEditGNDivisionModal.value = false;
    fetchGNDivision();
}

onMounted(() => {
    fetchGNDivision();
});

function addNewGNDivision() {
    selectedGNDivision.value = {
        id: "",
        name: "",
        gn_code: "",
        mpa_code: "",
        gn_officer: {
            id: "",
            name: "",
            contact_number: "",
        },
    };

    isShowingEditGNDivisionModal.value = true;
}

function renderIcon(icon) {
    return () => h(NIcon, null, { default: () => h(icon) });
}
async function fetchGNDivision() {
    isLoading.value = true;
    const { data } = await Http.get("gnDivision");
    isLoading.value = false;
    gnDivisions.value = data.data;
}

async function deleteGNDivision(gnDivision) {
    isLoading.value = true;
    await Http.delete(`gnDivision/${gnDivision.id}`);
    isLoading.value = false;
}
</script>
