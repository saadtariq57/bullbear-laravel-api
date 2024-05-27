import searchService from '../services/searchService';

const searchModule = {
    namespaced: true,
    state: () => ({
        isLoading: false,
        error: null,
        success: null,
        symbolResults: [],
        groupsResults: [],
        membersResults: []
    }),
    mutations: {
        SET_LOADING(state, isLoading) {
            state.isLoading = isLoading;
        },
        SET_ERROR(state, error) {
            state.error = error;
        },
        SET_SUCCESS(state, success) {
            state.success = success;
        },
        SET_SEARCH_SYMBOL_RESULTS(state, symbolResults){
            state.symbolResults = symbolResults;
        },
        SET_SEARCH_GROUPS_RESULTS(state, groupsResults){
            state.groupsResults = groupsResults;
        },
        SET_SEARCH_MEMBERS_RESULTS(state, membersResults){
            state.membersResults = membersResults;
        }
    },
    actions: {
        async searchSymbols({ commit }, searchQuery) {
            try {
                
                const data = await searchService.searchSymbols(searchQuery);
                commit('SET_SEARCH_SYMBOL_RESULTS', data);
                console.log('search symbol results: ', data);
            } catch (error) {
                console.error('Error searching data:', error);
            }
        },
        async searchGroups({ commit }, searchQuery) {
            try {
                const data = await searchService.searchGroups(searchQuery);
                commit('SET_SEARCH_GROUPS_RESULTS', data);
                console.log('search groups results: ', data);
            } catch (error) {
                console.error('Error searching data:', error);
            }
        },
        async searchMembers({ commit }, searchQuery) {
            try {
                
                const data = await searchService.searchMembers(searchQuery);
                commit('SET_SEARCH_MEMBERS_RESULTS', data);
                console.log('search members results: ', data);
            } catch (error) {
                console.error('Error searching data:', error);
            }
        },
    },
    getters: {
        isLoading(state) {
            return state.isLoading;
        },
        getError(state) {
            return state.error;
        },
    }
};

export default searchModule;
