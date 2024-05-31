import searchService from '../services/searchService';

const searchModule = {
    namespaced: true,
    state: () => ({
        isLoading: false,
        error: null,
        success: null,
        symbolResults: [],
        groupsResults: [],
        membersResults: [],
        defaultSymbolResults: [],
        defaultGroupsResults: [],
        defaultMembersResults: [],
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
        SET_SEARCH_SYMBOL_RESULTS(state, symbolResults) {
            state.symbolResults = symbolResults;
        },
        SET_SEARCH_GROUPS_RESULTS(state, groupsResults) {
            state.groupsResults = groupsResults;
        },
        SET_SEARCH_MEMBERS_RESULTS(state, membersResults) {
            state.membersResults = membersResults;
        },
        SET_DEFAULT_SYMBOL_RESULTS(state, defaultSymbolResults) {
            state.defaultSymbolResults = defaultSymbolResults;
        },
        SET_DEFAULT_GROUPS_RESULTS(state, defaultGroupsResults) {
            state.defaultGroupsResults = defaultGroupsResults;
        },
        SET_DEFAULT_MEMBERS_RESULTS(state, defaultMembersResults) {
            state.defaultMembersResults = defaultMembersResults;
        }
    },
    actions: {
        async searchSymbols({ commit }, searchQuery) {
            try {
                const data = await searchService.searchSymbols(searchQuery);
                commit('SET_SEARCH_SYMBOL_RESULTS', data);
            } catch (error) {
                console.error('Error searching data:', error);
            }
        },
        async searchGroups({ commit }, searchQuery) {
            try {
                const data = await searchService.searchGroups(searchQuery);
                commit('SET_SEARCH_GROUPS_RESULTS', data);
            } catch (error) {
                console.error('Error searching data:', error);
            }
        },
        async searchMembers({ commit }, searchQuery) {
            try {
                const data = await searchService.searchMembers(searchQuery);
                commit('SET_SEARCH_MEMBERS_RESULTS', data);
            } catch (error) {
                console.error('Error searching data:', error);
            }
        },
        async fetchDefaultSymbols({ commit }) {
            try {
                const data = await searchService.fetchDefaultSymbols();
                commit('SET_DEFAULT_SYMBOL_RESULTS', data);
            } catch (error) {
                console.error('Error fetching default symbols:', error);
            }
        },
        async fetchDefaultGroups({ commit }) {
            try {
                const data = await searchService.fetchDefaultGroups();
                commit('SET_DEFAULT_GROUPS_RESULTS', data);
            } catch (error) {
                console.error('Error fetching default groups:', error);
            }
        },
        async fetchDefaultMembers({ commit }) {
            try {
                const data = await searchService.fetchDefaultMembers();
                commit('SET_DEFAULT_MEMBERS_RESULTS', data);
            } catch (error) {
                console.error('Error fetching default members:', error);
            }
        }
    },
    getters: {
        isLoading(state) {
            return state.isLoading;
        },
        getError(state) {
            return state.error;
        }
    }
};

export default searchModule;
