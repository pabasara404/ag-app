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
                        <n-h5>Citizen Demographics Report</n-h5>

                    </n-grid>


                </n-tab-pane>
                <n-tab-pane name="Timber Cutting">
                    <n-h5>Timber Cutting Permit Issuance Report</n-h5>
                    <n-h5>Timber Cutting Application Status Report</n-h5>
                </n-tab-pane>
                <n-tab-pane name="Timber Transportation">
                    <n-h5>Timber Transportation Permit Report</n-h5>
                    <n-h5>Transportation Activity Report</n-h5>
                </n-tab-pane>
                <n-tab-pane name="Business Registration">
                    <n-h5>Business Registration Report</n-h5>
                    <n-h5>Business Activity Report</n-h5>
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
const columns = [
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
    {
        title: "",
        key: "actions",
        render(row) {
            return h(
                NButton,
                {
                    round: true,
                    type: "info",
                    strong: true,
                    secondary: true,
                    // renderIcon: EyeIcon,
                    size: "small",
                    onClick: () => {
                        selectedPayment.value = row;
                        isShowingEditPaymentModal.value = true;
                    },
                },
                { default: () => "View" }
            );
        },
    },
    {
        title: "",
        key: "actions",
        render(row) {
            return h(
                NButton,
                {
                    round: true,
                    type: "info",
                    strong: true,
                    secondary: true,
                    size: "small",
                    onClick: async () => {
                        await deletePayment(row);
                        await fetchPayment();
                    },
                },
                { default: () => "Delete" }
            );
        },
    },
];

onMounted(() => {
    fetchPayment();
    loadGnDivisionChart();
    loadStatusChart();
    fetchGraphData();
    fetchSubmittedApplicationsData();
});

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
