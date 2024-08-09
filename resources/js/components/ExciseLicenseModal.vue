<template>
  <n-modal
    v-model:show="isShowing"
    preset="card"
    style="width: 800px"
    :on-update:show="(value) => emit('close', value)"
  >
    <n-layout style="padding-left: 8px">
      <n-page-header>
        <div class="flex justify-between ...">
          <n-h2>Excise Licence Form</n-h2>
        </div>
      </n-page-header>
      <n-form ref="formRef" :model="formValue">
          <n-form-item
              label="Application Reference Number" path="application_code">
          <n-input
              :disabled="initialStatus==='Active'"
              v-model:value="formValue.application_code"
          />
        </n-form-item>
          <n-form-item label="The Name of the Applicant" path="business_name">
              <n-input
                  :disabled="initialStatus==='Active'"
                  v-model:value="formValue.name"
                  placeholder="Ex: Siripala"
              />
          </n-form-item>
          <n-form-item label="The Address of the Applicant" path="address">
          <n-input
              :disabled="initialStatus==='Active'"
            v-model:value="formValue.address"
            placeholder="401, Katana, Negombo"
          /> </n-form-item>
          <n-form-item label="National Identity Card Number" path="ownerNic">
              <n-input
                  :disabled="initialStatus==='Active'"
                  v-model:value="formValue.nic"
                  placeholder="National Identity Card Number" />
          </n-form-item>
          <n-form-item label="Name of the Business" path="business_name">
              <n-input
                  :disabled="initialStatus==='Active'"
                  v-model:value="formValue.business_name"
                  placeholder="Name of the Business" />
          </n-form-item>
          <n-form-item label="Telephone number" path="contactNumber">
              <n-input
                  :disabled="initialStatus==='Active'"
                  v-model:value="formValue.contact_number"
                  placeholder="Telephone number" />
          </n-form-item>
          <n-form-item
              label="Grama Niladari Division"
              path="grama_niladari_division"
          >
              <n-dropdown
                  :disabled="initialStatus==='Active'"
                  trigger="hover"
                  placement="bottom-start"
                  :options="gnDivisionsForDropdown"
                  @select="selectGramaNiladariDivision"
              >
                  <n-button
                  >{{
                          selectedGramaNiladariDivision
                              ? selectedGramaNiladariDivision.label
                              : "Select an option"
                      }}
                      <n-icon><ArrowDropDownRoundIcon /></n-icon>
                  </n-button>
              </n-dropdown>
          </n-form-item>
              <n-form-item
                  label="Status"
                  path="status"
              >
                  <n-dropdown
                      :disabled="initialStatus==='Active'"
                      trigger="hover"
                      placement="bottom-start"
                      :options="statusOptions"
                      @select="handleStatusSelect"
                  >
                      <n-button
                      >{{
                              selectedStatus
                                  ? selectedStatus.label
                                  : "Change the Status"
                          }}
                          <n-icon><ArrowDropDownRoundIcon /></n-icon>
                      </n-button>
                  </n-dropdown>
              </n-form-item>
              <n-form-item label="Date of Issue" path="nature">
                  <n-date-picker
                      :disabled="initialStatus==='Active'" v-model:value="selectedIssuedDate" type="date" /> </n-form-item>
              <n-form-item label="Date  of Expire" path="nature">
                  <n-date-picker
                      :disabled="initialStatus==='Active'" v-model:value="selectedExpireDate" type="date" /> </n-form-item>

         <n-p>Upload following documents:

              <n-p>Required documents to obtain an income certificate:</n-p>
              <n-ul>
                  <n-li>1. To confirm the source of income </n-li>
                  <n-li>2. If the business is not located in the domain of residence, a report from the village officer of the division where it is located must also be submitted.</n-li>
              </n-ul>
        </n-p>
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
        <n-p
          >I certify that I have the legal right to the land related to felling
          of trees and that there is no dispute, that the above information is
          true and that I will take full responsibility if any problem
          arises.</n-p
        >
        <div class="flex justify-end">
            <n-form-item>
                <n-button v-if="initialStatus!=='Active'" @click="certifyAndSubmit"> {{ isNewApplication? "Certify and Submit" : "Resubmit" }} </n-button>
            </n-form-item>
        </div>
      </n-form>
    </n-layout>
    <template #footer></template>
  </n-modal>
  <n-back-top :right="100" />
</template>

<script setup>
import { computed, ref, watch, onMounted, defineEmits } from "vue";
import { NButton, useMessage } from "naive-ui";
import {
  ArchiveOutline as ArchiveIcon,
} from "@vicons/ionicons5";
import {
  ArrowDropDownRound as ArrowDropDownRoundIcon,
  ClearOutlined as ClearOutlinedIcon,
} from "@vicons/material";
import Http from "@/services/http";
import moment from "moment";

const formRef = ref(null);
const message = useMessage();
const isShowing = ref(false);
const emit = defineEmits(["close", "save"]);
const props = defineProps({
    isShowing: Boolean,
    application: Object,
    initialStatus: String
});

const GNDivisionOptions = ref([]);

const formValue = ref({
    id: "",
    name: "John Doe",
    address: "123 Main St, Colombo",
    nic: "123456789V",
    contact_number: "0712345678",
    business_name: "Will's Bar",
    issued_date: "",
    expire_date: "",
    gn_division: {
        id: "74",
        gn_code: "370",
        name: "Kotugoda",
        mpa_code: "204",
    },
    status: "Active",
    submission_timestamp: "2023-07-15 10:00:00",
    comment: "This is a test comment",
    application_code: "",
});

const statusOptions = [
    { label: 'Active', key: 'Active' },
    { label: 'Expired', key: 'Expired' }
];

const selectedStatus = computed(() => {
    if (!formValue.value.status) {
        return { label: "Active" };
    }
    return statusOptions.find(statusOption => statusOption.label === formValue.value.status) || { label: formValue.value.status };
});

function handleStatusSelect(selected) {
    console.log(selected);
    formValue.value.status = selected;
}

watch(
  () => props.isShowing,
  (newValue) => {
    isShowing.value = newValue;
    formValue.value = {...props.application };
  }
);
async function certifyAndSubmit() {
    try{
        if (isNewApplication.value) {
            formValue.value.status = "Active";
            await Http.post("exciseApplication", formValue.value);
            message.success("Application was submitted successfully!");
            emit("close", false);
            return;
        }
        if (props.initialStatus === "Pending" && formValue.value.status === "Pending") {
            formValue.value.status = "Resubmitted";
        }
        await Http.put(`exciseApplication/${formValue.value.id}`, formValue.value);
        message.success("Application was updated successfully!");
        emit("close", false);
    }catch (e) {
        console.error(e);
        message.error("An error occurred while saving the Application");
    }
}

const updateStatus = async (status) => {
    try {
        await Http.put(`exciseApplication/${props.application.id}`, {
            status: status
        });
        emit('save');
        emit('close', false);
    } catch (error) {
        console.error("Failed to update status:", error);
    }
};

const selectedIssuedDate = computed({
    get: () => {
        const issuedDate = formValue.value.issued_date;
        return moment(issuedDate, "YYYY-MM-DD").isValid()
            ? moment(issuedDate).valueOf()
            : null;
    },
    set: (epoch) => {
        formValue.value.issued_date = moment
            .unix(epoch / 1000)
            .format("YYYY-MM-DD");
    },
});

const selectedExpireDate = computed({
    get: () => {
        const expireDate = formValue.value.expire_date;
        return moment(expireDate, "YYYY-MM-DD").isValid()
            ? moment(expireDate).valueOf()
            : null;
    },
    set: (epoch) => {
        formValue.value.expire_date = moment
            .unix(epoch / 1000)
            .format("YYYY-MM-DD");
    },
});

const isNewApplication = computed(() => {
  return !formValue.value.id;
});

const gnDivisionsForDropdown = computed(() => {
  return GNDivisionOptions.value.map((gnDivisionOption) => {
    return {
      key: gnDivisionOption.id,
      label: gnDivisionOption.name,
    };
  });
});

const selectedGramaNiladariDivision = computed(() => {
  return gnDivisionsForDropdown.value.find((gnDivisionForDropdown) => {
    return (
      gnDivisionForDropdown.key === formValue.value.gn_division.id
    );
  });
});

onMounted(() => {
  fetchGnDivisions();
});

const fetchGnDivisions = async () => {
  try {
    const response = await Http.get("gnDivision");
    const data = response.data.data;
    GNDivisionOptions.value = data;
  } catch (error) {
    console.error(error);
  }
};

function selectGramaNiladariDivision(key) {
  formValue.value.gn_division = GNDivisionOptions.value.find(
    (GNDivisionOption) => {
      return GNDivisionOption.id === key;
    }
  );
}

</script>

<style scoped></style>
