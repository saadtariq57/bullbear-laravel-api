import "vue-skeletor/dist/vue-skeletor.css";
import { Skeletor } from "vue-skeletor";
import axios from "axios";

export default {
  components: {
    Skeletor,
  },
  methods: {
    searchTags() {
      this.initValues();
      if (this.search) {
        axios.get('/api/symbol/search?query=' + this.search).then(response => {
          this.symbols = response.data;
          this.error = this.symbols.length == 0 ? 'No symbols found against this search' : '';
        }).catch(error => {
          this.error = 'Error while fetching symbols';
          console.log(error)
        });
      }
    },
    addWatchlistSymbol(symbolId) {
      let postData = {
        user_id: this.watchlist.user_id,
        watchlist_id: this.watchlist.id,
        symbol_id: symbolId
      }
        axios.post('/api/watchlist/symbol', postData).then(response => {
          if(response.data){
            this.watchlistData = response.data;
            this.search = '';
          }
        }).catch(error => {
          this.error = 'Error while adding symbol';
          console.log(error)
        });
    },
    deleteWatchlistSymbol(id) {
        axios.delete(`/api/watchlist/symbol?id=${id}&watchlist_id=${this.watchlist.id}`).then(response => {
          if(response.data){
            this.watchlistData = response.data;
          }
        }).catch(error => {
          this.error = 'Error while deleting symbol';
          console.log(error)
        });
    },
    initValues() {
      this.error = '';
      this.symbols = [];
    }
  },
  mounted() {
    this.initValues();
    this.watchlistData = JSON.parse(JSON.stringify(this.watchlist));
  },
  data() {
    return {
      watchlistData: Object,
      error: '',
      search: '',
      symbols: []
    };
  },
  props: {
    watchlist: {
      type: Object, // Adjust the type based on your data structure
      required: true,
    },
  },
};