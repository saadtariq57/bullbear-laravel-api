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
                const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
                
                const response = await axios.get('/api/userdata', { // Update this line
                    withCredentials: true,
                    headers: {
                        'X-CSRF-TOKEN': csrfToken,
                    },
                });

                this.userData = response.data;
            } catch (error) {
                console.error('Error fetching user data:', error);
            }
        },
    },
};