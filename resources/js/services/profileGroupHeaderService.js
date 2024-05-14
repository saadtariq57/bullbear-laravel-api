const ProfileGroupHeaderService = {
    async uploadCoverImage({ file, context, groupId }) {
        const formData = new FormData();
        formData.append('cover_photo', file);
        formData.append('group_id', groupId);  // Include group ID in the form data
        try {
            if (context == 'profileHeader') {
                const response = await axios.post('/api/uploadCover', formData, {
                    headers: {
                        'Content-Type': 'multipart/form-data'
                    }
                });
                return response.data;
            } else if (context == 'groupHeader') {
                console.log('request Recieved from: ', context);
                const response = await axios.post('/api/uploadGroupCover', formData, {
                    headers: {
                        'Content-Type': 'multipart/form-data'
                    }
                });
                return response.data;
            } else {
                return 'This action is not alowed';
            }
        } catch (error) {
            console.error('Error uploading cover photo:', error);
            throw error; // Rethrow the error to handle in the store
        }
    },
    async RemoveCoverImage(context, group_Id) {
        const formData = new FormData();
        formData.append('group_id', group_Id);
        let url = '/api/removeCover';  // Default to profile header

        if (context === 'groupHeader') {
            url = '/api/removeGroupCover';  // Use group header URL
        }

        try {
            const response = await axios.post(url, formData, {
                headers: {
                    'Content-Type': 'multipart/form-data'
                }
            });
            return response.data;
        } catch (error) {
            console.error('Error removing cover photo:', error);
            // throw error;  // Re-throw to handle it in the Vuex store
            console.error('Error removing cover photo:', error);
            this.message = response.data.error;
        }
    },
    async uploadProfileImage({ file, context, group_Id}) {
        const formData = new FormData();
        formData.append('profile_photo', file);
        formData.append('group_id', group_Id);

        try {
            if (context == 'profileHeader') {
                const response = await axios.post('/api/profileImage', formData, {
                    headers: {
                        'Content-Type': 'multipart/form-data'
                    }
                });
                return response.data;
            } else if (context == 'groupHeader') {
                const response = await axios.post('/api/profileGroupImage', formData, {
                    headers: {
                        'Content-Type': 'multipart/form-data'
                    }
                });
                return response.data;
            } else {
                return 'This action is not alowed';
            }
            // this.profileImagePath = response.data.profile_photo;
        } catch (error) {
            console.error('Error uploading profile photo:', error);
            this.message = response.data.error;
        }
    },

};

export default ProfileGroupHeaderService;
