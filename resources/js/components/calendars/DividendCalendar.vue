<template>
<div class="container my-4">
    <div class="row">
        <div class="col-lg-8">
            <div class="mb-5 border-bottom">
                <h1 class="fs-1 fw-bold icon-heading">Upcoming Dividend Payments</h1>
            </div>
            <div class="dividend">
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
                                        {{ tabName.charAt(0).toUpperCase() + tabName.slice(1) }}
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
                                                <th class="fw-6">Company</th>
                                                <th class="text-end fw-6">Symbol</th>
                                                <th class="text-end fw-6">Ex-Dividend Date</th>
                                                <th class="text-end fw-6">Dividend</th>
                                                <th class="text-end fw-6">Payment Date</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <template v-if="allDividends[tabName] && allDividends[tabName].length > 0">
                                                <template v-for="(item, index) in allDividends[tabName].slice(0, visibleRows[tabName])" :key="item.id">
                                                    <tr v-if="index === 0 || item.record_date !== allDividends[tabName][index - 1].record_date" class="crunt_date">
                                                        <td colspan="5" class="text-center">{{ formatDate(item.record_date) }}</td>
                                                    </tr>
                                                    <tr>
                                                        <td class="fw-5">
                                                            <div class="d-flex gap-1 align-items-center">
                                                                <span class="ceFlags" :class="item.country ? item.country : 'default_country'"></span>
                                                                <div class="w-100">
                                                                    <a :href="`/quotes/${item.symbol}`" class="text-decoration-none">
                                                                        <abbr :title="item.name"><span class="company_name text-oneline">{{ truncateName(item.name) }}</span></abbr>
                                                                    </a>
                                                                </div>
                                                            </div>
                                                        </td>
                                                        <td class="text-end">{{ item.symbol }}</td>
                                                        <td class="text-end">{{ formatDate(item.record_date) }}</td>
                                                        <td class="text-end fw-5">{{ formatDividend(item.amount) }}</td>
                                                        <td class="text-end fw-5">{{ formatDate(item.payment_date) }}</td>
                                                    </tr>
                                                </template>
                                            </template>
                                            <tr v-else>
                                                <td colspan="5" class="text-center">{{ loadedTabs.has(tabName) ? 'No data available' : 'Loading...' }}</td>
                                            </tr>
                                        </tbody>
                                    </table>
                                    <div class="d-flex align-items-center gap-3 justify-content-center mt-3">
                                        <button v-if="allDividends[tabName] && allDividends[tabName].length > visibleRows[tabName]" 
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
      allDividends: {
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
      initialRowCount: 50,
      contentLoaded = false;
    };
  },
  methods: {
    async fetchDividendsCalendar(startDate, endDate, targetArray) {
      if (this.loadedTabs.has(targetArray)) return;
      
      try {
        const response = await axios.get(`/api/calendar/dividends?startDate=${startDate}&endDate=${endDate}`);
        this.allDividends[targetArray] = response.data;
        this.loadedTabs.add(targetArray);
      } catch (error) {
        console.error('Error fetching dividends calendar:', error);
        this.allDividends[targetArray] = [];
        this.loadedTabs.add(targetArray);
      }
    },
    formatDate(dateString) {
      const options = { year: 'numeric', month: 'short', day: 'numeric' };
      return new Date(dateString).toLocaleDateString('en-US', options);
    },
    formatDividend(amount) {
      return parseFloat(amount).toFixed(2);
    },
    showMore(tab) {
      this.visibleRows[tab] = Math.min(this.visibleRows[tab] + this.initialRowCount, this.allDividends[tab].length);
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
          this.fetchDividendsCalendar(formatDate(yesterday), formatDate(yesterday), 'yesterday');
          break;
        case 'today':
          this.fetchDividendsCalendar(formatDate(today), formatDate(today), 'today');
          break;
        case 'tomorrow':
          const tomorrow = new Date(today);
          tomorrow.setDate(tomorrow.getDate() + 1);
          this.fetchDividendsCalendar(formatDate(tomorrow), formatDate(tomorrow), 'tomorrow');
          break;
        case 'thisWeek':
          const thisWeekStart = new Date(today);
          thisWeekStart.setDate(today.getDate() - today.getDay());
          const thisWeekEnd = new Date(thisWeekStart);
          thisWeekEnd.setDate(thisWeekStart.getDate() + 6);
          this.fetchDividendsCalendar(formatDate(thisWeekStart), formatDate(thisWeekEnd), 'thisWeek');
          break;
        case 'nextWeek':
          const nextWeekStart = new Date(today);
          nextWeekStart.setDate(today.getDate() - today.getDay() + 7);
          const nextWeekEnd = new Date(nextWeekStart);
          nextWeekEnd.setDate(nextWeekStart.getDate() + 6);
          this.fetchDividendsCalendar(formatDate(nextWeekStart), formatDate(nextWeekEnd), 'nextWeek');
          break;
      }
    },
    truncateName(name) {
      return name.length > 20 ? name.substring(0, 17) + '...' : name;
    }
  },
  mounted() {
    this.loadTabData(this.activeTab);
    this.contentLoaded = true;
  }
};
</script>
<style type="text/css">
  abbr{cursor: pointer !important;}
</style>