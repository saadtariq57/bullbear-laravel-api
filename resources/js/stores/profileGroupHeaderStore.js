import ProfileGroupHeaderService from '../services/profileGroupHeaderService';
import Swal from 'sweetalert2';

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
        async uploadCoverImage({ commit }, {file, context , groupId}) {
            // commit('SET_LOADING', true);
            // commit('SET_ERROR', null); // Clear previous error
            try {
                const data = await ProfileGroupHeaderService.uploadCoverImage({file, context , groupId});
                commit('SET_COVER_IMAGE_PATH', data.cover_photo);
                commit('SET_MESSAGE', data.message);
                const Toast = Swal.mixin({
                    toast: true,
                    position: "top-end",
                    showConfirmButton: false,
                    width: "450px",
                    timer: 1000,
                    timerProgressBar: true,
                    didOpen: (toast) => {
                      toast.onmouseenter = Swal.stopTimer;
                      toast.onmouseleave = Swal.resumeTimer;
                    }
                  });
                  Toast.fire({
                    icon: "success",
                    title: "cover photo updated successfully!"
                  });
                // return ;
            } catch (error) {
                console.error('Error uploading cover photo:', error);
                commit('SET_ERROR', error.response ? error.response.data.error : 'Unknown error occurred');
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
                    title: "Error uploading cover photo"
                  });
            } finally {
                commit('SET_LOADING', false);
                commit('SET_SUCCESS', null);
            }
        },
        async RemoveCoverImage({ commit }, { context, group_Id }) {
            try {
                const data = await ProfileGroupHeaderService.RemoveCoverImage(context , group_Id);
                
                commit('SET_COVER_IMAGE_PATH', 'photos/d-cover.jpg');
                commit('SET_MESSAGE', data.message);
                const Toast = Swal.mixin({
                    toast: true,
                    position: "top-end",
                    showConfirmButton: false,
                    width: "450px",
                    timer: 1000,
                    timerProgressBar: true,
                    didOpen: (toast) => {
                      toast.onmouseenter = Swal.stopTimer;
                      toast.onmouseleave = Swal.resumeTimer;
                    }
                  });
                  Toast.fire({
                    icon: "success",
                    title: "Cover Photo deleted successfully!"
                  });
            } catch (error) {
                console.error('Error removing cover photo:', error);
                commit('SET_ERROR', error.response ? error.response.data.error : 'Unknown error occurred');
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
                    title: "Error deleting cover photo"
                  });
            } finally {
                commit('SET_LOADING', false);
            }
        },
        async uploadProfileImage({ commit }, {file, context, group_Id}) {
            // commit('SET_LOADING', true);
            // commit('SET_ERROR', null); // Clear previous error
            try {
                const data = await ProfileGroupHeaderService.uploadProfileImage({file, context, group_Id});
                commit('SET_PROFILE_IMAGE_PATH', data.profile_photo);
                commit('SET_MESSAGE', data.message);
                const Toast = Swal.mixin({
                    toast: true,
                    position: "top-end",
                    showConfirmButton: false,
                    width: "450px",
                    timer: 1000,
                    timerProgressBar: true,
                    didOpen: (toast) => {
                      toast.onmouseenter = Swal.stopTimer;
                      toast.onmouseleave = Swal.resumeTimer;
                    }
                  });
                  Toast.fire({
                    icon: "success",
                    title: "Profile Photo updated successfully!"
                  });
            } catch (error) {
                console.error('Error uploading cover photo:', error);
                commit('SET_ERROR', error.response ? error.response.data.error : 'Unknown error occurred');
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
                    title: "Error updating profile photo"
                  });
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
