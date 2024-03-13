import GroupService from '../services/groupService';

const userGroupModule = {
    namespaced: true,
    state: () => ({
        suggestedChats: [],
        joinedChats: [],
        isLoading: false,
        error: null
    }),
    mutations: {
        setSuggestedChats(state, chats) {
            state.suggestedChats = chats;
        },
        setJoinedChats(state, chats) {
            state.joinedChats = chats;
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
        async fetchJoinedChats({ commit }) {
            commit('setLoading', true);
            try {
                const chats = await GroupService.fetchJoinedChats();
                commit('setJoinedChats', chats);
            } catch (error) {
                commit('setError', error.message);
            } finally {
                commit('setLoading', false);
            }
        }
        // Add more actions as needed
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
