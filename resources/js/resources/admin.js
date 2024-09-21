import admin_dashboard from './../components/admin/dashboard/index.vue';
import order_template from './../components/admin/order/index.vue';

export const registerAdminComponents = (app) => {
    app.component('admin-dashboard', admin_dashboard);
    app.component('order_template', order_template);

}
