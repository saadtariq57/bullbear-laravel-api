const ProfileGroupHeaderService = {
    async uploadCoverImage({file, context}) {
        const formData = new FormData();
        formData.append('cover_photo', file);
        try {
            if(context == 'profileHeader'){
                const response = await axios.post('/api/uploadCover', formData, {
                    headers: {
                        'Content-Type': 'multipart/form-data'
                    }
                });
                return response.data;
            }else if(context == 'groupHeader'){
                console.log('request Recieved from: ', context);
                const response = await axios.post('/api/uploadGroupCover', formData, {
                    headers: {
                        'Content-Type': 'multipart/form-data'
                    }
                });
                return response.data;
            }else{
                return 'This action is not alowed';
            }
        } catch (error) {
            console.error('Error uploading cover photo:', error);
            throw error; // Rethrow the error to handle in the store
        }
    },
    async RemoveCoverImage(context){
        try {
            if(context == 'profileHeader'){
                const response = await axios.post('/api/removeCover', {
                    headers: {
                        'Content-Type': 'multipart/form-data'
                    }
                });
                return response.data
            }else if(context == 'groupHeader'){
                const response = await axios.post('/api/removeGroupCover', {
                    headers: {
                        'Content-Type': 'multipart/form-data'
                    }
                });
                return response.data;
            }else{
                return 'This action is not alowed';
            }
        } catch (error) {
            console.error('Error removing cover photo:', error);
            // this.message = response.data.error;
        }
    },
    async uploadProfileImage({file, context}) {
        const formData = new FormData();
        formData.append('profile_photo', file);

        try {
            if(context == 'profileHeader'){
                const response = await axios.post('/api/profileImage', formData, {
                    headers: {
                        'Content-Type': 'multipart/form-data'
                    }
                });
                return response.data;
            }else if(context == 'groupHeader'){
                const response = await axios.post('/api/profileGroupImage', formData, {
                    headers: {
                        'Content-Type': 'multipart/form-data'
                    }
                });
                return response.data;
            }else{
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
