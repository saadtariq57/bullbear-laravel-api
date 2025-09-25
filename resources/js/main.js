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

router.isReady().then(() => {
    //store.dispatch('checkLoginStatus').finally(() => {
        app.mount("#app");
        setTimeout(() => {
            hideLoader();
        }, 150);
    //});
});


// Fallback for hiding loader if Vue doesn't mount (optional)
setTimeout(() => {
    const appElement = document.getElementById('app');
    if (appElement) {
        hideLoader();
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
