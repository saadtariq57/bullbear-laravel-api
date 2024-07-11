// stores/index.js
import { createStore } from 'vuex';
import userFeedModule from './userFeedStore';
import userFeedCommentModule from './userFeedCommentStore';
import userGroupModule from './groupStore';
import userSubscriptionModule from './pricingStore';
import userProfileModule from './profileStore';
import ProfileGroupHeaderModule from './profileGroupHeaderStore';
import userNotificationModule from './notificationStore';
import userWatchlistModule from './watchlistStore';
import userWidgetsModule from './widgetsStore';
import searchModule from './searchStore';
import axios from 'axios';
import Swal from 'sweetalert2';

const store = createStore({
    state: {
        userData: null,
        loggedIn: false,
        isCheckingAuth: true
    },
    mutations: {
        SET_USER_DATA(state, userData) {
            state.userData = userData;
            state.loggedIn = true;
            state.isCheckingAuth = false;
        },
        SET_LOGOUT(state) {
            state.userData = null;
            state.loggedIn = false;
            state.isCheckingAuth = false;
        },
        SET_SHOW_LOGIN_POPUP(state, show) {
            state.showLoginPopup = show;
        },
        SET_CHECKING_AUTH(state, isChecking) {
            state.isCheckingAuth = isChecking;
        }
    },
    actions: {
        async checkLoginStatus({ dispatch, commit }) {
            commit('SET_CHECKING_AUTH', true);
            try {
                const response = await axios.get('/api/check-login');
                if (response.data.loggedIn) {
                    await dispatch('fetchUserData');
                } else {
                    commit('SET_LOGOUT');
                }
            } catch (error) {
                console.error('Error checking login status:', error);
                commit('SET_LOGOUT');
            } finally {
                commit('SET_CHECKING_AUTH', false);
            }
        },
        async login({ dispatch }, credentials) {
            try {
                const response = await axios.post('/login', credentials);
                if (response.data.success) {
                    await dispatch('fetchUserData');
                    return { success: true };
                } else {
                    return { success: false, message: response.data.message };
                }
            } catch (error) {
                console.error('Login error:', error);
                return { success: false, message: 'An error occurred during login' };
            }
        },
        async fetchUserData({ commit }) {
            try {
                const response = await axios.get('/api/userdata');
                if (response.data) {
                    commit('SET_USER_DATA', response.data);
                } else {
                    commit('SET_LOGOUT');
                }
            } catch (error) {
                console.error('Error fetching user data:', error);
                commit('SET_LOGOUT');
            }
        },
        updateUserData({ commit }, userData) {
            axios.post('/api/user/update', userData)
                .then(response => {
                    commit('SET_USER_DATA', response.data.user);
                    const Toast = Swal.mixin({
                        toast: true,
                        position: "top-end",
                        showConfirmButton: false,
                        width: "400px",
                        timer: 1000,
                        timerProgressBar: true,
                        didOpen: (toast) => {
                            toast.onmouseenter = Swal.stopTimer;
                            toast.onmouseleave = Swal.resumeTimer;
                        }
                    });
                    Toast.fire({
                        icon: "success",
                        title: "User data updated successfully!"
                    });
                })
                .catch(error => {
                    console.error('Error updating user data:', error.response.data);
                    const Toast = Swal.mixin({
                        toast: true,
                        position: "top-end",
                        showConfirmButton: false,
                        width: "400px",
                        timer: 1000,
                        timerProgressBar: true,
                        didOpen: (toast) => {
                            toast.onmouseenter = Swal.stopTimer;
                            toast.onmouseleave = Swal.resumeTimer;
                        }
                    });
                    Toast.fire({
                        icon: "error",
                        title: "Error updating user data"
                    });
                });
        }
    },
    modules: {
        userNotification: userNotificationModule,
        userFeed: userFeedModule,
        userFeedComment: userFeedCommentModule,
        UserGroups: userGroupModule,
        userSubscriptionModule: userSubscriptionModule,
        userProfile: userProfileModule,
        profileGroupHeader: ProfileGroupHeaderModule,
        userWatchlists: userWatchlistModule,
        userWidgets: userWidgetsModule,
        searchResults: searchModule
    }
});

export default store;

export const isCheckingAuth = () => store.state.isCheckingAuth;
export const checkLoginStatus = () => store.dispatch('checkLoginStatus');
export const isLoggedIn = () => store.state.loggedIn;
export const showLoginPopup = () => store.commit('SET_SHOW_LOGIN_POPUP', true);