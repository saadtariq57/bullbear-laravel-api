const searchService = {
    async searchSymbols(searchQuery) {
        try {
            const response = await axios.get('/api/symbol/search?query=' + searchQuery);
            return response.data;
            
        } catch (error) {
            console.error('Error searching data:', error);
        }
        this.groupsError = '';
    },
    async searchGroups(searchQuery) {
        try {
            const response = await axios.get('/api/searchGroups?query=' + searchQuery);
            return response.data;
            
        } catch (error) {
            console.error('Error searching data:', error);
        }
        this.groupsError = '';
    },
    async searchMembers(searchQuery) {
        try {
            const response = await axios.get('/api/searchMembers?query=' + searchQuery);
            return response.data;
            
        } catch (error) {
            console.error('Error searching data:', error);
        }
        this.groupsError = '';
    },
    
};

export default searchService;
