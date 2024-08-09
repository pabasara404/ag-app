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
          <n-h2>Income Assessment Form</n-h2>
        </div>
      </n-page-header>
      <n-form ref="formRef" :rules="rules"  :model="formValue">
          <n-form-item
              v-if="!isNewApplication"
              label="Application Reference Number" path="application_code">
          <n-input
              :disabled="true"
              v-model:value="formValue.application_code"
          />
        </n-form-item>
          <n-form-item label="The Name of the Applicant" path="business_name">
              <n-input
                  :disabled="initialStatus==='Escalated'"
                  v-model:value="formValue.name"
                  placeholder="Ex: Siripala"
              />
          </n-form-item>
          <n-form-item label="The Address of the Applicant" path="address">
          <n-input
              :disabled="initialStatus==='Escalated'"
            v-model:value="formValue.address"
            placeholder="401, Katana, Negombo"
          /> </n-form-item>
          <n-form-item label="National Identity Card Number" path="ownerNic">
              <n-input
                  :disabled="initialStatus==='Escalated'"
                  v-model:value="formValue.nic"
                  placeholder="National Identity Card Number" />
          </n-form-item>
          <n-form-item label="Telephone number" path="contactNumber">
              <n-input
                  :disabled="initialStatus==='Escalated'"
                  v-model:value="formValue.contact_number"
                  placeholder="Telephone number" />
          </n-form-item>
          <n-form-item
              label="Grama Niladari Division"
              path="grama_niladari_division"
          >
              <n-dropdown
                  :disabled="initialStatus==='Escalated'"
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
          <n-form-item label="Purpose for which Certificate is obtained" path="initial_capital">
              <n-input
                  :disabled="initialStatus==='Escalated'"
                  v-model:value="formValue.purpose"
                  placeholder="Purpose for which Certificate is obtained" /></n-form-item>
          <n-form-item label="Institution submitting the Certificate" path="submitting_institute">
              <n-input
                  :disabled="initialStatus==='Escalated'"
                  v-model:value="formValue.submitting_institute"
                  placeholder="Institution submitting the Certificate" /></n-form-item>
          <n-card title="How the income is earned" v-if="isNewApplication">
              <n-p>(Specify Business/Self-Employed Property/Animal Husbandry/Rental Income/Agriculture/Other.)
              </n-p>
              <n-form-item label="Source of Income" path="initial_capital">
                  <n-input
                      :disabled="initialStatus==='Escalated'"
                      v-model:value="incomeDetailsForm.source_of_income"
                      placeholder="Source of Income" /></n-form-item>
              <n-form-item label="Deed/Vehicle Number/Business Registration Number" path="registration_no">
                  <n-input
                      :disabled="initialStatus==='Escalated'"
                      v-model:value="incomeDetailsForm.registration_no"
                      placeholder="Deed/Vehicle Number/Business Registration Number" />
              </n-form-item>
              <n-form-item label="Name of Land/Business Name">
                  <n-input
                      :disabled="initialStatus==='Escalated'"
                      v-model:value="incomeDetailsForm.name"
                      placeholder="Name of Land/Business Name"
                  />
              </n-form-item>
              <n-form-item label="Size">
                  <n-input
                      :disabled="initialStatus==='Escalated'"
                      v-model:value="incomeDetailsForm.size"
                      placeholder="Size"
                  />
              </n-form-item>
              <n-form-item label="Monthly Income in Numbers" path="principal_place">
                  <n-input
                      :disabled="initialStatus==='Escalated'"
                      v-model:value="incomeDetailsForm.monthly_income"
                      placeholder="Monthly Income in Numbers" /></n-form-item>
              <n-form-item label="Annual Income in Numbers" path="principal_place">
                  <n-input
                      :disabled="initialStatus==='Escalated'"
                      v-model:value="incomeDetailsForm.annual_income"
                      placeholder="Annual Income in Numbers" /></n-form-item>
            <n-button :disabled="initialStatus==='Escalated'" @click="addIncomeDetails">Add Income Details</n-button>
          </n-card>
          <br/>

          <br/>
          <n-form-item>
              <n-table :bordered="false" :single-line="false">
                  <thead>
                  <tr>
                      <th>Source of<br> Income</th>
                      <th>Deed/Vehicle No/<br>Business Reg. No</th>
                      <th>Name of Land/<br>Business Name</th>
                      <th>Size</th>
                      <th>Monthly Income</th>
                      <th>Annual Income</th>
                      <th>Remove</th>
                  </tr>
                  </thead>
                  <tbody>
                  <tr :key="key" v-for="(income, key) in formValue.incomes">
                      <td>{{ income.source_of_income}}</td>
                      <td>{{ income.registration_no}}</td>
                      <td>{{ income.name}}</td>
                      <td>{{ income.size}}</td>
                      <td>{{ income.monthly_income}}</td>
                      <td>{{ income.annual_income}}</td>
                      <td><n-button :disabled="initialStatus==='Escalated'" @click="removeIncomeRow(key)">
                          <n-icon>
                              <clear-outlined-icon/>
                          </n-icon>
                      </n-button></td>
                  </tr>
                  </tbody>
              </n-table>
          </n-form-item>
          <n-form-item label="Total of Annual Income" path="principal_place">
              <n-input
                  :disabled="true"
                  v-model:value="totalAnnualIncome"
                  placeholder="Total of Annual Income" />
          </n-form-item>
          <n-form-item label="File No. if paying income tax" path="principal_place">
            <n-input
                :disabled="initialStatus==='Escalated'"
            v-model:value="formValue.income_tax_number"
            placeholder="File No. if paying income tax" />
          </n-form-item>
          <p>I confirm that the above facts are correct and that my income is true.</p><br/>

          <div v-if="!isNewApplication">
              <n-form-item label="If the Applicant is a Samurdhi Beneficiary?" path="otherBusiness">
                  <n-radio-group
                      :disabled="initialStatus==='Pending' || initialStatus==='Escalated'"
                      v-model:value="formValue.is_samurdhi_beneficiary"
                      name="otherBusiness"
                  >
                      <n-space>
                          <n-radio :value="'Yes'" label="Yes"> Yes </n-radio>
                          <n-radio :value="'No'" label="No"> No </n-radio>
                      </n-space>
                  </n-radio-group>
              </n-form-item>

              <n-card v-if="formValue.is_samurdhi_beneficiary === 'Yes'">
                  <n-h3>By Samurdhi Development Officer</n-h3>
                  <n-form-item label="Samurdhi subside amount" path="subside_amount">
                      <n-input
                          :disabled="initialStatus==='Pending' || initialStatus==='Escalated'"
                          v-model:value="samurdhiSubsideAmount"
                          placeholder="Samurdhi subside amount"
                      />
                  </n-form-item>
                  <n-form-item label="Has the Samurdhi subsidiaries been returned or not?" path="otherBusiness">
                      <n-radio-group
                          :disabled="initialStatus==='Pending' || initialStatus==='Escalated'"
                          v-model:value="samurdhiIsSubsidiariesReturned"
                          name="otherBusiness"
                      >
                          <n-space>
                              <n-radio :value="'Yes'" label="Yes"> Yes </n-radio>
                              <n-radio :value="'No'" label="No"> No </n-radio>
                          </n-space>
                      </n-radio-group>
                  </n-form-item>
                  <n-form-item label="Recommendation of Samurdhi Development Officer">
                      <n-input
                          :disabled="initialStatus==='Pending' || initialStatus==='Escalated'"
                          type="textarea"
                          v-model:value="samurdhiRecommendation"
                          placeholder="Recommendation of Samurdhi Development Officer"
                      />
                  </n-form-item>
                  <n-form-item label="Samurdhi Development Officer Checked Date" path="land_deed_date">
                      <n-date-picker
                          :disabled="initialStatus==='Pending' || initialStatus==='Escalated'"
                          v-model:value="selectedSamurdhiCheckedDate" type="date" />
                  </n-form-item>
              </n-card>
          </div>
          <n-card v-if="!isNewApplication">
              <n-h3>By GN Officer</n-h3>
              <n-form-item label="Checked Date" path="land_deed_date">
                      <n-date-picker
                          :disabled="initialStatus==='Pending' || initialStatus==='Escalated' || initialStatus==='Need to Reviewed By Samurdhi Officer'" v-model:value="selectedCheckedDate" type="date" />
              </n-form-item>
              <n-form-item
                  label="Status"
                  path="status"
              >
                  <n-dropdown
                      :disabled="initialStatus==='Pending' || initialStatus==='Escalated'|| initialStatus==='Need to Reviewed By Samurdhi Officer'"
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
              <n-form-item
                  label="Comments"
              >
                  <n-input
                      :disabled="initialStatus==='Pending' || initialStatus==='Escalated'|| initialStatus==='Need to Reviewed By Samurdhi Officer'"
                      type="textarea"
                      v-model:value="formValue.comment"
                      placeholder="Comments"
                  />
              </n-form-item>
              <p>I have personally checked the details and I recommend/ do not recommend issuing the Income Certificate as per
                  the information given above.</p>
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
                <n-button v-if="initialStatus!=='Escalated'" @click="certifyAndSubmit"> {{ isNewApplication? "Certify and Submit" : "Resubmit" }} </n-button>
                <n-button v-if="initialStatus==='Escalated'" type="primary" class="mx-5" @click="updateStatus('Awaiting Payment')">Approve</n-button>
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
} from "@vicons/ionicons5";
import {
  ArrowDropDownRound as ArrowDropDownRoundIcon,
  ClearOutlined as ClearOutlinedIcon,
} from "@vicons/material";
import Http from "@/services/http";
import moment from "moment";
import {getLocalAuthUser} from "@/services/auth.js";

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
    gn_division: {
        id: "74",
        gn_code: "370",
        name: "Kotugoda",
        mpa_code: "204",
    },
    purpose: "Income Certificate Application",
    submitting_institute: "Sample Institute",
    incomes: [
        {
            id: "",
            source_of_income: "Salary",
            registration_no: "REG001",
            name: "Company A",
            size: "Large",
            monthly_income: "100000",
            annual_income: "1200000"
        }
    ],
    total_annual_income: "1800000",
    income_tax_number: "TAX123",
    is_samurdhi_beneficiary: "Yes",
    samurdhi_details: {
        id: "",
        subside_amount: "5000",
        is_subsidiaries_returned: "No",
        recommendation: "Approved",
        checked_date: "2023-05-15"
    },
    checked_date: "2023-01-01",
    status: "Pending",
    submission_timestamp: "2023-07-15 10:00:00",
    checked_time: "10:30:00",
    comment: "This is a test comment",
    application_code: "",
});

const incomeDetailsForm = ref({
    id: "",
    source_of_income: "Business",
    registration_no: "REG002",
    name: "Business B",
    size: "Small",
    monthly_income: "50000",
    annual_income: "600000"
});

const statusOptions = [
    { label: 'Pending', key: 'Pending' },
    { label: 'Escalated', key: 'Escalated' }
];

const selectedStatus = computed(() => {
    if (!formValue.value.status) {
        return { label: "Submitted" };
    }
    return statusOptions.find(statusOption => statusOption.label === formValue.value.status) || { label: formValue.value.status };
});

function handleStatusSelect(selected) {
    console.log(selected);
    formValue.value.status = selected;
}

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
            formValue.value.status = "Need to Reviewed By Samurdhi Officer";
            await Http.post("incomeCertificate", formValue.value);
            message.success("Application was submitted successfully!");
            emit("close", false);
            return;
        }
        if ((props.initialStatus === "Pending" && formValue.value.status === "Pending")) {
            formValue.value.status = "Resubmitted";
        }
        if (props.initialStatus === "Need to Reviewed By Samurdhi Officer" && formValue.value.status === "Need to Reviewed By Samurdhi Officer") {
            formValue.value.status = "Need to Reviewed By GN Officer";
        }
        if (props.initialStatus === "Need to Reviewed By GN Officer" && formValue.value.status === "Need to Reviewed By GN Officer") {
            formValue.value.status = "Escalated";
        }
        await Http.put(`incomeCertificate/${formValue.value.id}`, formValue.value);
        message.success("Application was updated successfully!");
        emit("close", false);
    }catch (e) {
    console.error(e);
    message.error("An error occurred while saving the Application");
}
}

const updateStatus = async (status) => {
    try {
        await Http.put(`incomeCertificate/${props.application.id}/status`, {
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

const selectedCheckedDate = computed({
    get: () => {
        const checkedDate = formValue.value.checked_date;
        return moment(checkedDate, "YYYY-MM-DD").isValid()
            ? moment(checkedDate).toDate()
            : null;
    },
    set: (date) => {
        formValue.value.checked_date = moment(date).format("YYYY-MM-DD");
    }
});

const selectedSamurdhiCheckedDate = computed({
    get: () => {
        const samurdhiCheckedDate = formValue.value.samurdhi_details?.checked_date;
        return moment(samurdhiCheckedDate, "YYYY-MM-DD").isValid()
            ? moment(samurdhiCheckedDate).toDate()
            : null;
    },
    set: (date) => {
        if (!formValue.value.samurdhi_details) {
            formValue.value.samurdhi_details = {};
        }
        formValue.value.samurdhi_details.checked_date = moment(date).format("YYYY-MM-DD");
    }
});

const samurdhiSubsideAmount = computed({
    get: () => formValue.value.samurdhi_details?.subside_amount || '',
    set: (value) => {
        if (!formValue.value.samurdhi_details) {
            formValue.value.samurdhi_details = {};
        }
        formValue.value.samurdhi_details.subside_amount = value;
    }
});

const samurdhiIsSubsidiariesReturned = computed({
    get: () => formValue.value.samurdhi_details?.is_subsidiaries_returned || false,
    set: (value) => {
        if (!formValue.value.samurdhi_details) {
            formValue.value.samurdhi_details = {};
        }
        formValue.value.samurdhi_details.is_subsidiaries_returned = value;
    }
});

const samurdhiRecommendation = computed({
    get: () => formValue.value.samurdhi_details?.recommendation || '',
    set: (value) => {
        if (!formValue.value.samurdhi_details) {
            formValue.value.samurdhi_details = {};
        }
        formValue.value.samurdhi_details.recommendation = value;
    }
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


const totalAnnualIncome = computed(() => {
    return formValue.value.incomes.reduce((acc, income) => acc + parseInt(income.annual_income), 0);
});

const addIncomeDetails = () => {
    formValue.value.incomes.push({...incomeDetailsForm.value});
    formValue.value.total_annual_income = totalAnnualIncome.value;
    clearDetailsForm();
};

const clearDetailsForm = () => {
  incomeDetailsForm.value.registration_no = "";
  incomeDetailsForm.value.source_of_income = "";
  incomeDetailsForm.value.registration_no = "";
  incomeDetailsForm.value.name = "";
  incomeDetailsForm.value.size = "";
  incomeDetailsForm.value.monthly_income = "";
  incomeDetailsForm.value.annual_income = "";
};

const removeIncomeRow = (index) => {
    formValue.value.incomes.splice(index, 1);
    formValue.value.total_annual_income = totalAnnualIncome.value;
};


</script>

<style scoped></style>
