const widgetsService = {
    async getWidgetData(widgetId) {
        try{
            const response = await axios.get(`/api/getWidget?widgetId=${widgetId}`);
            return response.data;
        } catch (error) {
            console.error('Error getting widget data:', error);
        }
    },
    async getSymbols(widgetId) {
        try {

            const response = await axios.get(`/api/widgetsymbols/${widgetId}`);
            return response.data;
        } catch (error) {
            console.error('Error fetching watchlist symbols:', error);
        }
    },
    // async copyAsWatchlist(postData) {
    //     try{
    //         const response = await axios.post('/api/watchlist/copyWatchlist', postData);
    //         return response.data;
    //     } catch (error) {
    //         console.error('Error adding symbol to watchlist:', error);
    //     }
    // },
    
};

export default widgetsService;
