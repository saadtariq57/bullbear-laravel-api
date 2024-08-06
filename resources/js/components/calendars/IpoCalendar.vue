<template>
     <div class="container my-4">
            <div class="row">
                <div class="col-lg-8">
                    <div class="mb-5 border-bottom">
                        <h1 class="fs-1 fw-bold icon-heading">Ipo Calendar</h1>
                    </div>
                    <div class="ipo">
                        <div class="calendar_tabels_wrapper">
                            <div class="all_calenders mb-5">
                                <ul class="list-unstyled d-flex" id="ecoCalTabsTop">
                                    <li class="economic_list">
                                        <a href="/economic-calendar/">Economic Calendar</a>
                                    </li>
                                    <li class="earnings_list">
                                        <a href="/earning-calendar">Earnings</a>
                                    </li>
                                    <li class="dividends_list">
                                        <a href="/dividend-calendar">Dividends</a>
                                    </li>
                                    <li class="splits_list">
                                        <a href="/splits-calendar">Splits</a>
                                    </li>
                                    <li class="ipo_list">
                                        <a href="/ipo-calendar">IPO</a>
                                    </li>
                                </ul>
                            </div>
                            <div class="calender_tabs">
                                <div class="filter_tabs d-flex justify-content-between align-items-center gap-2">
                                    <div class="day_filters">
                                      <ul class="nav nav-tabs gap-2" id="myTab" role="tablist">
                                          <li class="nav-item" role="presentation" v-for="tabName in tabNames" :key="tabName">
                                              <button class="nav-link btn btn-primary" 
                                                      :class="{ active: activeTab === tabName }" 
                                                      :id="`${tabName}-tab`" 
                                                      data-bs-toggle="tab" 
                                                      :data-bs-target="`#${tabName}_calendar_tab`" 
                                                      type="button" 
                                                      role="tab" 
                                                      :aria-controls="`${tabName}_calendar_tab`" 
                                                      :aria-selected="activeTab === tabName"
                                                      @click="setActiveTab(tabName)">
                                                  {{ getTabLabel(tabName) }}
                                              </button>
                                          </li>
                                      </ul>
                                    </div>
                                </div>
                                <div class="tab-content" id="myTabContent">
                                  <div v-for="tabName in tabNames" :key="tabName" 
                                      :class="['tab-pane fade', { 'show active': activeTab === tabName }]" 
                                      :id="`${tabName}_calendar_tab`" 
                                      role="tabpanel" 
                                      :aria-labelledby="`${tabName}-tab`" 
                                      tabindex="0">
                                      <div class="overflow-auto market-table-wapper">
                                          <table class="table table-width border">
                                              <thead>
                                                  <tr>
                                                      <th class="fw-6">Form</th>
                                                      <th class="text-start fw-6">Symbol</th>
                                                      <th class="text-end fw-6">IPO Value</th>
                                                      <th class="text-end fw-6">IPO Price</th>
                                                      <th class="text-end fw-6">PDF</th>
                                                  </tr>
                                              </thead>
                                              <tbody>
                                                  <template v-if="ipoEvents[tabName] && ipoEvents[tabName].length > 0">
                                                      <tr v-for="event in ipoEvents[tabName].slice(0, visibleRows[tabName])" :key="event.id">
                                                          <td class="text-start">{{ event.form }}</td>
                                                          <td class="text-start fw-5">{{ event.symbol }}</td>
                                                          <td class="text-end fw-5">{{event.price_public_total}}</td>
                                                          <td class="text-end fw-5">{{event.price_public_per_share}}</td>
                                                          <td class="text-end fw-5"><a :href="event.url" download="download"><i class="bi bi-download"></i></a></td>
                                                      </tr>
                                                  </template>
                                                  <tr v-else>
                                                      <td colspan="5" class="text-center">{{ loadedTabs.has(tabName) ? 'No data available' : 'Loading...' }}</td>
                                                  </tr>
                                              </tbody>
                                          </table>
                                          <div class="gap-3 d-flex align-items-center justify-content-center mt-3">
                                              <button v-if="ipoEvents[tabName] && ipoEvents[tabName].length > visibleRows[tabName]" 
                                                      class="btn btn-primary" 
                                                      @click="showMore(tabName)">
                                                  Show More
                                              </button>
                                              <button v-if="visibleRows[tabName] > initialRowCount" 
                                                      class="btn btn-border" 
                                                      @click="showLess(tabName)">
                                                  Show Less
                                              </button>
                                          </div>
                                      </div>
                                  </div>
                              </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4">
                <Markets />
                <LatestArticles />
            </div>
        </div>
    </div>
</template>
<script>
import axios from 'axios';
import Markets from '../widgets/Markets.vue';
import LatestArticles from '../widgets/LatestArticles.vue';

export default {
  components: {
    LatestArticles,
    Markets
  },
  data() {
    return {
      ipoEvents: {
        upcoming: [],
        recent: []
      },
      visibleRows: {
        upcoming: 50,
        recent: 50
      },
      activeTab: 'recent',
      tabNames: ['upcoming', 'recent'],
      loadedTabs: new Set(),
      initialRowCount: 50
    };
  },
  methods: {
    async fetchIpoCalendar(tabName) {
      if (this.loadedTabs.has(tabName)) return;
      
      const today = new Date();
      let startDate, endDate;
      
      if (tabName === 'upcoming') {
        startDate = today;
        endDate = new Date(today);
        endDate.setDate(today.getDate() + 30); // Fetch upcoming IPOs for the next 30 days
      } else { // recent
        startDate = new Date(today);
        startDate.setDate(today.getDate() - 30); // Fetch recent IPOs from the last 30 days
        endDate = today;
      }

      const formatDate = (date) => date.toISOString().split('T')[0];
      
      try {
        const response = await axios.get(`https://dev.stocks.richtv.io/api/ipo-calendar?startDate=${formatDate(startDate)}&endDate=${formatDate(endDate)}`);
        console.log(`Fetched IPO data for ${tabName}:`, response.data);
        this.ipoEvents[tabName] = response.data;
        this.loadedTabs.add(tabName);
      } catch (error) {
        console.error(`Error fetching IPO calendar for ${tabName}:`, error);
        this.ipoEvents[tabName] = [];
        this.loadedTabs.add(tabName);
      }
    },
    formatDate(dateString) {
      const options = { year: 'numeric', month: 'short', day: 'numeric' };
      return new Date(dateString).toLocaleDateString('en-US', options);
    },
    showMore(tab) {
      this.visibleRows[tab] = Math.min(this.visibleRows[tab] + this.initialRowCount, this.ipoEvents[tab].length);
    },
    showLess(tab) {
      this.visibleRows[tab] = Math.max(this.initialRowCount, this.visibleRows[tab] - this.initialRowCount);
    },
    setActiveTab(tabName) {
      this.activeTab = tabName;
      this.fetchIpoCalendar(tabName);
    },
    getTabLabel(tabName) {
      const labels = {
        upcoming: 'Upcoming',
        recent: 'Recent'
      };
      return labels[tabName] || tabName;
    }
  },
  mounted() {
    this.fetchIpoCalendar(this.activeTab);
  }
};
</script>