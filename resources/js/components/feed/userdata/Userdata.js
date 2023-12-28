// Userdata.js
import axios from "axios";
export default {
    data() {
        return {
            userData: null,
        };
    },
    created() {
        this.fetchUserData();
    },
    methods: {
        async fetchUserData() {
            try {
                const response = await axios.get('/api/user-data'); // Make sure the URL matches your route
                this.userData = response.data;
            } catch (error) {
                console.error('Error fetching user data:', error);
            }
        },
    },
};
