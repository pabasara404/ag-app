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
import EditApplicationModal from "@/components/TimberTransportingPermitApplicationModal.vue";
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
        title: "Reference Number",
        key: "application_code",
    },{
        title: "Name of Applicant",
        key: "name",
    },
    {
        title: "Total Pieces",
        key: "total_pieces",
    },
    {
        title: "Address",
        key: "address",
    },
    {
        title: "Status",
        key: "status",
    },
    {
        title: "Submitted date",
        key: "submission_timestamp",
    },
    {
        title: "Last updated date",
        key: "updated_at",
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
        name: "John Doe",
        address: "123 Main St, Anytown, USA",
        contact_number: "123-456-7890",
        gn_division: {
            id: "74",
            gn_code: "370",
            name: "Kotugoda",
            mpa_code: "204",
        },
        address_of_timber: "456 Oak St, Anytown, USA",
        is_timber_bought_checked_value: true,
        receipt_no: "ABC123",
        bought_date: "2022-01-01",
        road_to_timber_location: "Take the highway and exit at Main St.",
        is_timber_private_land_checked_value: false,
        private_land: {
            land_deed_number: "123456",
            registration_date: "2021-01-01",
            plan_plot_number: "789",
            registration_office: "Anytown Registry",
            plan_number: "01234",
            land_name: "John Doe's Land",
            land_size: "10 acres",
        },
        boundary: {
            north: "123 Main St",
            south: "456 Oak St",
            east: "789 Elm St",
            west: "321 Maple Ave",
        },
        end_location: "567 Pine St, Anytown, USA",
        route: "Take the highway and exit at Pine St.",
        timber_transport_date: "2022-02-01",
        plate_number: "XYZ123",
        timber_details: [
            {
                timber_type: "Oak",
                length: "10 ft",
                width: "1 ft",
                piece_count: "5",
            },
            {
                timber_type: "Maple",
                length: "8 ft",
                width: "0.75 ft",
                piece_count: "0",
            },
        ],
        total_pieces: "15",
        checked_date: "2024-07-01",
        comment: "",
        status: "Submitted",
        submission_timestamp:"",
        application_code:""
    };

    isShowingEditApplicationModal.value = true;
}

function renderIcon(icon) {
    return () => h(NIcon, null, { default: () => h(icon) });
}
async function fetchApplication() {
    isLoading.value = true;
    const {data} = await Http.get("timberTransportingPermitApplication");
    isLoading.value = false;
    applications.value = data.data;
}

async function deleteApplication(application) {
    isLoading.value = true;
    await Http.delete(`timberTransportingPermitApplication/${application.id}`);
    isLoading.value = false;
}
</script>
