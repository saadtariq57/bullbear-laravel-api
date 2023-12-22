import "vue-skeletor/dist/vue-skeletor.css";
import { Skeletor } from "vue-skeletor";
import axios from "axios";
import Confirm from '../../shared/confirm.vue';

export default {
  components: {
    Skeletor,
    Confirm
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
    },
    openModal(item) {
      this.modalData = { id: item.id, modalId: 'delete-symbol', title: item.symbol.name, body: `Are you sure you want to delete symbol : ${item.symbol.name}?` },
      this.isModalOpen = true
    },
    handleActionFromModal(response) {
      if(response.type == 'confirm'){
        this.deleteWatchlistSymbol(response.id);
      }
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
      symbols: [],
      isModalOpen: false,
      modalData: undefined
    };
  },
  props: {
    watchlist: {
      type: Object, // Adjust the type based on your data structure
      required: true,
    },
  },
};