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
      <n-form ref="formRef" :model="formValue">
          <n-form-item
              label="Application Reference Number" path="application_code">
          <n-input
              :disabled="initialStatus==='Escalated'||initialStatus==='Approved'"
              v-model:value="formValue.application_code"
          />
        </n-form-item>
          <n-form-item label="The Name of the Applicant" path="business_name">
              <n-input
                  :disabled="initialStatus==='Escalated'||initialStatus==='Approved'"
                  v-model:value="formValue.name"
                  placeholder="Ex: Siripala"
              />
          </n-form-item>
          <n-form-item label="The Address of the Applicant" path="address">
          <n-input
              :disabled="initialStatus==='Escalated'||initialStatus==='Approved'"
            v-model:value="formValue.address"
            placeholder="401, Katana, Negombo"
          /> </n-form-item>
          <n-form-item label="National Identity Card Number" path="ownerNic">
              <n-input
                  :disabled="initialStatus==='Escalated'||initialStatus==='Approved'"
                  v-model:value="formValue.nic"
                  placeholder="National Identity Card Number" />
          </n-form-item>
          <n-form-item label="Telephone number" path="contactNumber">
              <n-input
                  :disabled="initialStatus==='Escalated'||initialStatus==='Approved'"
                  v-model:value="formValue.contact_number"
                  placeholder="Telephone number" />
          </n-form-item>
          <n-form-item
              label="Grama Niladari Division"
              path="grama_niladari_division"
          >
              <n-dropdown
                  :disabled="initialStatus==='Escalated'||initialStatus==='Approved'"
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
                      :disabled="initialStatus==='Pending' || initialStatus==='Escalated'||initialStatus==='Approved'"
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
                      :disabled="initialStatus==='Pending' || initialStatus==='Escalated'||initialStatus==='Approved'"
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
                      :disabled="initialStatus==='Pending' || initialStatus==='Escalated'||initialStatus==='Approved'"
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
            <v-file-input @update:modelValue=handleFiles clearable label="Upload files" multiple variant="outlined"></v-file-input>

        </n-form-item >
          <v-list v-if="!isNewApplication" lines="one">
              <v-list-item
                  v-for="fileDetail in formValue.file_details"
                  :key="fileDetail.id"
                  :title="fileDetail.name"
              ><n-button @click="handleDownload(fileDetail.path, fileDetail.name)">Download</n-button></v-list-item>
          </v-list>
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
  ArrowDropDownRound as ArrowDropDownRoundIcon
} from "@vicons/material";
import Http from "@/services/http";
import {getLocalAuthUser} from "@/services/auth.js";
import { useCookies } from "vue3-cookies";

const submittedApplicationId = ref(0);
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
    user: getLocalAuthUser()
});


const rules = {
    name: [
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
    nic: [
        { required: true, message: "NIC is required", trigger: "blur" },
        {
            pattern: /^(?:\d{9}[vVxX]|\d{12})$/,
            message: "NIC should be in the old format (9 digits followed by a letter) or the new format (12 digits)",
            trigger: "blur"
        }
    ]
};


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

const fileList = ref([]);


watch(
  () => props.isShowing,
  (newValue) => {
    isShowing.value = newValue;
    formValue.value = {...props.application };
  }
);
async function certifyAndSubmit() {
    try {
        if (isNewApplication.value) {
            formValue.value.status = "Submitted";
            const { data } = await Http.post("mahapolaApplication", formValue.value);

            for (const file of fileList.value) {
                let formData = new FormData();
                formData.append("file", file);
                await Http.post(`mahapolaApplication/upload?id=${data.id}`, formData, {
                    headers: {
                        'Content-Type': 'multipart/form-data'
                    }
                })
            }
            message.success("Application was submitted successfully!");
            emit("close", false);
            return;
        }
        if (props.initialStatus === "Pending" && formValue.value.status === "Pending") {
            formValue.value.status = "Resubmitted";
        }
        await Http.put(`mahapolaApplication/${formValue.value.id}`, formValue.value);
        message.success("Application was updated successfully!");
        emit("close", false);
    }catch (e) {
        console.error(e);
        message.error("An error occurred while saving the Application");
    }
}

const updateStatus = async (status) => {
    try {
        await Http.put(`mahapolaApplication/${props.application.id}`, {
            status: status
        });
        message.success("Application was updated successfully!");
        emit('save');
        emit('close', false);
    } catch (error) {
        console.error("Failed to update status:", error);
        message.error("An error occurred while saving the Application");
    }
};

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

function handleFiles(files){
    fileList.value = files;

}

async function handleDownload(path, name ) {
    await Http({
        url: `mahapolaApplication/download?path=${path}&name=${name}`,
        method: "GET",
        responseType: "blob", // important
    }).then((response) => {
        // Service that handles ajax call
        const url = window.URL.createObjectURL(new Blob([response.data]));
        const link = document.createElement("a");
        link.href = url;
        link.setAttribute("download", name);
        document.body.appendChild(link);
        link.click();
        link.remove();
    });
}

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
