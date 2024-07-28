<template>
    <n-modal
        v-model:show="isShowing"
        preset="card"
        style="width: 630px"
        :on-update:show="(value) => emit('close', value)"
    >
        <n-card
            style="width: 600px"
            :bordered="false"
            size="huge"
            role="dialog"
            aria-modal="true"
        >
            <n-layout style="padding-left: 8px">
                <n-page-header>
                    <n-h2 v-if="!isNewPayment">Edit Payment</n-h2>
                    <n-h2 v-else>Add New Payment</n-h2>
                </n-page-header>
                <n-form ref="formRef" :model="formValue">
                    <n-form-item label="Name with Initials" path="user.firstName">
                        <n-input v-model:value="formValue.name" placeholder="Enter Name" />
                    </n-form-item>
                    <n-form-item label="Payment Type " label-placement="left" path="role">
                        <n-dropdown
                            trigger="hover"
                            placement="bottom-start"
                            :options="paymentTypeOptions"
                            @select="handleSelect"
                        >
                            <n-button>
                                {{
                                    selectedPaymentType
                                        ? selectedPaymentType.label
                                        : "Payment Type"
                                }}
                                <n-icon><ArrowDropDownRoundIcon /></n-icon>
                            </n-button>
                        </n-dropdown>
                    </n-form-item>
                    <n-form-item label="Application Code" path="user.firstName">
                        <n-input
                            v-model:value="formValue.application_code"
                            placeholder="Enter Application Code"
                        />
                        <n-button class="mx-1.5" attr-type="button" @click="handleValidateClick">
                            <n-icon size="25"><SearchIcon /></n-icon>
                        </n-button>
                    </n-form-item>
                    <n-card title="Application Details">
                        <p v-if="formValue.value.applicationDetails">
                            <strong>Application Code:</strong> {{ formValue.value.applicationDetails.application_code }}<br>
                            <!-- Add more fields as needed -->
                        </p>
                        <p v-else>No application details available</p>
                    </n-card>

                    <n-form-item label="Amount" path="user.firstName">
                        <n-input v-model:value="formValue.amount" placeholder="Enter Amount" />
                    </n-form-item>
                    <n-form-item label="Receipt No" path="user.firstName">
                        <n-input v-model:value="formValue.receipt_no" placeholder="Receipt No" />
                    </n-form-item>
                    <n-form-item label="Paid Date">
                        <n-date-picker v-model:value="selectedDate" type="date" />
                    </n-form-item>
                    <n-form-item label="Phone Number" path="phone">
                        <n-input
                            v-model:value="formValue.contact_number"
                            placeholder="Phone Number"
                        />
                    </n-form-item>
                    <n-form-item label="NIC" path="nic">
                        <n-input v-model:value="formValue.nic" placeholder="NIC" />
                    </n-form-item>
                    <n-form-item label="Upload the Payment Receipt" path="nic">
                        <n-upload
                            multiple
                            directory-dnd
                            action="https://www.mocky.io/v2/5e4bafc63100007100d8b70f"
                            :max="5"
                        >
                            <n-upload-dragger>
                                <div style="margin-bottom: 12px">
                                    <n-icon size="48" :depth="3">
                                        <archive-icon />
                                    </n-icon>
                                </div>
                                <n-text style="font-size: 16px">
                                    Click or drag a file to this area to upload
                                </n-text>
                                <n-p depth="3" style="margin: 8px 0 0 0">
                                    Strictly prohibit from uploading sensitive information. For
                                    example, your bank card PIN or your credit card expiry date.
                                </n-p>
                            </n-upload-dragger>
                        </n-upload>
                    </n-form-item>
                    <n-form-item>
                        <n-button @click="save">
                            {{ isNewPayment ? "Add Payment" : "Update Payment" }}
                        </n-button>
                    </n-form-item>
                </n-form>
            </n-layout>
            <template #footer></template>
        </n-card>
    </n-modal>
</template>

<script setup>
import { computed, ref, watch } from "vue";
import { useMessage } from "naive-ui";
import {
    ArchiveOutline as ArchiveIcon,
    Search as SearchIcon,
} from "@vicons/ionicons5";
import { ArrowDropDownRound as ArrowDropDownRoundIcon } from "@vicons/material";

import Http from "@/services/http";
import moment from "moment";

const formRef = ref(null);
const message = useMessage();
const isShowing = ref(false);
const emit = defineEmits(["close", "save"]);
const props = defineProps({
    isShowing: Boolean,
    application: Object,
});
watch(
    () => props.isShowing,
    (newValue) => {
        isShowing.value = newValue;
        formValue.value = { ...props.application };
    }
);
const formValue = ref({
    name: "",
    payment_type: "",
    application_code: "",
    amount: "",
    bank_receipt_no: "",
    contact_number: "",
    nic: "",
    receipt_no: "",
    paid_date: "",
});

const paymentTypeOptions = [
    {
        label: "Timber Cutting Payment",
        key: "timber_cutting_permit_applications",
    },
    {
        label: "Timber Transporting Payment",
        key: "timber_transporting_applications",
    },
    {
        label: "Individual Business Registration Certificate Payment",
        key: "individual_businesses",
    },
    {
        label: "Firm Registration Certificate Payment",
        key: "firms",
    },
    {
        label: "Income Certificate Payment",
        key: "income_certificates",
    },
    {
        label: "Animal Transportation Permit Payment",
        key: "animal_transportations",
    },
    {
        label: "President Fund Payment",
        key: "president_funds",
    },
    {
        label: "Mahapola Payment",
        key: "mahapolas",
    },
    {
        label: "Excise License Payment",
        key: "excises",
    },
    {
        label: "Valuation Report Payment",
        key: "valuations",
    },
];

const selectedPaymentType = computed(() => {
    if (!formValue.value.payment_type) {
        return { label: "Payment Type" };
    }
    return paymentTypeOptions.find(
        (paymentTypeOption) => paymentTypeOption.key === formValue.value.payment_type
    ) || { label: formValue.value.payment_type };
});

function handleSelect(selected) {
    const selectedOption = paymentTypeOptions.find(
        (option) => option.key === selected
    );
    formValue.value.payment_type = selectedOption ? selectedOption.key : selected;
}

const selectedDate = computed({
    get: () => {
        return moment(formValue.value.paid_date).valueOf();
    },
    set: (epoch) => {
        formValue.value.paid_date = moment.unix(epoch / 1000).format("YYYY-MM-DD");
    },
});

const isNewPayment = computed(() => {
    return !formValue.value.id;
});

const applicationDetails = ref(null);

async function save() {
    if (isNewPayment.value) {
        await Http.post(`payment`, formValue.value);
        emit("close");

        return;
    }

    await Http.put(`payment/${formValue.value.id}`, formValue.value);
    emit("close");
}

async function handleValidateClick(e) {
    e.preventDefault();

    try {
        const response = await Http.get(`/application-details`, {
            params: {
                table_name: formValue.value.payment_type,
                application_code: formValue.value.application_code
            }
        });

        if (response.data) {
            // Display the retrieved application details in the n-card
            formValue.value.applicationDetails = response.data;
        } else {
            message.error("Application not found");
        }
    } catch (error) {
        message.error("Error retrieving application details");
        console.error(error);
    }
}

</script>

<style scoped></style>
