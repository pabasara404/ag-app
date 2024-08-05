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
        <n-page-header
          ><n-h2 v-if="!isNewCitizen">Edit Citizen</n-h2>
          <n-h2 v-else>Add New Citizen</n-h2>
        </n-page-header>
        <n-form ref="formRef" :model="formValue" :rules="rules">
          <n-form-item label="Full Name"  path="user.name">
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
          <n-form-item label="NIC" path="nic">
            <n-input v-model:value="formValue.nic" placeholder="NIC" />
          </n-form-item>
          <n-form-item label="Address">
            <n-input
              type="textarea"
              v-model:value="formValue.address"
              maxlength="255"
              show-count
            />
          </n-form-item>
          <n-form-item label="Date of Birth">
            <n-date-picker v-model:value="selectedDOB" type="date" />
          </n-form-item>
          <n-form-item>
            <n-button @click="save">
              {{ isNewCitizen ? "Add Citizen" : "Update Citizen" }}
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
import Http from "@/services/http";
import moment from "moment";

const formRef = ref(null);
const message = useMessage();
const isShowing = ref(false);
const emit = defineEmits(["close", "save"]);
const props = defineProps({
  isShowing: Boolean,
  citizen: Object,
});
watch(
  () => props.isShowing,
  (newValue) => {
    isShowing.value = newValue;
    formValue.value = { ...props.citizen };
  }
);
const formValue = ref({
  id: "",
  name: "",
  nic: "",
  address: "",
  contact_number: "",
    user: {
        name: "",
        email: "",
        role_id: "3",
    },
  date_of_birth: "",
});

watch(
    () => props.isShowing,
    (newValue) => {
        isShowing.value = newValue;
        formValue.value = { ...props.citizen };
        if (!formValue.value.user) {
            formValue.value.user = {
                name: "",
                email: "",
                role_id: "3",
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
        {required: true, type: 'email', message: "Email should be a valid email address", trigger: ["input", "blur"]}
    ],
    nic: [
        {required: true, message: "NIC is required", trigger: "blur"},
        {
            pattern: /^(?:\d{9}[vVxX]|\d{12})$/,
            message: "NIC should be in the old format (9 digits followed by a letter) or the new format (12 digits)",
            trigger: "blur"
        }
    ],
    date_of_birth: [
        {
            validator(rule, value) {
                if (!value) {
                    return Promise.resolve();
                }
                const today = new Date();
                const selectedDate = new Date(value);
                if (selectedDate > today) {
                    return Promise.reject("Date of birth cannot be a future date");
                }
                return Promise.resolve();
            },
            trigger: "blur"
        }
    ]
};

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

const isNewCitizen = computed(() => {
  return !formValue.value.id;
});

async function save() {
    try{

        await formRef.value.validate();
        if (isNewCitizen.value) {
            const emailResponse = await Http.post("checkEmail", {email: formValue.value.user.email});
            if (emailResponse.data.exists) {
                message.error("Email already exists!");
                return;
            }
            const nicResponse = await Http.post("checkNic", {nic: formValue.value.nic});
            if (nicResponse.data.exists) {
                message.error("NIC already exists!");
                return;
            }
            const response = await Http.post(`citizen`, formValue.value);
            if (response.status === 204) {
                message.success("Citizen added successfully. An email has been sent to set the password.");
            }
            emit("close",false);
        }else{
                await Http.put(`citizen/${formValue.value.id}`, formValue.value);
                emit("close",false);
            }
        }catch(error){
            message.error("Failed to save employee data.");
            console.error(error);
        }
  }

</script>

<style scoped></style>
