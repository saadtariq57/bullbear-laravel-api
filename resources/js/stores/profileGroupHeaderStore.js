import ProfileGroupHeaderService from '../services/profileGroupHeaderService';

const ProfileGroupHeaderModule = {
    namespaced: true,
    state: () => ({
        UpdatedCoverImagePath: null,
        UpdatedProfileImagePath: null,
        message: null,
        isLoading: false,
        error: null,
        success: null,
    }),
    mutations: {
        SET_COVER_IMAGE_PATH(state, UpdatedCoverImagePath) {
            state.UpdatedCoverImagePath = UpdatedCoverImagePath;
        },
        SET_PROFILE_IMAGE_PATH(state, UpdatedProfileImagePath) {
            state.UpdatedProfileImagePath = UpdatedProfileImagePath;
        },
        SET_MESSAGE(state, message) {
            state.message = message;
        },
        SET_LOADING(state, isLoading) {
            state.isLoading = isLoading;
        },
        SET_ERROR(state, error) {
            state.error = error;
        },
        SET_SUCCESS(state, success) {
            state.success = success;
        }
    },
    actions: {
        async uploadCoverImage({ commit }, {file, context}) {
            // commit('SET_LOADING', true);
            // commit('SET_ERROR', null); // Clear previous error
            try {
                const data = await ProfileGroupHeaderService.uploadCoverImage({file, context});
                commit('SET_COVER_IMAGE_PATH', data.cover_photo);
                commit('SET_MESSAGE', data.message);
                // return ;
            } catch (error) {
                console.error('Error uploading cover photo:', error);
                commit('SET_ERROR', error.response ? error.response.data.error : 'Unknown error occurred');
            } finally {
                commit('SET_LOADING', false);
                commit('SET_SUCCESS', null);
            }
        },
        async RemoveCoverImage({ commit }, context) {
            try {
                const data = await ProfileGroupHeaderService.RemoveCoverImage(context);
                
                commit('SET_COVER_IMAGE_PATH', 'photos/d-cover.jpg');
                commit('SET_MESSAGE', data.message);
            } catch (error) {
                console.error('Error removing cover photo:', error);
                commit('SET_ERROR', error.response ? error.response.data.error : 'Unknown error occurred');
            } finally {
                commit('SET_LOADING', false);
            }
        },
        async uploadProfileImage({ commit }, {file, context}) {
            // commit('SET_LOADING', true);
            // commit('SET_ERROR', null); // Clear previous error
            try {
                const data = await ProfileGroupHeaderService.uploadProfileImage({file, context});
                commit('SET_PROFILE_IMAGE_PATH', data.profile_photo);
                commit('SET_MESSAGE', data.message);
                
            } catch (error) {
                console.error('Error uploading cover photo:', error);
                commit('SET_ERROR', error.response ? error.response.data.error : 'Unknown error occurred');
            } finally {
                commit('SET_LOADING', false);
            }
        },
        clearMessage({ commit }) {
            commit('SET_MESSAGE', null);
        },
        // Add more actions as needed
    },
    getters: {
        getCoverImagePath(state){
            return state.UpdatedCoverImagePath;
        },
        getProfileImagePath(state){
            return state.UpdatedProfileImagePath;
        },
        getMessage(state) {
            return state.message;
        },
        isLoading(state) {
            return state.isLoading;
        },
        getError(state) {
            return state.error;
        }
    }
};

export default ProfileGroupHeaderModule;
