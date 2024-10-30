import ProfileService from '../services/profileService';
import Swal from 'sweetalert2';


const userProfileModule = {
    namespaced: true,
    state: () => ({
        isLoadingProfile: true,
        error: null,
        success: null,
        userProfileData: null,
        coverImagePath: 'photos/d-cover.jpg',
        profileImagePath: 'photos/d-avatar.jpg',
        isOwnProfile: null,
        userMedia: null,
        isFollowing: false,
        followersCount: 0,
        followingsCount: 0,
        followersData: null,
        followingsData: null,
        currentFollowersData: null,
        currentFollowingsData: null,
        suggestedTraders: [],
        isSuggestedTradersLoading: false,
        userOnline: 'Offline',
    }),
    mutations: {
        SET_SUGGESTED_TRADERS(state, suggestedTraders) {
            state.suggestedTraders = suggestedTraders;
        },
        SET_SUGGESTED_TRADERS_LOADING(state, isLoadingProfile) {
            state.isSuggestedTradersLoading = isLoadingProfile;
        },
        SET_USER_ONLINE(state, active_status){
            state.userOnline = active_status;
        },
        SET_PROFILE_DATA(state, userProfileData) {
            state.userProfileData = userProfileData;
        },
        SET_IS_OWN_PROFILE(state, isOwnProfile) {
            state.isOwnProfile = isOwnProfile;
        },
        SET_COVER_IMAGE_PATH(state, coverImagePath) {
            state.coverImagePath = coverImagePath;
        },
        SET_PROFILE_IMAGE_PATH(state, profileImagePath) {
            state.profileImagePath = profileImagePath;
        },
        SET_IS_FOLLOWING(state, isFollowing) {
            state.isFollowing = isFollowing;
        },
        SET_IS_FOLLOWERS_COUNT(state, followersCount) {
            state.followersCount = followersCount;
        },
        SET_FOLLOWINGS_DATA(state, followingsData) {
            state.followingsData = followingsData;
        },
        SET_CURRENT_FOLLOWERS_DATA(state, currentFollowersData) {
            state.currentFollowersData = currentFollowersData;
        },
        SET_CURRENT_FOLLOWINGS_DATA(state, currentFollowingsData) {
            state.currentFollowingsData = currentFollowingsData;
        },
        SET_FOLLOWERS_DATA(state, followersData) {
            state.followersData = followersData;
        },
        SET_IS_FOLLOWING_COUNT(state, followingsCount) {
            state.followingsCount = followingsCount;
        },
        SET_USER_MEDIA(state, userMedia) {
            state.userMedia = userMedia;
        },
        SET_LOADING(state, isLoadingProfile) {
            state.isLoadingProfile = isLoadingProfile;
        },
        SET_ERROR(state, error) {
            state.error = error;
        },
        SET_SUCCESS(state, success) {
            state.success = success;
        },
    },
    actions: {
        async fetchSuggestedTraders({ commit }) {
            commit('SET_SUGGESTED_TRADERS_LOADING', true);
            try {
                const response = await axios.get('/api/suggested-followers');
                commit('SET_SUGGESTED_TRADERS', response.data.data);
            } catch (error) {
                console.error('Error fetching suggested traders:', error);
                // Optionally, set an error state
            } finally {
                commit('SET_SUGGESTED_TRADERS_LOADING', false);
            }
        },
        async followSuggestedTrader({ commit, dispatch }, traderId) {
            try {
                await ProfileService.followUser(traderId);
                commit('SET_IS_FOLLOWING', true);
                // Optionally, update counts or fetch updated data
                Swal.fire({
                    toast: true,
                    position: "top-end",
                    showConfirmButton: false,
                    width: "400px",
                    timer: 1000,
                    timerProgressBar: true,
                    icon: "success",
                    title: "Followed trader successfully!"
                });
                // Refresh suggested traders
                dispatch('fetchSuggestedTraders');
            } catch (error) {
                Swal.fire({
                    toast: true,
                    position: "top-end",
                    showConfirmButton: false,
                    width: "400px",
                    timer: 1000,
                    timerProgressBar: true,
                    icon: "error",
                    title: "Error while following trader"
                });
                console.error('Error while following trader:', error);
            }
        },
        async getUserProfileData({ commit }, { userName = null }) {
            try {
                const data = await ProfileService.getUserProfileData(userName);
                commit('SET_PROFILE_DATA', data.userProfile);
                commit('SET_USER_ONLINE', data.active_status);
                commit('SET_IS_OWN_PROFILE', data.isOwnProfile);
                commit('SET_USER_MEDIA', data.userMedia);
                commit('SET_IS_FOLLOWING', data.isFollowing);
                commit('SET_IS_FOLLOWERS_COUNT', data.followersCount);
                commit('SET_IS_FOLLOWING_COUNT', data.followingsCount);
                commit('SET_FOLLOWINGS_DATA', data.followingsUserData);
                commit('SET_FOLLOWERS_DATA', data.followerUserData);
                commit('SET_CURRENT_FOLLOWINGS_DATA', data.currentFollowingsUserData);
                commit('SET_CURRENT_FOLLOWERS_DATA', data.currentFollowerUserData);
                commit('SET_COVER_IMAGE_PATH', data.userProfile.cover);
                if (data.avatar != '') {
                    commit('SET_PROFILE_IMAGE_PATH', data.userProfile.avatar);
                } else {
                    commit('SET_COVER_IMAGE_PATH', 'photos/d-avatar.jpg');
                }
                console.log('Profile data: ', data);
            } catch (error) {
                console.error('Error fetching profile data:', error);
            } finally{
                commit('SET_LOADING', false);
            }
        },
        async followUser({ commit }, { userId, followersCount }) {
            try {
                const data = await ProfileService.followUser(userId);
                commit('SET_IS_FOLLOWING', true);
                commit('SET_IS_FOLLOWERS_COUNT', followersCount + 1);
                console.log(data);
                // Handle UI update or other actions upon successful follow/unfollow
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
                    title: "Follow user successfully!"
                  });
            } catch (error) {
                // console.error('Error while following user:', error);
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
                    title: "Error while following user"
                  });
                throw error;
            }
        },
        async unfollowUser({ commit, dispatch }, { userId, followersCount }) {
            try {
                const data = await ProfileService.unfollowUser(userId);
                commit('SET_IS_FOLLOWING', false);
                commit('SET_IS_FOLLOWERS_COUNT', followersCount - 1);
                dispatch('userNotification/removeFollowerNotification', data.deletedFollowerNotification, { root: true });
                console.log(data);
                // Handle UI update or other actions upon successful follow/unfollow
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
                    title: "unfollow user successfully!"
                  });
            } catch (error) {
                // console.error('Error while unfollowing user:', error);
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
                    title: "Error while unfollowing user"
                  });
                throw error;
            }
        },
    },
    getters: {
        getSuggestedTraders(state) {
            return state.suggestedTraders;
        },
        isSuggestedTradersLoading(state) {
            return state.isSuggestedTradersLoading;
        },
        getOnlineStatus(state){
            return state.userOnline;
        },
        getProfileData(state) {
            return state.userProfileData;
        },
        getIsOwnProfile(state) {
            return state.isOwnProfile;
        },
        getIsFollowing(state) {
            return state.isFollowing;
        },
        getFollowersCount(state) {
            return state.followersCount;
        },
        getFollowingsCount(state) {
            return state.followingsCount;
        },
        getUserMedia(state) {
            return state.userMedia;
        },
        isLoadingProfile(state) {
            return state.isLoadingProfile;
        },
        getError(state) {
            return state.error;
        },
        getCoverImagePath(state) {
            return state.coverImagePath;
        },
        getProfileImagePath(state) {
            return state.profileImagePath;
        },
        // **Access Control Getters**
        canViewPosts(state, getters) {
            if (!state.userProfileData) return false;
            if (getters.getIsOwnProfile) return true;
            const privacy = state.userProfileData.post_privacy;
            if (privacy === 'Public') return true;
            if (privacy === 'Private') return false;
            // Assuming 'Followers' is the third option
            return getters.getIsFollowing;
        },
        canViewGroups(state, getters) {
            if (!state.userProfileData) return false;
            if (getters.getIsOwnProfile) return true;
            const privacy = state.userProfileData.groups_privacy;
            if (privacy === 'Everyone') return true;
            if (privacy === 'Private') return false;
            // Assuming 'Followers' is the third option
            return getters.getIsFollowing;
        },
        canViewWatchlists(state, getters) {
            if (!state.userProfileData) return false;
            if (getters.getIsOwnProfile) return true;
            const privacy = state.userProfileData.watchlists_privacy;
            if (privacy === 'Everyone') return true;
            if (privacy === 'Private') return false;
            // Assuming 'Followers' is the third option
            return getters.getIsFollowing;
        },
        canViewPhotos(state, getters) {
            if (!state.userProfileData) return false;
            if (getters.getIsOwnProfile) return true;
            const privacy = state.userProfileData.photos_privacy;
            if (privacy === 'Everyone') return true;
            if (privacy === 'Private') return false;
            // Assuming 'Followers' is the third option
            return getters.getIsFollowing;
        },
    }
};

export default userProfileModule;
