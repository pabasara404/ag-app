import {getLocalAuthUser} from "@/services/auth.js";

const authUserRole = () => getLocalAuthUser()?.role?.role_type;
console.log('4 ', authUserRole);

const routes = [
    {
        path: '/login',
        name: "login",
        meta: {
            middleware: "guest",
            title: `Permits, License and Welfare Fund Request Management System`,
        },
        component: () => import('./views/Login.vue')
    },
    {
        path: '/register',
        component: () => import('./views/Register.vue')
    },
    {
        path: '/',
        name: "appLayout",
        component: () => import('./views/AppLayout.vue'),
        meta: {
            middleware: "auth",
            title: `Home`,
            allowed: ['Admin', 'GuestUser', 'GeneralUser']
        },
        children: [
            {
                path: "home",
                name: "dashboard",
                meta: {
                    middleware: "auth",
                    title: `Dashboard`,
                    allowed: ['Admin', 'GuestUser', 'GeneralUser']
                },
                component: () => import(`./views/${authUserRole()}/DashboardView.vue`),
            },
            {
                path: "employee",
                name: "employee",
                meta: {
                    middleware: "auth",
                    title: `Employee`,
                    allowed: ['Admin', 'GuestUser', 'GeneralUser']
                },
                component: () => import(`./views/${authUserRole()}/EmployeeView.vue`),
            },
            {
                path: "gramaNiladari",
                name: "gramaNiladari",
                meta: {
                    middleware: "auth",
                    title: `Grama Niladari`,
                    allowed: ['Admin', 'GuestUser', 'GeneralUser']
                },
                component: () => import("./views/Admin/GNOfficerView.vue"),
            },
            {
                path: "citizen",
                name: "citizen",
                meta: {
                    middleware: "auth",
                    title: `Citizen`,
                    allowed: ['Admin', 'GuestUser', 'GeneralUser']
                },
                component: () => import("./views/Admin/CitizenView.vue"),
            },
            {
                path: "timberCutting",
                name: "timberCutting",
                meta: {
                    middleware: "auth",
                    title: `Timber Cutting Application`,
                    allowed: ['Admin', 'GuestUser', 'GeneralUser']
                },
                to:"name",
                component: () => import("./views/Admin/TimberCuttingMainView.vue"),
            },{
                path: "timberCuttingPermitRenewal",
                name: "TimberCuttingPermitRenewal",
                meta: {
                    middleware: "auth",
                    title: `Timber Cutting Permit Renewal`,
                    allowed: ['Admin', 'GuestUser', 'GeneralUser']
                },
                component: () => import("./views/Admin/TimberCuttingPermitRenewalRequestView.vue"),
            },
            {
                path: "timberCuttingPermitStatus",
                name: "TimberCuttingPermitStatus",
                meta: {
                    middleware: "auth",
                    title: `Timber Cutting Permit Status`,
                    allowed: ['Admin', 'GuestUser', 'GeneralUser']
                },
                component: () => import("./views/Admin/TimberCuttingPermitStatusView.vue"),
            },
            {
                path: "timberCuttingIssuePermits",
                name: "TimberCuttingIssuePermits",
                meta: {
                    middleware: "auth",
                    title: `Timber Cutting Issue Permits`,
                    allowed: ['Admin', 'GuestUser', 'GeneralUser']
                },
                component: () => import("./views/Admin/TimberCuttingIssuePermitsView.vue"),
            },
            {
                path: "timberCuttingApplication",
                name: "TimberCuttingApplication",
                meta: {
                    middleware: "auth",
                    title: `Timber Cutting Application`,
                    allowed: ['Admin', 'GuestUser', 'GeneralUser']
                },
                component: () => import("./views/Admin/TimberCuttingApplicationView.vue"),
            },
            {
                path: "timberCuttingReviewApplication",
                name: "TimberCuttingReviewApplication",
                meta: {
                    middleware: "auth",
                    title: `Timber Cutting Review Application`,
                    allowed: ['Admin', 'GuestUser', 'GeneralUser']
                },
                component: () => import("./views/Admin/TimberCuttingReviewApplicationsView.vue"),
            },
            {
                path: "gramaNiladariDivision",
                name: "gramaNiladariDivision",
                meta: {
                    middleware: "auth",
                    title: `GN Division`,
                    allowed: ['Admin', 'GuestUser', 'GeneralUser']
                },
                component: () => import("./views/Admin/GNDivisionView.vue"),
            },
            {
                path: "timberTransportation",
                name: "timberTransportation",
                meta: {
                    middleware: "auth",
                    title: `Timber Transportation Process and Permits`,
                    allowed: ['Admin', 'GuestUser', 'GeneralUser']
                },
                component: () => import("./views/Admin/TimberTransportationView.vue"),
            },{
                path: "timberTransportationPermitRenewal",
                name: "TimberTransportationPermitRenewal",
                meta: {
                    middleware: "auth",
                    title: `Timber Transportation Permit Renewal`,
                    allowed: ['Admin', 'GuestUser', 'GeneralUser']
                },
                component: () => import("./views/Admin/TimberTransportationPermitRenewalRequestView.vue"),
            },
            {
                path: "timberTransportationPermitStatus",
                name: "TimberTransportationPermitStatus",
                meta: {
                    middleware: "auth",
                    title: `Timber Transportation Permit Status`,
                    allowed: ['Admin', 'GuestUser', 'GeneralUser']
                },
                component: () => import("./views/Admin/TimberTransportationPermitStatusView.vue"),
            },
            {
                path: "timberTransportationIssuePermits",
                name: "TimberTransportationIssuePermits",
                meta: {
                    middleware: "auth",
                    title: `Timber Transportation Issue Permits`,
                    allowed: ['Admin', 'GuestUser', 'GeneralUser']
                },
                component: () => import("./views/Admin/TimberTransportationIssuePermitsView.vue"),
            },
            {
                path: "timberTransportationApplication",
                name: "TimberTransportationApplication",
                meta: {
                    middleware: "auth",
                    title: `Timber Transportation Application`,
                    allowed: ['Admin', 'GuestUser', 'GeneralUser']
                },
                component: () => import("./views/Admin/TimberTransportationApplicationView.vue"),
            },
            {
                path: "timberTransportationReviewApplication",
                name: "TimberTransportationReviewApplication",
                meta: {
                    middleware: "auth",
                    title: `Timber Transportation Review Application`,
                    allowed: ['Admin', 'GuestUser', 'GeneralUser']
                },
                component: () => import("./views/Admin/TimberTransportationReviewApplicationsView.vue"),
            },
            {
                path: "businessRegistrationCertificates",
                name: "businessRegistrationCertificates",
                meta: {
                    middleware: "auth",
                    title: `Business Registration Certificates`,
                    allowed: ['Admin', 'GuestUser', 'GeneralUser']
                },
                component: () => import("./views/Admin/BusinessRegistrationCertificatesView.vue"),
            }, {
                path: "individualBusiness",
                name: "Individual Business",
                meta: {
                    middleware: "auth",
                    title: `Timber Transportation Permit Renewal`,
                    allowed: ['Admin', 'GuestUser', 'GeneralUser']
                },
                component: () => import("./views/Admin/BusinessRegistrationIndividualApplicationView.vue"),
            },
            {
                path: "firm",
                name: "Firm",
                meta: {
                    middleware: "auth",
                    title: `Apply to a Registration by a Firm`,
                    allowed: ['Admin', 'GuestUser', 'GeneralUser']
                },
                component: () => import("./views/Admin/BusinessRegistrationFirmApplicationView.vue"),
            },
            {
                path: "businessRegistrationStatus",
                name: "BusinessRegistrationStatus",
                meta: {
                    middleware: "auth",
                    title: `View Application Status`,
                    allowed: ['Admin', 'GuestUser', 'GeneralUser']
                },
                component: () => import("./views/Admin/BusinessRegistrationStatusView.vue"),
            },
            {
                path: "cessation",
                name: "Cessation",
                meta: {
                    middleware: "auth",
                    title: `Submit a Notice of Cessation of Business`,
                    allowed: ['Admin', 'GuestUser', 'GeneralUser']
                },
                component: () => import("./components/BusinessRegistrationCessationApplicationModal.vue"),
            },
            {
                path: "businessRegistrationReviewApplication",
                name: "businessRegistrationReviewApplication",
                meta: {
                    middleware: "auth",
                    title: `Review the Applications`,
                    allowed: ['Admin', 'GuestUser', 'GeneralUser']
                },
                component: () => import("./views/Admin/BusinessRegistrationReviewApplicationsView.vue"),
            },{
                path: "businessRegistrationIssuePermits",
                name: "businessRegistrationIssuePermits",
                meta: {
                    middleware: "auth",
                    title: `Issue the Certificates`,
                    allowed: ['Admin', 'GuestUser', 'GeneralUser']
                },
                component: () => import("./views/Admin/BusinessRegistrationIssuePermitsView.vue"),
            },
            {
                path: "requestingAndIssuingIncomeCertificates",
                name: "requestingAndIssuingIncomeCertificates",
                meta: {
                    middleware: "auth",
                    title: `Requesting & Issuing Income Certificates`,
                    allowed: ['Admin', 'GuestUser', 'GeneralUser']
                },
                component: () => import("./views/Admin/RequestingAndIssuingIncomeCertificatesView.vue"),
            },
            {
                path: "welfareInformationVerification",
                name: "welfareInformationVerification",
                meta: {
                    middleware: "auth",
                    title: `Welfare Information Verification`,
                    allowed: ['Admin', 'GuestUser', 'GeneralUser']
                },
                component: () => import("./views/Admin/WelfareInformationVerificationView.vue"),
            },
            {
                path: "presidentFund",
                name: "presidentFund",
                meta: {
                    middleware: "auth",
                    title: `President Fund Information Verification`,
                    allowed: ['Admin', 'GuestUser', 'GeneralUser']
                },
                component: () => import("./views/Admin/PresidentFundView.vue"),
            },
            {
                path: "mahapola",
                name: "mahapola",
                meta: {
                    middleware: "auth",
                    title: `Mahapola Application Processing`,
                    allowed: ['Admin', 'GuestUser', 'GeneralUser']
                },
                component: () => import("./views/Admin/MahapolaView.vue"),
            },
            {
                path: "animalTransportationPermit",
                name: "animalTransportationPermit",
                meta: {
                    middleware: "auth",
                    title: `Animal Transportation Permit`,
                    allowed: ['Admin', 'GuestUser', 'GeneralUser']
                },
                component: () => import("./views/Admin/AnimalTransportationPermitView.vue"),
            },
            {
                path: "exciseLicensing",
                name: "exciseLicensing",
                meta: {
                    middleware: "auth",
                    title: `Excise Licensing`,
                    allowed: ['Admin', 'GuestUser', 'GeneralUser']
                },
                component: () => import("./views/Admin/ExciseLicensingView.vue"),
            },
            {
                path: "valuationReportIssuing",
                name: "valuationReportIssuing",
                meta: {
                    middleware: "auth",
                    title: `Valuation Report Issuing`,
                    allowed: ['Admin', 'GuestUser', 'GeneralUser']
                },
                component: () => import("./views/Admin/ValuationReportIssuingView.vue"),
            },
            {
                path: "paymentManagement",
                name: "paymentManagement",
                meta: {
                    middleware: "auth",
                    title: `Payment Management`,
                    allowed: ['Admin', 'GuestUser', 'GeneralUser']
                },
                component: () => import("./views/Admin/PaymentManagementView.vue"),
            },
        ],
    }
]

export default routes;
