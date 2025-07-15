import store from './index';

/**
 * Dynamically registers a Vuex module if it's not already registered.
 * @param {string} name - The namespace name of the module.
 * @param {object} module - The Vuex module object.
 */
export const registerVuexModule = (name, module) => {
    if (!store.hasModule(name)) {
        store.registerModule(name, module);
    }
};

/**
 * Optionally, unregister a module if it's no longer needed.
 * @param {string} name - The namespace name of the module.
 */
export const unregisterVuexModule = (name) => {
    if (store.hasModule(name)) {
        store.unregisterModule(name);
    }
};