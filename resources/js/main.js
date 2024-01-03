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
    {
        path: '/profile',
        name: 'profile',
        component: () => import('./components/feed/UserPosts.vue'),
    },
    {
        path: "/watchlist",
        component: () => import("./components/watchlist/tabs/Tabs.vue"),
        children: [
            {
                path: "",
                name: "watchlist",
                component: () =>
                    import("./components/watchlist/tabs/Tabs.vue"),
            },
        ],
    },
    {
        path: "/watchlist/edit/:id",
        name: "watchlist.edit",
        component: () =>
            import("./components/watchlist/searchsymbols/Searchsymbols.vue"), 
    },
    {
        path: "/watchlist/manage",
        name: "watchlist.manage",
        component: () =>
            import("./components/watchlist/manage/Manage.vue"),
    },
    {
        path: "/exams",
        name: "exams",
        component: () => import("./components/exam/Exam.vue"),
    },
    {
        path: "/exam/:examName/question/:questionId",
        name: "exam.question",
        component: () => import("./components/exam/ExamQuestions.vue"),
        props: (route) => ({
            examId: route.query.examId,
            timeLimit: route.query.timeLimit,
        }),
    },
    {
        path: "/exam/result/:id",
        name: "exam.result",
        component: () => import("./components/exam/ExamResult.vue"),
        props: true,
    },
    {
        path: '/groups',
        name: 'groups',
        component: () => import('./components/chat/ChatGroups.vue'),
    },
    {
        path: '/groups/chat-single',
        name: 'chat-single',
        component: () => import('./components/chat/SingleChat.vue'),

    },
    {
        path: '/',
        name: 'home',
        component: () => import('./components/home/HomeMain.vue'),

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