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
          <n-h2>Timber Cutting Permit Application</n-h2>
        </div>
      </n-page-header>

      <n-form ref="formRef" :model="formValue">
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
          /> </n-form-item
        ><n-form-item label="Telephone No." path="contact_number">
          <n-input
            v-model:value="formValue.contact_number"
            placeholder="Telephone Number" /></n-form-item
        ><n-form-item label="Are you a Timber seller?" path="timberSeller">
          <n-radio-group
            v-model:value="formValue.timber_seller_checked_value"
            name="timberSeller"
          >
            <n-space>
              <n-radio :value="true" label="Yes"> Yes </n-radio>
              <n-radio :value="false" label="No"> No </n-radio>
            </n-space>
          </n-radio-group> </n-form-item
        ><n-form-item
          label="Are you cutting trees for non-commercial use?"
          path="timberSeller"
          ><n-radio-group
            v-model:value="formValue.non_commercial_use_checked_value"
            name="nonCommercialUse"
          >
            <n-space>
              <n-radio :value="true" label="Yes"> Yes </n-radio>
              <n-radio :value="false" label="No"> No </n-radio>
            </n-space>
          </n-radio-group>
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
        <n-form-item label="Land Deed Number" path="land_deed_number">
          <n-input
            v-model:value="formValue.deed_details.land_deed_number"
            placeholder="Land Deed Number"
          />
        </n-form-item>
        <n-form-item label="Land deed date" path="land_deed_date">
          <n-date-picker v-model:value="selectedDeedDate" type="date" />
        </n-form-item>
        <n-form-item label="Ownership of land" path="ownershipOfLand">
          <n-radio-group
            v-model:value="formValue.ownership_of_land_checked_value"
            name="ownershipOfLand"
          >
            <n-space>
              <n-radio :value="'Freehold(Sinnakkara)'" label="Yes"
                >Freehold(Sinnakkara)</n-radio
              >
              <n-radio :value="'Co-owner'" label="No">Co-owner</n-radio>
              <n-radio :value="'Granted by Government(Swarnabhumi)'" label="No"
                >Granted by Government(Swarnabhumi)</n-radio
              >
            </n-space>
          </n-radio-group>
        </n-form-item>
        <n-form-item label="Land Name" path="land_name">
          <n-input
            v-model:value="formValue.land_details.land_name"
            placeholder="Land Name"
          />
        </n-form-item>
        <n-form-item label="Land Size in perches" path="land_size">
          <n-input
            v-model:value="formValue.land_details.land_size"
            placeholder="Land Size in perches"
          />
          <n-tooltip trigger="hover">
            <template #trigger>
              <n-icon><InformationCircleOutlineIcon /></n-icon>
            </template>
            <span>1 Acre = 160 Perches = 4 Roods = 4,000 Sqm</span>
          </n-tooltip>
        </n-form-item>
        <n-form-item label="Plan No." path="plan_number">
          <n-input
            v-model:value="formValue.land_details.plan_number"
            placeholder="Plan No."
          />
        </n-form-item>
        <n-form-item label="Plan Date" path="plan_date">
          <n-date-picker v-model:value="selectedPlanDate" type="date" />
        </n-form-item>
        <n-form-item label="Plan plot No." path="plan_plot_no">
          <n-input
            v-model:value="formValue.land_details.plan_plot_number"
            placeholder="Plan plot No."
          />
        </n-form-item>
        <n-form-item label="Boundaries:" path="boundaries">
          <n-input
            v-model:value="formValue.boundaries.north"
            placeholder="To North"
          />
          <n-input
            v-model:value="formValue.boundaries.south"
            placeholder="To South"
          />
          <n-input
            v-model:value="formValue.boundaries.east"
            placeholder="To East"
          />
          <n-input
            v-model:value="formValue.boundaries.west"
            placeholder="To West"
          />
        </n-form-item>
        <n-form-item
          label="Number of trees currently on this plot:"
          path="no_of_trees"
        >
          <n-input
            v-model:value="formValue.tree_count.jackfruit"
            placeholder="Jackfruit"
          />
          <n-input
            v-model:value="formValue.tree_count.breadfruit"
            placeholder="Breadfruit"
          />
          <n-input
            v-model:value="formValue.tree_count.coconut"
            placeholder="Coconut"
          />
          <n-input
            v-model:value="formValue.tree_count.palmyra"
            placeholder="Palmyra"
          />
        </n-form-item>
        <n-card title="Enter details of the trees in the land">
          <!--            <n-form ref="treeForm">-->
          <n-form-item label="Sub no">
            <n-input
              v-model:value="treeDetailsForm.sub_no"
              placeholder="Sub no"
            />
          </n-form-item>

          <n-form-item label="Type">
            <n-input
              v-model:value="treeDetailsForm.type"
              placeholder="Type"
            />
          </n-form-item>

          <n-form-item label="Height (feets)">
            <n-input
              v-model:value="treeDetailsForm.height"
              placeholder="Height (feets)"
            />
          </n-form-item>

          <n-form-item label="Girth (feets)">
            <n-input
              v-model:value="treeDetailsForm.girth"
              placeholder="Girth (feets)"
            />
          </n-form-item>

          <n-form-item label="Reproducibility">
            <n-radio-group
              v-model:value="treeDetailsForm.reproducibility"
              name="Reproducibility"
            >
              <n-space>
                <n-radio :value="true" label="Yes"> Yes </n-radio>
                <n-radio :value="false" label="No"> No </n-radio>
              </n-space>
            </n-radio-group>
          </n-form-item>

          <n-form-item label="Age">
            <n-input
              v-model:value="treeDetailsForm.age"
              placeholder="Age"
            />
          </n-form-item>
          <!--            </n-form>-->
          <n-button @click="addTreeDetails">Add Detail</n-button>
        </n-card>
          <br/>
      <label>Please select the trees you want to cut from the below table.</label>
        <n-form-item>
            <n-table :bordered="false" :single-line="false">
                <thead>
                <tr>
                    <th>Sub No</th>
                    <th>Type</th>
                    <th>Height</th>
                    <th>Girth</th>
                    <th>Reproducibility</th>
                    <th>Age</th>
                    <th>Remove</th>
                </tr>
                </thead>
                <tbody>
                <tr :key="key" v-for="(tree_detail, key) in formValue.tree_details">
                    <td><n-checkbox :v-model="tree_detail.want_to_cut" size="large" label="  " />{{ tree_detail.sub_no }}</td>
                    <td>{{ tree_detail.type}}</td>
                    <td>{{ tree_detail.height}}</td>
                    <td>{{ tree_detail.girth }}</td>
                    <td>{{ tree_detail.reproducibility }}</td>
                    <td>{{ tree_detail.age }}</td>
                    <td><n-button @click="removeRow(key)">
                        <n-icon>
                            <clear-outlined-icon/>
                        </n-icon>
                    </n-button></td>
                </tr>
                </tbody>
            </n-table>
        </n-form-item>

        <n-form-item label="Reasons for cutting down tree/trees:">
          <n-select
            v-model:value="selectedTreeCuttingReasons"
            multiple
            :options="treeCuttingReasonsForSelect"
          />
        </n-form-item>
        <n-form-item
          label="Have jackfruit, coconut, breadfruit and female palm trees been cut on this land before?"
        >
          <n-input
            v-model:value="formValue.trees_cut_before"
            placeholder="If any, that number"
          />
        </n-form-item>
        <n-form-item
          label="How many trees of that type are planted to replace the trees that are asked to be cut down?"
        >
          <n-input
            v-model:value="formValue.planted_tree_count"
            placeholder="How many trees of that type are planted to replace the trees that are asked to be cut down?"
          />
        </n-form-item>
        <n-form-item
          label="Briefly mention the road signs from the Divisional Secretariat to the land"
        >
          <n-input
            type="textarea"
            v-model:value="formValue.road_to_land"
            placeholder="Briefly mention the road signs from the Divisional Secretariat to the land"
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
          >I certify that I have the legal right to the land related to felling
          of trees and that there is no dispute, that the above information is
          true and that I will take full responsibility if any problem
          arises.</n-p
        >
        <div class="flex justify-end">
          <n-form-item>
            <n-button @click="certifyAndSubmit"> Certify and Submit </n-button>
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
import axios from "axios";

import TableRow from "./TableRow.vue";

const formRef = ref(null);
const message = useMessage();
const isShowing = ref(false);
const emit = defineEmits(["close", "save"]);
const props = defineProps({
  isShowing: Boolean,
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
    name: "John Doe",
    address: "123 Main St",
    contact_number: "555-1234",
    timber_seller_checked_value: true,
    non_commercial_use_checked_value: false,
    grama_niladari_division: {
        id: "74",
        gn_code: "370",
        name: "Kotugoda",
        mpa_code: "204",
    },
    deed_details: {
        land_deed_number: "789",
        land_deed_date: "2022-04-11",
    },
    ownership_of_land_checked_value: "Co-owner",
    land_details: {
        land_name: "Example Land",
        land_size: "10 acres",
        plan_number: "Plan123",
        plan_date: "2022-04-11",
        plan_plot_number: "Plot456",
    },
    boundaries: {
        north: "North boundary",
        south: "South boundary",
        east: "East boundary",
        west: "West boundary",
    },
    tree_count: {
        breadfruit: 5,
        coconut: 10,
        jackfruit: 3,
        palmyra: 2,
    },
    tree_details: [{id:"", sub_no: "001", type: "Pine", height: "10 meters", girth: "2 meters", reproducibility: true, age:"12"}],
    tree_cutting_reasons: [{id: 2, label: "To build the house intended to be built", created_at: null, updated_at: null, value: 2}, {id: 3, label: "Due to death due to natural causes", created_at: null, updated_at: null, value: 3}],
    trees_cut_before: "Yes",
    planted_tree_count: "20",
    road_to_land: "Paved road",
});

const treeDetailsForm = ref({
    sub_no: "001",
    type: "Pine",
    height: "10 meters",
    girth: "2 meters",
    reproducibility: true,
    age: "5 years",
    // want_to_cut: true
});
// const formValue = ref({
//     id: "",
//     name: "",
//     address: "",
//     contact_number: "",
//     timber_seller_checked_value: "",
//     non_commercial_use_checked_value: "",
//     grama_niladari_division: {
//         id: "",
//         gn_code: "",
//         name: "",
//         mpa_code: "",
//     },
//     deed_details: {
//         land_deed_number: "",
//         land_deed_date: "",
//     },
//     ownership_of_land_checked_value: "",
//     land_details: {
//         land_name: "",
//         land_size: "",
//         plan_number: "",
//         plan_date: "",
//         plan_plot_number: "",
//     },
//     boundaries: {
//         north: "",
//         south: "",
//         east: "",
//         west: "",
//     },
//     tree_count: {
//         breadfruit: "",
//         coconut: "",
//         jackfruit: "",
//         palmyra: "",
//     },
//     tree_details: [
//     ],
//     tree_cutting_reasons: [],
//     trees_cut_before: "",
//     planted_tree_count: "",
//     road_to_land: "",
// });
//
// const treeDetailsForm = ref({
//     sub_no: "",
//     type: "",
//     height: "",
//     girth: "",
//     reproducibility: "",
//     age: "",
//     want_to_cut: "",
// });

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
  }
);
async function certifyAndSubmit() {
  console.log(formValue.value);
  await Http.post("timberCuttingPermitApplication", formValue.value);
  isShowing.value = false;
  emit("close", false);
}

const selectedDeedDate = computed({
  get: () => {
    const landDeedDate = formValue.value.deed_details.land_deed_date;
    return moment(landDeedDate, "YYYY-MM-DD").isValid()
      ? moment(landDeedDate).valueOf()
      : null;
  },
  set: (epoch) => {
    formValue.value.deed_details.land_deed_date = moment
      .unix(epoch / 1000)
      .format("YYYY-MM-DD");
  },
});

const selectedPlanDate = computed({
  get: () => {
    const planDate = formValue.value.land_details.plan_date;
    return moment(planDate, "YYYY-MM-DD").isValid()
      ? moment(planDate).valueOf()
      : null;
  },
  set: (epoch) => {
    formValue.value.land_details.plan_date = moment
      .unix(epoch / 1000)
      .format("YYYY-MM-DD");
  },
});

const isNewTimberCuttingPermitApplication = computed(() => {
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
      gnDivisionForDropdown.key === formValue.value.grama_niladari_division.id
    );
  });
});

const treeCuttingReasonsForSelect = computed(() => {
  return treeCuttingReasons.value.map((treeCuttingReason) => {
    return {
      ...treeCuttingReason,
      value: treeCuttingReason.id,
    };
  });
});

const selectedTreeCuttingReasons = computed({
  get: () => {
    if (!formValue.value.tree_cutting_reasons?.length) {
      return [];
    }
    return formValue.value.tree_cutting_reasons.map(
      (treeCuttingReason) => treeCuttingReason.id
    );
  },
  set: (treeCuttingReasonIds) => {
    formValue.value.tree_cutting_reasons =
      treeCuttingReasonsForSelect.value.filter((treeCuttingReason) =>
        treeCuttingReasonIds.some(
          (treeCuttingReasonId) => treeCuttingReasonId === treeCuttingReason.id
        )
      );
  },
});

onMounted(() => {
  fetchGnDivisions();
  // fetchTimberCuttingPermitApplication();
  fetchTreeCuttingReasons();
});

async function save() {
  if (isNewTimberCuttingPermitApplication.value) {
    await Http.post(`timberCuttingPermitApplication`, formValue.value);
    emit("save");

    return;
  }
}

async function fetchTimberCuttingPermitApplication() {
  // await Http.get("timberCuttingPermitApplication");
  timberCuttingPermitApplications.value = data;
}

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

function selectGramaNiladariDivision(key) {
  formValue.value.grama_niladari_division = GNDivisionOptions.value.find(
    (GNDivisionOption) => {
      return GNDivisionOption.id === key;
    }
  );
}
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
// function handleChange(e) {
//   checkedValueRef.value = e.target.value;
//   console.log(`Selected value: ${checkedValueRef.value}`);
// }
function handleChange(group, e) {
  if (group === "nonCommercialUse") {
    non_commercial_use_checked_value.value = e.target.value;
    console.log(
      `Selected non-commercial use value: ${non_commercial_use_checked_value.value}`
    );
  } else if (group === "timberSeller") {
    timber_seller_checked_value.value = e.target.value;
    console.log(
      `Selected timber seller value: ${timber_seller_checked_value.value}`
    );
  } else if (group === "ownershipOfLand") {
    ownership_of_land_checked_value.value = e.target.value;
    console.log(
      `Selected timber seller value: ${ownership_of_land_checked_value.value}`
    );
  }
}

const addTreeDetails = () => {
    formValue.value.tree_details.push({...treeDetailsForm.value});
    clearTreeForm(); // Clear the form after adding tree details
};

const clearTreeForm = () => {
  treeDetailsForm.value.sub_no = "";
  treeDetailsForm.value.type = "";
  treeDetailsForm.value.height = "";
  treeDetailsForm.value.girth = "";
  treeDetailsForm.value.reproducibility = false;
  treeDetailsForm.value.age = "";
    treeDetailsForm.value.want_to_cut = "";
};

const removeRow = (index) => {
    formValue.value.tree_details.splice(index, 1);
};

async function fetchTreeCuttingReasons() {
  const { data } = await Http.get("/treeCuttingReason");
  treeCuttingReasons.value = data;
}
</script>

<style scoped></style>
