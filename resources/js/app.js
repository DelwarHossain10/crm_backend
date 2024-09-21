import './bootstrap';
import { createApp } from "vue/dist/vue.esm-bundler";
// Vuetify
import { createVuetify } from 'vuetify';
import 'vuetify/styles';
// import { VDataTable } from 'vuetify/lib/components/VDataTable';
import * as components from 'vuetify/components';
import * as directives from 'vuetify/directives';
import VueSelect from "vue-select";
import 'vue-select/dist/vue-select.css';
// import { registerFrontendComponents } from './resources/frontend';
import { registerAdminComponents } from './resources/admin';
import router from './router.js';

export const app = createApp({});
const vuetify = createVuetify({
    components,
    directives,
});
// registerFrontendComponents(app);
registerAdminComponents(app);

// require('./resources/seller');
// require('./resources/user');
// require('./resources/frontend');
// app.component('VDataTable', VDataTable);
app.component('v-select', VueSelect);

app.use(router).use(vuetify).mount("#app");



// import {createApp} from 'vue'

// \import App from './App.vue'

// createApp(App).mount("#app")
