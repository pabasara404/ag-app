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
          ><n-h2 v-if="!isNewGNDivision">Edit GN Division</n-h2>
          <n-h2 v-else>Add New GN Division</n-h2>
        </n-page-header>
        <n-form ref="formRef" :model="formValue">
          <n-form-item label="Name" path="user.name">
            <n-input v-model:value="formValue.name" placeholder="Enter Name" />
          </n-form-item>
          <n-form-item label="Gn Code" path="gn_code">
            <n-input
              v-model:value="formValue.gn_code"
              placeholder="Gn Code Number"
            />
          </n-form-item>
          <n-form-item label="MPA Code" path="mpa_code">
            <n-input v-model:value="formValue.mpa_code" placeholder="MPA Code" />
          </n-form-item>
          <n-form-item label="Gn Officer" path="gnOfficer">
            <n-dropdown
              trigger="hover"
              placement="bottom-start"
              :options="gnOfficersForDropdown"
              @select="selectGNOfficer"
            >
              <n-button
                >{{selectedGNOfficer ? selectedGNOfficer.label : "Select a Gn Officer" }} <n-icon><ArrowDropDownRoundIcon /></n-icon
              ></n-button>
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
    formValue.value = { ...props.gnDivision};
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
    fetchGNOfficers();
})

const isNewGNDivision = computed(() => {
  return !formValue.value.id;
});

async function save() {
  if (isNewGNDivision.value) {
    await Http.post(`gnDivision`, formValue.value);
    emit("close");

    return;
  }

  await Http.put(`gnDivision/${formValue.value.id}`, formValue.value);
  emit("close");
}
function handleSelect(key) {
  message.info(String(key));
}

const fetchGNOfficers = async () => {
    try {
        const response = await Http.get("gnOfficer");
        const data = response.data.data;
        // console.log(data);
        gnOfficerOptions.value = data;
        console.log(gnOfficerOptions.value);
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
}

const selectedGNOfficer = computed(() => {
    return gnOfficersForDropdown.value.find((gnOfficerForDropdown) => {
        return gnOfficerForDropdown.key === formValue.value.gn_officer?.id;
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
