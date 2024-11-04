import { createRouter, createWebHistory } from "vue-router";
import { ref, watch } from 'vue';
import { isCheckingAuth, checkLoginStatus, isLoggedIn, showLoginPopup } from './stores';
import NotFound from './components/NotFound.vue';

const routes = [
    {
        path: '/404',
        name: 'NotFoundPage',
        component: NotFound,
    },
    {
        path: '/:pathMatch(.*)*',
        name: 'NotFound',
        redirect: '/404',
    },
    {
        path: '/about-us',
        name: 'About',
        component: () => import('./components/static/About.vue'),
    },
    {
        path: '/privacy-policy',
        name: 'PrivacyPolicy',
        component: () => import('./components/static/PrivacyPolicy.vue'),
    },
    {
        path: '/terms-of-use',
        name: 'TermsOfUse',
        component: () => import('./components/static/TermsOfUse.vue'),
    },
    {
        path: '/contact-us',
        name: 'ContactUs',
        component: () => import('./components/static/ContactUs.vue'),
    },
    {
        path: '/glossary',
        name: 'Glossary',
        component: () => import('./components/static/Glossary.vue'),
    },
    {
      path: '/blog/:slug',
      name: 'category',
      component: () => import('./components/blog/Category.vue'),
      props: true,
    },
    {
      path: '/blog/:categorySlug/:postSlug',
      name: 'post',
      component: () => import('./components/blog/Post.vue'),
      props: true,
    },
    {
      path: '/author/:id/:name',
      name: 'Author',
      component: () => import('./components/blog/Author.vue'),
      props: true,
    },
    {
        path: '/markets/:category',
        name: route => `markets.${route.params.category}`,
        component: () => import('./components/markets/Markets.vue'),
        props: route => ({
            category: route.params.category
        }),
    },
    {
        path: '/markets/:category/:subCategory',
        name: route => `markets.${route.params.category}.${route.params.subCategory}`,
        component: () => import('./components/markets/Markets.vue'),
        props: route => ({
            category: route.params.category,
            subCategory: route.params.subCategory
        }),
    },
    {
        path: '/pro-picks',
        name: 'propicks',
        component: () => import('./components/richpicks/RichTvPicks.vue'),
    },
    {
        path: '/personal-access',
        name: 'personal-access',
        component: () => import('./components/richtvpro/PersonalAccess.vue'),
    },
    {
        path: '/stocks-screener',
        name: 'stocks-screener',
        component: () => import('./components/screener/StockScreener.vue'),
    },
    {
        path: '/specialize-reports',
        name: 'specialize-reports',
        component: () => import('./components/richtvpro/SpecializeReports.vue'),
    },
    {
        path: '/trading-education',
        name: 'trading-education',
        component: () => import('./components/education/TradingSchool.vue'),
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
        path: '/post/:username/:id',
        name: 'singlePost',
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
        path: '/notifications',
        name: 'notifications',
        component: () => import('./components/profile/Notifications.vue'),

    },
    {
        path: "/watchlist",
        name: "watchlist",
        component: () => import("./components/watchlist/tabs/Tabs.vue"),
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
        props: true,
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
            { path: '', name: 'group-single-default', redirect: { name: 'group-live-chat' } },
            {
                path: 'discussion',
                name: 'group-discussion',
                component: () => import('./components/groups/tabs/GroupDiscussionTab.vue')
            },
            {
                path: 'live-chat',
                name: 'group-live-chat',
                component: () => import('./components/groups/tabs/LiveChatTab.vue')
            },
            {
                path: 'members',
                name: 'group-members',
                component: () => import('./components/groups/tabs/MembersTab.vue')
            },
        ],
    },
    {
        path: '/',
        name: 'home',
        component: () => import('./components/home/HomeMain.vue'),
        beforeEnter: (to, from, next) => {
            if (isLoggedIn()) {
                next('/feed');
            } else {
                next();
            }
        }
    },
    {
        path: '/:period/:planId/checkout',
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
    },
    {
        path: '/single-report',
        name: 'single-report',
        component: () => import('./components/richtvpro/SingleSpecializeReports.vue'),
    },
    {
        path: '/quotes/:symbol',
        name: 'quote',
        component: () => import('./components/stocks/SingleStock.vue'),
    }
];

routes.forEach(route => {
    const unprotectedRoutes = [
        'pricing', 'checkout', 'thank-you', 'home', 'quote', 'economic-calendar', 'groups', 'richtv-live',
        'earning-calendar', 'ipo-calendar', 'dividend-calendar', 'splits-calendar', 'watchlist', 'personal-access',
        'stocks-screener', 'trading-education', 'category', 'post', 'NotFound', 'NotFoundPage', 'propicks', 'exams',
        'PrivacyPolicy', 'ContactUs', 'TermsOfUse', 'About', 'Glossary', 'singlePost'
    ];

    const routeName = typeof route.name === 'function' ? route.name({ params: { category: '', subCategory: '' } }) : route.name;
    
    if (
        !unprotectedRoutes.includes(routeName) &&
        !(typeof routeName === 'string' && routeName.startsWith('markets'))
    ) {
        route.meta = { ...route.meta, requiresAuth: true };
    }
});



const router = createRouter({
    history: createWebHistory(),
    routes,
});

const isCheckingAuthRef = ref(true);
const isLoggedInRef = ref(false);

watch(isCheckingAuthRef, (newValue) => {
    if (!newValue) {
        isLoggedInRef.value = isLoggedIn();
    }
});

router.beforeEach(async (to, from, next) => {
    if (isCheckingAuthRef.value) {
        await checkLoginStatus();
        isCheckingAuthRef.value = isCheckingAuth();
        isLoggedInRef.value = isLoggedIn();
    }

    if (to.matched.some(record => record.meta.requiresAuth)) {
        if (!isLoggedInRef.value) {
            // Redirect to Laravel login route
            window.location.href = `/login?redirect=${encodeURIComponent(to.fullPath)}`;
        } else {
            next();
        }
    } else if (to.path === '/' && isLoggedInRef.value) {
        next('/feed');
    } else {
        next();
    }
});
export default router;