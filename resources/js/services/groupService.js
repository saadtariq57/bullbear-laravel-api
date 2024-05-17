const GroupService = {
    async fetchSuggestedChats() {
        try {
            const response = await axios.get('/api/suggested-chats');
            // Transform the data as needed
            const suggestedChats = response.data;
            return suggestedChats;
        } catch (error) {
            console.error('Error fetching suggested chats:', error);
            throw error;
        }
    },

    async fetchJoinedChats(userName = null) {
        try {
            if (userName) {
                const response = await axios.get('/api/joined-chats', {
                    params: { userName }
                });
                const joinedChats = response.data;
                console.log(joinedChats);
                return joinedChats;
            }
            else {
                const response = await axios.get('/api/joined-chats');
                const joinedChats = response.data;
                console.log(joinedChats);
                return joinedChats;
            }
        } catch (error) {
            console.error('Error fetching joined chats:', error.message);
            throw error;
        }
    }
};

export default GroupService;
