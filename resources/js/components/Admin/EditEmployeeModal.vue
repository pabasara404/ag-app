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
          ><n-h2 v-if="!isNewEmployee">Edit Employee</n-h2>
          <n-h2 v-else>Add New Employee</n-h2>
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
              :options="rolesForDropdown"
              @select="selectRole"
            >
              <n-button
                >{{selectedRole ? selectedRole.label : "Select a Role" }} <n-icon><ArrowDropDownRoundIcon /></n-icon
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
import { computed, ref, watch, onMounted } from "vue";
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
const roleOptions = ref([]);
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
  user: {
      name: "",
      email: "",
      password: "",
      role_id: "",
  },
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

onMounted(()=>{
    fetchRoles();
})

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
    emit("close", false);

    return;
  }

  await Http.put(`employee/${formValue.value.id}`, formValue.value);
  emit("close");
}
function handleSelect(key) {
  message.info(String(key));
}

const fetchRoles = async () => {
    try {
        const response = await Http.get("role");
        const data = response.data.data;
        // console.log(data);
        roleOptions.value = data;
        console.log(roleOptions.value);
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
    formValue.value.role = roleOptions.value.find(
        (roleOption) => {
            return roleOption.id === key;
        }
    );
}
const selectedRole = computed(() => {
    return rolesForDropdown.value.find((roleForDropdown) => {
        return (
            roleForDropdown.key === formValue.value?.role?.id
        );
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
