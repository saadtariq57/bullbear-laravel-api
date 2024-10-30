<template>
  <div class="container my-4">
    <div class="row">
      <div class="col-lg-8">
        <div class="mb-5 border-bottom">
          <h1 class="fs-1 fw-bold icon-heading">IPO Calendar</h1>
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
                <div class="ipo-type-filter">
                  <select v-model="selectedIpoType" @change="filterIpoEvents">
                    <option value="all">All</option>
                    <option value="confirmed">Confirmed</option>
                    <option value="prospectus">Prospectus</option>
                  </select>
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
                            <th class="fw-6">Filing Date</th>
                            <th class="text-start fw-6">Company</th>
                            <th class="text-start fw-6">Symbol</th>
                            <th class="text-end fw-6">Form</th>
                            <th class="text-end fw-6">IPO Type</th>
                            <th class="text-end fw-6">IPO Value</th>
                            <th class="text-end fw-6">IPO Price</th>
                            <th class="text-end fw-6">PDF</th>
                          </tr>
                        </thead>
                        <tbody>
                          <template v-if="filteredIpoEvents[tabName] && filteredIpoEvents[tabName].length > 0">
                            <tr v-for="event in filteredIpoEvents[tabName].slice(0, visibleRows[tabName])" :key="event.id">
                              <td class="text-start">{{ formatDate(event.filing_date) }}</td>
                              <td class="text-start fw-5">{{ event.name || 'N/A' }}</td>
                              <td class="text-start fw-5">
                                <a v-if="event.symbol" :href="`/quotes/${event.symbol}`">{{ event.symbol }}</a>
                                <span v-else>N/A</span>
                              </td>
                              <td class="text-end fw-5">{{ event.form }}</td>
                              <td class="text-end fw-5">{{ capitalizeFirstLetter(event.ipo_type) }}</td>
                              <td class="text-end fw-5">{{ formatCurrency(event.price_public_total) }}</td>
                              <td class="text-end fw-5">{{ formatCurrency(event.price_public_per_share) }}</td>
                              <td class="text-end fw-5">
                                <a :href="event.url" target="_blank" rel="noopener noreferrer">
                                  <i class="bi bi-file-earmark-pdf"></i>
                                </a>
                              </td>
                            </tr>
                          </template>
                          <tr v-else>
                            <td colspan="8" class="text-center">{{ loadedTabs.has(tabName) ? 'No data available' : 'Loading...' }}</td>
                          </tr>
                        </tbody>
                      </table>
                      <div class="gap-3 d-flex align-items-center justify-content-center mt-3">
                        <button v-if="filteredIpoEvents[tabName] && filteredIpoEvents[tabName].length > visibleRows[tabName]" 
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
        <SidebarCalendars v-if="this.contentLoaded"/>
      </div>
    </div>
  </div>
</template>

<script>
import axios from 'axios';
import SidebarCalendars from './SidebarCalendars.vue';

export default {
  components: {
    SidebarCalendars
  },
  data() {
    return {
      ipoEvents: {
        upcoming: [],
        recent: []
      },
      filteredIpoEvents: {
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
      initialRowCount: 50,
      selectedIpoType: 'all',
      contentLoaded = false;
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
        endDate.setDate(today.getDate() + 30);
      } else {
        startDate = new Date(today);
        startDate.setDate(today.getDate() - 30);
        endDate = today;
      }

      const formatDate = (date) => date.toISOString().split('T')[0];
      
      try {
        const response = await axios.get(`/api/calendar/ipo?startDate=${formatDate(startDate)}&endDate=${formatDate(endDate)}`);
        this.ipoEvents[tabName] = response.data;
        this.filterIpoEvents();
        this.loadedTabs.add(tabName);
      } catch (error) {
        console.error(`Error fetching IPO calendar for ${tabName}:`, error);
        this.ipoEvents[tabName] = [];
        this.filteredIpoEvents[tabName] = [];
        this.loadedTabs.add(tabName);
      }
    },
    formatDate(dateString) {
      const options = { year: 'numeric', month: 'short', day: 'numeric' };
      return new Date(dateString).toLocaleDateString('en-US', options);
    },
    formatCurrency(value) {
      if (!value) return 'N/A';
      return new Intl.NumberFormat('en-US', { style: 'currency', currency: 'USD' }).format(value);
    },
    capitalizeFirstLetter(string) {
      return string.charAt(0).toUpperCase() + string.slice(1);
    },
    showMore(tab) {
      this.visibleRows[tab] = Math.min(this.visibleRows[tab] + this.initialRowCount, this.filteredIpoEvents[tab].length);
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
    },
    filterIpoEvents() {
      for (const tabName of this.tabNames) {
        if (this.selectedIpoType === 'all') {
          this.filteredIpoEvents[tabName] = this.ipoEvents[tabName];
        } else {
          this.filteredIpoEvents[tabName] = this.ipoEvents[tabName].filter(event => event.ipo_type === this.selectedIpoType);
        }
      }
    }
  },
  mounted() {
    this.fetchIpoCalendar(this.activeTab);
    this.contentLoaded = true;
  }
};
</script>