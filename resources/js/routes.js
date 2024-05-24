const authUserRole = 'Admin';

const routes = [
    {
        path: '/login',
        name: "login",
        meta: {
            middleware: "guest",
            title: `Permits, License and Welfare Fund Request Management System`,
            // icon:'Emblem_of_Sri_Lanka.svg.png'
        },
        component: () => import('./views/Login.vue')
    },{
        path: '/register',
        component: () => import('./views/Register.vue')
    },
    {
        path: '/',
        name: "appLayout",
        component: () => import('./views/AppLayout.vue'),
        meta: {
            middleware: "auth",
            title: ``,
        },
        children: [
            {
                path: "/home",
                name: "home",
                meta: {
                    middleware: "auth",
                    title: `Home`,
                },
                component: () => import(`./views/${authUserRole}/DashboardView.vue`),
            },
            {
                path: "/employee",
                name: "employee",
                meta: {
                    middleware: "auth",
                    title: `Employee`,
                },
                component: () => import("./views/Employee/EmployeeView.vue"),
            },
            {
                path: "/gramaNiladari",
                name: "gramaNiladari",
                meta: {
                    middleware: "auth",
                    title: `Grama Niladari`,
                },
                component: () => import("./views/Admin/GNOfficerView.vue"),
            },
            {
                path: "/citizen",
                name: "citizen",
                meta: {
                    middleware: "auth",
                    title: `Citizen`,
                },
                component: () => import("./views/Admin/CitizenView.vue"),
            },
            {
                path: "/timberCutting",
                name: "timberCutting",
                meta: {
                    middleware: "auth",
                    title: `Citizen`,
                },
                component: () => import("./views/Admin/TimberCuttingMainView.vue"),
            },
            {
                path: "/timberCuttingPermitRenewal",
                name: "TimberCuttingPermitRenewal",
                meta: {
                    middleware: "auth",
                    title: `Citizen`,
                },
                component: () => import("./views/Admin/TimberCuttingPermitRenewalRequestView.vue"),
            },
            {
                path: "/timberCuttingPermitStatus",
                name: "TimberCuttingPermitStatus",
                meta: {
                    middleware: "auth",
                    title: `Citizen`,
                },
                component: () => import("./views/Admin/TimberCuttingPermitStatusView.vue"),
            },
            {
                path: "/timberCuttingIssuePermits",
                name: "TimberCuttingIssuePermits",
                meta: {
                    middleware: "auth",
                    title: `Admin`,
                },
                component: () => import("./views/Admin/TimberCuttingIssuePermitsView.vue"),
            },
            {
                path: "/timberCuttingApplication",
                name: "timberCuttingApplication",
                meta: {
                    middleware: "auth",
                    title: `Timber Cutting Application`,
                },
                component: () =>
                    import(`./views/Admin/TimberCuttingApplicationView.vue`),
            },
            {
                path: "/timberCuttingReviewApplication",
                name: "TimberCuttingReviewApplication",
                meta: {
                    middleware: "auth",
                    title: `Timber Cutting Application`,
                },
                component: () =>
                    import(`./views/Admin/TimberCuttingReviewApplicationsView.vue`),
            },
            {
                path: "/gramaNiladariDivision",
                name: "gramaNiladariDivision",
                meta: {
                    middleware: "auth",
                    title: `Grama Niladari Division`,
                },
                component: () => import("./views/Admin/GNDivisionView.vue"),
            },
            {
                path: "/timberTransportation",
                name: "timberTransportation",
                meta: {
                    middleware: "auth",
                    title: `Timber Transportation Process and Permits`,
                },
                component: () => import("./views/Admin/TimberTransportationView.vue"),
            },

            {
                path: "/timberTransportationPermitRenewal",
                name: "TimberTransportationPermitRenewal",
                meta: {
                    middleware: "auth",
                    title: `Citizen`,
                },
                component: () => import("./views/Admin/TimberTransportationPermitRenewalRequestView.vue"),
            },
            {
                path: "/timberTransportationPermitStatus",
                name: "TimberTransportationPermitStatus",
                meta: {
                    middleware: "auth",
                    title: `Citizen`,
                },
                component: () => import("./views/Admin/TimberTransportationPermitStatusView.vue"),
            },
            {
                path: "/timberTransportationIssuePermits",
                name: "TimberTransportationIssuePermits",
                meta: {
                    middleware: "auth",
                    title: `Admin`,
                },
                component: () => import("./views/Admin/TimberTransportationIssuePermitsView.vue"),
            },
            {
                path: "/timberTransportationApplication",
                name: "timberTransportationApplication",
                meta: {
                    middleware: "auth",
                    title: `Timber Cutting Application`,
                },
                component: () =>
                    import(`./views/Admin/TimberTransportationApplicationView.vue`),
            },
            {
                path: "/timberTransportationReviewApplication",
                name: "TimberTransportationReviewApplication",
                meta: {
                    middleware: "auth",
                    title: `Timber Cutting Application`,
                },
                component: () =>
                    import(`./views/Admin/TimberTransportationReviewApplicationsView.vue`),
            },
            {
                path: "/businessRegistrationCertificates",
                name: "businessRegistrationCertificates",
                meta: {
                    middleware: "auth",
                    title: `Business Registration Certificates`,
                },
                component: () => import("./views/Admin/BusinessRegistrationCertificatesView.vue"),
            },
            {
                path: "/requestingAndIssuingIncomeCertificates",
                name: "requestingAndIssuingIncomeCertificates",
                meta: {
                    middleware: "auth",
                    title: `Requesting & Issuing Income Certificates`,
                },
                component: () => import("./views/Admin/RequestingAndIssuingIncomeCertificatesView.vue"),
            },
            {
                path: "/welfareInformationVerification",
                name: "welfareInformationVerification",
                meta: {
                    middleware: "auth",
                    title: `Welfare Information Verification`,
                },
                component: () => import("./views/Admin/WelfareInformationVerificationView.vue"),
            },
            {
                path: "/presidentFund",
                name: "presidentFund",
                meta: {
                    middleware: "auth",
                    title: `President Fund Information Verification`,
                },
                component: () => import("./views/Admin/PresidentFundView.vue"),
            },
            {
                path: "/mahapola",
                name: "mahapola",
                meta: {
                    middleware: "auth",
                    title: `Mahapola Application Processing`,
                },
                component: () => import("./views/Admin/MahapolaView.vue"),
            },
            {
                path: "/animalTransportationPermit",
                name: "animalTransportationPermit",
                meta: {
                    middleware: "auth",
                    title: `Animal Transportation Permit`,
                },
                component: () => import("./views/Admin/AnimalTransportationPermitView.vue"),
            },
            {
                path: "/exciseLicensing",
                name: "exciseLicensing",
                meta: {
                    middleware: "auth",
                    title: `Excise Licensing`,
                },
                component: () => import("./views/Admin/ExciseLicensingView.vue"),
            },
            {
                path: "/valuationReportIssuing",
                name: "valuationReportIssuing",
                meta: {
                    middleware: "auth",
                    title: `Valuation Report Issuing`,
                },
                component: () => import("./views/Admin/ValuationReportIssuingView.vue"),
            },
            {
                path: "/paymentManagement",
                name: "paymentManagement",
                meta: {
                    middleware: "auth",
                    title: `Payment Management`,
                },
                component: () => import("./views/Admin/PaymentManagementView.vue"),
            },
        ],
    }
]

export default routes;
