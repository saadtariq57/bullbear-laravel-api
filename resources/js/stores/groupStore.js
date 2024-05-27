import GroupService from '../services/groupService';
import UserFeedService from '../services/userFeedService'
import ablyService from '../services/ablyService.js';

const userGroupModule = {
    namespaced: true,
    state: () => ({
        suggestedChats: [],
        joinedChats: [],
        messages: [],
        newMessage: '',
        isLoading: false,
        allMessagesLoaded: false,
        error: null
    }),
    mutations: {
        setSuggestedChats(state, chats) {
            state.suggestedChats = chats;
        },
        setJoinedChats(state, chats) {
            state.joinedChats = chats;
        },
        setMessages(state, messages){
            state.messages = messages;
        },
        addMessage(state, message) {
            state.messages.unshift(message);
        },
        addMoreMessages(state, messages) {
            if (messages.length === 0) {
                state.allMessagesLoaded = true;
            }else{
                state.messages = [...state.messages, ...messages];
            } 
        },
        updateMessage(state, { messageId, newText }) {
            const message = state.messages.find(msg => msg.id === messageId);
            if (message) {
                message.text = newText;
            }
        },
        deleteMessage(state, messageId){
            const index = state.messages.findIndex(msg => msg.id === messageId);
            if (index !== -1) {
                state.messages.splice(index, 1);
            }
        },
        setLoading(state, isLoading) {
            state.isLoading = isLoading;
        },
        setError(state, error) {
            state.error = error;
        }
    },
    actions: {
        async fetchSuggestedChats({ commit }) {
            commit('setLoading', true);
            try {
                const chats = await GroupService.fetchSuggestedChats();
                commit('setSuggestedChats', chats);
            } catch (error) {
                commit('setError', error.message);
            } finally {
                commit('setLoading', false);
            }
        },
        async fetchJoinedChats({ commit }, userName = null) {
            commit('setLoading', true);
            try {
                const chats = await GroupService.fetchJoinedChats(userName);
                commit('setJoinedChats', chats);
            } catch (error) {
                commit('setError', error.message);
            } finally {
                commit('setLoading', false);
            }
        },
        async fetchMessages({ commit, rootState }, groupId) {
          commit('setLoading', true);
          try {
            let messages;
              messages = await GroupService.fetchGroupMessages(groupId);
            console.log(messages);
            commit('setMessages', messages);
          } catch (error) {
            commit('setError', error.message);
          } finally {
            commit('setLoading', false);
          }
        },
        async loadMoreMessages({ commit, state, rootState }, { groupId, page }) {
            commit('setLoading', true);
            try {
                const response = await GroupService.fetchGroupMessages(groupId, page);
                if (response.length) {
                    commit('addMoreMessages', response);
                } else{
                    commit('addMoreMessages', []);
                }
                return response.data;
            } catch (error) {
                commit('setError', error.message);
            } finally {
                commit('setLoading', false);
            }
        },
        async sendMessage({ commit, state }, { groupId, text, userId, replyTo = null}) {
            try {
                const messageData = { text, userId, replyTo };
                const message = await GroupService.sendMessage(groupId, messageData);
                //commit('addMessage', message.data);
            } catch (error) {
                console.error('Error sending message:', error);
            }
        },
        async editMessage({commit}, { groupId, messageId, newText } ){
            try{
                const updatedMessage = await GroupService.editMessage(groupId, messageId, newText);
                commit('updateMessage', {messageId, newText: updatedMessage.text })

            } catch(error) {
                console.error('Error updateing message:', error)
            }
        },
        async deleteMessage({commit}, {messageId}){
            try {
                const deletedMessage = await GroupService.deleteMessage(messageId);
                commit('deleteMessage', messageId);
            } catch (error) {
                console.error('Error Deleting Message' , error);
            }
        },
        initializeRealTimeMessages({commit, rootState}, groupId){
            if (!rootState.loggedIn || !rootState.userData) return;
                ablyService.initializeAbly().then(() => {
                  ablyService.subscribeToGroupChat(groupId, (message) => {
                    console.log('Hello Callback');
                    if (message.name === "NewMessage") {
                        commit('addMessage', message.data);
                    }
                  });
            });
        }
    },
    getters: {
        getSuggestedChats(state) {
            return state.suggestedChats;
        },
        getJoinedChats(state) {
            return state.joinedChats;
        },
        isLoading(state) {
            return state.isLoading;
        },
        getError(state) {
            return state.error;
        }
    }
};

export default userGroupModule;
