<template>
  <n-modal
    v-model:show="isShowing"
    preset="card"
    style="width: 900px"
    :on-update:show="(value) => emit('close', value)"
  >
    <n-layout style="padding-left: 8px">
      <n-page-header>
        <div class="flex justify-between ...">
          <n-h2>Application for Request an Animal Transportation Permit</n-h2>
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


          <n-form-item label="The Applicant Name" path="name">
              <n-input
                  v-model:value="formValue.name"
                  placeholder="Enter Name of the Applicant"
              />
          </n-form-item>
          <n-form-item label="Address of the Applicant" path="destination">
              <n-input
                  v-model:value="formValue.address"
                  placeholder="Address of the Applicant" />
          </n-form-item>
          <n-form-item label="Telephone number" path="contactNumber">
              <n-input
                  v-model:value="formValue.contact_number"
                  placeholder="Telephone number" />
          </n-form-item>
          <n-form-item label="Reason to Transport" path="nature">
          <n-input
              type="textarea"
            v-model:value="formValue.reason_to_transport"
            placeholder="Reason to Transport"
          /> </n-form-item
        ><n-form-item label="Start Point" path="start_point">
          <n-input
            v-model:value="formValue.start_point"
            placeholder="Start Point" /><n-tooltip trigger="hover">
          <template #trigger>
              <n-icon><InformationCircleOutlineIcon /></n-icon>
          </template>
          <span>From where animals are transported</span>
      </n-tooltip></n-form-item>
          <n-form-item label="Destination" path="destination">
          <n-input
              v-model:value="formValue.destination"
              placeholder="Destination" /></n-form-item>
              <n-card title="Animal Details">
                  <n-form-item label="Serial No" path="registration_no">
                      <n-input
                          v-model:value="animalDetailsForm.serial_no"
                          placeholder="Serial No" />
                  </n-form-item>
                  <n-form-item label="Identification No./ Brand Marks">
                      <n-input
                          v-model:value="animalDetailsForm.identification_no"
                          placeholder="Identification No./ Brand Marks"
                      />
                  </n-form-item>
                  <n-form-item label="Animal Species">
                      <n-input
                          v-model:value="animalDetailsForm.species"
                          placeholder="Animal Species"
                      />
                  </n-form-item><n-form-item label="Breed">
                      <n-input
                          v-model:value="animalDetailsForm.breed"
                          placeholder="Breed"
                      />
                  </n-form-item><n-form-item label="Age (approx.)">
                      <n-input
                          v-model:value="animalDetailsForm.age"
                          placeholder="Age (approx.)"
                      />
                  </n-form-item><n-form-item label="Sex">
                      <n-input
                          v-model:value="animalDetailsForm.sex"
                          placeholder="Sex"
                      />
                  </n-form-item><n-form-item label="Color">
                      <n-input
                          v-model:value="animalDetailsForm.color"
                          placeholder="Color"
                      />
                  </n-form-item><n-form-item label="Other specific Marks">
                      <n-input
                          v-model:value="animalDetailsForm.specific_marks"
                          placeholder="Other specific Marks"
                      />
                  </n-form-item><n-form-item label="Health Certificate no">
                      <n-input
                          v-model:value="animalDetailsForm.health_certificate_no"
                          placeholder="Health Certificate no"
                      />
                  </n-form-item>
                  <n-form-item label="Registration No. of the Vehicle ">
                      <n-input
                          v-model:value="animalDetailsForm.vehicle_registration_no"
                          placeholder="Registration No. of the Vehicle "
                      />
                  </n-form-item>
              </n-card>
              <br/>
              <n-button @click="addAnimalDetails">Add Another Animal</n-button>
          <br/>
          <n-form-item>
              <n-table :bordered="false" :single-line="false">
                  <thead>
                  <tr>
                      <th>Serial<br/> No</th>
                      <th>Identification <br/>No./ Brand <br/>Marks</th>
                      <th>Animal <br/>Species</th>
                      <th>Breed</th>
                      <th>Age<br/>(approx.)</th>
                      <th>Sex</th>
                      <th>Color</th>
                      <th>Other <br/>specific<br/> Marks</th>
                      <th>Health<br/> Certificate <br/> No.</th>
                      <th>Registration<br/> No. of the<br/> Vehicle</th>
                      <th>Remove</th>
                  </tr>
                  </thead>
                  <tbody>
                  <tr :key="key" v-for="(animal, key) in formValue.animals">
                      <td>{{ animal.serial_no}}</td>
                      <td>{{ animal.identification_no}}</td>
                      <td>{{ animal.species}}</td>
                      <td>{{ animal.breed}}</td>
                      <td>{{ animal.age}}</td>
                      <td>{{ animal.sex}}</td>
                      <td>{{ animal.color}}</td>
                      <td>{{ animal.specific_marks}}</td>
                      <td>{{ animal.health_certificate_no}}</td>
                      <td>{{ animal.vehicle_registration_no}}</td>
                      <td><n-button @click="removeAnimalRow(key)">
                          <n-icon>
                              <clear-outlined-icon/>
                          </n-icon>
                      </n-button></td>
                  </tr>
                  </tbody>
              </n-table>
          </n-form-item>
          <n-form-item label="Cost Per Animal" path="nature">
              <n-input
                  :disabled="true"
                  v-model:value="costPerAnimal"
              /></n-form-item>
        <div>
            <n-form-item label="Date of Issue" path="nature">
              <n-date-picker v-model:value="selectedIssuedDate" type="date" /> </n-form-item>
          <n-form-item label="Date  of Expire" path="nature">
              <n-date-picker v-model:value="selectedExpireDate" type="date" /> </n-form-item>
          </div>

          <p>By subtting this application i certify this details in this application is correct.</p><br/>
          <n-card v-if="!isNewApplication">
              <n-h3>By Government Veterinary Office</n-h3>
              <n-form-item label="Checked Date" path="land_deed_date">
                      <n-date-picker v-model:value="selectedCheckedDate" type="date" />
              </n-form-item><n-form-item
              label="Any comment about application">
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
              <p>I certify above details are correct.</p>
          </n-card>
          <n-p>To get a animal transportation permit please fill out the form below.The original copies of relevant documents must be submitted.</n-p>
          <n-p>Required documents to obtain an animal transportation permit:</n-p>
          <n-ul>
              <n-li>1. Cattle Voucher </n-li>
              <n-li>2. Health Certificate issued by Government Veterinary Surgeon Officer</n-li>
              <n-li>3. Vehicle Revenue License</n-li>
          </n-ul>
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
    // application: Object,
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
    contact_number: "0712345678",
    reason_to_transport: "Transporting animals for sale",
    start_point: "Colombo",
    destination: "Kandy",
    animals: [{
        id:"",
        serial_no: "AN001",
        identification_no: "ID001",
        species: "Cow",
        breed: "Angus",
        age: "2 years",
        sex: "Male",
        color: "Black",
        specific_marks: "White patch on forehead",
        health_certificate_no: "HC001",
        vehicle_registration_no: "WP ABC 1234"
    },{
        id:"",
        serial_no: "AN002",
        identification_no: "ID002",
        species: "Goat",
        breed: "Boer",
        age: "1 year",
        sex: "Female",
        color: "Brown",
        specific_marks: "White spot on nose",
        health_certificate_no: "HC002",
        vehicle_registration_no: "WP DEF 5678"
    }],
    cost_per_animal: "5000",
    issued_date: "2023-01-01",
    expire_date: "2023-01-31",
    checked_date: "2023-01-01",
    status: "",
    submission_timestamp: "",
    checked_time: "",
    comment: "This is a test comment"
});

const animalDetailsForm = ref({
    id:"",
    serial_no: "AN003",
    identification_no: "ID003",
    species: "Sheep",
    breed: "Dorper",
    age: "3 years",
    sex: "Male",
    color: "White",
    specific_marks: "Black spot on ear",
    health_certificate_no: "HC003",
    vehicle_registration_no: "WP GHI 9012"
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
const options = [
  {
    label: "Marina Bay Sands",
    key: "Marina Bay Sands",
  },
  {
    label: "Brown's Hotel, London",
    key: "Brown's Hotel, London",
  },
  {
    label: "Atlantis Bahamas, Nassau",
    key: "Atlantis Bahamas, Nassau",
  },
  {
    label: "The Beverly Hills Hotel, Los Angeles",
    key: "The Beverly Hills Hotel, Los Angeles",
  },
];

watch(
  () => props.isShowing,
  (newValue) => {
    isShowing.value = newValue;
    // formValue.value = {...props.application };
  }
);
async function certifyAndSubmit() {
    if (isNewApplication.value) {
        formValue.value.status = "Submitted";
        await Http.post("animalTransport", formValue.value);
        emit("close", false);
        return;
    }
    if (props.initialStatus === "Pending" && formValue.value.status === "Pending") {
        formValue.value.status = "Resubmitted";
    }
    await Http.put(`animalTransport/${formValue.value.id}`, formValue.value);
    emit("close", false);
}

const updateStatus = async (status) => {
    try {
        await Http.put(`animalTransport/${props.application.id}`, {
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

const totalAnimals = computed(() => formValue.value.animals.length);
const costPerAnimal = computed({
    get: () => totalAnimals.value * 50,
    set: (value) => {
        formValue.value.cost_per_animal = value;
    }
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

const addAnimalDetails = () => {
    formValue.value.animals.push({...animalDetailsForm.value});
    clearDetailsForm();
};

const clearDetailsForm = () => {
  animalDetailsForm.value.serial_no="";
  animalDetailsForm.value.identification_no="";
  animalDetailsForm.value.species="";
  animalDetailsForm.value.breed="";
  animalDetailsForm.value.age="";
  animalDetailsForm.value.sex="";
  animalDetailsForm.value.color="";
  animalDetailsForm.value.specific_marks="";
  animalDetailsForm.value.health_certificate_no="";
  animalDetailsForm.value.vehicle_registration_no="";
};

const removeAnimalRow = (index) => {
    formValue.value.animals.splice(index, 1);
};

</script>

<style scoped></style>
