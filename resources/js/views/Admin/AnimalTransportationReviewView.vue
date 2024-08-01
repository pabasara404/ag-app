<template>
    <n-layout style="height: 540px" has-sider>
        <n-layout style="padding-left: 8px" :inverted="inverted">
            <PageHeader title="Application Review Management" />
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
import EditApplicationModal from "@/components/AnimalTranportationModal.vue";
import PageHeader from "@/components/PageHeader.vue";
const isShowingEditApplicationModal = ref(false);
const selectedApplication = ref(false);
const applications = ref([]);
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

const columns = [
    {
        title: "Reference No.",
        key: "application_code",
    },
    {
        title: "Name of the Applicant",
        key: "name",
    },
    {
        title: "Total Animals",
        key: "total_animal_count",
    },
    {
        title: "Reason",
        key: "reason_to_transport",
    },
    {
        title: "Status",
        key: "status",
    },
    {
        title: "issued Date",
        key: "issued_date",
    },
    {
        title: "Last updated Date",
        key: "updated_at",
    },
    {
        title: "Expire Date",
        key: "expire_date",
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
                {default: () => "Review"}
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
//
// function addNewApplication() {
//     selectedApplication.value = {
//         id: "",
//         business_name: "",
//         nature: "",
//         principal_place: "",
//         initial_capital: "",
//         addresses: [],
//         start_date: "",
//         owner_detail: {
//             name: "",
//             previous_name: "",
//             nationality: "",
//             nic: "",
//             residence: ""
//         },
//         is_other_business_value: "",
//         other_businesses: [],
//         is_director: "",
//         director_details: [],
//         other_business_name: "",
//         government_officer_checked_value: "",
//         contact_number: "",
//         ownership_of_land_checked_value: "",
//         checked_date: "",
//         status: "",
//         submission_timestamp: "",
//         checked_time: "",
//         comment: "",
//         application_code: "",
//     };
//
//     isShowingEditApplicationModal.value = true;
// }

function renderIcon(icon) {
    return () => h(NIcon, null, {default: () => h(icon)});
}

async function fetchApplication() {
    isLoading.value = true;
    const { data } = await Http.get("animalTransportationByStatus", {
        params: {
            statuses: 'Submitted,Resubmitted'
        }
    });
    isLoading.value = false;

    // Add total_animal_count to each application
    applications.value = data.data.map(application => ({
        ...application,
        total_animal_count: application.animals.length
    }));
}

async function deleteApplication(application) {
    isLoading.value = true;
    await Http.delete(`animalTransportation/${application.id}`);
    isLoading.value = false;
}
</script>
