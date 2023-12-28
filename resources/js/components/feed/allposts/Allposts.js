import "vue-skeletor/dist/vue-skeletor.css";
import { Skeletor } from "vue-skeletor";
import axios from "axios";

export default {
    components: {
        Skeletor,
    },
    props: {
        user: {
            type: Object
        },
    },
    data() {
        return {
            allPosts: [], // Placeholder for all posts data
            users: {}, // Placeholder for user data
            currentUser: {}, // Placeholder for the current user data
            newComment: '' // Placeholder for new comment text
        };
    },
    methods: {
        async getUserPosts() {
            try {
                const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
                console.log('CSRF Token:', csrfToken);

                const response = await axios.get('/api/userposts/all', {
                    withCredentials: true,
                    headers: {
                        'X-CSRF-TOKEN': csrfToken,
                    },
                });

                console.log('Response:', response.data);
                this.allPosts = response.data;
                this.allPosts.forEach(posts => {
                    this.fetchUserById(posts.user_id);
                });
            } catch (error) {
                console.error('Error fetching data:', error);
                // Handle error appropriately
            }
        },
        async fetchUserById(userId) {
            try {

                const response = await axios.get(`/userposts/users/${userId}`);
                // Update the users object with user data
                console.log('Response:', response.data);
                this.$set(this.users, userId, response.data);
            } catch (error) {
                console.error('Error fetching user data:', error);
                // Handle error appropriately
            }
        },
        getUserById(userId) {
            // Retrieve user data based on user_id
            return this.users[userId] || {};
        },
    },
    filters: {
        formatTime(value) {
            // Format time logic (e.g., using moment.js)
            return value; // Placeholder
        }
    },
    mounted() {
        this.getUserPosts();
    },
    // data() {
    //     return {
    //         allPosts: [], // Placeholder for all posts data
    //         currentUser: {}, // Placeholder for the current user data
    //         newComment: '' // Placeholder for new comment text
    //     };
    // },
    // mounted() {
    //     // Fetch all posts data from the "all" route
    //     axios.get('/userposts/all', { withCredentials: true })
    //         .then(response => {
    //             this.allPosts = response.data;
    //         })
    //         .catch(error => {
    //             console.error('Error fetching posts:', error);
    //         });

    //     // Mock current user data for demonstration
    //     this.currentUser = {
    //         id: 1,
    //         name: 'John Doe',
    //         avatar: 'https://example.com/avatar.jpg'
    //         // Add more properties as needed
    //     };
    // },
    // filters: {
    //     formatTime(value) {
    //         // Format time logic (e.g., using moment.js)
    //         return value; // Placeholder
    //     }
    // }
};
