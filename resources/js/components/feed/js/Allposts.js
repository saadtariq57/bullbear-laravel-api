import axios from "axios";
import Postcomments from '../Postcomments.vue';
export default {
    data() {
        return {
            allPosts: [], // Stores all posts
            csrfToken: '', // CSRF token for API requests
        };
    },
    methods: {
        // Fetch all posts of the user
        async fetchUserPosts() {
            try {
                const response = await axios.get('/api/userposts/all', {
                    headers: {
                        'X-CSRF-TOKEN': this.csrfToken,
                        'Accept': 'application/json'
                    },
                    withCredentials: true,
                });

                this.allPosts = response.data;
            } catch (error) {
                console.error('Error fetching posts:', error);
                // Handle the error appropriately
            }
        },

        // Method to format the date/time (optional, implement as needed)
        formatDateTime(dateTime) {
            // Implement your date/time formatting logic here
            return dateTime;
        },
    },
    mounted() {
        // Get the CSRF token from the meta tag
        this.csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

        // Fetch posts when the component is mounted
        this.fetchUserPosts();
    }
};