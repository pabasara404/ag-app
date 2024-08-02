<template>
    <n-modal
        v-model:show="isShowing"
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
                    <n-h2 v-if="!isNewEmployee">Edit Employee</n-h2>
                    <n-h2 v-else>Add New Employee</n-h2>
                    <n-icon size="25"><CloseIcon /></n-icon>
                </n-page-header>
                <n-form ref="formRef" :model="formValue">
                    <n-form-item label="Name" path="name">
                        <n-input v-model:value="formValue.name" placeholder="Enter Name" />
                    </n-form-item>
                    <n-form-item label="Email" path="user.email">
                        <n-input v-model:value="formValue.user.email" placeholder="Enter Email" />
                        <n-alert v-if="emailExists" type="error" style="margin-top: 10px">
                            Email already exists!
                        </n-alert>
                    </n-form-item>
                    <n-form-item label="Phone" path="contact_number">
                        <n-input
                            v-model:value="formValue.contact_number"
                            placeholder="Phone Number"
                        />
                    </n-form-item>
                    <n-form-item label="NIC" path="nic">
                        <n-input v-model:value="formValue.nic" placeholder="NIC" />
                    </n-form-item>
                    <n-form-item label="Role" path="role">
                        <n-dropdown
                            trigger="hover"
                            placement="bottom-start"
                            :options="options"
                            @select="handleSelect"
                        >
                            <n-button>
                                Role <n-icon><ArrowDropDownRoundIcon /></n-icon>
                            </n-button>
                        </n-dropdown>
                    </n-form-item>
                    <n-form-item label="Address">
                        <n-input
                            type="textarea"
                            v-model:value="formValue.address"
                            maxlength="100"
                            show-count
                        />
                    </n-form-item>
                    <n-form-item label="Date of Birth">
                        <n-date-picker v-model:value="selectedDOB" type="date" />
                    </n-form-item>
                    <n-form-item>
                        <n-upload
                            multiple
                            directory-dnd
                            action="https://www.mocky.io/v2/5e4bafc63100007100d8b70f"
                            :max="5"
                        >
                            <n-upload-dragger>
                                <div style="margin-bottom: 12px">
                                    <n-icon size="48" :depth="3">
                                        <ArchiveIcon />
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
                        <n-button @click="handleSave">
                            {{ isNewEmployee ? "Add Employee" : "Update Employee" }}
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
    Close as CloseIcon,
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
    employee: Object,
});
const emailExists = ref(false);

watch(
    () => props.isShowing,
    (newValue) => {
        isShowing.value = newValue;
        formValue.value = { ...props.employee };
    }
);
const formValue = ref({
    id: "",
    name: "",
    user: {
        email: "",
    },
    nic: "",
    address: "",
    contact_number: "",
    role: "",
    date_of_birth: "",
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
const options = [
    {
        label: "Marina Bay Sands",
        key: "Marina Bay Sands",
    },
    {
        label: "Brown's Hotel, London",
        key: "Brown's Hotel, London",
    },
    {
        label: "Atlantis Bahamas, Nassau",
        key: "Atlantis Bahamas, Nassau",
    },
    {
        label: "The Beverly Hills Hotel, Los Angeles",
        key: "The Beverly Hills Hotel, Los Angeles",
    },
];

const selectedDOB = computed({
    get: () => {
        return moment(formValue.value.date_of_birth).valueOf();
    },
    set: (epoch) => {
        formValue.value.date_of_birth = moment
            .unix(epoch / 1000)
            .format("YYYY-MM-DD");
    },
});

const isNewEmployee = computed(() => {
    return !formValue.value.id;
});

async function handleSave() {
    try {
        // Check email first
        console.log('Checking email...');
        await checkEmail();

        if (emailExists.value) {
            message.error("Email already exists! Please use a different email.");
            return;
        }

        // If email is not duplicate, proceed with save
        console.log('Saving employee...');
        await save();
    } catch (error) {
        console.error(error);
        message.error("An error occurred while saving the employee");
    }
}

async function save() {
    try {
        if (isNewEmployee.value) {
            await Http.post("employee", formValue.value);
            message.success("Successfully created the Employee and email is sent to the user");
        } else {
            await Http.put(`employee/${formValue.value.id}`, formValue.value);
            message.success("Successfully updated the Employee");
        }
        emit("close");
    } catch (error) {
        console.error(error);
        message.error("An error occurred while saving the employee");
    }
}

async function checkEmail() {
    try {
        console.log('Sending request to check email...');
        const response = await Http.post("checkEmail", { email: formValue.value.user.email });
        console.log('Response received:', response);
        emailExists.value = response.data.exists;
    } catch (error) {
        console.error(error);
        message.error("An error occurred while checking the email");
    }
}

function handleSelect(key) {
    message.info(String(key));
}

function handleValidateClick(e) {
    e.preventDefault();
    formRef.value?.validate((errors) => {
        if (!errors) {
            message.success("Valid");
        } else {
            console.log(errors);
            message.error("Invalid");
        }
    });
}
</script>

<style scoped></style>
