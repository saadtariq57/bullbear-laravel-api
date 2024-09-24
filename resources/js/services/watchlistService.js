const watchlistService = {
    async getUserWatchlistData(userId) {
        try {
            const response = await axios.get(`/api/watchlist/?user_id=${userId}`);
            return response.data;
        } catch (error) {
            console.error('Error fetching watchlist data:', error);
        }
    },
    async getFeaturedWatchlists() {
        try {
            const response = await axios.get('/api/watchlist/featured');
            return response.data;
        } catch (error) {
            console.error('Error fetching featured watchlists:', error);
        }
    },
    async getSymbols(watchlistId) {
        try {

            const response = await axios.get(`/api/watchlist/symbols/${watchlistId}`);
            return response.data;
        } catch (error) {
            console.error('Error fetching watchlist symbols:', error);
        }
    },
    async searchSymbols({searchedSymbol}) {
        try{
            const response = await axios.get('/api/symbol/search?query=' + searchedSymbol);
            return response.data;
        } catch (error) {
            console.error('Error fetching searched symbols:', error);
        }
    },
    async addWatchlistSymbol(postData) {
        try{
            const response = await axios.post('/api/watchlist/symbol', postData);
            return response.data;
        } catch (error) {
            console.error('Error adding symbol to watchlist:', error);
        }
    },
    async editWatchlist(watchlistId) {
        try{
            const response = await axios.get(`/api/watchlist/editWatchlistData/${watchlistId}`);
            return response.data;
        } catch (error) {
            console.error('Error adding symbol to watchlist:', error);
        }
    },
    async editWatchlistName(watchlistId, newWatchlistName) {
        try{
            const response = await axios.put(`/api/watchlist/update/${watchlistId}`, { title: newWatchlistName });
            return response.data;
        } catch (error) {
            console.error('Error adding symbol to watchlist:', error);
        }
    },
    async deleteWatchlistSymbol(watchlistId, symbolId) {
        try{
            const response = await axios.delete(`/api/watchlist/symbol?id=${symbolId}&watchlist_id=${watchlistId}`);
            return response.data;
        } catch (error) {
            console.error('Error deleting symbol from watchlist:', error);
        }
    },
    async symbolPosition(watchlistId, updatedPositions) {
        try{
            const response = await axios.put(`/api/watchlist/update/${watchlistId}`, { symbol_positions: updatedPositions});
            return response.data;
        } catch (error) {
            console.error('Error updating symbol position:', error);
        }
    },
    async deleteWatchlist(watchlistId) {
        try{
            const response = await axios.delete(`/api/watchlist/deletewatchlist?id=${watchlistId}`);
            return response.data;
        } catch (error) {
            console.error('Error deleting watchlist:', error);
        }
    },
    async watchlistPosition(updatedPositions) {
        try{
            const response = await axios.put(`/api/watchlist/update-positions`, { positions: updatedPositions});
            return response.data;
        } catch (error) {
            console.error('Error updating symbol position:', error);
        }
    },
    async watchlistPrivacy(watchlistId, selectedPrivacy) {
        try{
            const response = await axios.put(`/api/watchlist/update-privacy`, { watchlist_id: watchlistId, privacy_option: selectedPrivacy});
            return response.data;
        } catch (error) {
            console.error('Error updating watchlist Privacy:', error);
        }
    },
    async copyWatchlist(postData) {
        try{
            const response = await axios.post('/api/watchlist/copyWatchlist', postData);
            return response.data;
        } catch (error) {
            console.error('Error adding symbol to watchlist:', error);
        }
    },
    
};

export default watchlistService;
