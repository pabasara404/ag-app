import './bootstrap';
import {createApp} from 'vue'
import App from './App.vue'
import {createRouter, createWebHistory} from 'vue-router'
import naive from 'naive-ui'

// Vuetify
import 'vuetify/styles'
import { createVuetify } from 'vuetify'
import * as components from 'vuetify/components'
import * as directives from 'vuetify/directives'
import { aliases, mdi } from 'vuetify/iconsets/mdi'
import routes from "./routes.js";

const vuetify = createVuetify({
    components,
    directives,
    icons: {
        defaultSet: 'mdi',
        aliases,
        sets: {
            mdi,
        },
    },
})


const router = createRouter({
    // 4. Provide the history implementation to use. We
    // are using the hash history for simplicity here.
    history: createWebHistory(),
    routes, // short for `routes: routes`
})


router.beforeEach( (to, from, next) => {
    const isLoggedIn = !!localStorage.getItem('APP_DEMO_USER_TOKEN');

    document.title = to.meta.title;

    if (to.meta.middleware === "auth" && !isLoggedIn) {
        next({ name: "login" });

        return;
    }

    if (to.meta.middleware === "guest" && isLoggedIn) {
        next({ name: "home" });

        return;
    }

    next();
});

createApp(App)
    .use(router)
    .use(vuetify)
    .use(naive)
    .mount("#app")
