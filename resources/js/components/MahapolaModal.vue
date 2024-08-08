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
          <n-h2>Mahapola Application Form</n-h2>
        </div>
      </n-page-header>
<!--        v-if="props.initialStatus === 'issued'"-->
<!--        <n-watermark-->

<!--            image="../../images/Emblem_of_Sri_Lanka.svg.png"-->
<!--            cross-->
<!--            fullscreen-->
<!--            :font-size="16"-->
<!--            :line-height="16"-->
<!--            :width="384"-->
<!--            :height="384"-->
<!--            :x-offset="12"-->
<!--            :y-offset="0"-->
<!--            :image-width="64"-->
<!--            :image-opacity="0.24"-->
<!--        />-->
<!--   v-if="initialStatus === 'issued'"-->
      <n-form ref="formRef" :model="formValue">
          <n-form-item
              label="Application Reference Number" path="application_code">
          <n-input
              v-model:value="formValue.application_code"
          />
        </n-form-item>
          <n-form-item label="The Name of the Applicant" path="business_name">
              <n-input
                  v-model:value="formValue.name"
                  placeholder="Ex: Siripala"
              />
          </n-form-item>
          <n-form-item label="The Address of the Applicant" path="address">
          <n-input
            v-model:value="formValue.address"
            placeholder="401, Katana, Negombo"
          /> </n-form-item>
          <n-form-item label="National Identity Card Number" path="ownerNic">
              <n-input
                  v-model:value="formValue.nic"
                  placeholder="National Identity Card Number" />
          </n-form-item>
          <n-form-item label="Telephone number" path="contactNumber">
              <n-input
                  v-model:value="formValue.contact_number"
                  placeholder="Telephone number" />
          </n-form-item>
          <n-form-item
              label="Grama Niladari Division"
              path="grama_niladari_division"
          >
              <n-dropdown
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
          <n-card v-if="!isNewApplication">
              <n-h3>By GN Officer</n-h3>
                  <n-form-item
                      label="Any comment about application"
                  >
                  <n-input
                      type="textarea"
                      v-model:value="formValue.comment"
                      placeholder="Any comment about application"
                      />
                  </n-form-item>
                    <n-form-item
                  label="Grama Niladari Division"
                  path="grama_niladari_division"
                    >
                  <n-dropdown
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
          </n-card>
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
            action="api/mahapolaApplication/upload"
            :max="5"
            :with-credentials=true
            :headers="{
                'Content-Type': 'multipart/form-data',
                'X-CSRF-TOKEN': csrf
              }"
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
                <n-button v-if="initialStatus!=='Escalated'" @click="certifyAndSubmit"> {{ isNewApplication? "Certify and Submit" : "Resubmit" }} </n-button>
                <n-button v-if="initialStatus==='Escalated'" type="primary" class="mx-5" @click="updateStatus('Approved')">Approve</n-button>
                <n-button v-if="initialStatus==='Escalated'" type="error" @click="updateStatus('Rejected')">Reject</n-button>
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
  InformationCircleOutline as InformationCircleOutlineIcon,
} from "@vicons/ionicons5";
import {
  ArrowDropDownRound as ArrowDropDownRoundIcon,
  ClearOutlined as ClearOutlinedIcon,
} from "@vicons/material";
import Http from "@/services/http";
import moment from "moment";
import {getLocalAuthUser} from "@/services/auth.js";
import { useCookies } from "vue3-cookies";

const formRef = ref(null);
const message = useMessage();
const isShowing = ref(false);
const emit = defineEmits(["close", "save"]);
const props = defineProps({
    isShowing: Boolean,
    application: Object,
    initialStatus: String
});

const { cookies } = useCookies();

const GNDivisionOptions = ref([]);

const formValue = ref({
    id: "",
    name: "John Doe",
    address: "123 Main St, Colombo",
    nic: "123456789V",
    contact_number: "0712345678",
    gn_division: {
        id: "74",
        gn_code: "370",
        name: "Kotugoda",
        mpa_code: "204",
    },
    status: "Submitted",
    submission_timestamp: "2023-07-15 10:00:00",
    comment: "This is a test comment",
    application_code: "bsdgh454564",
});

const statusOptions = [
    { label: 'Pending', key: 'Pending' },
    { label: 'Escalated', key: 'Escalated' }
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

watch(
  () => props.isShowing,
  (newValue) => {
    isShowing.value = newValue;
    formValue.value = {...props.application };
  }
);
async function certifyAndSubmit() {
    if (isNewApplication.value) {
        formValue.value.status = "Submitted";
        await Http.post("mahapolaApplication", formValue.value);
        emit("close", false);
        return;
    }
    if (props.initialStatus === "Pending" && formValue.value.status === "Pending") {
        formValue.value.status = "Resubmitted";
    }
    await Http.put(`mahapolaApplication/${formValue.value.id}`, formValue.value);
    emit("close", false);
}

const updateStatus = async (status) => {
    try {
        await Http.put(`mahapolaApplication/${props.application.id}`, {
            status: status
        });
        emit('save');
        emit('close', false);
    } catch (error) {
        console.error("Failed to update status:", error);
    }
};

const csrf = computed(()=>{
    return cookies.get('XSRF-TOKEN');
})

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
    console.log(cookies.get('XSRF-TOKEN'));
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
