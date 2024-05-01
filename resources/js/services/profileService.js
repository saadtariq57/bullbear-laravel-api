const ProfileService = {
    async getUserProfileData(userName) {
        try {
            const response = await axios.post(`/api/profileData/${userName}`, {
                withCredentials: true,
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                },
            });
            return response.data;
        } catch (error) {
            console.error('Error fetching profile data:', error);
            this.message = error.response.data.error;
        }
    },
    async followUser(userId) {
        try {
            const response = await axios.post(`/api/users/${userId}/follow`, null, {
                withCredentials: true,
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                },
            });
            return response.data;
        } catch (error) {
            console.error('Error following user:', error);
            throw error;
        }
    },
    async unfollowUser(userId) {
        try {
            const response = await axios.delete(`/api/users/${userId}/unfollow`, {
                withCredentials: true,
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                },
            });
            return response.data;
        } catch (error) {
            console.error('Error unfollowing user:', error);
            throw error;
        }
    },
    
};

export default ProfileService;
