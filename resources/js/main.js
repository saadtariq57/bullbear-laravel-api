import { createApp } from "vue";
import Navigation from "./components/header/Navigation.vue";
import { createRouter, createWebHistory } from "vue-router";
import store from './store';

// Define routes with lazy loading
const routes = [
    {
        path: '/feed',
        name: 'feed',
        component: () => import('./components/feed/UserFeed.vue'),
    },
];

// Create router instance
const router = createRouter({
    history: createWebHistory(),
    routes,
});

// Create Vue app
const app = createApp({});
app.component("Navigation", Navigation);

// Use router
app.use(router);
app.use(store);

// Mount the app
router.isReady().then(() => {
    store.dispatch('checkLoginStatus').finally(() => {
        app.mount("#app");
    });
});