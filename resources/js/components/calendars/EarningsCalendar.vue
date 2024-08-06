<template>
    <div class="container my-4">
            <div class="row">
                <div class="col-lg-8">
                    <div class="mb-5">
                        <h1 class="fs-1 fw-bold icon-heading">Earnings Calendar</h1>
                    </div>
                    <div class="earning">
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
                                    <a class="" data-bs-toggle="collapse" href="#collapseFilters" role="button" aria-expanded="false" aria-controls="collapseFilters">
                                    <i class="bi bi-sliders2"></i> Filters
                                    </a>
                                </div>
                                </div>
                                <div class="collapse" id="collapseFilters">
                                <div class="card card-body">
                                    <div class="category_filter mb-4">
                                    <div class="filterList_label">
                                        <p class="fw-bold mb-1">Category:</p>
                                        <a href="javascript:void(0);" class="" @click="selectAll">Select All</a><br>
                                        <a href="javascript:void(0);" @click="clearAll" class="">Clear</a>
                                    </div>
                                    <div class="w-100">
                                        <ul class="filterList">
                                        <li v-for="category in categories" :key="category.id">
                                            <input :id="category.id" name="category[]" type="checkbox" :value="category.value" v-model="selectedCategories">
                                            <label :for="category.id">{{ category.label }}</label>
                                        </li>
                                        </ul>
                                    </div>
                                    </div>
                                    <div class="category_filter mb-4">
                                    </div>
                                    <div class="apply_filter d-flex gap-sm-3 justify-content-end">
                                    <a href="javascript:void(0);" id="ecSubmitButton" class="btn btn-primary">Apply</a>
                                    <a href="javascript:void(0);" id="filterRestoreDefaults" class="restore btn"><i class="bi bi-arrow-clockwise"></i> Restore Default Settings</a>
                                    </div>
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
                                                      <th class="fw-6">Company</th>
                                                      <th class="text-end fw-6 pe-0">EPS</th>
                                                      <th class="text-start fw-6 ps-1">/ Forecast</th>
                                                      <th class="text-end fw-6 pe-0">Revenue</th>
                                                      <th class="text-start fw-6 ps-1">/ Forecast</th>
                                                      <th class="text-end fw-6">Time</th>
                                                  </tr>
                                              </thead>
                                              <tbody>
                                                  <template v-if="allEarnings[tabName] && allEarnings[tabName].length > 0">
                                                      <template v-for="(item, index) in allEarnings[tabName].slice(0, visibleRows[tabName])" :key="item.id">
                                                          <tr v-if="index === 0 || item.date !== allEarnings[tabName][index - 1].date" class="crunt_date">
                                                              <td colspan="6" class="text-center">{{ formatDate(item.date) }}</td>
                                                          </tr>
                                                          <tr>
                                                              <td class="fw-5">
                                                                  <div class="d-flex gap-1 align-items-center">
                                                                    <span class="ceFlags" :class="item.country ? item.country : 'default_country'"></span>
                                                                      <div class="w-100">
                                                                         <abbr :title="item.name"><span class="company_name text-oneline">{{ item.name }}</span></abbr> 
                                                                      </div>
                                                                  </div>
                                                              </td>
                                                              <td class="text-end" :class="getColorClass(item.eps_actual, item.eps_estimate)">{{ item.eps_actual }}</td>
                                                              <td class="text-start fw-5 ps-1">/ {{ item.eps_estimate }}</td>
                                                              <td class="text-end" :class="getColorClass(item.revenue, item.revenue_estimated)">{{ item.revenue }}</td>
                                                              <td class="text-start fw-5 ps-1">/ {{ item.revenue_estimated }}</td>
                                                              <td class="text-end fw-5">
                                                                  <span :class="getMarketTimeClass(item.time)" class="genToolTip oneliner reverseToolTip" :data-tooltip="getMarketTimeTooltip(item.time)"></span>
                                                              </td>
                                                          </tr>
                                                      </template>
                                                  </template>
                                                  <tr v-else>
                                                      <td colspan="6" class="text-center">{{ loadedTabs.has(tabName) ? 'No data available' : 'Loading...' }}</td>
                                                  </tr>
                                              </tbody>
                                          </table>
                                          <div class="d-flex align-items-center gap-3 justify-content-center mt-3">
                                              <button v-if="allEarnings[tabName] && allEarnings[tabName].length > visibleRows[tabName]" 
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
      categories: [
        // ... (categories remain the same) ...
      ],
      allEarnings: {
        yesterday: [],
        today: [],
        tomorrow: [],
        thisWeek: [],
        nextWeek: []
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
      loadedTabs: new Set(),
      initialRowCount: 50
    };
  },
  methods: {
    async fetchEarningsCalendar(startDate, endDate, targetArray) {
      if (this.loadedTabs.has(targetArray)) return;
      
      try {
        const response = await axios.get(`https://dev.stocks.richtv.io/api/earnings-calendar?startDate=${startDate}&endDate=${endDate}`);
        console.log(`Fetched data for ${targetArray}:`, response.data);
        this.allEarnings[targetArray] = response.data;
        this.loadedTabs.add(targetArray);
      } catch (error) {
        console.error('Error fetching earnings calendar:', error);
        this.allEarnings[targetArray] = [];
        this.loadedTabs.add(targetArray);
      }
    },
    formatDate(dateString) {
      const options = { weekday: 'long', year: 'numeric', month: 'long', day: 'numeric' };
      return new Date(dateString).toLocaleDateString('en-US', options);
    },
    getColorClass(actual, estimate) {
      if (actual > estimate) return 'Green';
      if (actual < estimate) return 'Red';
      return '';
    },
    getMarketTimeClass(time) {
      if (time === 'bmo') return 'marketOpen';
      if (time === 'amc') return 'marketClosed';
      return '';
    },
    getMarketTimeTooltip(time) {
      if (time === 'bmo') return 'Before market open';
      if (time === 'amc') return 'After market close';
      return '';
    },
    showMore(tab) {
      this.visibleRows[tab] = Math.min(this.visibleRows[tab] + this.initialRowCount, this.allEarnings[tab].length);
    },
    showLess(tab) {
      this.visibleRows[tab] = Math.max(this.initialRowCount, this.visibleRows[tab] - this.initialRowCount);
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
          this.fetchEarningsCalendar(formatDate(yesterday), formatDate(yesterday), 'yesterday');
          break;
        case 'today':
          this.fetchEarningsCalendar(formatDate(today), formatDate(today), 'today');
          break;
        case 'tomorrow':
          const tomorrow = new Date(today);
          tomorrow.setDate(tomorrow.getDate() + 1);
          this.fetchEarningsCalendar(formatDate(tomorrow), formatDate(tomorrow), 'tomorrow');
          break;
        case 'thisWeek':
          const thisWeekStart = new Date(today);
          thisWeekStart.setDate(today.getDate() - today.getDay());
          const thisWeekEnd = new Date(thisWeekStart);
          thisWeekEnd.setDate(thisWeekStart.getDate() + 6);
          this.fetchEarningsCalendar(formatDate(thisWeekStart), formatDate(thisWeekEnd), 'thisWeek');
          break;
        case 'nextWeek':
          const nextWeekStart = new Date(today);
          nextWeekStart.setDate(today.getDate() - today.getDay() + 7);
          const nextWeekEnd = new Date(nextWeekStart);
          nextWeekEnd.setDate(nextWeekStart.getDate() + 6);
          this.fetchEarningsCalendar(formatDate(nextWeekStart), formatDate(nextWeekEnd), 'nextWeek');
          break;
      }
    }
  },
  mounted() {
    this.loadTabData(this.activeTab);
  }
};
</script>
