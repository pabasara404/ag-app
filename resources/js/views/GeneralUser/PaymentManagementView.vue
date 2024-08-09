<template>
    <n-layout style="height: 540px" has-sider>
        <n-layout style="padding-left: 8px" :inverted="inverted">
            <PageHeader title="Payments Management" />
            <div class="flex justify-end pb-6">
                <n-space>
                    <n-button @click="addNewPayment">
                        <template #icon
                        ><n-icon><add-icon /></n-icon></template
                        >Add New Payment</n-button
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
                    :data="payments"
                    :bordered="false"
                />
            </n-space>
        </n-layout>
        <edit-payment-modal
            :payment="selectedPayment"
            :is-showing="isShowingEditPaymentModal"
            @close="handleEditPaymentModalClose"
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
import EditPaymentModal from "@/components/EditPaymentModal.vue";
import PageHeader from "@/components/PageHeader.vue";
const isShowingEditPaymentModal = ref(false);
const selectedPayment = ref(false);
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
const payments = ref([]);
const columns = [
    {
        title: "Application Code",
        key: "application_code",
    },
    {
        title: "Name",
        key: "name",
    },
    {
        title: "NIC",
        key: "nic",
    },
    {
        title: "Amount",
        key: "amount",
    },
    {
        title: "Payment Type",
        key: "payment_type",
    },
    // {
    //   title: "Role",
    //   key: "role",
    // },

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
                        selectedPayment.value = row;
                        isShowingEditPaymentModal.value = true;
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
                        await deletePayment(row);
                        await fetchPayment();
                    },
                },
                { default: () => "Delete" }
            );
        },
    },
];

function handleEditPaymentModalClose(){
    isShowingEditPaymentModal.value = false;
    fetchPayment();
}

onMounted(() => {
    fetchPayment();
});

function addNewPayment() {
    selectedPayment.value = {
        id: "",
        name: "",
        nic: "",
        address: "",
        contact_number: "",
        user: "",
        date_of_birth: "2000-12-01",
    };

    isShowingEditPaymentModal.value = true;
}

function renderIcon(icon) {
    return () => h(NIcon, null, { default: () => h(icon) });
}
async function fetchPayment() {
    isLoading.value = true;
    const { data } = await Http.get("payment");
    isLoading.value = false;
    payments.value = data;
}

async function deletePayment(payment) {
    isLoading.value = true;
    await Http.delete(`payment/${payment.id}`);
    isLoading.value = false;
}
</script>
