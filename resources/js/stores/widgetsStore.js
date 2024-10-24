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
                widget.symbols.forEach(widgetSymbol => {
                    const quote = quotes.symbols.find(q => q.id === widgetSymbol.symbol_id);
                    if (quote) {
                        widgetSymbol.price = quote.price;
                        widgetSymbol.change = quote.change;
                        widgetSymbol.change_percent = quote.change_percent;
                        widgetSymbol.volume = quote.volume;
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
                commit('SET_WIDGETS', widgets);
                for (const widget of widgets) {
                    try {
                        const quotes = await widgetsService.getQuotes([widget.id]);
                        dispatch('updateWidgetSymbolQuotes', { widgetId: widget.id, quotes });
                    } catch (quoteError) {
                        console.error(`Error fetching quotes for widget ${widget.id}:`, quoteError);
                    }
                }

                commit('SET_LOADING', false);
            } catch (error) {
                commit('SET_ERROR', error.message);
                commit('SET_LOADING', false);
            }
        },
        async updateWidgetSymbolQuotes({ state, commit }, { widgetId, quotes }) {
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