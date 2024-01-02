import btcImage from '../../../../images/brands/cryptocurrency_btc.png';
import "vue-skeletor/dist/vue-skeletor.css";
import { Skeletor } from "vue-skeletor";
import axios from "axios";
import DataTable from 'datatables.net-vue3';
import DataTablesCore from 'datatables.net';
import 'datatables.net-dt/css/jquery.dataTables.css';
 
DataTable.use(DataTablesCore);

export default {
  components: {
    Skeletor,
    DataTable,
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
      selectedWatchlist: null,
      watchlist_symbols: null,
    };
  },
  methods: {
    async getUserData() {
      try {
        const response = await axios.get('/api/watchlist/', {
          withCredentials: true,
          headers: {
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
          },
        });
        this.watchlists = response.data;
        // this.selectedWatchlist = this.watchlists[0];
        console.log(this.watchlists = response.data);
        for (const watchlist of this.watchlists) {
          if (watchlist.watchlist_symbols.length >= 1) {
            await this.getSymbols(watchlist.id);
          }
          
        }
        
      } catch (error) {
        console.error('Error fetching data:', error);
        // Handle error appropriately
      }
    },
    async getSymbols(watchlistId) {
      try {
       
        const symbolsResponse = await axios.get(`/api/watchlist/symbols/${watchlistId}`, {
          withCredentials: true,
          headers: {
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
          },
        });
        
        const watchlistIndex = this.watchlists.findIndex(w => w.id === watchlistId);
        
        this.watchlists[watchlistIndex] = {
          ...this.watchlists[watchlistIndex],
          watchlist_symbols: symbolsResponse.data.watchlist_symbols,
        };

        console.log('Symbols:', symbolsResponse.data);
      } catch (error) {
        console.error('Error fetching symbols:', error);
      }
    },
    
    calculateCaretPosition(symbolData) {
      const low = parseFloat(symbolData.symbol.stats.fiftyTwoWeekLow);
      const high = parseFloat(symbolData.symbol.stats.fiftyTwoWeekHigh);
      const currentValue = parseFloat(symbolData.symbol.stats.regularMarketPrice);
      const positionPercentage = ((currentValue - low) / (high - low)) * 100;
      return `${positionPercentage - 3}%`;
    },
    selectWatchlist(watchlist) {
      this.selectedWatchlist = watchlist;
      if(this.selectedWatchlist!=null){
        const tab = new bootstrap.Tab(document.getElementById('content-tab'));
        tab.show();
        
      }else{
        const tab = new bootstrap.Tab(document.getElementById('dashboard-tab-pane'));
        tab.show();
      }
    },
    backgroundChangeClasses(symbolData) {
      const percentChange = symbolData.symbol.stats.regularMarketChangePercent;
      const marketChange = symbolData.symbol.stats.regularMarketChange;
      const extraClasses = 'position-relative badge rounded-0 w-100 text-end fs-14 pt-2';
      if (percentChange > 0 && marketChange > 0) {
        return ' positive-symbol bg-success '+extraClasses;
      } else {
        return ' negative-symbol bg-danger '+extraClasses;
      }
    },
    textChangeClasses(symbolData) {
      const percentChange = symbolData.symbol.stats.regularMarketChangePercent;
      const marketChange = symbolData.symbol.stats.regularMarketChange;
      const extraClasses = 'd-flex gap-3 justify-content-end';
      if (percentChange > 0 && marketChange > 0) {
        return ' Green '+extraClasses;
      } else {
        return ' Red '+extraClasses;
      }
    },
  },
  mounted() {
    this.getUserData();
  },
};