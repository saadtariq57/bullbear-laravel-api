import ProfileService from '../services/profileService';

const userProfileModule = {
    namespaced: true,
    state: () => ({
        isLoading: false,
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
    }),
    mutations: {
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
        SET_LOADING(state, isLoading) {
            state.isLoading = isLoading;
        },
        SET_ERROR(state, error) {
            state.error = error;
        },
        SET_SUCCESS(state, success) {
            state.success = success;
        },
    },
    actions: {
        async getUserProfileData({ commit }, { userName = null }) {
            try {
                const data = await ProfileService.getUserProfileData(userName);
                commit('SET_PROFILE_DATA', data.userProfile);
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
            }
        },
        async followUser({ commit }, { userId, followersCount }) {
            try {
                const data = await ProfileService.followUser(userId);
                commit('SET_IS_FOLLOWING', true);
                commit('SET_IS_FOLLOWERS_COUNT', followersCount + 1);
                console.log(data);
                // Handle UI update or other actions upon successful follow/unfollow
            } catch (error) {
                console.error('Error while following user:', error);
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
            } catch (error) {
                console.error('Error while unfollowing user:', error);
                throw error;
            }
        },
        // Add more actions as needed
    },
    getters: {
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
        isLoading(state) {
            return state.isLoading;
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
    }
};

export default userProfileModule;
