import { createStore } from 'vuex';
import userFeedModule from './userFeedStore';
import userFeedCommentModule from './userFeedCommentStore';
import userGroupModule from './groupStore';
import userSubscriptionModule from './pricingStore';
import userProfileModule from './profileStore';
import ProfileGroupHeaderModule from './profileGroupHeaderStore';
import axios from 'axios';

export default createStore({
    state: {
        userData: null,
        loggedIn: false
    },
    mutations: {
        SET_USER_DATA(state, userData) {
            state.userData = userData;
            state.loggedIn = true;
        },
        SET_LOGOUT(state) {
            state.userData = null;
            state.loggedIn = false;
        }
    },
    actions: {
        async checkLoginStatus({ dispatch, commit }) {
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
            }
        },
        async fetchUserData({ commit }) {
            try {
                const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
                const response = await axios.get('/api/userdata', {
                    withCredentials: true,
                    headers: { 'X-CSRF-TOKEN': csrfToken },
                });
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
            const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
            axios.post('/api/user/update', userData, {
                headers: { 'X-CSRF-TOKEN': csrfToken },
                withCredentials: true
            })
            .then(response => {
                commit('SET_USER_DATA', response.data.user);  // Update the store with the returned user data
                alert('User data updated successfully!');
            })
            .catch(error => {
                console.error('Error updating user data:', error.response.data);
                alert('Failed to update data.');
            });
        }
    },
    modules:{
        userFeed: userFeedModule,
        userFeedComment: userFeedCommentModule,
        UserGroups: userGroupModule,
        userSubscriptionModule: userSubscriptionModule,
        userProfile: userProfileModule,
        profileGroupHeader: ProfileGroupHeaderModule
    }
});
