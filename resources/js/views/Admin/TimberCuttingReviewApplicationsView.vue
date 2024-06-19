<template>
    <n-layout style="height: 540px" has-sider>
        <n-layout style="padding-left: 8px" :inverted="inverted">
            <PageHeader title="Timber Cutting Application Management" />
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
import EditApplicationModal from "@/components/TimberCuttingPermitApplicationModal.vue";
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
        key: "tree_count",
    },
    {
        title: "Address",
        key: "address",
    },
    {
        title: "Status",
        key: "status",
    },
    // {
    //   title: "Role",
    //   key: "role",
    // },
    {
        title: "Submitted date",
        key: "submission_timestamp",
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
                        await deleteApplication(row);
                        await fetchApplication();
                    },
                },
                { default: () => "Delete" }
            );
        },
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
        timber_seller_checked_value: false,
        non_commercial_use_checked_value: false,
        gn_division: {
            id: "",
            gn_code: "",
            name: "",
            mpa_code: "",
        },
        deed_detail: {
            land_deed_number: "",
            land_deed_date: "",
        },
        ownership_of_land_checked_value: "",
        land_detail: {
            land_name: "",
            land_size: "",
            plan_number: "",
            plan_date: "",
            plan_plot_number: "",
        },
        boundary: {
            north: "",
            south: "",
            east: "",
            west: "",
        },
        tree_count: "",
        tree_details: [
            {
                id: "",
                sub_no: "",
                type: "",
                height: "",
                girth: "",
                reproducibility: false,
                want_to_cut: false,
                age: ""
            }
        ],
        tree_cutting_reasons: [],
        trees_cut_before: "",
        planted_tree_count: "",
        road_to_land: "",
        status: "",
        submission_timestamp: "",
        checked_date: "",
        checked_time: ""
        // citizen_id: {
        //    name: "",
        //    address: "",
        //    nic: "",
        //    contact_number: "",
        //    date_of_birth: "",
        //    gn_division_id: "",
        //    user_id: ""
        // }
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

async function deleteApplication(Application) {
    isLoading.value = true;
    await Http.delete(`timberCuttingPermitApplication/${Application.id}`);
    isLoading.value = false;
}
</script>
