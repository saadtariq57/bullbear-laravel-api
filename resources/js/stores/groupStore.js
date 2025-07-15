import GroupService from '../services/groupService';
import UserFeedService from '../services/userFeedService'
import ablyService from '../services/ablyService.js';

const userGroupModule = {
    namespaced: true,
    state: () => ({
        groupData: {},
        suggestedChats: [],
        joinedChats: [],
        currentPage: 1,
        lastPage: 1,
        perPage: 9,
        // Suggested chats pagination
        suggestedChatsCurrentPage: 1,
        suggestedChatsLastPage: 1,
        suggestedChatsPerPage: 9,
        suggestedChatsTotal: 0,
        suggestedChatsHasMore: false,
        searchQuery: '',
        isLoadingJoinedChats: false,
        joinedChatsError: null,
        messages: [],
        newMessage: '',
        isLoading: false,
        allMessagesLoaded: false,
        error: null
    }),
    mutations: {
        setGroup(state, groupData){
            state.groupData = groupData;
        },
        setJoinedStatus(state, payload) {
            state.groupData.isJoined = payload.joined;
            state.groupData.requestPending = payload.requestPending;
        },
        setCurrentPage(state, page) {
            state.currentPage = page;
        },
        setLastPage(state, lastPage) {
            state.lastPage = lastPage;
        },
        setPerPage(state, perPage) {
            state.perPage = perPage;
        },
        setLoadingJoinedChats(state, isLoading) {
            state.isLoadingJoinedChats = isLoading;
        },
        setJoinedChatsError(state, error) {
            state.joinedChatsError = error;
        },
        setSuggestedChats(state, chats) {
            state.suggestedChats = chats;
        },
        appendSuggestedChats(state, chats) {
            state.suggestedChats = [...state.suggestedChats, ...chats];
        },
        setSuggestedChatsPage(state, page) {
            state.suggestedChatsCurrentPage = page;
        },
        setSuggestedChatsLastPage(state, lastPage) {
            state.suggestedChatsLastPage = lastPage;
        },
        setSuggestedChatsPerPage(state, perPage) {
            state.suggestedChatsPerPage = perPage;
        },
        setSuggestedChatsTotal(state, total) {
            state.suggestedChatsTotal = total;
        },
        setSuggestedChatsHasMore(state, hasMore) {
            state.suggestedChatsHasMore = hasMore;
        },
        setSearchQuery(state, query) {
            state.searchQuery = query;
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
        async fetchGroupData({commit}, groupId){
            try{
                const groupData = await GroupService.fetchSingleGroup(groupId);
                commit('setGroup', groupData);
            }catch(error){
                commit('setError', error.message);
            }
        },
        async fetchSuggestedChats({ commit, state }, { page = 1, search = '', loadMore = false } = {}) {
            commit('setLoading', true);
            try {
                const response = await GroupService.fetchSuggestedChats(page, state.suggestedChatsPerPage, search);
                
                if (loadMore) {
                    commit('appendSuggestedChats', response.data);
                } else {
                    commit('setSuggestedChats', response.data);
                }
                
                commit('setSuggestedChatsPage', response.current_page);
                commit('setSuggestedChatsLastPage', response.last_page);
                commit('setSuggestedChatsPerPage', response.per_page);
                commit('setSuggestedChatsTotal', response.total);
                commit('setSuggestedChatsHasMore', response.has_more);
                commit('setSearchQuery', search);
                commit('setError', null);
            } catch (error) {
                commit('setError', error.message);
            } finally {
                commit('setLoading', false);
            }
        },
        async searchSuggestedChats({ dispatch }, searchQuery) {
            return dispatch('fetchSuggestedChats', { page: 1, search: searchQuery, loadMore: false });
        },
        async loadMoreSuggestedChats({ commit, state, dispatch }) {
            if (!state.suggestedChatsHasMore) return;
            
            const nextPage = state.suggestedChatsCurrentPage + 1;
            return dispatch('fetchSuggestedChats', { 
                page: nextPage, 
                search: state.searchQuery, 
                loadMore: true 
            });
        },
        async fetchJoinedChats({ commit, state}, { userName = null, page = 1 } = {}) {
            commit('setLoading', true);
            try {
                const per_page = state.perPage;
                const chats = await GroupService.fetchJoinedChats(userName, page, per_page);
                
                commit('setJoinedChats', chats.data);
                commit('setCurrentPage', chats.current_page);
                commit('setLastPage', chats.last_page);
                commit('setPerPage', chats.per_page);
                commit('setJoinedChatsError', null);
            } catch (error) {
                commit('setJoinedChatsError', error.response?.data?.error || 'Failed to fetch joined chats');
            } finally {
                commit('setLoadingJoinedChats', false);
                commit('setLoading', false);
            }
        },
        async fetchMessages({ commit, rootState }, groupId) {
          commit('setLoading', true);
          try {
            let messages;
              messages = await GroupService.fetchGroupMessages(groupId);
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
                commit('addMessage', message.data);
            } catch (error) {
                console.error('Error sending message:', error);
            }
        },
        async editMessage({commit}, { groupId, messageId, newText } ){
            try{
                const updatedMessage = await GroupService.editMessage(groupId, messageId, newText);
                commit('updateMessage', {messageId, newText: updatedMessage.data.text })

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
        },
        getSuggestedChatsHasMore(state) {
            return state.suggestedChatsHasMore;
        },
        getSearchQuery(state) {
            return state.searchQuery;
        }
    }
};

export default userGroupModule;
