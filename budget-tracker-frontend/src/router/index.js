import { createRouter, createWebHistory } from "vue-router";
import DashboardView from "../views/DashboardView.vue";
import TransactionView from "../views/TransactionView.vue";

const routes = [
  {
    path: "/",
    name: "dashboard",
    component: DashboardView,
  },
  {
    path: "/transactions",
    name: "transactions",
    component: TransactionView,
  },
];

const router = createRouter({
  history: createWebHistory(),
  routes,
});

export default router;
