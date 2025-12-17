import { createApp } from "vue";
import router from "./router";
import store from './stores/index';
import App from "./components/App.vue";
import { VueReCaptcha } from 'vue-recaptcha-v3';
import axios from 'axios';
import emailCollector from './components/emailCollector.vue';

// CSRF Token setup
const token = document.head.querySelector('meta[name="csrf-token"]');
if (token) {
    axios.interceptors.request.use((config) => {
        config.headers = config.headers || {};
        if (!/^(http|https):\/\//.test(config.url)) {
            config.headers.common = config.headers.common || {};
            config.headers.common['X-CSRF-TOKEN'] = token.content;
        }
        return config;
    }, (error) => {
        return Promise.reject(error);
    });
} else {
    console.error('CSRF token not found: https://laravel.com/docs/csrf#csrf-x-csrf-token');
}
axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';
window.axios = axios;

// Create Vue app
const app = createApp(App);

//Registering emailCollectorpopup
app.component('email-popup', emailCollector);

// Use router and store
app.use(router);
app.use(store);
app.use(VueReCaptcha, { siteKey: '6LdtJ2oqAAAAAL8q_A4fD3SsYRDL4Obq34tqbAO5' });

// Hide loader function
function hideLoader() {
    const overlayLoader = document.getElementById('overlay_loader');
    if (overlayLoader) {
        overlayLoader.style.display = 'none';
    }
}

// Check if main content is visible/rendered
function isMainContentReady() {
    const appElement = document.getElementById('app');
    if (!appElement) return false;
    
    // Check if Vue app has rendered content (not just mounted)
    const hasContent = appElement.children.length > 0;
    if (!hasContent) return false;
    
    // Check if we're past the preloader stage (isCheckingAuthState is false)
    // The preloader shows when isCheckingAuthState is true
    const preloader = appElement.querySelector('.preloader');
    if (preloader && preloader.offsetParent !== null) {
        // Preloader is still visible, content not ready
        return false;
    }
    
    // Check if the main content area is visible
    const pageContent = appElement.querySelector('.page-content, .feed-main');
    if (pageContent) {
        // Check if element has dimensions (is rendered and visible)
        const rect = pageContent.getBoundingClientRect();
        const isVisible = rect.height > 0 && window.getComputedStyle(pageContent).display !== 'none';
        if (isVisible) {
            // Additional check: ensure Navigation is also rendered
            const navigation = appElement.querySelector('nav, .navbar, [class*="navigation"], [class*="Navigation"]');
            return navigation !== null || rect.height > 100; // Navigation might not have specific class
        }
    }
    
    // Fallback: if app has children and no preloader, assume content is ready
    return !preloader || preloader.offsetParent === null;
}

// Show footer and hide skeleton when Vue app is ready
function showFooter() {
    const footerSkeleton = document.getElementById('footer-skeleton');
    const footerContent = document.getElementById('footer-content');
    
    if (footerSkeleton && footerContent) {
        footerSkeleton.classList.add('hidden');
        footerContent.classList.add('visible');
    }
}

// Wait for main content to be ready before showing footer
function waitForContentAndShowFooter(maxAttempts = 20, attempt = 0) {
    if (isMainContentReady()) {
        hideLoader();
        showFooter();
        return;
    }
    
    if (attempt < maxAttempts) {
        setTimeout(() => {
            waitForContentAndShowFooter(maxAttempts, attempt + 1);
        }, 100);
    } else {
        // Fallback: show footer even if content check fails
        hideLoader();
        showFooter();
    }
}

router.isReady().then(() => {
    //store.dispatch('checkLoginStatus').finally(() => {
        app.mount("#app");
        // Wait for Vue to render content before showing footer
        setTimeout(() => {
            waitForContentAndShowFooter();
        }, 100);
    //});
});


// Fallback for hiding loader if Vue doesn't mount (optional)
setTimeout(() => {
    const appElement = document.getElementById('app');
    if (appElement && appElement.children.length > 0) {
        hideLoader();
        showFooter();
    }
}, 5000);

// Ensure profile dropdowns open on click using Bootstrap API
document.addEventListener('click', function (event) {
    const toggleSelector = '.profile-wrapper [data-bs-toggle="dropdown"], .btn-drps [data-bs-toggle="dropdown"]';
    const toggleButton = event.target.closest(toggleSelector);
    if (!toggleButton) return;

    // Prevent default to avoid duplicate handling
    event.preventDefault();

    // Use Bootstrap's Dropdown API if available
    const BootstrapDropdown = window.bootstrap && window.bootstrap.Dropdown;
    if (BootstrapDropdown) {
        const instance = BootstrapDropdown.getOrCreateInstance(toggleButton);
        instance.toggle();
    }
});
