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
  methods: {
    getUserData() {
      axios.get('/api/watchlist').then(response => {
        this.watchlists = response.data;
      });
    },
  },
  mounted() {
    this.getUserData();
  },
  data() {
    return {
      btcImage: btcImage,
      watchlists: undefined
    };
  },
};