const widgetsService = {
    async getWidgetsByCategory({ category, subCategory }) {
        try {
            const response = await axios.get('/api/getWidget', {
                params: { category, subCategory },
            });
            return response.data;
        } catch (error) {
            console.error('Error getting widgets by category:', error);
            // Always return an array so callers can safely iterate / check length
            return [];
        }
    },
    async getQuotes(widgetId) {
        try {
            const response = await axios.get(`/api/widget/${widgetId}`);
            return response.data;
        } catch (error) {
            console.error(`Error fetching quotes for widget ${widgetId}:`, error);
        }
    },
};

export default widgetsService;