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
        <n-page-header
          ><n-h2 v-if="!isNewEmployee">Edit Employee</n-h2>
          <n-h2 v-else>Add New Employee</n-h2>
          <n-icon size="25"><CloseIcon /></n-icon>
        </n-page-header>
        <n-form ref="formRef" :model="formValue">
          <n-form-item label="First Name" path="user.firstName">
            <n-input v-model:value="formValue.name" placeholder="Enter Name" />
          </n-form-item>
          <n-form-item label="Phone" path="phone">
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
              <n-button
                >Role <n-icon><ArrowDropDownRoundIcon /></n-icon
              ></n-button>
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

async function save() {
  if (isNewEmployee.value) {
    await Http.post(`employee`, formValue.value);
    emit("close");

    return;
  }

  await Http.put(`employee/${formValue.value.id}`, formValue.value);
  emit("close");
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
