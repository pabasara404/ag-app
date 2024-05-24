<template>
    <n-layout style="height: 540px" has-sider>
        <n-layout style="padding-left: 8px" :inverted="inverted">
            <PageHeader title="Citizen Details Management" />
            <div class="flex justify-end pb-6">
                <n-space>
                    <n-button @click="addNewCitizen">
                        <template #icon
                        ><n-icon><add-icon /></n-icon></template
                        >Add New Citizen</n-button
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
                    :data="citizens"
                    :bordered="false"
                />
            </n-space>
        </n-layout>
        <edit-citizen-modal
            :citizen="selectedCitizen"
            :is-showing="isShowingEditCitizenModal"
            @close="handleEditCitizenModalClose"
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
import EditCitizenModal from "@/components/Admin/EditCitizenModal.vue";
import PageHeader from "@/components/PageHeader.vue";
const isShowingEditCitizenModal = ref(false);
const selectedCitizen = ref(false);
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
const citizens = ref([]);
const columns = [
    {
        title: "Name",
        key: "name",
    },
    {
        title: "NIC",
        key: "nic",
    },
    {
        title: "Address",
        key: "address",
    },
    {
        title: "Contact Number",
        key: "contact_number",
    },
    {
        title: "DOB",
        key: "date_of_birth",
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
                        selectedCitizen.value = row;
                        isShowingEditCitizenModal.value = true;
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
                        await deleteCitizen(row);
                        await fetchCitizen();
                    },
                },
                { default: () => "Delete" }
            );
        },
    },
];

const components = {
    PageHeader,
};

onMounted(() => {
    fetchCitizen();
});

function handleEditCitizenModalClose() {
    isShowingEditCitizenModal.value = false;
    fetchCitizen();
}

function addNewCitizen() {
    selectedCitizen.value = {
        id: "",
        name: "",
        nic: "",
        address: "",
        contact_number: "",
        role: {
            id: "",
            role_type: ""
        },
        date_of_birth: "2000-12-01",
    };

    isShowingEditCitizenModal.value = true;
    fetchCitizen();
}

function renderIcon(icon) {
    return () => h(NIcon, null, { default: () => h(icon) });
}
async function fetchCitizen() {
    isLoading.value = true;
    const { data } = await Http.get("citizen");
    isLoading.value = false;
    citizens.value = data.data;
}

async function deleteCitizen(citizen) {
    isLoading.value = true;
    await Http.delete(`citizen/${citizen.id}`);
    isLoading.value = false;
    await fetchCitizen();
}
</script>
