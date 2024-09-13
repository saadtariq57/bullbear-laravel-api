<template>
    <div class="container my-4">
        <div class="row">
            <div class="col-lg-8">
                <div class="mb-5">
                    <h1 class="fs-1 fw-bold icon-heading">Economic Calendar</h1>
                </div>
                <div class="economic">
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
                                            <button class="nav-link nav-link btn btn-primary" 
                                                    :class="{ active: activeTab === tabName }" 
                                                    :id="`${tabName}-tab`" 
                                                    data-bs-toggle="tab" 
                                                    :data-bs-target="`#${tabName}_calendar_tab`" 
                                                    type="button" 
                                                    role="tab" 
                                                    :aria-controls="`${tabName}_calendar_tab`" 
                                                    :aria-selected="activeTab === tabName"
                                                    @click="setActiveTab(tabName)">
                                                {{ tabName.charAt(0).toUpperCase() + tabName.slice(1) }}
                                            </button>
                                        </li>
                                    </ul>
                                </div>
                                <div class="other_filters">
                                  <a href="javascript:void(0);" @click="toggleFilters">
                                    <i class="bi bi-sliders2"></i> Filters 
                                  </a>
                                </div>
                            </div>
                            <div class="collapse" id="collapseFilters">
                                <div class="card card-body">
                                    <div class="category_filter mb-4">
                                        <div class="filterList_label">
                                            <p class="fw-bold mb-1">Countries:</p>
                                            <a href="javascript:void(0);" class="" @click="selectAllCountries">Select All</a><br>
                                            <a href="javascript:void(0);" @click="clearAllCountries" class="">Clear</a>
                                        </div>
                                        <div class="w-100">
                                            <ul class="filterList">
                                                <li v-for="country in topCountries" :key="country.code">
                                                    <input :id="'country-' + country.code" name="country[]" type="checkbox" :value="country.code" v-model="selectedCountries">
                                                    <label :for="'country-' + country.code">{{ country.name }}</label>
                                                </li>
                                            </ul>
                                        </div>
                                    </div>
                                    <div class="category_filter mb-4">
                                        <div class="filterList_label">
                                            <p class="fw-bold mb-1">Importance:</p>
                                        </div>
                                        <div class="w-100">
                                            <ul class="filterList">
                                              <li v-for="level in [1, 2, 3]" :key="level">
                                                <input :id="'importance' + level" name="importance[]" type="checkbox" :value="level" v-model="selectedImportance">
                                                <label :for="'importance' + level">
                                                  <span class="sentiment d-flex gap-1 justify-content-end">
                                                    <i v-for="n in level" :key="n" class="bi bi-star-fill"></i>
                                                    <i v-for="n in 3 - level" :key="n + 3" class="bi bi-star"></i>
                                                  </span>
                                                </label>
                                              </li>
                                            </ul>
                                        </div>
                                    </div>
                                    <div class="apply_filter d-flex gap-sm-3 justify-content-end">
                                        <a href="javascript:void(0);" @click="applyFilters" class="btn btn-primary">Apply</a>
                                        <a href="javascript:void(0);" @click="restoreDefaultSettings" class="restore btn"><i class="bi bi-arrow-clockwise"></i> Restore Default Settings</a>
                                    </div>
                                </div>
                            </div>
                            <div class="">
                                    <p class="m-0 fs-6 text-center py-2 border-top border-bottom">All data are streaming and updated automatically.</p>
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
                                                    <th class="fw-6">Time</th>
                                                    <th class="text-end fw-6">Cur.</th>
                                                    <th class="text-end fw-6">Imp.</th>
                                                    <th class="text-end fw-6">Event</th>
                                                    <th class="text-end fw-6">Actual</th>
                                                    <th class="text-end fw-6">Forecast</th>
                                                    <th class="text-end fw-6">Previous</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <template v-if="allEvents[tabName] && allEvents[tabName].length > 0">
                                                    <template v-for="(event, index) in allEvents[tabName].slice(0, visibleRows[tabName])" :key="event.id">
                                                        <tr v-if="index === 0 || event.event_date !== allEvents[tabName][index - 1].event_date" class="crunt_date">
                                                            <td colspan="7" class="text-center">{{ formatDate(event.event_date) }}</td>
                                                        </tr>
                                                        <tr>
                                                            <td class="fw-5">{{ formatTime(event.event_time) }}</td>
                                                            <td class="text-end fw-5">
                                                                <span class="flagCur d-flex gap-1 align-items-center justify-content-end">
                                                                    <span class="ceFlags" :class="event.country ? event.country : 'default_country'"></span>
                                                                    <span class="currency">{{ event.currency }}</span> 
                                                                </span>
                                                            </td>
                                                            <td class="text-end fw-5">
                                                                <span class="sentiment d-flex gap-1 justify-content-end">
                                                                    <i v-for="n in getImportanceLevel(event.importance)" :key="n" class="bi bi-star-fill"></i>
                                                                    <i v-for="n in 3 - getImportanceLevel(event.importance)" :key="n + 3" class="bi bi-star"></i>
                                                                </span>
                                                            </td>
                                                            <td class="text-end fw-5">{{ event.event_name }}</td>
                                                            <td class="text-end fw-5" :class="getValueClass(event.actual, event.forecast)">
                                                                {{ formatValue(event.actual, event.unit) }}
                                                            </td>
                                                            <td class="text-end fw-5">{{ formatValue(event.forecast, event.unit) }}</td>
                                                            <td class="text-end fw-5">{{ formatValue(event.previous, event.unit) }}</td>
                                                        </tr>
                                                    </template>
                                                </template>
                                                <tr v-else>
                                                    <td colspan="7" class="text-center">{{ loadedTabs.has(tabName) ? 'No data available' : 'Loading...' }}</td>
                                                </tr>
                                            </tbody>
                                        </table>
                                        <div class="text-center">
                                            <button v-if="allEvents[tabName] && allEvents[tabName].length > visibleRows[tabName]" 
                                                    class="btn btn-primary" 
                                                    @click="toggleShowMore(tabName)">
                                                {{ showMore[tabName] ? 'Show Less' : 'Show More' }}
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
import Markets from "../widgets/Markets.vue";
import LatestArticles from "../widgets/LatestArticles.vue";

export default {
  components: {
    LatestArticles,
    Markets,
  },
  data() {
    return {
        selectedImportance: [1, 2, 3],
        topCountries: [
          { code: 'US', name: 'United States', selected: true },
          { code: 'CN', name: 'China', selected: true },
          { code: 'JP', name: 'Japan', selected: true },
          { code: 'DE', name: 'Germany', selected: true },
          { code: 'UK', name: 'United Kingdom', selected: true },
          { code: 'FR', name: 'France', selected: true },
          { code: 'IN', name: 'India', selected: true },
          { code: 'IT', name: 'Italy', selected: true },
          { code: 'BR', name: 'Brazil', selected: true },
          { code: 'CA', name: 'Canada', selected: true },
          { code: 'RU', name: 'Russia', selected: false },
          { code: 'KR', name: 'South Korea', selected: false },
          { code: 'AU', name: 'Australia', selected: false },
          { code: 'ES', name: 'Spain', selected: false },
          { code: 'MX', name: 'Mexico', selected: false },
          { code: 'ID', name: 'Indonesia', selected: false },
          { code: 'NL', name: 'Netherlands', selected: false },
          { code: 'SA', name: 'Saudi Arabia', selected: false },
          { code: 'TR', name: 'Turkey', selected: false },
          { code: 'CH', name: 'Switzerland', selected: false },
          { code: 'PL', name: 'Poland', selected: false },
          { code: 'SE', name: 'Sweden', selected: false },
          { code: 'BE', name: 'Belgium', selected: false },
          { code: 'TH', name: 'Thailand', selected: false },
          { code: 'AT', name: 'Austria', selected: false },
          { code: 'NO', name: 'Norway', selected: false },
          { code: 'AE', name: 'United Arab Emirates', selected: false },
          { code: 'IR', name: 'Iran', selected: false },
          { code: 'NG', name: 'Nigeria', selected: false },
          { code: 'ZA', name: 'South Africa', selected: false },
          { code: 'MY', name: 'Malaysia', selected: false },
          { code: 'SG', name: 'Singapore', selected: false },
          { code: 'PH', name: 'Philippines', selected: false },
          { code: 'DK', name: 'Denmark', selected: false },
          { code: 'HK', name: 'Hong Kong', selected: false },
          { code: 'IE', name: 'Ireland', selected: false },
          { code: 'FI', name: 'Finland', selected: false },
          { code: 'PT', name: 'Portugal', selected: false },
          { code: 'CL', name: 'Chile', selected: false },
          { code: 'CO', name: 'Colombia', selected: false },
          { code: 'RO', name: 'Romania', selected: false },
          { code: 'CZ', name: 'Czech Republic', selected: false },
          { code: 'NZ', name: 'New Zealand', selected: false },
          { code: 'VN', name: 'Vietnam', selected: false },
          { code: 'GR', name: 'Greece', selected: false },
          { code: 'IL', name: 'Israel', selected: false },
          { code: 'EG', name: 'Egypt', selected: false },
          { code: 'PK', name: 'Pakistan', selected: false },
          { code: 'HU', name: 'Hungary', selected: false },
        ],
      selectedCountries: ['US', 'CN', 'JP', 'DE', 'UK', 'FR', 'IN', 'IT', 'BR', 'CA'],
      originalEvents: {
          yesterday: [],
          today: [],
          tomorrow: [],
          thisWeek: [],
          nextWeek: []
      },
      allEvents: {
        yesterday: [],
        today: [],
        tomorrow: [],
        thisWeek: [],
        nextWeek: []
      },
      showMore: {
        yesterday: false,
        today: false,
        tomorrow: false,
        thisWeek: false,
        nextWeek: false
      },
      visibleRows: {
        yesterday: 50,
        today: 50,
        tomorrow: 50,
        thisWeek: 50,
        nextWeek: 50
      },
      activeTab: 'today',
      tabNames: ['yesterday', 'today', 'tomorrow', 'thisWeek', 'nextWeek'],
      loadedTabs: new Set()
    };
  },
  methods: {
    formatDate(dateString) {
      const options = { weekday: 'long', year: 'numeric', month: 'long', day: 'numeric' };
      return new Date(dateString).toLocaleDateString('en-US', options);
    },
    formatTime(timeString) {
      return new Date(`1970-01-01T${timeString}Z`).toLocaleTimeString('en-US', { hour: '2-digit', minute: '2-digit' });
    },
    formatValue(value, unit) {
      if (value === null || value === undefined) return '-';
      return `${value}${unit ? ' ' + unit : ''}`;
    },
    selectAllCountries() {
      this.selectedCountries = this.topCountries.map(country => country.code);
    },
    clearAllCountries() {
      this.selectedCountries = [];
    },
    async fetchEconomicCalendar(startDate, endDate, targetArray) {
      if (this.loadedTabs.has(targetArray)) return;
      
      try {
        const response = await axios.get(`https://dev.stocks.richtv.io/api/economic-calendar?startDate=${startDate}&endDate=${endDate}`);
        console.log(`Fetched data for ${targetArray}:`, response.data);
        
        this.originalEvents[targetArray] = response.data;
        this.allEvents[targetArray] = this.filterEvents(targetArray);
        this.loadedTabs.add(targetArray);
      } catch (error) {
        console.error('Error fetching economic calendar:', error);
        this.originalEvents[targetArray] = [];
        this.allEvents[targetArray] = [];
        this.loadedTabs.add(targetArray);
      }
    },
    getValueClass(actual, forecast) {
      if (actual > forecast) return 'text-success';
      if (actual < forecast) return 'text-danger';
      return '';
    },
    toggleShowMore(tab) {
      this.showMore[tab] = !this.showMore[tab];
      if (this.showMore[tab]) {
        this.visibleRows[tab] = this.allEvents[tab].length;
      } else {
        this.visibleRows[tab] = 50;
      }
    },
    toggleFilters() {
      const collapseElement = document.getElementById('collapseFilters');
      collapseElement.classList.toggle('show');
    },
    filterEvents(tabName) {
      if (this.originalEvents[tabName] && this.originalEvents[tabName].length > 0) {
        return this.originalEvents[tabName].filter(event => 
          this.selectedCountries.includes(event.country) &&
          this.selectedImportance.includes(this.getImportanceLevel(event.importance))
        );
      }
      return [];
    },

    applyFilters() {
      Object.keys(this.allEvents).forEach(tabName => {
        this.allEvents[tabName] = this.filterEvents(tabName);
      });
      this.toggleFilters();
    },
    restoreDefaultSettings() {
      this.selectedCountries = this.topCountries.filter(country => country.selected).map(country => country.code);
      this.selectedImportance = [1, 2, 3];
      this.applyFilters();
    },
    getImportanceLevel(importance) {
      const importanceLevels = {
        'Low': 1,
        'Medium': 2,
        'High': 3
      };
      return importanceLevels[importance] || 1;
    },
    setActiveTab(tabName) {
      this.activeTab = tabName;
      this.loadTabData(tabName);
    },
    loadTabData(tabName) {
      const today = new Date();
      const formatDate = (date) => date.toISOString().split('T')[0];

      switch (tabName) {
        case 'yesterday':
          const yesterday = new Date(today);
          yesterday.setDate(yesterday.getDate() - 1);
          this.fetchEconomicCalendar(formatDate(yesterday), formatDate(yesterday), 'yesterday');
          break;
        case 'today':
          this.fetchEconomicCalendar(formatDate(today), formatDate(today), 'today');
          break;
        case 'tomorrow':
          const tomorrow = new Date(today);
          tomorrow.setDate(tomorrow.getDate() + 1);
          this.fetchEconomicCalendar(formatDate(tomorrow), formatDate(tomorrow), 'tomorrow');
          break;
        case 'thisWeek':
          const thisWeekStart = new Date(today);
          thisWeekStart.setDate(today.getDate() - today.getDay());
          const thisWeekEnd = new Date(thisWeekStart);
          thisWeekEnd.setDate(thisWeekStart.getDate() + 6);
          this.fetchEconomicCalendar(formatDate(thisWeekStart), formatDate(thisWeekEnd), 'thisWeek');
          break;
        case 'nextWeek':
          const nextWeekStart = new Date(today);
          nextWeekStart.setDate(today.getDate() - today.getDay() + 7);
          const nextWeekEnd = new Date(nextWeekStart);
          nextWeekEnd.setDate(nextWeekStart.getDate() + 6);
          this.fetchEconomicCalendar(formatDate(nextWeekStart), formatDate(nextWeekEnd), 'nextWeek');
          break;
      }
    }
  },
  mounted() {
    this.loadTabData(this.activeTab);
  }
};
</script>