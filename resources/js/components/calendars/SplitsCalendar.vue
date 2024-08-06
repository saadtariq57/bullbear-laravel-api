<template>
     <div class="container my-4">
            <div class="row">
                <div class="col-lg-8">
                    <div class="mb-5 border-bottom">
                        <h1 class="fs-1 fw-bold icon-heading">Splits Calendar</h1>
                    </div>
                    <div class="splits">
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
                                        <div class="filterList_label">
                                        <p class="fw-bold mb-1">Importance:</p>
                                        </div>
                                        <div class="w-100">
                                        <ul class="filterList">
                                            <li>
                                            <input id="importance1" name="importance[]" type="checkbox" value="1">
                                            <label for="importance1">
                                                <span class="sentiment d-flex gap-1 justify-content-end">
                                                <i class="bi bi-star-fill"></i>
                                                <i class="bi bi-star"></i>
                                                <i class="bi bi-star"></i>
                                                </span>
                                            </label>
                                            </li>
                                            <li>
                                            <input id="importance2" name="importance[]" type="checkbox" value="2">
                                            <label for="importance2">
                                                <span class="sentiment d-flex gap-1 justify-content-end">
                                                <i class="bi bi-star-fill"></i>
                                                <i class="bi bi-star-fill"></i>
                                                <i class="bi bi-star"></i>
                                                </span>
                                            </label>
                                            </li>
                                            <li>
                                            <input id="importance3" name="importance[]" type="checkbox" value="3">
                                            <label for="importance3">
                                                <span class="sentiment d-flex gap-1 justify-content-end">
                                                <i class="bi bi-star-fill"></i>
                                                <i class="bi bi-star-fill"></i>
                                                <i class="bi bi-star-fill"></i>
                                                </span>
                                            </label>
                                            </li>
                                        </ul>
                                        </div>
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
                                                      <th class="fw-6">Split date</th>
                                                      <th class="text-start fw-6">Company</th>
                                                      <th class="text-end fw-6">Split ratio</th>
                                                  </tr>
                                              </thead>
                                              <tbody>
                                                  <template v-if="splitsEvents[tabName] && splitsEvents[tabName].length > 0">
                                                      <template v-for="(groupedEvents, date) in groupedEvents(splitsEvents[tabName].slice(0, visibleRows[tabName]))" :key="date">
                                                          <tr class="crunt_date">
                                                              <td colspan="3" class="text-center">{{ formatDate(date) }}</td>
                                                          </tr>
                                                          <tr v-for="event in groupedEvents" :key="event.id">
                                                              <td class="text-start">{{ formatDate(event.date) }}</td>
                                                              <td class="text-start fw-5">
                                                                  <div class="d-flex gap-1 align-items-center">
                                                                      <span class="ceFlags" :class="event.country ? event.country : 'default_country'"></span>
                                                                      <div class="w-100">
                                                                          <abbr :title="event.name"><span class="company_name text-oneline">{{ event.name }}</span></abbr> 
                                                                      </div>
                                                                  </div>
                                                              </td>
                                                              <td class="text-end fw-5">{{ event.from_factor }}:{{ event.to_factor }}</td>
                                                          </tr>
                                                      </template>
                                                  </template>
                                                  <tr v-else>
                                                      <td colspan="3" class="text-center">{{ loadedTabs.has(tabName) ? 'No data available' : 'Loading...' }}</td>
                                                  </tr>
                                              </tbody>
                                          </table>
                                          <div class="gap-3 d-flex align-items-center justify-content-center mt-3">
                                              <button v-if="splitsEvents[tabName] && splitsEvents[tabName].length > visibleRows[tabName]" 
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
      splitsEvents: {
        last30Days: [],
        last7Days: [],
        yesterday: []
      },
      visibleRows: {
        last30Days: 50,
        last7Days: 50,
        yesterday: 50
      },
      activeTab: 'last7Days',
      tabNames: ['last30Days', 'last7Days', 'yesterday'],
      loadedTabs: new Set(),
      initialRowCount: 50
    };
  },
  methods: {
    async fetchSplitsCalendar(tabName) {
      if (this.loadedTabs.has(tabName)) return;
      
      const today = new Date();
      let startDate, endDate;
      
      switch (tabName) {
        case 'last30Days':
          startDate = new Date(today);
          startDate.setDate(today.getDate() - 30);
          endDate = today;
          break;
        case 'last7Days':
          startDate = new Date(today);
          startDate.setDate(today.getDate() - 7);
          endDate = today;
          break;
        case 'yesterday':
          startDate = new Date(today);
          startDate.setDate(today.getDate() - 1);
          endDate = startDate;
          break;
      }

      const formatDate = (date) => date.toISOString().split('T')[0];
      
      try {
        const response = await axios.get(`https://dev.stocks.richtv.io/api/splits-calendar?startDate=${formatDate(startDate)}&endDate=${formatDate(endDate)}`);
        console.log(`Fetched data for ${tabName}:`, response.data);
        this.splitsEvents[tabName] = response.data;
        this.loadedTabs.add(tabName);
      } catch (error) {
        console.error(`Error fetching splits calendar for ${tabName}:`, error);
        this.splitsEvents[tabName] = [];
        this.loadedTabs.add(tabName);
      }
    },
    formatDate(dateString) {
      const options = { year: 'numeric', month: 'short', day: 'numeric' };
      return new Date(dateString).toLocaleDateString('en-US', options);
    },
    groupedEvents(events) {
      return events.reduce((acc, event) => {
        const date = event.date;
        if (!acc[date]) {
          acc[date] = [];
        }
        acc[date].push(event);
        return acc;
      }, {});
    },
    showMore(tab) {
      this.visibleRows[tab] = Math.min(this.visibleRows[tab] + this.initialRowCount, this.splitsEvents[tab].length);
    },
    showLess(tab) {
      this.visibleRows[tab] = Math.max(this.initialRowCount, this.visibleRows[tab] - this.initialRowCount);
    },
    setActiveTab(tabName) {
      this.activeTab = tabName;
      this.fetchSplitsCalendar(tabName);
    },
    getTabLabel(tabName) {
      const labels = {
        last30Days: 'Last 30 Days',
        last7Days: 'Last 7 Days',
        yesterday: 'Yesterday'
      };
      return labels[tabName] || tabName;
    }
  },
  mounted() {
    this.fetchSplitsCalendar(this.activeTab);
  }
};
</script>