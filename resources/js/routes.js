import {getLocalAuthUser} from "@/services/auth.js";

const authUserRole = () => getLocalAuthUser()?.role?.role_type;
// console.log('4 ', authUserRole);

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
        path: '/password/reset/:token',
        name: 'SetPassword',
        component: () => import('./views/SetPassword.vue')
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
                    allowed: ['Admin', 'GeneralUser']
                },
                component: () => import(`./views/${authUserRole()}/EmployeeView.vue`),
            },
            {
                path: "gramaNiladari",
                name: "gramaNiladari",
                meta: {
                    middleware: "auth",
                    title: `Grama Niladari`,
                    allowed: ['Admin',  'GeneralUser']
                },
                component: () => import(`./views/${authUserRole()}/GNOfficerView.vue`),
            },
            {
                path: "citizen",
                name: "citizen",
                meta: {
                    middleware: "auth",
                    title: `Citizen`,
                    allowed: ['Admin', 'GeneralUser']
                },
                component: () => import(`./views/${authUserRole()}/CitizenView.vue`),
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
                component: () => import(`./views/${authUserRole()}/TimberCuttingMainView.vue`),
            }, {
                path: "applicationSearch",
                name: "applicationSearch",
                meta: {
                    middleware: "auth",
                    title: `Application Search`,
                    allowed: ['Admin',  'GeneralUser']
                },
                to:"name",
                component: () => import(`./views/${authUserRole()}/ApplicationSearchView.vue`),
            },{
                path: "timberCuttingPermitRenewal",
                name: "TimberCuttingPermitRenewal",
                meta: {
                    middleware: "auth",
                    title: `Timber Cutting Permit Renewal`,
                    allowed: ['Admin', 'GuestUser', 'GeneralUser']
                },
                component: () => import(`./views/${authUserRole()}/TimberCuttingPermitRenewalRequestView.vue`),
            },
            {
                path: "timberCuttingPermitStatus",
                name: "TimberCuttingPermitStatus",
                meta: {
                    middleware: "auth",
                    title: `Timber Cutting Permit Status`,
                    allowed: ['Admin', 'GuestUser', 'GeneralUser']
                },
                component: () => import(`./views/${authUserRole()}/TimberCuttingPermitStatusView.vue`),
            },
            {
                path: "timberCuttingIssuePermits",
                name: "TimberCuttingIssuePermits",
                meta: {
                    middleware: "auth",
                    title: `Timber Cutting Issue Permits`,
                    allowed: ['Admin',  'GeneralUser']
                },
                component: () => import(`./views/${authUserRole()}/TimberCuttingIssuePermitsView.vue`),
            },
            {
                path: "timberCuttingApplication",
                name: "TimberCuttingApplication",
                meta: {
                    middleware: "auth",
                    title: `Timber Cutting Application`,
                    allowed: ['Admin', 'GuestUser', 'GeneralUser']
                },
                component: () => import(`./views/${authUserRole()}/TimberCuttingApplicationView.vue`),
            },
            {
                path: "timberCuttingReviewApplication",
                name: "TimberCuttingReviewApplication",
                meta: {
                    middleware: "auth",
                    title: `Timber Cutting Review Application`,
                    allowed: ['Admin', 'GeneralUser']
                },
                component: () => import(`./views/${authUserRole()}/TimberCuttingReviewApplicationsView.vue`),
            },
            {
                path: "exciseLicensePermitStatus",
                name: "ExciseLicensePermitStatus",
                meta: {
                    middleware: "auth",
                    title: `View Excise License Status`,
                    allowed: ['Admin', 'GuestUser', 'GeneralUser']
                },
                component: () => import(`./views/${authUserRole()}/ExciseLicensePermitStatusView.vue`),
            },
            {
                path: "exciseLicenseApplication",
                name: "ExciseLicenseApplication",
                meta: {
                    middleware: "auth",
                    title: `Apply to a Excise License`,
                    allowed: ['Admin', 'GuestUser', 'GeneralUser']
                },
                component: () => import(`./views/${authUserRole()}/ExciseLicenseApplicationView.vue`),
            }, {
                path: "presidentFundStatus",
                name: "PresidentFundPermitStatus",
                meta: {
                    middleware: "auth",
                    title: `Upload a President Fund Request`,
                    allowed: ['Admin', 'GuestUser', 'GeneralUser']
                },
                component: () => import(`./views/${authUserRole()}/PresidentFundPermitStatusView.vue`),
            },
            {
                path: "presidentFundApplication",
                name: "PresidentFundApplication",
                meta: {
                    middleware: "auth",
                    title: `View President Fund Request Status`,
                    allowed: ['Admin', 'GuestUser', 'GeneralUser']
                },
                component: () => import(`./views/${authUserRole()}/PresidentFundApplicationView.vue`),
            }, {
                path: "presidentFundReview",
                name: "PresidentFundReview",
                meta: {
                    middleware: "auth",
                    title: `View President Fund Request Review`,
                    allowed: ['Admin', 'GeneralUser']
                },
                component: () => import(`./views/${authUserRole()}/PresidentFundPermitReviewView.vue`),
            }, {
                path: "presidentFundApprove",
                name: "PresidentFundApprove",
                meta: {
                    middleware: "auth",
                    title: `View President Fund Request Approval`,
                    allowed: ['Admin',  'GeneralUser']
                },
                component: () => import(`./views/${authUserRole()}/PresidentFundPermitApproveView.vue`),
            },{
                path: "mahapolaStatus",
                name: "MahapolaPermitStatus",
                meta: {
                    middleware: "auth",
                    title: `Upload a Application`,
                    allowed: ['Admin', 'GuestUser', 'GeneralUser']
                },
                component: () => import(`./views/${authUserRole()}/MahapolaPermitStatusView.vue`),
            },
            {
                path: "mahapolaApplication",
                name: "MahapolaApplication",
                meta: {
                    middleware: "auth",
                    title: `View Application Status`,
                    allowed: ['Admin', 'GuestUser', 'GeneralUser']
                },
                component: () => import(`./views/${authUserRole()}/MahapolaApplicationView.vue`),
            }, {
                path: "mahapolaReview",
                name: "MahapolaReview",
                meta: {
                    middleware: "auth",
                    title: `Review Mahapola Applications`,
                    allowed: ['Admin', 'GeneralUser']
                },
                component: () => import(`./views/${authUserRole()}/MahapolaPermitReviewView.vue`),
            }, {
                path: "mahapolaApprove",
                name: "MahapolaApprove",
                meta: {
                    middleware: "auth",
                    title: `Approve Mahapola Applications`,
                    allowed: ['Admin', 'GeneralUser']
                },
                component: () => import(`./views/${authUserRole()}/MahapolaPermitApproveView.vue`),
            },
            {
                path: "gramaNiladariDivision",
                name: "gramaNiladariDivision",
                meta: {
                    middleware: "auth",
                    title: `GN Division`,
                    allowed: ['Admin',  'GeneralUser']
                },
                component: () => import(`./views/${authUserRole()}/GNDivisionView.vue`),
            },
            {
                path: "timberTransportation",
                name: "timberTransportation",
                meta: {
                    middleware: "auth",
                    title: `Timber Transportation Process and Permits`,
                    allowed: ['Admin', 'GuestUser', 'GeneralUser']
                },
                component: () => import(`./views/${authUserRole()}/TimberTransportationView.vue`),
            },{
                path: "timberTransportationPermitRenewal",
                name: "TimberTransportationPermitRenewal",
                meta: {
                    middleware: "auth",
                    title: `Timber Transportation Permit Renewal`,
                    allowed: ['Admin', 'GuestUser', 'GeneralUser']
                },
                component: () => import(`./views/${authUserRole()}/TimberTransportationPermitRenewalRequestView.vue`),
            },
            {
                path: "timberTransportationPermitStatus",
                name: "TimberTransportationPermitStatus",
                meta: {
                    middleware: "auth",
                    title: `Timber Transportation Permit Status`,
                    allowed: ['Admin', 'GuestUser', 'GeneralUser']
                },
                component: () => import(`./views/${authUserRole()}/TimberTransportationPermitStatusView.vue`),
            },
            {
                path: "timberTransportationIssuePermits",
                name: "TimberTransportationIssuePermits",
                meta: {
                    middleware: "auth",
                    title: `Timber Transportation Issue Permits`,
                    allowed: ['Admin', 'GeneralUser']
                },
                component: () => import(`./views/${authUserRole()}/TimberTransportationIssuePermitsView.vue`),
            },
            {
                path: "timberTransportationApplication",
                name: "TimberTransportationApplication",
                meta: {
                    middleware: "auth",
                    title: `Timber Transportation Application`,
                    allowed: ['Admin', 'GuestUser', 'GeneralUser']
                },
                component: () => import(`./views/${authUserRole()}/TimberTransportationApplicationView.vue`),
            },
            {
                path: "timberTransportationReviewApplication",
                name: "TimberTransportationReviewApplication",
                meta: {
                    middleware: "auth",
                    title: `Timber Transportation Review Application`,
                    allowed: ['Admin', 'GeneralUser']
                },
                component: () => import(`./views/${authUserRole()}/TimberTransportationReviewApplicationsView.vue`),
            },
            {
                path: "firmView",
                name: "firmView",
                meta: {
                    middleware: "auth",
                    title: `Firm Registration`,
                    allowed: ['Admin', 'GuestUser', 'GeneralUser']
                },
                component: () => import(`./views/${authUserRole()}/FirmRegistrationView.vue`),
            },
            {
                path: "individualView",
                name: "individualView",
                meta: {
                    middleware: "auth",
                    title: `Individual Business Registration`,
                    allowed: ['Admin', 'GuestUser', 'GeneralUser']
                },
                component: () => import(`./views/${authUserRole()}/IndividualBusinessRegistrationView.vue`),
            }, {
                path: "individualBusiness",
                name: "Individual Business",
                meta: {
                    middleware: "auth",
                    title: `Individual Business Registration Management`,
                    allowed: ['Admin', 'GuestUser', 'GeneralUser']
                },
                component: () => import(`./views/${authUserRole()}/BusinessRegistrationIndividualApplicationView.vue`),
            },
            {
                path: "firm",
                name: "Firm",
                meta: {
                    middleware: "auth",
                    title: `Apply to a Registration by a Firm`,
                    allowed: ['Admin', 'GuestUser', 'GeneralUser']
                },
                component: () => import(`./views/${authUserRole()}/BusinessRegistrationFirmApplicationView.vue`),
            },
            {
                path: "individualBusinessRegistrationStatus",
                name: "individualBusinessRegistrationStatus",
                meta: {
                    middleware: "auth",
                    title: `View Individual Business Application Status`,
                    allowed: ['Admin', 'GuestUser', 'GeneralUser']
                },
                component: () => import(`./views/${authUserRole()}/IndividualBusinessRegistrationStatusView.vue`),
            },{
                path: "firmBusinessRegistrationStatus",
                name: "firmBusinessRegistrationStatus",
                meta: {
                    middleware: "auth",
                    title: `View Firm Application Status`,
                    allowed: ['Admin', 'GuestUser', 'GeneralUser']
                },
                component: () => import(`./views/${authUserRole()}/FirmRegistrationStatusView.vue`),
            },
            {
                path: "individualCessation",
                name: "IndividualCessation",
                meta: {
                    middleware: "auth",
                    title: `Submit a Notice of Cessation of Business`,
                    allowed: ['Admin', 'GuestUser', 'GeneralUser']
                },
                component: () => import(`./views/${authUserRole()}/IndividualBusinessRegistrationCessationApplication.vue`),
            },
            {
                path: "firmCessation",
                name: "firmCessation",
                meta: {
                    middleware: "auth",
                    title: `Submit a Notice of Cessation of Business`,
                    allowed: ['Admin', 'GuestUser', 'GeneralUser']
                },
                component: () => import(`./views/${authUserRole()}/FirmRegistrationCessationApplication.vue`),
            },
            {
                path: "firmRegistrationReviewApplication",
                name: "firmRegistrationReviewApplication",
                meta: {
                    middleware: "auth",
                    title: `Review the Applications`,
                    allowed: ['Admin', 'GeneralUser']
                },
                component: () => import(`./views/${authUserRole()}/FirmRegistrationReviewApplicationsView.vue`),
            },{
                path: "individualBusinessRegistrationReviewApplication",
                name: "individualBusinessRegistrationReviewApplication",
                meta: {
                    middleware: "auth",
                    title: `Review the Applications`,
                    allowed: ['Admin', 'GeneralUser']
                },
                component: () => import(`./views/${authUserRole()}/IndividualBusinessRegistrationReviewApplicationsView.vue`),
            },{
                path: "firmRegistrationIssuePermits",
                name: "firmRegistrationIssuePermits",
                meta: {
                    middleware: "auth",
                    title: `Issue the Certificates`,
                    allowed: ['Admin','GeneralUser']
                },
                component: () => import(`./views/${authUserRole()}/FirmRegistrationIssuePermitsView.vue`),
            },{
                path: "individualBusinessRegistrationIssuePermits",
                name: "individualBusinessRegistrationIssuePermits",
                meta: {
                    middleware: "auth",
                    title: `Issue the Certificates`,
                    allowed: ['Admin', 'GeneralUser']
                },
                component: () => import(`./views/${authUserRole()}/IndividualBusinessRegistrationIssuePermitsView.vue`),
            },
            {
                path: "requestingAndIssuingIncomeCertificates",
                name: "requestingAndIssuingIncomeCertificates",
                meta: {
                    middleware: "auth",
                    title: `Requesting & Issuing Income Certificates`,
                    allowed: ['Admin', 'GuestUser', 'GeneralUser']
                },
                component: () => import(`./views/${authUserRole()}/RequestingAndIssuingIncomeCertificatesView.vue`),
            },{
                path: "incomeCertificateStatus",
                name: "IncomeCertificateStatus",
                meta: {
                    middleware: "auth",
                    title: `Income Certificate Status`,
                    allowed: ['Admin', 'GuestUser', 'GeneralUser']
                },
                component: () => import(`./views/${authUserRole()}/IncomeCertificateStatusView.vue`),
            },
            {
                path: "incomeCertificateIssue",
                name: "IncomeCertificateIssue",
                meta: {
                    middleware: "auth",
                    title: `Income Certificate Issuance`,
                    allowed: ['Admin',  'GeneralUser']
                },
                component: () => import(`./views/${authUserRole()}/IncomeCertificateIssueView.vue`),
            },
            {
                path: "incomeCertificateApplication",
                name: "IncomeCertificateApplication",
                meta: {
                    middleware: "auth",
                    title: `Income Certificate Application`,
                    allowed: ['Admin', 'GuestUser', 'GeneralUser']
                },
                component: () => import(`./views/${authUserRole()}/IncomeCertificateApplicationView.vue`),
            },
            {
                path: "incomeCertificateReview",
                name: "IncomeCertificateReview",
                meta: {
                    middleware: "auth",
                    title: `Income Certificate Review Application`,
                    allowed: ['Admin', 'GeneralUser']
                },
                component: () => import(`./views/${authUserRole()}/IncomeCertificateReviewView.vue`),
            },
            {
                path: "welfareInformationVerification",
                name: "welfareInformationVerification",
                meta: {
                    middleware: "auth",
                    title: `Welfare Information Verification`,
                    allowed: ['Admin', 'GuestUser', 'GeneralUser']
                },
                component: () => import(`./views/${authUserRole()}/WelfareInformationVerificationView.vue`),
            },
            {
                path: "presidentFund",
                name: "presidentFund",
                meta: {
                    middleware: "auth",
                    title: `President Fund Information Verification`,
                    allowed: ['Admin', 'GuestUser', 'GeneralUser']
                },
                component: () => import(`./views/${authUserRole()}/PresidentFundView.vue`),
            },
            {
                path: "mahapola",
                name: "mahapola",
                meta: {
                    middleware: "auth",
                    title: `Mahapola Application Processing`,
                    allowed: ['Admin', 'GuestUser', 'GeneralUser']
                },
                component: () => import(`./views/${authUserRole()}/MahapolaView.vue`),
            },
            {
                path: "animalTransportationPermit",
                name: "animalTransportationPermit",
                meta: {
                    middleware: "auth",
                    title: `Animal Transportation Permit`,
                    allowed: ['Admin', 'GuestUser', 'GeneralUser']
                },
                component: () => import(`./views/${authUserRole()}/AnimalTransportationPermitView.vue`),
            },
            {
                path: "animalTransportationStatus",
                name: "animalTransportationStatus",
                meta: {
                    middleware: "auth",
                    title: `Animal Transportation Status`,
                    allowed: ['Admin', 'GuestUser', 'GeneralUser']
                },
                component: () => import(`./views/${authUserRole()}/AnimalTransportationStatusView.vue`),
            },
            {
                path: "animalTransportationIssue",
                name: "animalTransportationIssue",
                meta: {
                    middleware: "auth",
                    title: `Animal Transportation Issuance`,
                    allowed: ['Admin', 'GeneralUser']
                },
                component: () => import(`./views/${authUserRole()}/AnimalTransportationIssueView.vue`),
            },
            {
                path: "animalTransportationApplication",
                name: "animalTransportationApplication",
                meta: {
                    middleware: "auth",
                    title: `Animal Transportation Application`,
                    allowed: ['Admin', 'GuestUser', 'GeneralUser']
                },
                component: () => import(`./views/${authUserRole()}/AnimalTransportationApplicationView.vue`),
            },
            {
                path: "animalTransportationReview",
                name: "animalTransportationReview",
                meta: {
                    middleware: "auth",
                    title: `Animal Transportation Review Application`,
                    allowed: ['Admin', 'GeneralUser']
                },
                component: () => import(`./views/${authUserRole()}/AnimalTransportationReviewView.vue`),
            },
            {
                path: "exciseLicensing",
                name: "exciseLicensing",
                meta: {
                    middleware: "auth",
                    title: `Excise Licensing`,
                    allowed: ['Admin', 'GeneralUser']
                },
                component: () => import(`./views/${authUserRole()}/ExciseLicensingView.vue`),
            },
            {
                path: "valuationReportIssuing",
                name: "valuationReportIssuing",
                meta: {
                    middleware: "auth",
                    title: `Valuation Report Issuing`,
                    allowed: ['Admin', 'GeneralUser']
                },
                component: () => import(`./views/${authUserRole()}/ValuationReportsView.vue`),
            },
            {
                path: "valuationReportStatus",
                name: "valuationReportStatus",
                meta: {
                    middleware: "auth",
                    title: `Valuation Report Status`,
                    allowed: ['Admin', 'GuestUser', 'GeneralUser']
                },
                component: () => import(`./views/${authUserRole()}/ValuationReportStatusView.vue`),
            },
            {
                path: "valuationReportIssue",
                name: "valuationReportIssue",
                meta: {
                    middleware: "auth",
                    title: `Valuation Report Issuance`,
                    allowed: ['Admin', 'GeneralUser']
                },
                component: () => import(`./views/${authUserRole()}/ValuationReportIssueView.vue`),
            },
            {
                path: "valuationReportApplication",
                name: "valuationReportApplication",
                meta: {
                    middleware: "auth",
                    title: `Valuation Report Application`,
                    allowed: ['Admin', 'GuestUser', 'GeneralUser']
                },
                component: () => import(`./views/${authUserRole()}/ValuationReportApplicationView.vue`),
            },
            {
                path: "valuationReportReview",
                name: "valuationReportReview",
                meta: {
                    middleware: "auth",
                    title: `Valuation Report Review Application`,
                    allowed: ['Admin', 'GeneralUser']
                },
                component: () => import(`./views/${authUserRole()}/ValuationReportReviewView.vue`),
            },
            {
                path: "paymentManagement",
                name: "paymentManagement",
                meta: {
                    middleware: "auth",
                    title: `Payment Management`,
                    allowed: ['Admin', 'GeneralUser']
                },
                component: () => import(`./views/${authUserRole()}/PaymentManagementView.vue`),
            },{
                path: "reportManagement",
                name: "reportManagement",
                meta: {
                    middleware: "auth",
                    title: `Report Management`,
                    allowed: ['Admin', 'GeneralUser']
                },
                component: () => import(`./views/${authUserRole()}/ReportManagementView.vue`),
            },
        ],
    }
]

export default routes;
