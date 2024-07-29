<template>
    <n-layout style="height: 540px" has-sider>
        <n-layout style="padding-left: 8px" :inverted="inverted">
            <PageHeader title="Reports Management" />
<!--            <n-grid x-gap="12" :cols="2">-->
<!--                <n-gi class="my-3">-->
<!--                    <n-h5>Application Count By Status</n-h5>-->
<!--                    <canvas id="statusChart"></canvas>-->
<!--                </n-gi>-->
<!--                <n-gi>-->
<!--                    <div class="green" />-->

<!--                </n-gi>-->
<!--            </n-grid>-->
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
                            <canvas id="gnDivisionChart"></canvas>
                        </n-gi>
                        <n-gi>
                            <n-h5>Division Activity Report</n-h5>
                            <canvas id="issuedApplicationsChart"></canvas>
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
                    <n-h5>Transportation Activity Report</n-h5>
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
                    <n-h5>Firm Activity Report</n-h5>
                </n-tab-pane>
                <n-tab-pane name="Income Certificates">
                    <n-h5>Income Certificate Issuance Report</n-h5>
                    <n-h5>Income Certificate Application Status Report</n-h5>
                </n-tab-pane>
                <n-tab-pane name="Animal Transportation">
                    <n-h5>Animal Transportation Permit Report</n-h5>
                    <n-h5>Animal Transportation Activity Report</n-h5>
                </n-tab-pane>
                <n-tab-pane name="Valuation Report">
                    <n-h5>Valuation Report Issuance Report</n-h5>
                    <n-h5>Valuation Activity Report</n-h5>
                </n-tab-pane>

            </n-tabs>
        </n-layout>


    </n-layout>
</template>

<script setup>
import { h, onMounted, ref } from "vue";
import {
    PencilSharp as PencilIcon,
    Add as AddIcon,
    TrashBin as TrashBinIcon,
    Eye as EyeIcon,
} from "@vicons/ionicons5";
import Http from "@/services/http";
import { NButton, NIcon } from "naive-ui";
import EditPaymentModal from "@/components/EditPaymentModal.vue";
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
const submittedApplicationsChart = ref(null);

const options = [
    {
        label: "Sort By Recently Added",
        key: "1",
    },
    {
        label: "Sort By Oldest Added",
        key: "2",
    },
];
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
    // {
    //   title: "Role",
    //   key: "role",
    // },
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

onMounted(() => {
    fetchPayment();
    loadGnDivisionChart();
    loadStatusChart();
    fetchGraphData();
    fetchSubmittedApplicationsData();
    fetchCitizen();
    fetchTimberCuttingApplication();
    fetchAllTimberCuttingApplication();
    fetchIndividualBusinessApplication();
    fetchAllIndividualBusinessApplication();
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
    timberCuttingApplications.value = data.data; // Ensure the response is handled correctly
}

async function fetchAllTimberCuttingApplication() {
    isLoading.value = true;
    const {data} = await Http.get("timberCuttingPermitApplication");
    isLoading.value = false;
    allTimberCuttingApplications.value = data.data;
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

        new Chart(document.getElementById('gnDivisionChart'), {
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
        });
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

    chart.value = new Chart(document.getElementById('issuedApplicationsChart'), {
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
    });
};

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
};
</script>
