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
          <n-h2>Application to a Valuation Certificate </n-h2>
        </div>
      </n-page-header>
<!--        v-if="props.initialStatus === 'issued'"-->
        <n-watermark
            image="../../images/Emblem_of_Sri_Lanka.svg.png"
            cross
            fullscreen
            :font-size="16"
            :line-height="16"
            :width="384"
            :height="384"
            :x-offset="12"
            :y-offset="0"
            :image-width="64"
            :image-opacity="0.24"
        />
<!--   v-if="initialStatus === 'issued'"-->
      <n-form ref="formRef" :model="formValue">
          <n-form-item
              label="Application Reference Number" path="application_code">
          <n-input
              :disabled="true"
              v-model:value="formValue.application_code"
          />
        </n-form-item>
          <n-form-item label="Enter Name of the Applicant" path="business_name">
              <n-input
                  v-model:value="formValue.name"
                  placeholder="Enter Name of the Applicant"
              />
          </n-form-item>
          <n-form-item label="Address" path="nature">
              <n-input
                v-model:value="formValue.address"
                placeholder="Address"
              />
          </n-form-item>
          <n-form-item label="Valuation Amount" path="valuation_amount">
              <n-input
                  v-model:value="formValue.valuation_amount"
                  placeholder="Valuation Amount" /></n-form-item>
          <n-form-item label="Reason" path="reason">
              <n-input
                  v-model:value="formValue.reason"
                  placeholder="Reason" /></n-form-item>
          <n-form-item label="Land Deed Number" path="land_deed_number">
              <n-input
                  v-model:value="formValue.land_deed_number"
                  placeholder="Land Deed Number"
              />
          </n-form-item>
          <n-form-item label="Boundary to North" path="to_north">
              <n-input
                  v-model:value="formValue.to_north"
                  placeholder="Boundary to North"
              />
          </n-form-item>
          <n-form-item label="Boundary to South" path="to_south">
              <n-input
                  v-model:value="formValue.to_south"
                  placeholder="Boundary to South"
              />
          </n-form-item>
          <n-form-item label="Boundary to East" path="to_east">
              <n-input
                  v-model:value="formValue.to_east"
                  placeholder="Boundary to East"
              />
          </n-form-item>
          <n-form-item label="Boundary to West" path="to_west">
              <n-input
                  v-model:value="formValue.to_west"
                  placeholder="Boundary to West"
              />
          </n-form-item>
          <n-form-item label="Size in Arches" path="size">
              <n-input
                  v-model:value="formValue.size"
                  placeholder="Size in Arches"
              />
          </n-form-item>
          <n-form-item label="Building Length" path="width">
              <n-input
                  v-model:value="formValue.length"
                  placeholder="Building Length"
              />
          </n-form-item>
          <n-form-item label="Building Width" path="width">
              <n-input
                  v-model:value="formValue.width"
                  placeholder="Building Width"
              />
          </n-form-item>
          <n-form-item label="Name of Notary Officer" path="notary_officer_name">
              <n-input
                  v-model:value="formValue.notary_officer_name"
                  placeholder="Name of Notary Officer"
              />
          </n-form-item>
          <n-form-item label="Plan No." path="plan_number">
              <n-input
                  v-model:value="formValue.plan_number"
                  placeholder="Plan No."
              />
          </n-form-item>
          <n-form-item label="Plan date" path="plan_date">
              <n-date-picker
                  v-model:value="selectedPlanDate"
                  placeholder="Plan date"
                  type="date" />
          </n-form-item>
          <n-form-item label="Land Name" path="land_name">
              <n-input
                  v-model:value="formValue.land_name"
                  placeholder="Land Name"
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
          <p>As I/we, kindly request a Valuation Certificate as a security, and in order to obtain it,  I/we hereby submit the deed details which is owned by me/us with the above details. I/we further certify that I am/ we are ready to pay the fee due to me/us, that this land is not subject to any other lawsuit and that I/we have ownership over it.</p><br/>
          <n-card v-if="!isNewApplication">
              <n-h3>By GN Officer</n-h3>
              <n-form-item label="Checked Date" path="land_deed_date">
<!--                  <n-input-group>-->
                      <n-date-picker v-model:value="selectedCheckedDate" type="date" />
<!--                      <n-time-picker v-model:value="checked_time" />-->
<!--                  </n-input-group>-->
              </n-form-item><n-form-item
              label="Any comment about application"
          >
              <n-input
                  type="textarea"
                  v-model:value="formValue.comment"
                  placeholder="Any comment about application"
              />
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
              <p>I hereby confirm that the land of the applicant/applicants mentioned above, reside in/ situated in my division. And I confirm that I have examined the land mentioned on the application form, have confirmed the information in the form to be truthful, and can certify the land including buildings are valued according to the mentioned amount.</p>
          </n-card>
          <n-p
          >Upload following documents:<n-ul>
            <n-li>
              Copy of the deed of the relevant land (Should've certified by the
              Grama Niladhari)
            </n-li>
            <n-li
              >Copy of the plan (Should've certified by the Grama Niladhari )
            </n-li>
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
import { computed, ref, watch, onMounted } from "vue";
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
const non_commercial_use_checked_value = ref(false);
const timber_seller_checked_value = ref(false);
const ownership_of_land_checked_value = ref(false);
const timberCuttingPermitApplications = ref([]);
const selectedValues = ref([]);
const GNDivisionOptions = ref([]);
const treeCuttingReasons = ref([]);

const formValue = ref({
    id: "",
    application_code: "",
    name: "John Doe",
    address: "123 Main St, Colombo",
    valuation_amount: "5000000",
    reason: "Property Sale",
    land_deed_number: "LDN456789",
    to_north: "Neighbor A",
    to_south: "Road",
    to_east: "River",
    to_west: "Empty Land",
    size: "2000 sqft",
    length: "50 ft",
    width: "40 ft",
    notary_officer_name: "Notary Public John",
    plan_number: "PN789456",
    plan_date: "2023-05-15",
    land_name: "Green Acres",
    gn_division: {
        id: "74",
        gn_code: "370",
        name: "Kotugoda",
        mpa_code: "204",
    },
    status: "",
    submission_timestamp: "2023-07-15 10:00:00",
    checked_date: "2023-07-20",
    comment: "Initial submission for review."
});


const statusOptions = [
    { label: 'Pending', key: 'Pending' },
    { label: 'Escalated', key: 'Escalated' },
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
        formValue.value.status = "Submitted";
        await Http.post("valuation", formValue.value);
        emit("close", false);
        return;
    }
    if (props.initialStatus === "Pending" && formValue.value.status === "Pending") {
        formValue.value.status = "Resubmitted";
    }
    await Http.put(`valuation/${formValue.value.id}`, formValue.value);
    emit("close", false);
}

const updateStatus = async (status) => {
    try {
        await Http.put(`valuation/${props.application.id}`, {
            status: status
        });
        emit('save');
        emit('close', false);
    } catch (error) {
        console.error("Failed to update status:", error);
    }
};

const selectedPlanDate = computed({
  get: () => {
    const planDate = formValue.value.plan_date;
    return moment(planDate, "YYYY-MM-DD").isValid()
      ? moment(planDate).valueOf()
      : null;
  },
  set: (epoch) => {
    formValue.value.plan_date = moment
      .unix(epoch / 1000)
      .format("YYYY-MM-DD");
  },
});

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
        return gnDivisionForDropdown.key === formValue.value.gn_division.id;
    });
});

onMounted(() => {
    fetchGnDivisions();
});

const fetchGnDivisions = async () => {
    try {
        const response = await Http.get("gnDivision");
        const data = response.data.data; // Assuming the API response contains the data you need
        GNDivisionOptions.value = data;
    } catch (error) {
        console.error(error);
    }
};

function selectGramaNiladariDivision(key) {
    const selectedDivision = GNDivisionOptions.value.find((GNDivisionOption) => {
        return GNDivisionOption.id === key;
    });

    if (selectedDivision) {
        formValue.value.gn_division = {
            id: selectedDivision.id,
            gn_code: selectedDivision.gn_code,
            name: selectedDivision.name,
            mpa_code: selectedDivision.mpa_code
        };
    }
}

</script>

<style scoped></style>
