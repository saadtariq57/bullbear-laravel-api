import btcImage from '../../../../images/brands/cryptocurrency_btc.png';
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
      btcImage: btcImage,
      watchlists: undefined,
    };
  },
  methods: {
    async getUserData() {
      try {
        const response = await axios.get('/api/watchlist/', {
          withCredentials: true, // Ensures cookies (like CSRF token) are sent with the request
          headers: {
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'), // Retrieves CSRF token from a meta tag
          },
        });
        this.watchlists = response.data;
      } catch (error) {
        console.error('Error fetching data:', error);
        // Handle error appropriately
      }
    },
  },
  mounted() {
    this.getUserData();
  },
};