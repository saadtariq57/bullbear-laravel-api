import watchlistService from '../services/watchlistService';
import Swal from 'sweetalert2';

const userWatchlistModule = {
    namespaced: true,
    state: () => ({
        isLoading: false,
        error: null,
        success: null,
        watchlists: undefined,
        searchedSymbols: [],
        editWatchlistData: [],
        selectedPrivacy: undefined,
        userHasWatchlist: null,
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
        SET_WATCHLISTS(state, watchlists){
            state.watchlists = watchlists;
        },
        SET_HAS_WATCHLIST(state, userHasWatchlist){
            state.userHasWatchlist = userHasWatchlist;
        },
        REMOVE_WATCHLIST(state, watchlistId) {
            state.watchlists = state.watchlists.filter(watchlist => watchlist.id !== watchlistId);
        },
        SET_SEARCHED_SYMBOL(state, searchedSymbols){
            state.searchedSymbols = searchedSymbols;
        },
        UPDATE_WATCHLIST_SYMBOLS(state, { watchlistId, symbols }) {
            const watchlistIndex = state.watchlists.findIndex(w => w.id === watchlistId);
            if (watchlistIndex !== -1) {
                state.watchlists[watchlistIndex].watchlist_symbols = symbols;
            }
        },
        SET_EDIT_WATCHLIST_DATA(state, editWatchlistData ){
            state.editWatchlistData = editWatchlistData;
        },
        SET_WATCHLIST_PRIVACY(state, selectedPrivacy){
            state.selectedPrivacy = selectedPrivacy;
        },
    },
    actions: {
        async getUserWatchlistData({ commit }, {userId, watchlistType}) {
            try {
                
                const data = await watchlistService.getUserWatchlistData(userId);
                commit('SET_HAS_WATCHLIST', data.hasUserWatchlist);
                commit('SET_WATCHLISTS', data.watchlistDetails);
                console.log('watchlist data: ', data);
                if(watchlistType !== 'manage'){
                    for (const watchlist of data.watchlistDetails) {
                        if (watchlist.watchlist_symbols.length >= 1) {
                            const symbolData = await watchlistService.getSymbols(watchlist.id);
                            console.log('symbol data: ', symbolData.watchlist_symbols);
                            
                            commit('UPDATE_WATCHLIST_SYMBOLS', {
                                watchlistId: watchlist.id,
                                symbols: symbolData.watchlist_symbols,
                            });
                        }
                    }
                }
            } catch (error) {
                console.error('Error fetching data:', error);
            }
        },
        async editWatchlist({ commit }, watchlistId){
            try{
                const data = await watchlistService.editWatchlist(watchlistId);
                commit('SET_EDIT_WATCHLIST_DATA', data);
                console.log('watchlist data', data);
            } catch (error) {
                console.error('Error editing watchlist:', error);
            }
        },
        async editWatchlistName({ commit }, {watchlistId, newWatchlistName}){
            try{
                const data = await watchlistService.editWatchlistName(watchlistId, newWatchlistName);
                // commit('SET_EDIT_WATCHLIST_DATA', data.title);
                console.log('watchlist updated name', data);
            } catch (error) {
                console.error('Error editing watchlist:', error);
            }
        },
        async searchSymbol({ commit }, {searchedSymbol}) {
            try{
                const data = await watchlistService.searchSymbols({searchedSymbol});
                if(data.length == 0){
                    commit('SET_SEARCHED_SYMBOL', '');
                    commit('SET_ERROR', 'No Symbol found');
                }else{
                    commit('SET_SEARCHED_SYMBOL', data);
                    commit('SET_ERROR', '');
                }
            } catch (error) {
                console.error('Error fetching symbols:', error);
            }
        },
        async addSymbolToWatchlist({ commit }, postData) {
            try{
                const data = await watchlistService.addWatchlistSymbol(postData);
                commit('SET_EDIT_WATCHLIST_DATA', data);
            } catch (error) {
                console.error('Error adding symbol to watchlist:', error);
            }
        },
        async deleteSymbolFromWatchlist({ commit }, {watchlistId, symbolId}) {
            try{
                const data = await watchlistService.deleteWatchlistSymbol(watchlistId, symbolId);
                commit('SET_EDIT_WATCHLIST_DATA', data);
                console.log('Symbol Deleted: ', data);
            } catch (error) {
                console.error('Error deleting symbol from watchlist:', error);
            }
        },
        async updateSymbolPosition({ commit }, {watchlistId, updatedPositions}) {
            try{
                const data = await watchlistService.symbolPosition(watchlistId, updatedPositions);
                console.log(data);
            } catch (error) {
                console.error('Error updating symbol position:', error);
            }
        },
        async deleteWatchlist({ commit }, watchlistId) {
            try{
                const data = await watchlistService.deleteWatchlist(watchlistId);
                commit('REMOVE_WATCHLIST', watchlistId);
                console.log('watchlist deleted', data);
            } catch (error) {
                console.error('Error deleting  watchlist:', error);
            }
        },
        async updateWatchlistPositions({ commit }, {updatedPositions}) {
            try{
                const data = await watchlistService.watchlistPosition(updatedPositions);
                console.log(data);
            } catch (error) {
                console.error('Error updating symbol position:', error);
            }
        },
        async watchlistPrivacy({ commit }, {watchlistId, selectedPrivacy}) {
            try{
                const data = await watchlistService.watchlistPrivacy(watchlistId, selectedPrivacy);
                commit('SET_WATCHLIST_PRIVACY', data.selectedPrivacy);
                console.log(data);
            } catch (error) {
                console.error('Error updating watchlist privacy:', error);
            }
        },
        async copyWatchlist({ commit }, postData) {
            commit('SET_LOADING', true);
            try {
                const data = await watchlistService.copyWatchlist(postData);
                if(data){
                    commit('SET_LOADING', false);
                    const Toast = Swal.mixin({
                        toast: true,
                        position: "top-end",
                        showConfirmButton: false,
                        width: "450px",
                        timer: 1000,
                        timerProgressBar: true,
                        didOpen: (toast) => {
                          toast.onmouseenter = Swal.stopTimer;
                          toast.onmouseleave = Swal.resumeTimer;
                        }
                      });
                      Toast.fire({
                        icon: "success",
                        title: "Watchlist copied successfully!"
                      });
                }
                // const updatedData = await watchlistService.getUserWatchlistData(data.original.user_id);
                // commit('SET_HAS_WATCHLIST', updatedData.hasUserWatchlist);
                // commit('SET_WATCHLISTS', updatedData.watchlistDetails);

                // const copiedWatchlist = updatedData.watchlistDetails.find(watchlist => watchlist.title === data.title);
                // if (copiedWatchlist) {
                //     commit('SET_LOADING', false);
                //     const symbolData = await watchlistService.getSymbols(copiedWatchlist.id);
                //     commit('UPDATE_WATCHLIST_SYMBOLS', {
                //         watchlistId: copiedWatchlist.id,
                //         symbols: symbolData.watchlist_symbols,
                //     });
                // }
            } catch (error) {
                console.error('Error copying watchlist:', error);
                const Toast = Swal.mixin({
                    toast: true,
                    position: "top-end",
                    showConfirmButton: false,
                    width: "400px",
                    timer: 1000,
                    timerProgressBar: true,
                    didOpen: (toast) => {
                      toast.onmouseenter = Swal.stopTimer;
                      toast.onmouseleave = Swal.resumeTimer;
                    }
                  });
                  Toast.fire({
                    icon: "error",
                    title: "Error copying watchlist"
                  });
            }
        } 
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

export default userWatchlistModule;
