<template>
    <n-space vertical>
        <n-layout>
            <n-layout-header :inverted="inverted" bordered class="h-20">
                <div class="flex w-full justify-between nav-bar">
                    <div class="flex w-full cursor-pointer" @click="handleCardClick('home')">
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
                            <div class="pt-2 pr-2">
                                <span class="font-medium">{{ userData.name }}</span>
                            </div>
                            <div class="mt-1.5">
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
                    <router-view #name/>
                </n-layout>
            </n-layout>
            <n-layout-footer :inverted="inverted" bordered align="center" class="h-6">
                Copyright © 2023 Divisional Secretariat - Katana. All Rights Reserved.
            </n-layout-footer>
        </n-layout>
    </n-space>
</template>

<script setup>

import {computed, h, ref, onMounted, watch} from "vue";
import { NIcon } from "naive-ui";
import {RouterLink, useRouter} from "vue-router";
import {
    Book as BookIcon,
    Storefront as BusinessIcon,
    DocumentText as DocumentTextIcon,
    Car as CarIcon,
    Document as DocumentIcon,
    Newspaper as LogoBitcoinIcon,
    Map as MapIcon,
    Person as PersonIcon,
    Beer as WineIcon,
    Moon as MoonIcon,
    BarChart as BarChartIcon,
    MoonOutline as MoonOutlineIcon,
    Search as SearchIcon
} from "@vicons/ionicons5";
import { Tree as LeafIcon} from "@vicons/carbon";
import { EmojiTransportationFilled as CartIcon} from "@vicons/material";

const router = useRouter();
import {getLocalAuthUser, logout} from "@/services/auth.js";

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
                                name: "gramaNiladari",
                            },
                        },
                        { default: () => "GN Officer Details Management" }
                    ),
                key: "gramaNiladhariDetails",
                authorizedBy: ["Employee", "Admin"],
            },
            {
                label: () =>
                    h(
                        RouterLink,
                        {
                            to: {
                                name: "citizen",
                            },
                        },
                        { default: () => "Citizen Details Management" }
                    ),
                key: "citizenDetailsManagement",
                authorizedBy: ["Employee", "Admin"],
            },
        ],
    },
    {
        label: () =>
            h(
                RouterLink,
                {
                    to: {
                        name: "gramaNiladariDivision",
                    },
                },
                { default: () => "Grama Niladari Division Details Management" }
            ),
        key: "gramaNiladariDivisionDetailsManagement",
        authorizedBy: ["Employee", "Admin"],
        icon: renderIcon(MapIcon),
    },{
        label: () =>
            h(
                RouterLink,
                {
                    to: {
                        name: "applicationSearch",
                    },
                },
                { default: () => "Search Applications" }
            ),
        key: "applicationSearch",
        authorizedBy: ["Employee", "Admin"],
        icon: renderIcon(SearchIcon),
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
        label: () =>
            h(
                RouterLink,
                {
                    to: {
                        name: "timberTransportation",
                    },
                },
                { default: () => "Timber Transportation Process and Permits" }
            ),
        key: "timberTransportationProcessAndPermits",
        authorizedBy: ["Employee", "Admin"],
        icon: renderIcon(CarIcon),
    },
    {
        label: "Business Registration Certificates",
        key: "businessRegistrationCertificates",
        authorizedBy: ["Employee", "Admin"],
        icon: renderIcon(BusinessIcon),
        children: [
            {
                label: () =>
                    h(
                        RouterLink,
                        {
                            to: {
                                name: "individualView",
                            },
                        },
                        { default: () => "Individual Business Registration" }
                    ),
                key: "individualBusinessRegistration",
                authorizedBy: ["Employee", "Admin"],
            },
            {
                label: () =>
                    h(
                        RouterLink,
                        {
                            to: {
                                name: "firmView",
                            },
                        },
                        { default: () => "Firm Registration" }
                    ),
                key: "firmRegistration",
                authorizedBy: ["Employee", "Admin"],
            }
        ],
    },
    {
        label: () =>
            h(
                RouterLink,
                {
                    to: {
                        name: "requestingAndIssuingIncomeCertificates",
                    },
                },
                { default: () => "Requesting & Issuing Income Certificates" }
            ),
        key: "requestingAndIssuingIncomeCertificates",
        authorizedBy: ["Employee", "Admin"],
        icon: renderIcon(DocumentTextIcon),
    },
    {
        label: "Welfare Information Verification",
        key: "welfareInformationVerification",
        authorizedBy: ["Employee", "Admin"],
        icon: renderIcon(LogoBitcoinIcon),
        children: [
            {
                label: () =>
                    h(
                        RouterLink,
                        {
                            to: {
                                name: "presidentFund",
                            },
                        },
                        { default: () => "President Fund Information Verification" }
                    ),
                key: "presidentFund",
                authorizedBy: ["Employee", "Admin"],
            },
            {
                label: () =>
                    h(
                        RouterLink,
                        {
                            to: {
                                name: "mahapola",
                            },
                        },
                        { default: () => "Mahapola Application Processing" }
                    ),
                key: "mahapola",
                authorizedBy: ["Employee", "Admin"],
            },
        ],
    },
    {
        label: () =>
            h(
                RouterLink,
                {
                    to: {
                        name: "animalTransportationPermit",
                    },
                },
                { default: () => "Animal Transportation Permit" }
            ),
        key: "animalTransportationPermit",
        authorizedBy: ["Client", "Admin"],
        icon: renderIcon(CartIcon),
    },
    {
        label: () =>
            h(
                RouterLink,
                {
                    to: {
                        name: "exciseLicensing",
                    },
                },
                { default: () => "Excise License Management" }
            ),
        key: "exciseLicensing",
        authorizedBy: ["Employee", "Admin"],
        icon: renderIcon(WineIcon),
    },
    {
        label: () =>
            h(
                RouterLink,
                {
                    to: {
                        name: "valuationReportIssuing",
                    },
                },
                { default: () => "Valuation Report Issuing" }
            ),
        key: "valuationReportIssuing",
        authorizedBy: ["Employee", "Admin"],
        icon: renderIcon(DocumentIcon),
    },
    {
        label: () =>
            h(
                RouterLink,
                {
                    to: {
                        name: "paymentManagement",
                    },
                },
                { default: () => "Payment Management" }
            ),
        key: "paymentManagement",
        authorizedBy: ["Employee", "Admin"],
        icon: renderIcon(BookIcon),
    },{
        label: () =>
            h(
                RouterLink,
                {
                    to: {
                        name: "reportManagement",
                    },
                },
                { default: () => "Report Management" }
            ),
        key: "reportManagement",
        authorizedBy: ["Employee", "Admin"],
        icon: renderIcon(BarChartIcon),
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

const userData = ref({});
onMounted(async () => {
    try {
        userData.value = getLocalAuthUser();
    } catch (error) {
        if (error && error.response) {
            if (error.response.status === 401) {
                await router.push('/login');
            } else {
                console.error("Error:", error);
            }
        } else {
            console.error("Unexpected error:", error);
        }
    }
});



const handleCardClick = (route) => {
    router.push(`${route}`);
};

const handleLogout = () => {
    logout();
}
</script>

<style scoped>
.nav-bar {
    background: rgb(255,191,0);
    background: linear-gradient(90deg, rgba(255,191,0,1) 41%, rgba(255,207,64,1) 79%, rgba(255,220,115,1) 100%);
}

</style>
