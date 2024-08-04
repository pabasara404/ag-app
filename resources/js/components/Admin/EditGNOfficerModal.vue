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
        <n-page-header
          ><n-h2 v-if="!isNewGNOfficer">Edit GNOfficer</n-h2>
          <n-h2 v-else>Add New GNOfficer</n-h2>
        </n-page-header>
        <n-form ref="formRef" :model="formValue" :rules="rules">
          <n-form-item label="Name" path="user.name">
            <n-input v-model:value="formValue.user.name" placeholder="Enter Name" />
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
    user: {
        name: "",
        email: "",
        role_id: "2",
    },
});

watch(
  () => props.isShowing,
  (newValue) => {
    isShowing.value = newValue;
    formValue.value = { ...props.GNOfficer };
      if (!formValue.value.user) {
          formValue.value.user = {
              name: "",
              email: "",
              role_id: "2",
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
    contact_number: [
        {
            pattern: /^(?:\+94|0094|0)\d{9}$/,
            message: "Phone number should be in the format +94xxxxxxxxx, 0094xxxxxxxxx, or 0xxxxxxxxx",
            trigger: "blur"
        }
    ],
    'user.email': [
        { required: true, type: 'email', message: "Email should be a valid email address", trigger: ["input", "blur"]}
    ]
};


const isNewGNOfficer = computed(() => {
  return !formValue.value.id;
});

async function save() {
    try {
        await formRef.value.validate();
        if (isNewGNOfficer.value) {
          const emailResponse = await Http.post("checkEmail", {email: formValue.value.user.email});
          if (emailResponse.data.exists) {
              message.error("Email already exists!");
              return;
          }

          const response = await Http.post(`gnOfficer`, formValue.value);
          if (response.status === 204) {
              message.success("Employee added successfully. An email has been sent to set the password.");
          }
        }else{
              await Http.put(`gnOfficer/${formValue.value.id}`, formValue.value);
              message.success("Employee updated successfully.");
          }
          emit("close", false);
    } catch(error){
        message.error("Failed to save employee data.");
        console.error(error);
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
