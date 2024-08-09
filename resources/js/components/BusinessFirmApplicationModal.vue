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
                    <n-h2 v-else>Application for Registration of a Business Name By a Firm</n-h2>
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
                <n-form-item label="The Business Name" path="business_name">
                    <n-input
                        :disabled="initialStatus==='Escalated'"
                        v-model:value="formValue.business_name"
                        placeholder="Enter Name of the Business"
                    />
                </n-form-item>
                <n-form-item label="The General Nature Of the Business" path="nature">
                    <n-input
                        :disabled="initialStatus==='Escalated'"
                        v-model:value="formValue.nature"
                        placeholder="The General Nature Of the Business"
                    /> <n-tooltip trigger="hover">
                    <template #trigger>
                        <n-icon><InformationCircleOutlineIcon /></n-icon>
                    </template>
                    <span>If trading. / export of manufacture. state clearly the of goods that are being traded imported/ exported or manufactured</span>
                </n-tooltip></n-form-item
                ><n-form-item label="The Principal Place of the Business" path="principal_place">
                <n-input
                    :disabled="initialStatus==='Escalated'"
                    v-model:value="formValue.principal_place"
                    placeholder="The Principal Place of the Business" /></n-form-item>
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
                <n-form-item label="Initial Capital of the Business" path="initial_capital">
                    <n-input
                        :disabled="initialStatus==='Escalated'"
                        v-model:value="formValue.initial_capital"
                        placeholder="Initial Capital of the Business" />
                </n-form-item>
                <n-form-item label="If any Branch Office/ Store / Stores Warehouse is prevailing the address">
                    <div v-for="(address, index) in formValue.addresses" :key="index">
                        <n-input
                            :disabled="initialStatus==='Escalated'" class="my-1"
                            maxlength="255" show-count clearable
                            v-model:value="formValue.addresses[index].name"
                            placeholder="If any Branch Office/Store/Stores Warehouse is prevailing the address"
                        />
                    </div>
                </n-form-item>
                <n-button
                    :disabled="initialStatus==='Escalated'" @click="addAddress">Add Another Address</n-button>
                <br /><br />
                <n-form-item label="The Date of Commencement of the Business" path="nature">
                    <n-date-picker
                        :disabled="initialStatus==='Escalated'" v-model:value="selectedStartDate" type="date" /> <n-tooltip trigger="hover">
                    <template #trigger>
                        <n-icon><InformationCircleOutlineIcon /></n-icon>
                    </template>
                    <span>State here the actual date of commencement of Business activities.</span>
                </n-tooltip></n-form-item>

                <n-card v-if="isNewApplication" title="Enter details of the partners">
                    <n-form-item label="Full Name of each partner of the Firm">
                        <n-input
                            :disabled="initialStatus==='Escalated'"
                            v-model:value="partnerDetailsForm.full_name"
                            placeholder="Sub no"
                        /><n-tooltip trigger="hover">
                        <template #trigger>
                            <n-icon><InformationCircleOutlineIcon /></n-icon>
                        </template>
                        <span>(Full name with names denoted by Initials. If any partner is an Incorporated Company the Corporate Name should stated.</span>
                    </n-tooltip>
                    </n-form-item>
                    <n-form-item label="If any previous Name for the Partner Name in full" path="partnerName">
                        <n-input
                            :disabled="initialStatus==='Escalated'"
                            v-model:value="partnerDetailsForm.previous_name"
                            placeholder="If any previous Name for the Partner Name in full"
                        /> <n-tooltip trigger="hover">
                        <template #trigger>
                            <n-icon><InformationCircleOutlineIcon /></n-icon>
                        </template>
                        <span>Any other Name (In full) used In addition to the usual name. In case of a married woman the maiden name (in full)</span>
                    </n-tooltip></n-form-item>
                    <n-form-item label="If the partner is a government officer?" path="timberSeller">
                    <n-radio-group
                        :disabled="initialStatus==='Escalated'"
                        v-model:value="partnerDetailsForm.government_officer_checked_value"
                        name="governmentOfficer"
                    >
                        <n-space>
                            <n-radio :value="'Yes'" label="Yes"> Yes </n-radio>
                            <n-radio :value="'No'" label="No"> No </n-radio>
                        </n-space>
                    </n-radio-group>
                </n-form-item>
                    <n-form-item label="The Nationality of the Partner" path="ownerNationality">
                        <n-input
                            :disabled="initialStatus==='Escalated'"
                            v-model:value="partnerDetailsForm.nationality"
                            placeholder="The Nationality of the Partner" /><n-tooltip trigger="hover">
                        <template #trigger>
                            <n-icon><InformationCircleOutlineIcon /></n-icon>
                        </template>
                        <span>If a corporation the cooperated law</span>
                    </n-tooltip>
                    </n-form-item>
                    <n-form-item label="National Identity Card Number" path="partnerNic">
                        <n-input
                            :disabled="initialStatus==='Escalated'"
                            v-model:value="partnerDetailsForm.nic"
                            placeholder="National Identity Card Number" /><n-tooltip trigger="hover">
                        <template #trigger>
                            <n-icon><InformationCircleOutlineIcon /></n-icon>
                        </template>
                        <span>If a corporation, Registered No.</span>
                    </n-tooltip>
                    </n-form-item>
                    <n-form-item label="Telephone Number" path="partnerNic">
                        <n-input
                            :disabled="initialStatus==='Escalated'"
                            v-model:value="partnerDetailsForm.contact_number"
                            placeholder="Telephone Number" />
                    </n-form-item>
                    <n-form-item label="The Usual residence of the Partner" path="partnerResidence">
                        <n-input
                            :disabled="initialStatus==='Escalated'"
                            v-model:value="partnerDetailsForm.residence"
                            placeholder="The Usual residence of the Partner" /><n-tooltip trigger="hover">
                        <template #trigger>
                            <n-icon><InformationCircleOutlineIcon /></n-icon>
                        </template>
                        <span>If any partner is an Incorporated Company Registered Principle Office should stated</span>
                    </n-tooltip>
                    </n-form-item>
                        <n-form-item label="If the Partner have other occupation?" path="otherBusiness">
                            <n-radio-group
                                :disabled="initialStatus==='Escalated'"
                                v-model:value="formValue.is_other_occupation_value"
                                name="otherBusiness"
                            >
                                <n-space>
                                    <n-radio :value="'Yes'" label="Yes"> Yes </n-radio>
                                    <n-radio :value="'No'" label="No"> No </n-radio>
                                </n-space>
                            </n-radio-group>
                        </n-form-item>
                        <div v-if="formValue.is_other_occupation_value  ==='Yes'">
                                <n-form-item label="Occupation name" >
                                    <n-input
                                        v-model:value="partnerDetailsForm.occupation"
                                        placeholder="Occupation name" />
                                </n-form-item>
                        </div>
                    <n-form-item label="If the Partner in any other business?" path="otherBusiness">
                        <n-radio-group
                            :disabled="initialStatus==='Escalated'"
                            v-model:value="formValue.is_other_business_value"
                            name="otherBusiness"
                        >
                            <n-space>
                                <n-radio :value="'Yes'" label="Yes"> Yes </n-radio>
                                <n-radio :value="'No'" label="No"> No </n-radio>
                            </n-space>
                        </n-radio-group>
                    </n-form-item>
                    <div v-if="formValue.is_other_business_value ==='Yes'">
                        <n-card v-if="isNewApplication" title="Business Details">
                            <n-form-item label="Business Registration no" path="registration_no">
                                <n-input
                                    :disabled="initialStatus==='Escalated'"
                                    v-model:value="otherBusinessDetailsForm.registration_no"
                                    placeholder="Business Registration number" />
                            </n-form-item>
                            <n-form-item label="Name of the other business" path="partnerResidence">
                                <n-input
                                    :disabled="initialStatus==='Escalated'"
                                    v-model:value="otherBusinessDetailsForm.business_name"
                                    placeholder="Name of the other business" />
                            </n-form-item>
                            <n-form-item label="Registered Date" path="registered_date">
                                <n-date-picker
                                    :disabled="initialStatus==='Escalated'"
                                    v-model:value="selectedRegisteredDate" type="date" />
                            </n-form-item>
                            <n-form-item label="The General Nature Of the Business" path="nature">
                                <n-input
                                    :disabled="initialStatus==='Escalated'"
                                    v-model:value="otherBusinessDetailsForm.nature"
                                    placeholder="The General Nature Of the Business"
                                />
                                <n-tooltip trigger="hover">
                                    <template #trigger>
                                        <n-icon><InformationCircleOutlineIcon /></n-icon>
                                    </template>
                                    <span>If trading. / export of manufacture. state clearly the of goods that are being traded imported/ exported or manufactured</span>
                                </n-tooltip>
                            </n-form-item>
                            <n-button
                                :disabled="initialStatus==='Escalated'" @click="addOtherBusinessDetails">Add Business</n-button>

                        </n-card>
                            <n-form-item>
                                <n-table :bordered="false" :single-line="false">
                                    <thead>
                                    <tr>
                                        <th>Business Registration No</th>
                                        <th>Business Name</th>
                                        <th>Registered Date</th>
                                        <th>Nature of the Business</th>
                                        <th>Remove</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <tr v-for="(otherBusiness, key) in otherBusinessDetails" :key="key">
                                        <td>{{ otherBusiness.registration_no }}</td>
                                        <td>{{ otherBusiness.business_name }}</td>
                                        <td>{{ otherBusiness.registered_date }}</td>
                                        <td>{{ otherBusiness.nature }}</td>
                                        <td>
                                            <n-button @click="removeBusinessRow(key)">
                                                <n-icon><clear-outlined-icon /></n-icon>
                                            </n-button>
                                        </td>
                                    </tr>
                                    </tbody>
                                </n-table>
                            </n-form-item>

                        <br/>
                    </div>
                    <br/>
                    <n-form-item label="If the owner is a director of a cooperation?" path="is_director">
                        <n-radio-group
                            :disabled="initialStatus==='Escalated'" v-model:value="partnerDetailsForm.is_director" name="otherBusiness">
                            <n-space>
                                <n-radio :value="'Yes'" label="Yes"> Yes </n-radio>
                                <n-radio :value="'No'" label="No"> No </n-radio>
                            </n-space>
                        </n-radio-group>
                    </n-form-item>
                    <div v-if="partnerDetailsForm.is_director ==='Yes'">
                        <n-card v-if="isNewApplication">
                            <n-form-item label="Registration no" path="registration_no">
                                <n-input
                                    :disabled="initialStatus==='Escalated'" v-model:value="directorDetailsForm.registration_no" placeholder="Registration number" />
                            </n-form-item>
                            <n-form-item label="Corporation Name">
                                <n-input v-model:value="directorDetailsForm.name" placeholder="Name" />
                            </n-form-item>
                            <br />
                            <n-button @click="addDirectorDetails">Add Director Details</n-button>
                        </n-card>
                    <br />
                    <n-form-item>
                        <n-table :bordered="false" :single-line="false">
                            <thead>
                            <tr>
                                <th>Registration No</th>
                                <th>Name</th>
                                <th>Remove</th>
                            </tr>
                            </thead>
                            <tbody>
                            <tr :key="key" v-for="(director_detail, key) in directorDetails">
                                <td>{{ director_detail.registration_no }}</td>
                                <td>{{ director_detail.name }}</td>
                                <td>
                                    <n-button
                                        :disabled="initialStatus==='Escalated'" @click="removeDirectorRow(key)">
                                        <n-icon><clear-outlined-icon /></n-icon>
                                    </n-button>
                                </td>
                            </tr>
                            </tbody>
                        </n-table>
                    </n-form-item>
                    <br/>
                    </div>

                    <p>After Entering the details click below button to add partner details.</p><br/>
                    <n-button
                        :disabled="initialStatus==='Escalated'" @click="addPartnerDetails">Add Partner</n-button>

                </n-card>
                    <n-h5>Partner List: </n-h5>
                    <n-form-item>
                        <n-table :bordered="false" :single-line="false">
                            <thead>
                            <tr>
                                <th>Business Registration No</th>
                                <th>Business Name</th>
                                <th>Registered Date</th>
                                <th>Nature of the Business</th>
                                <th>Remove</th>
                            </tr>
                            </thead>
                            <tbody>
                            <tr v-for="(partner, key) in partnerDetails" :key="key">
                                    <td>{{ partner.full_name }}</td>
                                    <td>{{ partner.nationality }}</td>
                                    <td>{{ partner.contact_number }}</td>
                                    <td>{{ partner.nic }}</td>
                                    <td>
                                        <n-button
                                            :disabled="initialStatus==='Escalated'" @click="removePartnerRow(key)">
                                            <n-icon><clear-outlined-icon /></n-icon>
                                        </n-button>
                                    </td>
                            </tr>
                            </tbody>
                        </n-table>
                    </n-form-item>
                <br/>
                <p>The above statement of particulars required for the purpose of registration is hereby furnished by me.</p><br/>
                <n-card v-if="!isNewApplication">
                    <n-h3>By GN Officer</n-h3>
                    <n-form-item label="Ownership of land" path="ownershipOfLand">
                        <n-radio-group
                            :disabled="initialStatus==='Pending' || initialStatus==='Escalated'"
                            v-model:value="formValue.ownership_of_land_checked_value"
                            name="ownershipOfLand"
                        >
                            <n-space>
                                <n-radio :value="'Freehold(Sinnakkara)'" label="Freehold(Sinnakkara)">Freehold(Sinnakkara)</n-radio>
                                <n-radio :value="'Co-owner'" label="Co-owner">Co-owner</n-radio>
                                <n-radio :value="'Granted by Government(Swarnabhumi)'" label="Granted by Government(Swarnabhumi)">Granted by Government(Swarnabhumi)</n-radio>
                                <n-radio :value="'Lease'" label="Lease">Lease</n-radio>
                                <n-radio :value="'Rent'" label="Rent">Rent</n-radio>
                                <n-radio :value="'Government Permitted'" label="Government Permitted">Government Permitted</n-radio>
                                <n-radio :value="'Illegal'" label="Illegal">Illegal</n-radio>
                            </n-space>
                        </n-radio-group>
                    </n-form-item>
                    <n-form-item label="Checked Date" path="land_deed_date">
                        <n-date-picker
                            :disabled="initialStatus==='Pending' || initialStatus==='Escalated'" v-model:value="selectedCheckedDate" type="date" />
                    </n-form-item>
                    <n-form-item
                        label="Any comment about application"
                    >
                        <n-input
                            :disabled="initialStatus==='Pending'"
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
                            :disabled="initialStatus==='Pending' || initialStatus==='Escalated'"
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
                >I certify that I have the legal right to the land related to business registration and that there is no dispute, that the above information is
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
const message = useMessage();

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
    business_name: "Tech Innovators",
    nature: "Technology",
    principal_place: "123 Tech Lane",
    initial_capital: "50000",
    addresses: [
        { id: "", name: "Main Office" },
        { id: "", name: "Branch Office" }
    ],
    start_date: "2024-01-01",
    gn_division: {
        id: "74",
        gn_code: "370",
        name: "Kotugoda",
        mpa_code: "204",
    },
    partner_details: [
        {
            id: "",
            full_name: "John Doe",
            previous_name: "John Smith",
            government_officer_checked_value: "Yes",
            nationality: "American",
            nic: "A1234567",
            contact_number: "123-456-7890",
            residence: "456 Elm Street",
            is_other_occupation_value: "Yes",
            occupation: "Engineer",
            is_other_business_value: "Yes",
            other_partnered_businesses: [
                { id: "", registration_no: "B123", business_name: "Tech Ventures", registered_date: "2022-05-15", nature: "Consulting" }
            ],
            is_director: "Yes",
            director_details: [
                { id: "", business_name: "Tech Holdings", registration_no: "D123" }
            ]
        }
    ],
    checked_date: "2024-07-01",
    comment: "",
    status: "Submitted",
    ownership_of_land_checked_value: "Rent",
    submission_timestamp:"",
    application_code:"",
    user: getLocalAuthUser()
});

const partnerDetailsForm = ref({
    id: "",
    full_name: "Jane Smith",
    previous_name: "Jane Doe",
    government_officer_checked_value: "Yes",
    nationality: "Canadian",
    nic: "C9876543",
    contact_number: "987-654-3210",
    residence: "789 Maple Avenue",
    is_other_occupation_value: "Yes",
    occupation: "Manager",
    is_other_business_value: "Yes",
    other_partnered_businesses: [],
    is_director: "Yes",
    director_details: []
});

const otherBusinessDetailsForm = ref({
    id: "",
    registration_no: "O456",
    business_name: "Creative Solutions",
    registered_date: "2023-03-10",
    nature: "Design"
});

const directorDetailsForm = ref({
    id: "",
    name: "Innovative Holdings",
    registration_no: "D789"
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

const isNewApplication = computed(() => {
    return !formValue.value.id;
});

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
            formValue.value.status = "Submitted";
            await Http.post("firmApplication", formValue.value);
            message.success("Application was submitted successfully!");
            emit("close", false);
            return;
        }

        if (props.initialStatus === "Pending" && formValue.value.status === "Pending") {
            formValue.value.status = "Resubmitted";
        }

        await Http.put(`firmApplication/${formValue.value.id}`, formValue.value);
        message.success("Application was updated successfully!");
        emit("close", false);
    }catch (e) {
        console.error(e);
        message.error("An error occurred while saving the Application");
    }
}

const gnDivisionsForDropdown = computed(() => {
    return GNDivisionOptions.value.map((gnDivisionOption) => {
        return {
            key: gnDivisionOption.id,
            label: gnDivisionOption.name,
        };
    });
});
const selectedGramaNiladariDivision = computed(() => {
    if (!formValue.value.gn_division) {
        return null;
    }
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



const partnerDetails = ref([]);

const addPartnerDetails = () => {
    partnerDetails.value.push({ ...partnerDetailsForm.value });
    clearPartnerDetailsForm();
};

const clearPartnerDetailsForm = () => {
    partnerDetailsForm.value = {
        id: "",
        full_name: "",
        previous_name: "",
        government_officer_checked_value: "",
        nationality: "",
        nic: "",
        contact_number: "",
        residence: "",
        is_other_occupation_value: "",
        occupation: "",
        is_other_business_value: "",
        other_partnered_businesses: [],
        is_director: "",
        director_details: []
    };
};

const removePartnerRow = (index) => {
    formValue.value.partner_details.splice(index, 1);
};

const otherBusinessDetails = ref([]);

const addOtherBusinessDetails = () => {
    otherBusinessDetails.value.push({ ...otherBusinessDetailsForm.value });
    clearDetailsForm();
};

const clearDetailsForm = () => {
    otherBusinessDetailsForm.value.registration_no = '';
    otherBusinessDetailsForm.value.business_name = '';
    otherBusinessDetailsForm.value.registered_date = '';
    otherBusinessDetailsForm.value.nature = '';
};

const removeBusinessRow = (index) => {
    otherBusinessDetails.value.splice(index, 1);
};

const directorDetails = ref([]);

const addDirectorDetails = () => {
    directorDetails.value.push({ ...directorDetailsForm.value });
    clearDirectorForm();
};

const clearDirectorForm = () => {
    directorDetailsForm.value.id = '';
    directorDetailsForm.value.name = '';
    directorDetailsForm.value.registration_no = '';
};

const removeDirectorRow = (index) => {
    directorDetails.value.splice(index, 1);
};



const selectedStartDate = computed({
    get: () => {
        const startDate = formValue.value.start_date;
        return moment(startDate, "YYYY-MM-DD").isValid()
            ? moment(startDate).valueOf()
            : null;
    },
    set: (epoch) => {
        formValue.value.start_date = moment
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


const selectedRegisteredDate = computed({
    get: () => {
        const registeredDate = otherBusinessDetailsForm.value.registered_date;
        return registeredDate ? new Date(registeredDate) : null;
    },
    set: (date) => {
        otherBusinessDetailsForm.value.registered_date = moment(date).format("YYYY-MM-DD");
    }
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
        await Http.put(`firmApplication/${props.application.id}`, {
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

const addresses = ref(['']);

function addAddress() {
    formValue.value.addresses.push({ id: "", name: "" });
}

</script>

<style scoped></style>
