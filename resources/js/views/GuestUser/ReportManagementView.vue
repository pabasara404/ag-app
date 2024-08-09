<template>
    <n-layout style="height: 540px" has-sider>
        <n-layout style="padding-left: 8px" :inverted="inverted">
            <PageHeader title="Reports Management" />
            <n-tabs
                type="line"
                size="large"
                :tabs-padding="20"
                pane-style="padding: 20px;"
            >
                <n-tab-pane name="Grama Niladari Division">
                    <n-grid x-gap="12" :cols="2">
                        <n-gi>
                            <n-h5>Division Comparison Report</n-h5>
                            <canvas ref="gnDivisionChart"></canvas>
                        </n-gi>
                        <n-gi>
                            <n-h5>Division Activity Report</n-h5>
                            <canvas ref="issuedApplicationsChart"></canvas>
                        </n-gi>
                    </n-grid>


                </n-tab-pane>
                <n-tab-pane name="Citizen Details">
                    <n-grid x-gap="12" :cols="2">
                        <n-gi>
                            <n-h5>Citizen Application Report</n-h5>
                            <canvas ref="submittedApplicationsChart"></canvas>
                        </n-gi>
                    </n-grid>
                        <n-h5>Citizen Demographics Report</n-h5>
                        <n-space vertical>
                            <n-data-table
                                :loading="isLoading"
                                :columns="citizenColumns"
                                :data="citizens"
                                :bordered="false"
                            />
                        </n-space>



                </n-tab-pane>
                <n-tab-pane name="Timber Cutting">
                    <n-h5>Timber Cutting Permit Issuance Report</n-h5>
                    <n-data-table
                        :loading="isLoading"
                        :columns="timberCuttingColumns"
                        :data="timberCuttingApplications"
                        :bordered="false"
                    />
                    <n-h5>Timber Cutting Application Status Report</n-h5>
                    <n-data-table
                        :loading="isLoading"
                        :columns="allTimberCuttingColumns"
                        :data="allTimberCuttingApplications"
                        :bordered="false"
                    />
                </n-tab-pane>
                <n-tab-pane name="Timber Transportation">
                    <n-h5>Timber Transportation Permit Report</n-h5>
                    <n-data-table
                        :loading="isLoading"
                        :columns="timberTransportationColumns"
                        :data="timberTransportationApplications"
                        :bordered="false"
                    />
                    <n-h5>Transportation Activity Report</n-h5>
                    <n-data-table
                        :loading="isLoading"
                        :columns="allTimberTransportationColumns"
                        :data="allTimberTransportationApplications"
                        :bordered="false"
                    />
                </n-tab-pane>
                <n-tab-pane name="Business Registration">
                    <n-h5>Individual Business Registration Report</n-h5>
                        <n-data-table
                            :loading="isLoading"
                            :columns="individualBusinessColumns"
                            :data="individualBusinessApplications"
                            :bordered="false"
                        />
                    <n-h5>Individual Business Activity Report</n-h5>
                        <n-data-table
                            :loading="isLoading"
                            :columns="allIndividualBusinessColumns"
                            :data="allIndividualBusinessApplications"
                            :bordered="false"
                        />
                    <n-h5>Firm Registration Report</n-h5>
                        <n-data-table
                            :loading="isLoading"
                            :columns="allIndividualBusinessColumns"
                            :data="firmApplications"
                            :bordered="false"
                        />
                    <n-h5>Firm Activity Report</n-h5>
                        <n-data-table
                            :loading="isLoading"
                            :columns="allIndividualBusinessColumns"
                            :data="allFirmApplications"
                            :bordered="false"
                        />
                </n-tab-pane>
                <n-tab-pane name="Income Certificates">
                    <n-h5>Income Certificate Issuance Report</n-h5>
                    <n-data-table
                        :loading="isLoading"
                        :columns="incomeColumns"
                        :data="incomeApplications"
                        :bordered="false"
                    />
                    <n-h5>Income Certificate Application Status Report</n-h5>
                    <n-data-table
                        :loading="isLoading"
                        :columns="allIncomeColumns"
                        :data="allIncomeApplications"
                        :bordered="false"
                    />
                </n-tab-pane>
                <n-tab-pane name="Animal Transportation">
                    <n-h5>Animal Transportation Permit Report</n-h5>
                    <n-data-table
                        :loading="isLoading"
                        :columns="animalColumns"
                        :data="animalApplications"
                        :bordered="false"
                    />
                    <n-h5>Animal Transportation Activity Report</n-h5>
                    <n-data-table
                        :loading="isLoading"
                        :columns="allAnimalColumns"
                        :data="allAnimalApplications"
                        :bordered="false"
                    />
                </n-tab-pane>
                <n-tab-pane name="Valuation Report">
                    <n-h5>Valuation Report Issuance Report</n-h5>
                    <n-data-table
                        :loading="isLoading"
                        :columns="valuationColumns"
                        :data="valuationApplications"
                        :bordered="false"
                    />
                    <n-h5>Valuation Activity Report</n-h5>
                    <n-data-table
                        :loading="isLoading"
                        :columns="allValuationColumns"
                        :data="allValuationApplications"
                        :bordered="false"
                    />
                </n-tab-pane>

            </n-tabs>
        </n-layout>


    </n-layout>
</template>

<script setup>
import {h, nextTick, onMounted, ref} from "vue";
import Http from "@/services/http";
import { NButton, NIcon } from "naive-ui";
import PageHeader from "@/components/PageHeader.vue";
const isShowingEditPaymentModal = ref(false);
import { Chart, registerables } from 'chart.js';
Chart.register(...registerables);
const selectedPayment = ref(false);
const inverted = ref(false);
const isLoading = ref(false);
const graphData = ref([]);
const chart = ref(null);
const citizens = ref([]);
const timberCuttingApplications = ref([]);
const allTimberCuttingApplications = ref([]);
const individualBusinessApplications = ref([]);
const allIndividualBusinessApplications = ref([]);
const firmApplications = ref([]);
const allFirmApplications = ref([]);
const incomeApplications = ref([]);
const allIncomeApplications = ref([]);
const animalApplications = ref([]);
const allAnimalApplications = ref([]);
const valuationApplications = ref([]);
const allValuationApplications = ref([]);
const timberTransportationApplications = ref([]);
const allTimberTransportationApplications = ref([]);
const submittedApplicationsChart = ref(null);
const issuedApplicationsChart = ref(null);
const statusChart = ref(null);

const payments = ref([]);
const citizenColumns = [
    {
        title: "Name",
        key: "name",
    },
    {
        title: "NIC",
        key: "nic",
    },
    {
        title: "Address",
        key: "address",
    },
    {
        title: "Contact Number",
        key: "contact_number",
    },
    {
        title: "DOB",
        key: "date_of_birth",
    },
];


const timberCuttingColumns = [
    {
        title: "Name of Applicant",
        key: "name",
    },
    {
        title: "Tree count",
        key: "tree_count",
    },
    {
        title: "Address",
        key: "address",
    },
    {
        title: "Comment",
        key: "comment",
    },
    {
        title: "Submitted date",
        key: "submission_timestamp",
    }
];

const allTimberCuttingColumns = [
    {
        title: "Name of Applicant",
        key: "name",
    },
    {
        title: "Tree count",
        key: "tree_count",
    },
    {
        title: "Address",
        key: "address",
    },
    {
        title: "Comment",
        key: "comment",
    },
    {
        title: "Status",
        key: "status",
    },
    {
        title: "Submitted date",
        key: "submission_timestamp",
    }
];

const individualBusinessColumns = [
    {
        title: "Reference No.",
        key: "application_code",
    },
    {
        title: "Name of the business",
        key: "business_name",
    },
    {
        title: "Nature of the Business",
        key: "nature",
    },
    {
        title: "Initial Capital",
        key: "initial_capital",
    },
    {
        title: "Submitted date",
        key: "submission_timestamp",
    },
    {
        title: "Last updated date",
        key: "updated_at",
    }
];

const allIndividualBusinessColumns = [
    {
        title: "Reference No.",
        key: "application_code",
    },
    {
        title: "Name of the business",
        key: "business_name",
    },
    {
        title: "Nature of the Business",
        key: "nature",
    },
    {
        title: "Initial Capital",
        key: "initial_capital",
    },
    {
        title: "Status",
        key: "status",
    },
    {
        title: "Submitted date",
        key: "submission_timestamp",
    },
    {
        title: "Last updated date",
        key: "updated_at",
    }
];

const incomeColumns = [
    {
        title: "Reference No.",
        key: "application_code",
    },
    {
        title: "Name of the Applicant",
        key: "name",
    },
    {
        title: "Total Annual Income",
        key: "total_annual_income",
    },
    {
        title: "Reason",
        key: "purpose",
    },
    {
        title: "Submitted date",
        key: "submission_timestamp",
    },
    {
        title: "Last updated date",
        key: "updated_at",
    },

];

const allIncomeColumns = [
    {
        title: "Reference No.",
        key: "application_code",
    },
    {
        title: "Name of the Applicant",
        key: "name",
    },
    {
        title: "Total Annual Income",
        key: "total_annual_income",
    },
    {
        title: "Reason",
        key: "purpose",
    },
    {
        title: "Status",
        key: "status",
    },
    {
        title: "Submitted date",
        key: "submission_timestamp",
    },
    {
        title: "Last updated date",
        key: "updated_at",
    }
];
const animalColumns = [
    {
        title: "Reference No.",
        key: "application_code",
    },
    {
        title: "Name of the Applicant",
        key: "name",
    },
    {
        title: "Total Animals",
        key: "total_animal_count",
    },
    {
        title: "Reason",
        key: "reason_to_transport",
    },
    {
        title: "Submitted Date",
        key: "submission_timestamp",
    },
    {
        title: "Issued Date",
        key: "issued_date",
    },
    {
        title: "Last updated Date",
        key: "updated_at",
    },
    {
        title: "Expire Date",
        key: "expire_date",
    },
];

const allAnimalColumns = [
    {
        title: "Reference No.",
        key: "application_code",
    },
    {
        title: "Name of the Applicant",
        key: "name",
    },
    {
        title: "Total Animals",
        key: "total_animal_count",
    },
    {
        title: "Reason",
        key: "reason_to_transport",
    },
    {
        title: "Status",
        key: "status",
    },
    {
        title: "Submitted Date",
        key: "submission_timestamp",
    },
    {
        title: "Issued Date",
        key: "issued_date",
    },
    {
        title: "Last updated Date",
        key: "updated_at",
    },
    {
        title: "Expire Date",
        key: "expire_date",
    },
];

const valuationColumns = [
    {
        title: "Reference No.",
        key: "application_code",
    },
    {
        title: "Name of the Applicant",
        key: "name",
    },
    {
        title: "Valuation amount",
        key: "valuation_amount",
    },
    {
        title: "Reason",
        key: "reason",
    },
    {
        title: "Submitted date",
        key: "submission_timestamp",
    },
    {
        title: "Last updated date",
        key: "updated_at",
    }
];

const allValuationColumns = [
    {
        title: "Reference No.",
        key: "application_code",
    },
    {
        title: "Name of the Applicant",
        key: "name",
    },
    {
        title: "Valuation amount",
        key: "valuation_amount",
    },
    {
        title: "Reason",
        key: "reason",
    },
    {
        title: "Status",
        key: "status",
    },
    {
        title: "Submitted date",
        key: "submission_timestamp",
    },
    {
        title: "Last updated date",
        key: "updated_at",
    }
];

const allTimberTransportationColumns= [
    {
        title: "Reference Number",
        key: "application_code",
    },{
        title: "Name of Applicant",
        key: "name",
    },
    {
        title: "Total Pieces",
        key: "total_pieces",
    },
    {
        title: "Address",
        key: "address",
    },
    {
        title: "Status",
        key: "status",
    },
    {
        title: "Submitted date",
        key: "submission_timestamp",
    },
    {
        title: "Last updated date",
        key: "updated_at",
    }];

const timberTransportationColumns = [
    {
        title: "Reference Number",
        key: "application_code",
    },{
        title: "Name of Applicant",
        key: "name",
    },
    {
        title: "Total Pieces",
        key: "total_pieces",
    },
    {
        title: "Address",
        key: "address",
    },
    {
        title: "Submitted date",
        key: "submission_timestamp",
    },
    {
        title: "Last updated date",
        key: "updated_at",
    }
];

onMounted(() => {
    fetchPayment();
    fetchGraphData();
    fetchSubmittedApplicationsData();
    fetchCitizen();
    fetchTimberCuttingApplication();
    fetchAllTimberCuttingApplication();
    fetchIndividualBusinessApplication();
    fetchAllIndividualBusinessApplication();
    fetchFirmApplication();
    fetchAllFirmApplication();
    fetchIncomeApplication();
    fetchAllIncomeApplication();
    fetchAnimalApplication();
    fetchAllAnimalApplication();
    fetchValuationApplication();
    fetchAllValuationApplication();
    fetchValuationApplication();
    fetchAllValuationApplication();
    fetchAllTimberTransportingApplication();
    fetchTimberTransportingApplication();
    nextTick(() => {
        loadGnDivisionChart();
        loadStatusChart();
        renderChart();
    });
});

async function fetchCitizen() {
    isLoading.value = true;
    const { data } = await Http.get("citizen");
    isLoading.value = false;
    citizens.value = data.data;
}

async function fetchTimberCuttingApplication() {
    isLoading.value = true;
    const { data } = await Http.get("timberCuttingPermitApplicationByStatus", {
        params: {
            status: 'Issued'
        }
    });
    isLoading.value = false;
    timberTransportationApplications.value = data.data; // Ensure the response is handled correctly
}

async function fetchAllTimberCuttingApplication() {
    isLoading.value = true;
    const {data} = await Http.get("timberCuttingPermitApplication");
    isLoading.value = false;
    allTimberTransportationApplications.value = data.data;
}

async function fetchIndividualBusinessApplication() {
    isLoading.value = true;
    const { data } = await Http.get("individualBusinessByStatus", {
        params: {
            status: 'Issued'
        }
    });
    isLoading.value = false;
    individualBusinessApplications.value = data.data;
}

async function fetchAllIndividualBusinessApplication() {
    isLoading.value = true;
    const {data} = await Http.get("individualBusiness");
    isLoading.value = false;
    allIndividualBusinessApplications.value = data.data;
}

async function fetchFirmApplication() {
    isLoading.value = true;
    const { data } = await Http.get("firmByStatus", {
        params: {
            status: 'Issued'
        }
    });
    isLoading.value = false;
    firmApplications.value = data.data;
}


async function fetchAllFirmApplication() {
    isLoading.value = true;
    const {data} = await Http.get("firmApplication");
    isLoading.value = false;
    allFirmApplications.value = data.data;
}

async function fetchAllIncomeApplication() {
    isLoading.value = true;
    const {data} = await Http.get("incomeCertificate");
    isLoading.value = false;
    allIncomeApplications.value = data.data;
}

async function fetchIncomeApplication() {
    isLoading.value = true;
    const { data } = await Http.get("incomeCertificateByStatus", {
        params: {
            status: 'Issued'
        }
    });
    isLoading.value = false;
    incomeApplications.value = data.data;
}

async function fetchAnimalApplication() {
    isLoading.value = true;
    const { data } = await Http.get("animalTransportationByStatus", {
        params: {
            statuses: 'Issued'
        }
    });
    isLoading.value = false;
    animalApplications.value = data.data;
}
async function fetchAllAnimalApplication() {
    isLoading.value = true;
    const {data} = await Http.get("animalTransportation");
    isLoading.value = false;
    allAnimalApplications.value = data.data;
}
async function fetchValuationApplication() {
    isLoading.value = true;
    const { data } = await Http.get("valuationByStatus", {
        params: {
            statuses: 'Issued'
        }
    });
    isLoading.value = false;
    valuationApplications.value = data.data;
}

async function fetchAllValuationApplication() {
    isLoading.value = true;
    const {data} = await Http.get("valuation");
    isLoading.value = false;
    allValuationApplications.value = data.data;
}

async function fetchTimberTransportingApplication() {
    isLoading.value = true;
    const { data } = await Http.get("timberTransportingPermitApplicationByStatus", {
        params: {
            status: 'Issued'
        }
    });
    isLoading.value = false;
    valuationApplications.value = data.data;
}

async function fetchAllTimberTransportingApplication() {
    isLoading.value = true;
    const {data} = await Http.get("timberTransportingPermitApplication");
    isLoading.value = false;
    allValuationApplications.value = data.data;
}



function addNewPayment() {
    selectedPayment.value = {
        id: "",
        name: "",
        nic: "",
        address: "",
        contact_number: "",
        user: "",
        date_of_birth: "2000-12-01",
    };

    isShowingEditPaymentModal.value = true;
}

function renderIcon(icon) {
    return () => h(NIcon, null, { default: () => h(icon) });
}
async function fetchPayment() {
    isLoading.value = true;
    const { data } = await Http.get("payment");
    isLoading.value = false;
    payments.value = data.data;
}

async function deletePayment(payment) {
    isLoading.value = true;
    await Http.delete(`payment/${payment.id}`);
    isLoading.value = false;
}

const gnDivisionChart = ref(null);
async function loadGnDivisionChart() {
    try {
        const response = await Http.get('/applicationCountsByGNDivision');
        const counts = response.data;

        const labels = Object.keys(counts);
        const data = Object.values(counts);

        if (gnDivisionChart.value) {
            new Chart(gnDivisionChart.value, {
                type: 'bar',
                data: {
                    labels: labels,
                    datasets: [
                        {
                            label: 'Application Count by GN Division',
                            data: data,
                            backgroundColor: 'rgba(75, 192, 192, 0.2)',
                            borderColor: 'rgba(75, 192, 192, 1)',
                            borderWidth: 1,
                        },
                    ],
                },
                options: {
                    scales: {
                        y: {
                            beginAtZero: true,
                        },
                    },
                },
            });
        }
    } catch (error) {
        console.error(error);
    }
}


async function loadStatusChart() {
    try {
        const response = await Http.get('/applicationCountsByStatus');
        const counts = response.data;

        const labels = Object.keys(counts);
        const data = Object.values(counts);
        if (statusChart.value) {
        new Chart(document.getElementById('statusChart'), {
            type: 'bar',
            data: {
                labels: labels,
                datasets: [
                    {
                        label: 'Application Count by Status',
                        data: data,
                        backgroundColor: 'rgba(75, 192, 192, 0.2)',
                        borderColor: 'rgba(75, 192, 192, 1)',
                        borderWidth: 1,
                    },
                ],
            },
            options: {
                scales: {
                    y: {
                        beginAtZero: true,
                    },
                },
            },
        });}
    } catch (error) {
        console.error(error);
    }
}



const fetchGraphData = async () => {
    try {
        const response = await Http.get('/issuedApplicationCounts');
        graphData.value = response.data;
        renderChart();
    } catch (error) {
        console.error(error);
    }
};

const renderChart = () => {
    if (chart.value) {
        chart.value.destroy();
    }
    if (issuedApplicationsChart.value) {
        chart.value = new Chart(issuedApplicationsChart.value, {
        type: 'bar',
        data: {
            labels: graphData.value.map(item => item.gn_division),
            datasets: [{
                label: 'Issued Applications',
                data: graphData.value.map(item => item.count),
                backgroundColor: 'rgba(75, 192, 192, 0.2)',
                borderColor: 'rgba(75, 192, 192, 1)',
                borderWidth: 1
            }]
        },
        options: {
            responsive: true,
            scales: {
                y: {
                    beginAtZero: true
                }
            }
        }
    });}
}

const fetchSubmittedApplicationsData = async () => {
    try {
        const response = await Http.get('/submittedApplicationCounts');
        const data = response.data;
        renderSubmittedApplicationsChart(data);
    } catch (error) {
        console.error('Failed to fetch submitted application data:', error);
    }
};

const renderSubmittedApplicationsChart = (data) => {
    if (submittedApplicationsChart.value) {
        const ctx = submittedApplicationsChart.value.getContext("2d");
    const labels = [
        "TCP", "TTP", "IBRC", "FRC", "IC", "ATP", "PF", "MP", "EL", "VR"
    ];
    const dataKeys = [
        "timber_cutting_permit_applications",
        "timber_transporting_applications",
        "individual_businesses",
        "firms",
        "income_certificates",
        "president_funds",
        "mahapolas",
        "excises",
        "valuations"
    ];
    const dataValues = dataKeys.map(key => data[key] || 0);

    new Chart(ctx, {
        type: "bar",
        data: {
            labels: labels,
            datasets: [
                {
                    label: "Submitted Applications Count",
                    data: dataValues,
                    backgroundColor: [
                        "rgb(255, 99, 132)",
                        "rgb(54, 162, 235)",
                        "rgb(255, 205, 86)",
                        "rgb(75, 192, 192)",
                        "rgb(153, 102, 255)",
                        "rgb(255, 159, 64)",
                        "rgb(0, 255, 255)",
                        "rgb(255, 0, 255)",
                        "rgb(128, 128, 128)"
                    ],
                },
            ],
        },
        options: {
            responsive: true,
            plugins: {
                legend: {
                    position: "top",
                },
                title: {
                    display: true,
                    text: "Number and Types of Applications Submitted",
                },
            },
            scales: {
                x: {
                    beginAtZero: true,
                },
            },
        },
    });
    }
}
</script>
