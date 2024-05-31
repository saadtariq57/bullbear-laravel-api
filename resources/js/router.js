import { createRouter, createWebHistory } from "vue-router";

// Define routes with lazy loading
//Add Categories of widget and then add each widget in a category
//Menu Module can be simplified
//One of the category could be sidebar-{pagetype}
const routes = [
    {
        path: '/markets/:cetagory/:id',
        name: 'markets.indices',
        component: () => import('./components/markets/Markets.vue'),
        props: (route) => ({
            category: route.params.category,
            widget_id: route.params.id
        }),
    },
    {
        path: '/markets/:cetagory/:subCetagory/:id',
        name: 'markets.indices.indices-futures',
        component: () => import('./components/markets/Markets.vue'),
        props: (route) => ({
            category: route.params.category,
            subCategory: route.params.subCategory,
            widget_id: route.params.id
        }),
    },
    {
        path: '/watchlist-ideas',
        name: 'watchlistpro',
        component: () => import('./components/richtvpro/WatchlistIdeas.vue'),
    },
    {
        path: '/pro-picks',
        name: 'propicks',
        component: () => import('./components/richtvpro/ProPicks.vue'),
    },
    {
        path: '/personal-access',
        name: 'personal-access',
        component: () => import('./components/richtvpro/PersonalAccess.vue'),
    },
    {
        path: '/specialize-reports',
        name: 'specialize-reports',
        component: () => import('./components/richtvpro/SpecializeReports.vue'),
    },
    {
        path: '/technical-analysis',
        name: 'technical-analysis',
        component: () => import('./components/richtvpro/TechnicalAnalysis.vue'),
    },

    {
        path: '/pricing',
        name: 'pricing',
        component: () => import('./components/pricing/Pricing.vue'),
    },
    {
        path: '/feed',
        name: 'feed',
        component: () => import('./components/feed/UserFeed.vue'),
    },
    {
        path: '/single-post',
        name: 'single-post',
        component: () => import('./components/feed/SinglePost.vue'),
    },
    {
        path: '/profile/:userName',
        name: 'profile',
        component: () => import('./components/profile/UserProfile.vue'),
    },
    {
        path: '/profile/:userName/setting',
        name: 'profile.setting',
        component: () => import('./components/profile/ProfileSetting.vue'),
    },
    {
        path: '/profile/:userName/follow',
        name: 'profile.follow',
        component: () => import('./components/profile/ProfileFollowers.vue'),
    },
    {
        path: '/profile/:userName/notification',
        name: 'profile.notification',
        component: () => import('./components/profile/ProfileNotification.vue'),

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
        component: () => import("./components/watchlist/searchsymbols/Searchsymbols.vue"),
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
        path: "/previous-results",
        name: "previous-results",
        component: () => import("./components/exam/PreviousResult.vue"),
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
        component: () => import('./components/groups/UserGroups.vue'),
    },
    {
        path: '/groups/:group_id/:group_name',
        name: 'group-single',
        component: () => import('./components/groups/SingleGroup.vue'),
        props: true,
        children: [
          { path: '', name: 'group-single-default', redirect: { name: 'group-discussion' } },
          { path: 'discussion', 
            name: 'group-discussion', 
            component: () => import('./components/groups/tabs/GroupDiscussionTab.vue')},
          { path: 'live-chat', 
            name: 'group-live-chat', 
            component: () => import('./components/groups/tabs/LiveChatTab.vue') },
          { path: 'members', 
            name: 'group-members', 
            component: () => import('./components/groups/tabs/MembersTab.vue')},
        ],
      },
    {
        path: '/',
        name: 'home',
        component: () => import('./components/home/HomeMain.vue'),

    },
    {
        path: '/trading-school',
        name: 'TradingBooks',
        component: () => import('./components/richtvpro/TradingSchool.vue'),
    },
    {
        path: '/checkout',
        name: 'checkout',
        component: () => import('./components/checkout/checkout.vue'),
        props: true,
    },
    {
        path: '/checkout/thank-you',
        name: 'thank-you',
        component: () => import('./components/checkout/ThankYou.vue'),
    },
    {
        path: '/ceo-interviews',
        name: 'ceo-interviews',
        component: () => import('./components/interviews/CeoInterviews.vue'),
    },
    {
        path: '/dividend-calendar',
        name: 'dividend-calendar',
        component: () => import('./components/calendars/DividendCalendar.vue'),
    },
    {
        path: '/earning-calendar',
        name: 'earning-calendar',
        component: () => import('./components/calendars/EarningsCalendar.vue'),
    },
    {
        path: '/economic-calendar',
        name: 'economic-calendar',
        component: () => import('./components/calendars/EconomicCalendar.vue'),
    },
    {
        path: '/holiday-calendar',
        name: 'holiday-calendar',
        component: () => import('./components/calendars/HolidayCalendar.vue'),
    },
    {
        path: '/splits-calendar',
        name: 'splits-calendar',
        component: () => import('./components/calendars/SplitsCalendar.vue'),
    },
    {
        path: '/ipo-calendar',
        name: 'ipo-calendar',
        component: () => import('./components/calendars/IpoCalendar.vue'),
    },
    {
        path: '/futures-expiry-calendar',
        name: 'futures-expiry-calendar',
        component: () => import('./components/calendars/FuturesExpiryCalendar.vue'),
    },
    {
        path: '/webinar',
        name: 'webinar',
        component: () => import('./components/richtvpro/Webinar.vue'),
    },
    {
        path: '/email-alerts',
        name: 'email-alerts',
        component: () => import('./components/richtvpro/EmailAlerts.vue'),
    },
    {
        path: '/richtv-live',
        name: 'richtv-live',
        component: () => import('./components/academy/RichtvLive.vue'),
    },
    {
        path: '/messages',
        name: 'messages',
        component: () => import('./components/groups/ChatRoom.vue'),
    }
];

// Create router instance
const router = createRouter({
    history: createWebHistory(),
    routes,
});

export default router;