<template>
    <n-modal v-model:show="isShowing" preset="card" style="width: 630px" :on-update:show="(value) => emit('close', value)">
        <n-card style="width: 600px" :bordered="false" size="huge" role="dialog" aria-modal="true">
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
                        <n-dropdown trigger="hover" placement="bottom-start" :options="paymentTypeOptions" @select="handleSelect">
                            <n-button>
                                {{
                                    selectedPaymentType ? selectedPaymentType.label : "Payment Type"
                                }}
                                <n-icon><ArrowDropDownRoundIcon /></n-icon>
                            </n-button>
                        </n-dropdown>
                    </n-form-item>
                    <n-form-item label="Application Code" path="user.firstName">
                        <n-input v-model:value="formValue.application_code" placeholder="Enter Application Code" />
                        <n-button class="mx-1.5" attr-type="button" @click="handleValidateClick">
                            <n-icon size="25"><SearchIcon /></n-icon>
                        </n-button>
                    </n-form-item>
                    <template v-if="formValue.applicationDetails">
                        <n-card  :loading="isLoading" title="Application Details">
                            <p v-for="(field, index) in applicationFields" :key="index">
                                <strong>{{ field.label }}:</strong> {{ formValue.applicationDetails[field.key] }}<br>
                            </p>
                        </n-card>
                    </template>
                    <br/>
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
                        <n-button @click="save" >
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
import {computed, onMounted, ref, watch} from "vue";
import { useMessage } from "naive-ui";
import { ArchiveOutline as ArchiveIcon, Search as SearchIcon } from "@vicons/ionicons5";
import { ArrowDropDownRound as ArrowDropDownRoundIcon } from "@vicons/material";

import Http from "@/services/http";
import moment from "moment";

const formRef = ref(null);
const isLoading = ref(false);
const message = useMessage();
const isShowing = ref(false);
const emit = defineEmits(["close", "save"]);
const props = defineProps({
    isShowing: Boolean,
    application: Object,
    applicationCode: String
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
    applicationDetails: null
});

const rules = {
    user: {
        firstName: {
            required: true,
            message: "Please input your name",
            trigger: "blur",
        },
        age: {
            required: true,
            message: "Please input your age",
            trigger: ["input", "blur"],
        },
    },
    phone: {
        required: true,
        message: "Please input your number",
        trigger: ["input"],
    },
};
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
        formValue.value.paid_date = moment(epoch).format("YYYY-MM-DD");
    },
});

const isNewPayment = computed(() => {
    return !formValue.value.id;
});async function save() {
    try {
        const response = await Http.post(`/payment`, formValue.value);
        message.success('Payment saved successfully');
        emit('close');
    } catch (error) {
        message.error(error.response.data.error || 'Error saving payment');
        console.error(error);
    }
}

async function handleValidateClick(e) {
    e.preventDefault();

    try {
        isLoading.value = true;
        const response = await Http.get(`/applicationDetails`, {
            params: {
                table_name: formValue.value.payment_type,
                application_code: formValue.value.application_code
            }
        });

        if (response.data) {
            // Display the retrieved application details in the n-card
            formValue.value.applicationDetails = response.data;
            isLoading.value = false;
        } else {
            message.error("Application not found");
            formValue.value.applicationDetails = null;
        }
    } catch (error) {
        message.error(error.response.data.error || 'Error retrieving application details');
        console.error(error);
        formValue.value.applicationDetails = null;
    }
}

// Define a mapping of fields for each payment type
const fieldMappings = {
    timber_cutting_permit_applications: [
        { label: "Application Code", key: "application_code" },
        { label: "Name of the Applicant", key: "name" },
        { label: "Address", key: "address" },
        { label: "Tree Count", key: "tree_count" },
        // Add more fields as necessary
    ],
    timber_transporting_applications: [
        { label: "Application Code", key: "application_code" },
        { label: "Name of the Applicant", key: "name" },
        { label: "Transport Date", key: "transport_date" },
        { label: "Vehicle Number", key: "plate_number" },
        { label: "Route", key: "route" },
        // Add more fields as necessary
    ],
    individual_businesses: [
        { label: "Application Code", key: "application_code" },
        { label: "Business Name", key: "business_name" },
        { label: "Nature", key: "nature" },
        { label: "Principle Place", key: "principal_place" },
        { label: "Initial Capital", key: "initial_capital" },
        { label: "Contact Number", key: "contact_number" },
        // Add more fields as necessary
    ],
    firms: [
        { label: "Application Code", key: "application_code" },
        { label: "Business Name", key: "business_name" },
        { label: "Nature", key: "nature" },
        { label: "Principle Place", key: "principal_place" },
        { label: "Initial Capital", key: "initial_capital" },
        { label: "Submission Timestamp", key: "submission_timestamp" },
        // Add more fields as necessary
    ],
    income_certificates: [
        { label: "Application Code", key: "application_code" },
        { label: "Name", key: "name" },
        { label: "Address", key: "address" },
        { label: "NIC", key: "nic" },
        { label: "Purpose", key: "purpose" },
        { label: "Submitting Institute", key: "submitting_institute" },
        { label: "Total Annual Income", key: "total_annual_income" },
        { label: "Checked Date", key: "checked_date" },
        // Add more fields as necessary
    ],
    animal_transportations: [
        { label: "Application Code", key: "application_code" },
        { label: "Name", key: "name" },
        { label: "Reason to Transport", key: "reason_to_transport" },
        { label: "Start Point", key: "start_point" },
        { label: "Destination", key: "destination" },
        { label: "Cost per Animal", key: "cost_per_animal" },
        { label: "Issued Date", key: "issued_date" },
        { label: "Expire Date", key: "expire_date" },
        // Add more fields as necessary
    ],
    valuations: [
        { label: "Application Code", key: "application_code" },
        { label: "Name", key: "name" },
        { label: "Address", key: "address" },
        { label: "Valuation Amount", key: "valuation_amount" },
        { label: "Reason", key: "reason" },
        { label: "Land Name", key: "land_name" },
        // Add more fields as necessary
    ],
    excises: [
        { label: "Application Code", key: "application_code" },
        { label: "Name", key: "name" },
        { label: "Address", key: "address" },
        { label: "Business Name", key: "business_name" },
        { label: "Issued Date", key: "issued_date" },
        { label: "Expire Date", key: "expire_date" },
        // Add more fields as necessary
    ],
    president_funds: [
        { label: "Application Code", key: "application_code" },
        { label: "Name", key: "name" },
        { label: "Address", key: "address" },
        { label: "NIC", key: "nic" },
        { label: "Contact Number", key: "contact_number" },
        // Add more fields as necessary
    ],
    mahapolas: [
        { label: "Application Code", key: "application_code" },
        { label: "Name", key: "name" },
        { label: "Address", key: "address" },
        { label: "NIC", key: "nic" },
        { label: "Contact Number", key: "contact_number" },
        // Add more fields as necessary
    ],
};

const applicationFields = computed(() => {
    return fieldMappings[formValue.value.payment_type] || [];
});
</script>

<style scoped></style>
