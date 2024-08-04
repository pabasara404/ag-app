<template>
    <n-modal
        v-model:show="isShowing"
        :on-update:show="(value) => emit('close', value)"
        preset="card"
        style="width: 630px"
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
                </n-page-header>
                <n-form ref="formRef" :model="formValue" :rules="rules">
                    <n-form-item label="Full Name" path="user.name">
                        <n-input v-model:value="formValue.user.name" placeholder="Full Name" />
                    </n-form-item>
                    <n-form-item label="Phone" path="contact_number">
                        <n-input
                            v-model:value="formValue.contact_number"
                            placeholder="Phone Number"
                        />
                    </n-form-item>
                    <n-form-item label="Email" path="user.email">
                        <n-input v-model:value="formValue.user.email" placeholder="Enter Email" />
                    </n-form-item>
                    <n-form-item label="NIC" path="nic">
                        <n-input v-model:value="formValue.nic" placeholder="NIC" />
                    </n-form-item>
                    <n-form-item label="Role" path="user.role_id">
                        <n-dropdown
                            trigger="hover"
                            placement="bottom-start"
                            :options="rolesForDropdown"
                            @select="selectRole"
                        >
                            <n-button>
                                {{ selectedRole ? selectedRole.label : "Select a Role" }}
                                <n-icon><ArrowDropDownRoundIcon /></n-icon>
                            </n-button>
                        </n-dropdown>
                    </n-form-item>
                    <n-form-item label="Address" path="address">
                        <n-input
                            type="textarea"
                            v-model:value="formValue.address"
                            maxlength="255"
                            show-count
                        />
                    </n-form-item>
                    <n-form-item label="Date of Birth" path="date_of_birth">
                        <n-date-picker v-model:value="selectedDOB" type="date" />
                    </n-form-item>
                    <n-form-item>
                        <n-button @click="save">
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
import { computed, ref, watch, onMounted } from "vue";
import { useMessage } from "naive-ui";
import { ArrowDropDownRound as ArrowDropDownRoundIcon } from "@vicons/material";

import Http from "@/services/http";
import moment from "moment";

const formRef = ref(null);
const message = useMessage();
const isShowing = ref(false);
const roleOptions = ref([]);
const emit = defineEmits(["close", "save"]);
const props = defineProps({
    isShowing: Boolean,
    employee: Object
});

const formValue = ref({
    id: "",
    name: "",
    nic: "",
    address: "",
    contact_number: "",
    user: {
        name: "",
        email: "",
        role_id: "",
    },
    date_of_birth: "",
});

watch(
    () => props.isShowing,
    (newValue) => {
        isShowing.value = newValue;
        formValue.value = { ...props.employee };
        if (!formValue.value.user) {
            formValue.value.user = {
                name: "",
                email: "",
                role_id: "",
            };
        }
    }
);

watch(
    () => formValue.value.user.name,
    (newName) => {
        formValue.value.name = newName;
    }
);

const rules = {
    'user.name': [
        { required: true, message: "Name is required", trigger: "blur" },
        { min: 2, message: "Name should contain at least two characters", trigger: "blur" }
    ],
    address: [
        { max: 255, message: "Address should not exceed 255 characters", trigger: "blur" }
    ],
    contact_number: [
        {
            pattern: /^(?:\+94|0094|0)\d{9}$/,
            message: "Phone number should be in the format +94xxxxxxxxx, 0094xxxxxxxxx, or 0xxxxxxxxx",
            trigger: "blur"
        }
    ],
    'user.email': [
        {type: 'email', message: "Email should be a valid email address", trigger: ["input", "blur"]}
    ],
    nic: [
        {required: true, message: "NIC is required", trigger: "blur"},
        {
            pattern: /^(?:\d{9}[vVxX]|\d{12})$/,
            message: "NIC should be in the old format (9 digits followed by a letter) or the new format (12 digits)",
            trigger: "blur"
        }
    ]
};

onMounted(() => {
    fetchRoles();
});

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

async function save() {
    try {
        await formRef.value.validate();
        if (isNewEmployee.value) {
            const emailResponse = await Http.post("checkEmail", {email: formValue.value.user.email});
            if (emailResponse.data.exists) {
                message.error("Email already exists!");
                return;
            }

            const response = await Http.post("employee", formValue.value);
            if (response.status === 204) {
                message.success("Employee added successfully. An email has been sent to set the password.");
            }
        } else {
            await Http.put(`employee/${formValue.value.id}`, formValue.value);
            message.success("Employee updated successfully.");
        }
        emit("close", false);
    } catch (error) {
        message.error("Failed to save employee data.");
        console.error(error);
    }
}

function handleSelect(key) {
    message.info(String(key));
}

const fetchRoles = async () => {
    try {
        const response = await Http.get("role");
        const data = response.data.data;
        roleOptions.value = data;
    } catch (error) {
        console.error(error);
    }
};

const rolesForDropdown = computed(() => {
    return roleOptions.value.map((roleOption) => {
        return {
            key: roleOption.id,
            label: roleOption.role_type,
        };
    });
});

function selectRole(key) {
    formValue.value.user.role_id = key;
}

const selectedRole = computed(() => {
    return rolesForDropdown.value.find((roleForDropdown) => {
        return roleForDropdown.key === formValue.value.user.role_id;
    });
});

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
