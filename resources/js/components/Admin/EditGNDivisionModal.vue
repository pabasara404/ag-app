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
                    <n-h2 v-if="!isNewGNDivision">Edit GN Division</n-h2>
                    <n-h2 v-else>Add New GN Division</n-h2>
                </n-page-header>
                <n-form ref="formRef" :model="formValue" :rules="rules">
                    <n-form-item label="Name" path="name">
                        <n-input v-model:value="formValue.name" placeholder="Enter Name" />
                    </n-form-item>
                    <n-form-item label="Gn Code" path="gn_code">
                        <n-input v-model:value="formValue.gn_code" placeholder="Gn Code Number" />
                    </n-form-item>
                    <n-form-item label="MPA Code" path="mpa_code">
                        <n-input v-model:value="formValue.mpa_code" placeholder="MPA Code" />
                    </n-form-item>
                    <n-form-item label="Gn Officer" path="gn_officer">
                        <n-dropdown
                            trigger="hover"
                            placement="bottom-start"
                            :options="gnOfficersForDropdown"
                            @select="selectGNOfficer"
                        >
                            <n-button>
                                {{ selectedGNOfficer ? selectedGNOfficer.label : "Select a Gn Officer" }}
                                <n-icon><ArrowDropDownRoundIcon /></n-icon>
                            </n-button>
                        </n-dropdown>
                    </n-form-item>
                    <n-form-item>
                        <n-button @click="save">
                            {{ isNewGNDivision ? "Add GN Division" : "Update GN Division" }}
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

const formRef = ref(null);
const message = useMessage();
const isShowing = ref(false);
const gnOfficerOptions = ref([]);
const emit = defineEmits(["close", "save"]);
const props = defineProps({
    isShowing: Boolean,
    gnDivision: Object,
});
watch(
    () => props.isShowing,
    (newValue) => {
        isShowing.value = newValue;
        formValue.value = { ...props.gnDivision };
    }
);
const formValue = ref({
    id: "",
    name: "",
    gn_code: "",
    mpa_code: "",
    gn_officer: {
        id: "",
        name: "",
        contact_number: "",
    },
});

const rules = {
    name: [
        {required: true, message: "Name is required", trigger: "blur"},
        {min: 2, message: "Name should contain at least two characters", trigger: "blur"}
    ],
    gn_code: [
        {required: true, message: "GN Code is required", trigger: "blur"},
    ],
    mpa_code: [
        {required: true, message: "MPA Code is required", trigger: "blur"},
    ]
};

onMounted(() => {
    fetchGNOfficers();
})

const isNewGNDivision = computed(() => {
    return !formValue.value.id;
});

async function save() {
    formRef.value.validate((errors) => {
        if (!errors) {

            if (isNewGNDivision.value) {
                Http.post(`gnDivision`, formValue.value).then(() => {
                    emit("close");
                    message.success("GN Division added successfully");
                }).catch(() => {
                    message.error("Failed to add GN Division");
                });
            } else {
                Http.put(`gnDivision/${formValue.value.id}`, formValue.value).then(() => {
                    emit("close");
                    message.success("GN Division updated successfully");
                }).catch(() => {
                    message.error("Failed to update GN Division");
                });
            }
        } else {
            message.error("Please fill in all required fields");
        }
    });
}

const fetchGNOfficers = async () => {
    try {
        const response = await Http.get("gnOfficer");
        const data = response.data.data;
        gnOfficerOptions.value = data;
    } catch (error) {
        console.error(error);
    }
};

const gnOfficersForDropdown = computed(() => {
    return gnOfficerOptions.value.map((gnOfficerOption) => {
        return {
            key: gnOfficerOption.id,
            label: gnOfficerOption.name,
        };
    });
});

function selectGNOfficer(key) {
    formValue.value.gn_officer = gnOfficerOptions.value.find(
        (gnOfficerOption) => {
            return gnOfficerOption.id === key;
        }
    );
    formRef.value.restoreValidation("gn_officer");
}

const selectedGNOfficer = computed(() => {
    return gnOfficersForDropdown.value.find((gnOfficerForDropdown) => {
        return gnOfficerForDropdown.key === formValue.value.gn_officer?.id;
    });
});
</script>

<style scoped></style>
