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
    async fetchDefaultSymbols() {
        try {
            const response = await axios.get('/api/searchSymbol/default');
            return response.data;
        } catch (error) {
            console.error('Error fetching default symbols:', error);
        }
    },
    async fetchDefaultGroups() {
        try {
            const response = await axios.get('/api/searchGroups/default');
            return response.data;
        } catch (error) {
            console.error('Error fetching default groups:', error);
        }
    },
    async fetchDefaultMembers() {
        try {
            const response = await axios.get('/api/searchMembers/default');
            return response.data;
        } catch (error) {
            console.error('Error fetching default members:', error);
        }
    },

};

export default searchService;
