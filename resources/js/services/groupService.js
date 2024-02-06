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

    async fetchJoinedChats() {
        try {
            const response = await axios.get('/api/joined-chats');
            // Transform the data as needed
            const joinedChats = response.data;
            return joinedChats;
        } catch (error) {
            console.error('Error fetching joined chats:', error);
            throw error;
        }
    },
};

export default GroupService;
