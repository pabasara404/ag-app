<template>
    <n-space vertical>
        <n-layout>
            <n-layout-header :inverted="inverted" bordered class="h-20">
                <div class="flex w-full justify-between nav-bar">
                    <div class="flex w-full">
                        <div>
                            <img
                                style="
                  display: inline;
                  padding: 10px 10px 10px 15px;
                  width: 60px;
                "
                                src="https://upload.wikimedia.org/wikipedia/commons/thumb/5/5f/Emblem_of_Sri_Lanka.svg/150px-Emblem_of_Sri_Lanka.svg.png"
                            />
                        </div>
                        <div class="flex flex-col py-3">
                            <div class="font-bold">
                                Permits, License and Welfare Fund Request Management System
                            </div>
                            <div class="font-bold">Divisional Secretariat - Katana</div>
                        </div>
                    </div>
                    <div class="flex w-full flex-col p-3">
                        <div class="flex justify-end">
                            <div class="pr-2">
                                <n-avatar
                                    round
                                    size="medium"
                                    src="https://07akioni.oss-cn-beijing.aliyuncs.com/07akioni.jpeg"
                                />
                            </div>
                            <div>
                                <n-button
                                    strong
                                    secondary
                                    round
                                    type="primary"
                                    size="small"
                                    @click="handleLogout"
                                >
                                    Log out
                                </n-button>
                            </div>
                        </div>
                        <div>
                            <n-space
                                style="
                  padding-right: 8px;
                  display: flex;
                  justify-content: flex-end;
                  gap: 8px 12px;
                "
                            >
                                <n-switch v-model:value="inverted" size="medium"
                                ><template #checked-icon
                                ><n-icon :component="MoonIcon" /></template
                                ><template #unchecked-icon
                                ><n-icon
                                    :component="MoonOutlineIcon" /></template></n-switch
                                ></n-space>
                        </div>
                    </div>
                </div>
            </n-layout-header>
            <n-layout has-sider>
                <n-layout-sider
                    bordered
                    show-trigger
                    collapse-mode="width"
                    :collapsed-width="64"
                    :width="350"
                    :native-scrollbar="false"
                    :inverted="inverted"
                    class="h-[calc(100vh-80px-24px)]"
                >
                    <n-menu
                        v-if="!hasOnlyOneSideBarItem"
                        :inverted="inverted"
                        :collapsed-width="64"
                        :collapsed-icon-size="22"
                        :options="authUserSideBarItems"
                    />
                </n-layout-sider>
                <n-layout class="h-[calc(100vh-80px-24px)]">
                    <router-view />
                </n-layout>
            </n-layout>
            <n-layout-footer :inverted="inverted" bordered align="center" class="h-6">
                Copyright © 2023 Divisional Secretariat - Katana. All Rights Reserved.
            </n-layout-footer>
        </n-layout>
    </n-space>
</template>

<script setup>


// const sideBarItems = {
//     open: ['Users'],
//     admins: [
//         ['Management', 'mdi-account-multiple-outline'],
//         ['Settings', 'mdi-cog-outline'],
//     ],
//     cruds: [
//         ['Create', 'mdi-plus-outline'],
//         ['Read', 'mdi-file-outline'],
//         ['Update', 'mdi-update'],
//         ['Delete', 'mdi-delete'],
//     ],
// };


import { computed, h, ref, onMounted } from "vue";
import { NIcon } from "naive-ui";
import { RouterLink, useRouter } from "vue-router";

import {
    BookOutline as BookIcon,
    Business as BusinessIcon,
    Car as CarIcon,
    Cart as CartIcon,
    Diamond as DiamondIcon,
    Document as DocumentIcon,
    Leaf as LeafIcon,
    LogoBitcoin as LogoBitcoinIcon,
    Map as MapIcon,
    Person as PersonIcon,
    WineOutline as WineIcon,
    Moon as MoonIcon,
    MoonOutline as MoonOutlineIcon,
    // PersonCircle as PersonCircleIcon,
} from "@vicons/ionicons5";
import Http from "@/services/http";
// import { useStore } from "vuex";
import router from "@/routes";
import http from "@/services/http.js";

// const store = useStore();

const inverted = ref(false);

const menuOptions = [
    {
        label: "User Details Management",
        key: "userDetailsManagement",
        icon: renderIcon(PersonIcon),
        authorizedBy: ["Admin"],
        children: [
            {
                label: () =>
                    h(
                        RouterLink,
                        {
                            to: {
                                name: "employee",
                            },
                        },
                        { default: () => "Employee Details Management" }
                    ),
                key: "employeeDetailsManagement",
                authorizedBy: ["Employee", "Admin"],
            },
            {
                label: () =>
                    h(
                        RouterLink,
                        {
                            to: {
                                name: "home",
                            },
                        },
                        { default: () => "Grama Niladhari Details Management" }
                    ),
                key: "gramaNiladhariDetails",
                authorizedBy: ["Employee", "Admin"],
            },
            {
                label: "Citizen Details Management",
                key: "citizenDetailsManagement",
                authorizedBy: ["Employee", "Admin"],
            },
            {
                label: "Field Officer Details Management",
                key: "fieldOfficerDetailsManagement",
                authorizedBy: ["Employee", "Admin"],
            },
        ],
    },
    {
        label: "Grama Niladari Division Details Management",
        key: "gramaNiladariDivisionDetailsManagement",
        authorizedBy: ["Employee", "Admin"],
        icon: renderIcon(MapIcon),
    },

    {
        label: () =>
            h(
                RouterLink,
                {
                    to: {
                        name: "timberCutting",
                    },
                },
                { default: () => "Timber Cutting Process Management" }
            ),
        key: "timberCuttingManagement",
        authorizedBy: ["Employee", "Admin"],
        icon: renderIcon(LeafIcon),
    },

    {
        label: "Timber Transportation Process and Permits",
        key: "timberTransportationProcessAndPermits",
        authorizedBy: ["Employee", "Admin"],
        icon: renderIcon(CarIcon),
    },
    {
        label: "Business Registration Certificates",
        key: "businessRegistrationCertificates",
        authorizedBy: ["Employee", "Admin"],
        icon: renderIcon(BusinessIcon),
    },
    {
        label: "Requesting & Issuing Income Certificates",
        key: "requestingAndIssuingIncomeCertificates",
        authorizedBy: ["Employee", "Admin"],
        icon: renderIcon(BusinessIcon),
    },
    {
        label: "Welfare Information Verification",
        key: "welfareInformationVerification",
        authorizedBy: ["Employee", "Admin"],
        icon: renderIcon(LogoBitcoinIcon),
        children: [
            {
                label: "Grade 5 Scholarship Information Verification",
                key: "grade5",
                authorizedBy: ["Employee", "Admin"],
            },
            {
                label: "Agrahara Information Verification",
                key: "agrahara",
                authorizedBy: ["Employee", "Admin"],
            },
            {
                label: "President Fund Information Verification",
                key: "presidentFund",
                authorizedBy: ["Employee", "Admin"],
            },
            {
                label: "Mahapola Application Processing",
                key: "mahapola",
                authorizedBy: ["Employee", "Admin"],
            },
        ],
    },
    {
        label: "Animal Transportation Permit",
        key: "animalTransportationPermit",
        authorizedBy: ["Client", "Admin"],
        icon: renderIcon(CartIcon),
    },
    {
        label: "Pawning Licensing",
        key: "pawningLicensing",
        authorizedBy: ["Employee", "Admin"],
        icon: renderIcon(DiamondIcon),
    },
    {
        label: "Excise Licensing",
        key: "exciseLicensing",
        authorizedBy: ["Employee", "Admin"],
        icon: renderIcon(WineIcon),
    },
    {
        label: "Valuation Report Issuing",
        key: "valuationReportIssuing",
        authorizedBy: ["Employee", "Admin"],
        icon: renderIcon(DocumentIcon),
    },
    {
        label: "Payment Management",
        key: "paymentManagement",
        authorizedBy: ["Employee", "Admin"],
        icon: renderIcon(BookIcon),
    },
];
// const signOut = () => store.dispatch("auth/logout");

const authUserSideBarItems = computed(() => {
    const authUserRole = 'Admin';

    return menuOptions.filter((option) => {
        return option.authorizedBy.includes(authUserRole);
    });
});

const hasOnlyOneSideBarItem = authUserSideBarItems.value.length === 1;
function renderIcon(icon) {
    return () => h(NIcon, null, { default: () => h(icon) });
}

onMounted(async () => {
    const response = await http.get('user');
    localStorage.setItem('AUTH_USER', JSON.stringify(response.data));
    console.log(response.data,"::", JSON.parse(localStorage.getItem('AUTH_USER')));
})

const handleLogout = () => {
    http.get('auth/logout');
    localStorage.removeItem('APP_DEMO_USER_TOKEN');
    localStorage.removeItem('AUTH_USER');
    window.location.reload();
}
</script>

<style scoped>
.nav-bar {
    background: rgb(255,191,0);
    background: linear-gradient(90deg, rgba(255,191,0,1) 41%, rgba(255,207,64,1) 79%, rgba(255,220,115,1) 100%);
}

</style>
