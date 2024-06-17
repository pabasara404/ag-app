<template>
    <n-layout style="height: 540px" has-sider>
        <n-layout style="padding-left: 8px" :inverted="inverted">
            <PageHeader title="Application Details Management" />
            <div class="flex justify-end pb-6">
                <n-space>
                    <n-dropdown :options="options" placement="bottom-start">
                        <n-button :bordered="false" style="padding: 0 4px"> ··· </n-button>
                    </n-dropdown>
                </n-space>
            </div>

            <n-space vertical>
                <n-data-table
                    :loading="isLoading"
                    :columns="columns"
                    :data="applications"
                    :bordered="false"
                />
            </n-space>
        </n-layout>
        <edit-application-modal
            :application="selectedApplication"
            :is-showing="isShowingEditApplicationModal"
            @close="isShowingEditApplicationModal = $event"
            @save="fetchApplication"
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
import EditApplicationModal from "@/components/EditTimberCuttingApplicationModal.vue";
import PageHeader from "@/components/PageHeader.vue";
const isShowingEditApplicationModal = ref(false);
const selectedApplication = ref(false);
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
const applications = ref([]);
const columns = [
    {
        title: "Name of Applicant",
        key: "name",
    },
    {
        title: "Tree count",
        key: "nic",
    },
    {
        title: "Address",
        key: "address",
    },
    {
        title: "Status",
        key: "contact_number",
    },
    // {
    //   title: "Role",
    //   key: "role",
    // },
    {
        title: "Submitted date",
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
                        selectedApplication.value = row;
                        isShowingEditApplicationModal.value = true;
                    },
                },
                { default: () => "Review" }
            );
        },
    // },
    // {
    //     title: "",
    //     key: "actions",
    //     render(row) {
    //         return h(
    //             NButton,
    //             {
    //                 round: true,
    //                 type: "info",
    //                 strong: true,
    //                 secondary: true,
    //                 size: "small",
    //                 onClick: async () => {
    //                     await deleteApplication(row);
    //                     await fetchApplication();
    //                 },
    //             },
    //             { default: () => "Reject" }
    //         );
    //     },
    },
];

onMounted(() => {
    fetchApplication();
});

function addNewApplication() {
    selectedApplication.value = {
        id: "",
        name: "",
        address: "",
        contact_number: "",
        timber_seller_checked_value: "",
        non_commercial_use_checked_value: "",
        grama_niladari_division: {
            id: "",
            gn_code: "",
            name: "",
            mpa_code: "",
        },
        deed_details: {
            land_deed_number: "",
            land_deed_date: "",
        },
        ownership_of_land_checked_value: "",
        land_details: {
            land_name: "",
            land_size: "",
            plan_number: "",
            plan_date: "",
            plan_plot_number: "",
        },
        boundaries: {
            north: "",
            south: "",
            east: "",
            west: "",
        },
        tree_count: {
            breadfruit: "",
            coconut: "",
            jackfruit: "",
            palmyra: "",
        },
        tree_details: [
        ],
        tree_cutting_reasons: [],
        trees_cut_before: "",
        planted_tree_count: "",
        road_to_land: "",
    };

    isShowingEditApplicationModal.value = true;
}

function renderIcon(icon) {
    return () => h(NIcon, null, { default: () => h(icon) });
}
async function fetchApplication() {
    isLoading.value = true;
    const { data } = await Http.get("timberCuttingPermitApplication");
    isLoading.value = false;
    applications.value = data.data;
}

async function deleteApplication(application) {
    isLoading.value = true;
    await Http.delete(`timberCuttingPermitApplication/${application.id}`);
    isLoading.value = false;
}
</script>
