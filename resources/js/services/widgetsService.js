const widgetsService = {
    async getWidgetsByCategory({ category, subCategory }) {
        try {
            const response = await axios.get('/api/getWidget', {
                params: { category, subCategory },
            });
            return response.data;
        } catch (error) {
            console.error('Error getting widgets by category:', error);
        }
    },
    async getQuotes(symbolIds) {
        try {
            const response = await axios.get(`http://localhost:3000/api/quotes`, {
                params: { ids: symbolIds.join(',') }
            });
            return response.data;
        } catch (error) {
            console.error('Error fetching quotes:', error);
        }
    },
};

export default widgetsService;