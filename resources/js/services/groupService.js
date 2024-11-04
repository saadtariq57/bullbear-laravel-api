import axios from "axios";

const GroupService = {
    async fetchSingleGroup(groupId){
        try{
            const response = await axios.get(`/api/groups/${groupId}`);
            return response.data;
        }catch(error){
            console.error('Error fetching suggested chats:', error);
            throw error;
        }
    },
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

    async fetchJoinedChats(userName = null, page = 1, per_page = 9) {
        try {
            if (userName) {
                console.log(userName);
                const response = await axios.get('/api/joined-chats', {
                    params: {
                      userName,
                      page,
                      per_page: per_page,
                    }
                });
                const joinedChats = response.data;
                console.log(joinedChats);
                return joinedChats;
            }
            else {
                console.log('No User Name Supplied');
                const response = await axios.get('/api/joined-chats', {
                    params: {
                      page,
                      per_page: per_page,
                    }
                });
                const joinedChats = response.data;
                console.log(joinedChats);
                return joinedChats;
            }
        } catch (error) {
            console.error('Error fetching joined chats:', error.message);
            throw error;
        }
    },

    async fetchGroupMessages(groupId, page = 1) {
        try {
            const response = await axios.get(`/api/${groupId}/messages?page=${page}`);
            return response.data;
        } catch (error) {
            console.error('Error fetching group messages:', error);
            throw error;
        }
    },
    async sendMessage(groupId, messageData) {
        try {
            const response = await axios.post(`/api/groups/${groupId}/send-message`, messageData);
            console.log(response);
            return response.data;
        } catch (error) {
            console.error('Error Sending Message', error);
            throw error;
        }
    },

    async editMessage(groupId, messageId, newText) {
        try {
            const response = await axios.put(`/api/groups/${groupId}/messages/${messageId}`, { text: newText });
            return response.data;
        } catch (error) {
            console.error('Error updating message:', error);
            throw error;
        }
    }, 
    async deleteMessage(messageId) {
        try {
            const response = await axios.delete(`/api/groups/${messageId}/delete`, {messageId: messageId});
            return response.data;
        } catch (error) {
            console.error('Error Deleting Message:', error);
            throw error;
        }
    }
};

export default GroupService;
