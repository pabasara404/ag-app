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
              :disabled="true"
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
          <n-form-item label="Purpose for which Certificate is obtained" path="initial_capital">
              <n-input
                  v-model:value="formValue.purpose"
                  placeholder="Purpose for which Certificate is obtained" /></n-form-item>
          <n-form-item label="Institution submitting the Certificate" path="submitting_institute">
              <n-input
                  v-model:value="formValue.submitting_institute"
                  placeholder="Institution submitting the Certificate" /></n-form-item>
          <n-card title="How the income is earned">
              <n-p>(Specify Business/Self-Employed Property/Animal Husbandry/Rental Income/Agriculture/Other.)
              </n-p>
              <n-form-item label="Source of Income" path="initial_capital">
                  <n-input
                      v-model:value="incomeDetailsForm.source_of_income"
                      placeholder="Source of Income" /></n-form-item>
              <n-form-item label="Deed/Vehicle Number/Business Registration Number" path="registration_no">
                  <n-input
                      v-model:value="incomeDetailsForm.registration_no"
                      placeholder="Deed/Vehicle Number/Business Registration Number" />
              </n-form-item>
              <n-form-item label="Name of Land/Business Name">
                  <n-input
                      v-model:value="incomeDetailsForm.name"
                      placeholder="Name of Land/Business Name"
                  />
              </n-form-item>
              <n-form-item label="Size">
                  <n-input
                      v-model:value="incomeDetailsForm.size"
                      placeholder="Size"
                  />
              </n-form-item>
              <n-form-item label="Monthly Income in Numbers" path="principal_place">
                  <n-input
                      v-model:value="incomeDetailsForm.monthly_income"
                      placeholder="Monthly Income in Numbers" /></n-form-item>
              <n-form-item label="Annual Income in Numbers" path="principal_place">
                  <n-input
                      v-model:value="incomeDetailsForm.annual_income"
                      placeholder="Annual Income in Numbers" /></n-form-item>
          </n-card>
          <br/>
          <n-button @click="addIncomeDetails">Add Income Details</n-button>

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
                      <td><n-button @click="removeIncomeRow(key)">
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
                  v-model:value="formValue.total_annual_income"
                  placeholder="Total of Annual Income" />
          </n-form-item>
          <n-form-item label="File No. if paying income tax" path="principal_place">
            <n-input
            v-model:value="formValue.income_tax_number"
            placeholder="File No. if paying income tax" />
          </n-form-item>
          <p>I confirm that the above facts are correct and that my income is true.</p><br/>
          <n-form-item label="If the Applicant is a Samurdhi Beneficiary?" path="otherBusiness">
              <n-radio-group
                  v-model:value="formValue.is_samurdhi_beneficiary"
                  name="otherBusiness"
              >
                  <n-space>
                      <n-radio :value="true" label="Yes"> Yes </n-radio>
                      <n-radio :value="false" label="No"> No </n-radio>
                  </n-space>
              </n-radio-group>
          </n-form-item>
          <div v-if="formValue.is_samurdhi_beneficiary">
          <n-card>
              <n-h3>By Samurdhi Development Officer</n-h3>
              <n-form-item label="If the Applicant is from a Samurdhi Beneficiary family?" path="otherBusiness">
                  <n-radio-group
                      v-model:value="formValue.samurdhi_details.is_samurdhi_beneficiary"
                      name="otherBusiness"
                  >
                      <n-space>
                          <n-radio :value="true" label="Yes"> Yes </n-radio>
                          <n-radio :value="false" label="No"> No </n-radio>
                      </n-space>
                  </n-radio-group>
              </n-form-item>
              <n-form-item label="Samurdhi subside amount" path="principal_place">
                  <n-input
                      v-model:value="formValue.samurdhi_details.subside_amount"
                      placeholder="Samurdhi subside amount" />
              </n-form-item>
              <n-form-item label="Has the Samurdhi subsidiaries been
returned or not?" path="otherBusiness">
                  <n-radio-group
                      v-model:value="formValue.samurdhi_details.is_subsidiaries_returned"
                      name="otherBusiness"
                  >
                      <n-space>
                          <n-radio :value="true" label="Yes"> Yes </n-radio>
                          <n-radio :value="false" label="No"> No </n-radio>
                      </n-space>
                  </n-radio-group>
              </n-form-item>
              <n-form-item
                  label="Recommendation of Samurdhi Development Officer"
              >
                  <n-input
                      type="textarea"
                      v-model:value="formValue.samurdhi_details.recommendation"
                      placeholder="Recommendation of Samurdhi Development Officer"
                  />
              </n-form-item>
              <n-form-item label="Samurdhi Development Officer Checked Date" path="land_deed_date">
                  <n-date-picker v-model:value="selectedSamurdhiCheckedDate" type="date" />
              </n-form-item>
          </n-card>
          </div>

          <n-card v-if="!isNewApplication">
              <n-h3>By GN Officer</n-h3>
              <n-form-item label="Checked Date" path="land_deed_date">
<!--                  <n-input-group>-->
                      <n-date-picker v-model:value="selectedCheckedDate" type="date" />
<!--                      <n-time-picker v-model:value="checked_time" />-->
<!--                  </n-input-group>-->
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
              <n-form-item
                  label="Comments"
              >
                  <n-input
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
                <n-button v-if="initialStatus==='Escalated'" type="primary" class="mx-5" @click="updateStatus('Issued')">Approve</n-button>
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
const treeCuttingReasons = ref([]);

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
    is_samurdhi_beneficiary: true,
    samurdhi_details: {
        id: "1",
        subside_amount: "5000",
        is_subsidiaries_returned: false,
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
        formValue.value.status = "Need to Reviewed By Samurdhi Officer";
        await Http.post("incomeCertificate", formValue.value);
        emit("close", false);
        return;
    }
    if ((props.initialStatus === "Pending" && formValue.value.status === "Pending") || (props.initialStatus === "Need to Reviewed By Samurdhi Officer" && props.initialStatus === "Need to Reviewed By Samurdhi Officer")) {
        formValue.value.status = "Resubmitted";
    }
    await Http.put(`incomeCertificate/${formValue.value.id}`, formValue.value);
    emit("close", false);
}

const updateStatus = async (status) => {
    try {
        await Http.put(`incomeCertificate/${props.application.id}`, {
            status: status
        });
        emit('save');
        emit('close', false);
    } catch (error) {
        console.error("Failed to update status:", error);
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
        const samurdhiCheckedDate = formValue.value.samurdhi_details.checked_date;
        return moment(samurdhiCheckedDate, "YYYY-MM-DD").isValid()
            ? moment(samurdhiCheckedDate).toDate()
            : null;
    },
    set: (date) => {
        formValue.value.samurdhi_details.checked_date = moment(date).format("YYYY-MM-DD");
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
  formValue.value.grama_niladari_division = GNDivisionOptions.value.find(
    (GNDivisionOption) => {
      return GNDivisionOption.id === key;
    }
  );
}

const addIncomeDetails = () => {
    formValue.value.incomes.push({...incomeDetailsForm.value});
    clearDetailsForm(); // Clear the form after adding tree details
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
};

</script>

<style scoped></style>
