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
            <n-h2 v-if="!isNewApplication">Review Application</n-h2>
            <n-h2 v-else>Timber Transportation Permit Application</n-h2>
        </div>
      </n-page-header>



      <n-form ref="formRef" :model="formValue">
          <n-form-item v-if="!isNewApplication"
              label="Application Reference Number" path="application_code">
              <n-input
                  :disabled="true"
                  v-model:value="formValue.application_code"
              />
          </n-form-item>
        <n-form-item label="Name of the Applicant" path="name">
          <n-input
            v-model:value="formValue.name"
            placeholder="Enter Name of the Applicant"
          />
        </n-form-item>
        <n-form-item label="Address of the Applicant" path="address">
          <n-input
            v-model:value="formValue.address"
            placeholder="Address of the Applicant"
          />
        </n-form-item>
          <n-form-item label="Telephone No." path="contact_number">
            <n-input
                v-model:value="formValue.contact_number"
                placeholder="Telephone Number" />
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
          <n-form-item label="Address of the timber" path="address_of_timber">
            <n-input
                v-model:value="formValue.address_of_timber"
                placeholder="Address of the timber" />
          </n-form-item>
          <n-form-item label="Was timber bought?" path="timber_bought">
          <n-radio-group
            v-model:value="formValue.is_timber_bought_checked_value"
            name="timberBought"
          >
            <n-space>
              <n-radio :value="true" label="Yes"> Yes </n-radio>
              <n-radio :value="false" label="No"> No </n-radio>
            </n-space>
          </n-radio-group>
          </n-form-item>
          <div v-if="formValue.is_timber_bought_checked_value">
          <n-card>
              <n-form-item label=" Receipt no" path="receipt_no">
                  <n-input
                      v-model:value="formValue.receipt_no"
                      placeholder=" Receipt no" />
              </n-form-item>
              <n-form-item label="Bought Date" path="date">
                  <n-date-picker v-model:value="selectedBoughtDate" type="date" />
              </n-form-item>
                  <n-form-item
                      label="How to go the location of timber from AG Office"
                  >
                      <n-input
                          type="textarea"
                          v-model:value="formValue.road_to_timber_location"
                          placeholder="How to go the location of timber from AG Office"
                      />
              </n-form-item>
          </n-card>
          </div>
          <br/>
          <n-form-item label="Was timber taken from a private land owner?" path="timber_private">
              <n-radio-group
                  v-model:value="formValue.is_timber_private_land_checked_value"
                  name="timberPrivate"
              >
                  <n-space>
                      <n-radio :value="true" label="Yes"> Yes </n-radio>
                      <n-radio :value="false" label="No"> No </n-radio>
                  </n-space>
              </n-radio-group>
          </n-form-item>
          <n-form-item label="Land Deed Number" path="land_deed_number">
              <n-input
                  v-model:value="formValue.private_land.land_deed_number"
                  placeholder="Land Deed Number"
              />
          </n-form-item>
          <n-form-item label="Registration Date" path="registration_date">
              <n-date-picker v-model:value="selectedRegistrationDate" type="date" />
          </n-form-item>
          <n-form-item label="Plan plot No." path="plan_plot_no">
              <n-input
                  v-model:value="formValue.private_land.plan_plot_number"
                  placeholder="Plan plot No."
              />
          </n-form-item>
          <n-form-item label="Registration office" path="registration_office">
              <n-input
                  v-model:value="formValue.private_land.registration_office"
                  placeholder="Registration office"
              />
          </n-form-item>
          <n-form-item label="Plan No." path="plan_number">
              <n-input
                  v-model:value="formValue.private_land.plan_number"
                  placeholder="Plan No."
              />
          </n-form-item>
          <n-form-item label="Land Name" path="land_name">
              <n-input
                  v-model:value="formValue.private_land.land_name"
                  placeholder="Land Name"
              />
          </n-form-item>
          <n-form-item label="Land Size in perches" path="land_size">
              <n-input
                  v-model:value="formValue.private_land.land_size"
                  placeholder="Land Size in perches"
              />
              <n-tooltip trigger="hover">
                  <template #trigger>
                      <n-icon><InformationCircleOutlineIcon /></n-icon>
                  </template>
                  <span>1 Acre = 160 Perches = 4 Roods = 4,000 Sqm</span>
              </n-tooltip>
          </n-form-item>
          <n-form-item label="Boundaries:" path="boundary">
              <n-input
                  v-model:value="formValue.boundary.north"
                  placeholder="To North"
              />
              <n-input
                  v-model:value="formValue.boundary.south"
                  placeholder="To South"
              />
              <n-input
                  v-model:value="formValue.boundary.east"
                  placeholder="To East"
              />
              <n-input
                  v-model:value="formValue.boundary.west"
                  placeholder="To West"
              />
          </n-form-item>
          <n-form-item label="End Location of the timber" path="end_location">
              <n-input
                  v-model:value="formValue.end_location"
                  placeholder="End Location of the timber"
              />
          </n-form-item>
          <n-form-item label="Route that timber is transported" path="route">
              <n-input
                  v-model:value="formValue.route"
                  placeholder="Route that timber is transported"
              />
          </n-form-item>
          <n-form-item label="Date timber is transported" path="timber_transport_date">
              <n-date-picker v-model:value="selectedTimberTransportDate" type="date" />
          </n-form-item>
          <n-form-item label="Plate number of the vehicle" path="plate_number">
              <n-input
                  v-model:value="formValue.plate_number"
                  placeholder="Plate number of the vehicle"
              />
          </n-form-item>
              <n-card title="Details about timber. (Use Standard measurements to complete the details.)">
                                    <!--            <n-form ref="treeForm">-->
                  <n-form-item label="Timber type">
                      <n-input
                          v-model:value="treeDetailsForm.timber_type"
                          placeholder="Timber type"
                      />
                  </n-form-item>
                  <n-form-item label="Length(meters and millimeters)">
                      <n-input
                          v-model:value="treeDetailsForm.length"
                          placeholder="Length(meters and millimeters)"
                      />
                  </n-form-item>

                  <n-form-item label="Width(mm)">
                      <n-input
                          v-model:value="treeDetailsForm.width"
                          placeholder="Width(mm)"
                      />
                  </n-form-item>
                  <n-form-item label="Number of pieces">
                      <n-input
                          v-model:value="treeDetailsForm.piece_count"
                          placeholder="Number of pieces"
                      />
                  </n-form-item>
                  <!--            </n-form>-->
                  <n-button @click="addTreeDetails">Add Detail</n-button>
              </n-card>
              <n-form-item>
                  <n-table :bordered="false" :single-line="false">
                      <thead>
                      <tr>
                          <th>Timber Type</th>
                          <th>Length(m & mm)</th>
                          <th>Width(mm)</th>
                          <th>No. of Pieces</th>
                          <th>Remove</th>
                      </tr>
                      </thead>
                      <tbody>
                      <tr :key="key" v-for="(timber_detail, key) in formValue.timber_details">
                          <td>{{ timber_detail.timber_type}}</td>
                          <td>{{ timber_detail.length}}</td>
                          <td>{{ timber_detail.width }}</td>
                          <td>{{ timber_detail.piece_count }}</td>
                          <td><n-button @click="removeRow(key)">
                              <n-icon>
                                  <clear-outlined-icon/>
                              </n-icon>
                          </n-button></td>
                      </tr>
                      </tbody>
                  </n-table>
              </n-form-item>
          <n-form-item label="Total Number of pieces">
              <n-input
                  v-model:value="totalPieces"
                  placeholder="Total Number of pieces"
                  disabled
              />
          </n-form-item>
        <n-p
          >Upload following documents:<n-ul>
            <n-li>Duly Filled application</n-li>
            <n-li>
              Copy of the deed of the relevant land (Should've certified by the
              Grama Niladhari)
            </n-li>
            <n-li
              >Copy of the plan (Should've certified by the Grama Niladhari )
            </n-li>
            <n-li> Extract for the relevant deed issued within a week. </n-li>
            <n-li>
              If the deed has life interest owner/ owners, a letter of consent
              regarding timber cutting ( Should've certified by the Grama
              Niladhari )
            </n-li>
            <n-li>
              If the life interest owner/owners have died applicant should
              present certified copy of the death certificate.
            </n-li>
            <n-li>
              If you are presenting a deed of declaration, it should submit with
              a grama niladhari report stating the clear holding of the land.
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
          >By submitting this application, you affirm that the information provided above is accurate and that the timber listed originates from either your private property or has been lawfully acquired by you. Furthermore, you assert that this timber has not been commingled with timber sourced from government reserves or forests.
        </n-p>

          <n-card v-if="!isNewApplication">
              <n-h3>By GN Officer</n-h3>
              <n-form-item label="Checked Date" path="land_deed_date">
                  <n-date-picker v-model:value="selectedCheckedDate" type="date" />
              </n-form-item>
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
              <p>I have personally checked the business and the business hasn't started yet. There is no business from the above name in this division.</p>
          </n-card>
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

const formRef = ref(null);
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
    address: "123 Main St, Anytown, USA",
    contact_number: "123-456-7890",
    gn_division: {
        id: "74",
        gn_code: "370",
        name: "Kotugoda",
        mpa_code: "204",
    },
    address_of_timber: "456 Oak St, Anytown, USA",
    is_timber_bought_checked_value: true,
    receipt_no: "ABC123",
    bought_date: "2022-01-01",
    road_to_timber_location: "Take the highway and exit at Main St.",
    is_timber_private_land_checked_value: false,
    private_land: {
        land_deed_number: "123456",
        registration_date: "2021-01-01",
        plan_plot_number: "789",
        registration_office: "Anytown Registry",
        plan_number: "01234",
        land_name: "John Doe's Land",
        land_size: "10 acres",
    },
    boundary: {
        north: "123 Main St",
        south: "456 Oak St",
        east: "789 Elm St",
        west: "321 Maple Ave",
    },
    end_location: "567 Pine St, Anytown, USA",
    route: "Take the highway and exit at Pine St.",
    timber_transport_date: "2022-02-01",
    plate_number: "XYZ123",
    timber_details: [
        {
            timber_type: "Oak",
            length: "10 ft",
            width: "1 ft",
            piece_count: "5",
        },
        {
            timber_type: "Maple",
            length: "8 ft",
            width: "0.75 ft",
            piece_count: "0",
        },
    ],
    total_pieces: "15",
    checked_date: "2024-07-01",
    comment: "",
    status: "Submitted",
    submission_timestamp:"",
    application_code:""
});

const treeDetailsForm = ref({
    timber_type: "Pine",
    length: "12 ft",
    width: "0.5 ft",
    piece_count: "8",
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

watch(
    () => props.isShowing,
    (newValue) => {
        isShowing.value = newValue;
        formValue.value = {
            ...{
                id: "",
                name: "",
                address: "",
                contact_number: "",
                gn_division: {
                    id: "",
                    gn_code: "",
                    name: "",
                    mpa_code: "",
                },
                address_of_timber: "",
                is_timber_bought_checked_value: false,
                receipt_no: "",
                bought_date: "",
                road_to_timber_location: "",
                is_timber_private_land_checked_value: false,
                private_land: {
                    land_deed_number: "",
                    registration_date: "",
                    plan_plot_number: "",
                    registration_office: "",
                    plan_number: "",
                    land_name: "",
                    land_size: "",
                },
                boundary: {
                    north: "",
                    south: "",
                    east: "",
                    west: "",
                },
                end_location: "",
                route: "",
                timber_transport_date: "",
                plate_number: "",
                timber_details: [],
                total_pieces: "6",
                checked_date: "",
                comment: "",
                status: "",
                submission_timestamp: "",
                application_code: "",
            },
            ...props.application,
        };
    }
);

async function certifyAndSubmit() {
    console.log("Submitting form:", formValue.value);

    if (isNewApplication.value) {
        formValue.value.status = "Submitted";
        await Http.post("timberTransportingPermitApplication", formValue.value);
        emit("close", false);
        return;
    }

    if (props.initialStatus === "Pending" && formValue.value.status === "Pending") {
        formValue.value.status = "Resubmitted";
    }

    console.log(`Updating timberTransportingPermitApplication/${formValue.value.id} with data:`, formValue.value);

    await Http.put(`timberTransportingPermitApplication/${formValue.value.id}`, formValue.value);
    emit("close", false);
}

const selectedRegistrationDate = computed({
  get: () => {
    const landRegistrationDate = formValue.value.private_land.registration_date;
    return moment(landRegistrationDate, "YYYY-MM-DD").isValid()
      ? moment(landRegistrationDate).valueOf()
      : null;
  },
  set: (epoch) => {
    formValue.value.private_land.registration_date = moment
      .unix(epoch / 1000)
      .format("YYYY-MM-DD");
  },
});

const selectedBoughtDate = computed({
  get: () => {
    const boughtDate = formValue.value.bought_date;
    return moment(boughtDate, "YYYY-MM-DD").isValid()
      ? moment(boughtDate).valueOf()
      : null;
  },
  set: (epoch) => {
    formValue.value.bought_date = moment
      .unix(epoch / 1000)
      .format("YYYY-MM-DD");
  },
});

const selectedTimberTransportDate = computed({
  get: () => {
    const TimberTransportDate = formValue.value.timber_transport_date;
    return moment(TimberTransportDate, "YYYY-MM-DD").isValid()
      ? moment(TimberTransportDate).valueOf()
      : null;
  },
  set: (epoch) => {
    formValue.value.timber_transport_date = moment
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


const totalPieces = computed(() => {
    return formValue.value.timber_details.reduce((total, detail) => {
        return total + parseInt(detail.piece_count || "0");
    }, 0);
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
    if (!formValue.value.gn_division || !formValue.value.gn_division.id) {
        return null;
    }
    return gnDivisionsForDropdown.value.find((gnDivisionForDropdown) => {
        return gnDivisionForDropdown.key === formValue.value.gn_division.id;
    });
});

const selectGramaNiladariDivision = (key) => {
    const selectedDivision = GNDivisionOptions.value.find(division => division.id === key);
    if (selectedDivision) {
        formValue.value.gn_division = {
            id: selectedDivision.id,
            gn_code: selectedDivision.gn_code,
            name: selectedDivision.name,
            mpa_code: selectedDivision.mpa_code,
        };
    }
};
const fetchGnDivisions = async () => {
    try {
        const response = await Http.get("gnDivision");
        const data = response.data.data; // Assuming the API response contains the data you need
        // console.log(data);
        GNDivisionOptions.value = data;
        // console.log(GNDivisionOptions.value);
    } catch (error) {
        console.error(error);
    }
};


onMounted(() => {
  fetchGnDivisions();
  // fetchTimberCuttingPermitApplication();
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


const updateStatus = async (status) => {
    try {
        await Http.put(`timberTransportingPermitApplication/${props.application.id}`, {
            status: status
        });
        emit('save');
        emit('close', false);
    } catch (error) {
        console.error("Failed to update status:", error);
    }
};


const addTreeDetails = () => {
    formValue.value.timber_details.push({...treeDetailsForm.value});
    clearTreeForm(); // Clear the form after adding tree details
};

const clearTreeForm = () => {
  treeDetailsForm.value.piece_count = "";
  treeDetailsForm.value.timber_type = "";
  treeDetailsForm.value.length = "";
  treeDetailsForm.value.width = "";
};

const removeRow = (index) => {
    formValue.value.timber_details.splice(index, 1);
};

</script>

<style scoped></style>
