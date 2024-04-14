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
        ],
    }
]

export default routes;
