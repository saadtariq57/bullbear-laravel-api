import widgetsService from '../services/widgetsService';

const userWidgetsModule = {
    namespaced: true,
    state: () => ({
        isLoading: false,
        error: null,
        success: null,
        widget: undefined,
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
        SET_WIDGET(state, widget){
            state.widget = widget;
        },
        UPDATE_WIDGET_SYMBOLS(state, { widgetId, symbols }) {
            const widgetIndex = state.widget.findIndex(w => w.id === widgetId);
            if (widgetIndex !== -1) {
                state.widget[widgetIndex].symbols = symbols;
            }
        },
    },
    actions: {
        async getWidgetData({ commit }, widgetId) {
            commit('SET_LOADING', true);
            try {
                const data = await widgetsService.getWidgetData(widgetId);
                commit('SET_WIDGET', data.widgetDetails);
                console.log('widgetData: ', data);
                if(data){
                    // const symbolData = await widgetsService.getSymbols(widgetId);
                    // console.log('the symbol data: ', symbolData);
                    for (const widget of data.widgetDetails) {
                        if (widget.symbols.length >= 1) {
                            const symbolData = await widgetsService.getSymbols(widgetId);
                            console.log('symbol data: ', symbolData);
                            
                            // commit('UPDATE_WIDGET_SYMBOLS', {
                            //     widgetId: widgetId,
                            //     symbols: symbolData.symbols,
                            // });
                        }
                    }
                    commit('SET_LOADING', false);
                }
            } catch (error) {
                console.error('Error fetching widget data:', error);
            }
        },
        // async copyWatchlist({ commit }, postData) {
        //     commit('SET_LOADING', true);
        //     try {
        //         const data = await widgetsService.copyWatchlist(postData);
        //         if(data){
        //             commit('SET_LOADING', false);
        //         }
        //     } catch (error) {
        //         console.error('Error copying watchlist:', error);
        //     }
        // } 
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

export default userWidgetsModule;
