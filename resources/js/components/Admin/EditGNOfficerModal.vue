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
          ><n-h2 v-if="!isNewGNOfficer">Edit GNOfficer</n-h2>
          <n-h2 v-else>Add New GNOfficer</n-h2>
          <n-icon size="25"><CloseIcon /></n-icon>
        </n-page-header>
        <n-form ref="formRef" :model="formValue">
          <n-form-item label="Name" path="user.Name">
            <n-input v-model:value="formValue.name" placeholder="Enter Name" />
          </n-form-item>
          <n-form-item label="Phone" path="phone">
            <n-input
              v-model:value="formValue.contact_number"
              placeholder="Phone Number"
            />
          </n-form-item>
          <n-form-item>
            <n-button @click="save">
              {{ isNewGNOfficer ? "Add GNOfficer" : "Update GNOfficer" }}
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
  GNOfficer: Object,
});

const formValue = ref({
    id: "",
    name: "",
    contact_number: "",
});

watch(
  () => props.isShowing,
  (newValue) => {
    isShowing.value = newValue;
    formValue.value = { ...props.GNOfficer };
  }
);

const rules = {
  user: {
    Name: {
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

const isNewGNOfficer = computed(() => {
  return !formValue.value.id;
});

async function save() {
  if (isNewGNOfficer.value) {
    await Http.post(`gnOfficer`, formValue.value);
    emit("close");

    return;
  }

  await Http.put(`gnOfficer/${formValue.value.id}`, formValue.value);
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
