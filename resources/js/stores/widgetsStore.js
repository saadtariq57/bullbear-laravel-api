import { all } from 'axios';
import widgetsService from '../services/widgetsService';

const userWidgetsModule = {
    namespaced: true,
    state: () => ({
        isLoading: false,
        error: null,
        success: null,
        widgets: [],
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
        SET_WIDGETS(state, widgets) {
            state.widgets = widgets;
        },
        UPDATE_WIDGET_SYMBOL_QUOTES(state, { widgetId, quotes }) {
            const widget = state.widgets.find(w => w.id === widgetId);
            if (widget) {
                Object.keys(widget.symbols).forEach(symbolKey => {
                    const symbolData = widget.symbols[symbolKey];
                    if (quotes[symbolData.symbol_id]) {
                        symbolData.stats = quotes[symbolData.symbol_id];
                    }
                });
            }
        },
    },
    actions: {
        async getWidgetsByCategory({ commit, dispatch }, { category, subCategory }) {
            commit('SET_LOADING', true);
            commit('SET_ERROR', null);
            try {
                const widgets = await widgetsService.getWidgetsByCategory({ category, subCategory });
                console.log(widgets);
                commit('SET_WIDGETS', widgets);
                // Fetch Quotes
                const allSymbolIds = widgets.flatMap(widget => Object.values(widget.symbols).map(symbol => symbol.symbol_id));
                if (allSymbolIds.length > 0) {
                    const quotes = await widgetsService.getQuotes(allSymbolIds);
                    widgets.forEach(widget => {
                        dispatch('updateWidgetSymbolQuotes', { widgetId: widget.id, quotes });
                    });
                }
                commit('SET_LOADING', false);
            } catch (error) {
                commit('SET_ERROR', error.message);
                commit('SET_LOADING', false);
            }
        },
        async updateWidgetSymbolQuotes({ commit }, { widgetId, quotes }) {
            commit('UPDATE_WIDGET_SYMBOL_QUOTES', { widgetId, quotes });
        },
    },
    getters: {
        isLoading(state) {
            return state.isLoading;
        },
        getError(state) {
            return state.error;
        },
        widgets(state) {
            return state.widgets;
        }
    }
};

export default userWidgetsModule;