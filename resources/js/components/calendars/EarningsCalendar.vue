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
                                        <li class="nav-item" role="presentation" v-for="(events, tabName) in allEarnings" :key="tabName">
                                            <button class="nav-link nav-link btn btn-primary" :class="{ active: activeTab === tabName }" 
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
                                    <div v-for="(events, tabName) in allEarnings" :key="tabName" 
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
                                                    <template v-for="(item, index) in events.slice(0, visibleRows[tabName])" :key="item.id">
                                                        <tr v-if="index === 0 || item.date !== events[index - 1].date" class="crunt_date">
                                                            <td colspan="6" class="text-center">{{ formatDate(item.date) }}</td>
                                                        </tr>
                                                        <tr>
                                                            <td class="fw-5">
                                                                <div class="d-flex gap-1 align-items-center">
                                                                    <span :title="getCompanyName(item.symbol_id)" :class="`ceFlags usa ${getCountryClass(item.symbol_id)}`"></span>
                                                                    <span class="company_name">{{ getCompanyName(item.symbol_id) }}</span>
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
                                                </tbody>
                                            </table>
                                            <div class="d-flex align-items-center gap-3 justify-content-center">
                                                <button v-if="events.length > visibleRows[tabName]" class="btn btn-primary" @click="toggleShowMore(tabName)">Show More </button>
                                                <button v-if="visibleRows[tabName] > 50" class="btn btn-border ml-2"  @click="visibleRows[tabName] = 50">Show Less</button>
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
      allEarnings: {
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
      activeTab: 'today'
    };
  },
  methods: {
    async fetchEarningsCalendar(startDate, endDate, targetArray) {
      try {
        const response = await axios.get(`https://dev.stocks.richtv.io/api/earnings-calendar?startDate=${startDate}&endDate=${endDate}`);
        this.allEarnings[targetArray] = response.data;
        console.log(`Fetched data for ${targetArray}:`, this.allEarnings[targetArray]);
      } catch (error) {
        console.error('Error fetching earnings calendar:', error);
      }
    },
    formatDate(dateString) {
      const options = { weekday: 'long', year: 'numeric', month: 'long', day: 'numeric' };
      return new Date(dateString).toLocaleDateString('en-US', options);
    },
    getCountryClass(symbolId) {
      // Replace with actual logic to get country class based on symbolId
      const countryMap = {
        'SAP': 'USA', // Example mapping
        // Add more mappings here
      };
      return countryMap[symbolId] || 'default-country';
    },
    getCompanyName(symbolId) {
      // Replace with actual logic to get company name based on symbolId
      const companyMap = {
        'SAP': 'SAP ADR (SAP)', // Example mapping
        // Add more mappings here
      };
      return companyMap[symbolId] || symbolId;
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
    toggleShowMore(tab) {
    this.visibleRows[tab] += 50;
  },
    setActiveTab(tabName) {
      this.activeTab = tabName;
    }
  },
  mounted() {
    const today = new Date();
    const yesterday = new Date(today);
    yesterday.setDate(yesterday.getDate() - 1);
    const tomorrow = new Date(today);
    tomorrow.setDate(tomorrow.getDate() + 1);
    
    const thisWeekStart = new Date(today);
    thisWeekStart.setDate(today.getDate() - today.getDay());
    const thisWeekEnd = new Date(thisWeekStart);
    thisWeekEnd.setDate(thisWeekStart.getDate() + 6);
    
    const nextWeekStart = new Date(thisWeekEnd);
    nextWeekStart.setDate(nextWeekStart.getDate() + 1);
    const nextWeekEnd = new Date(nextWeekStart);
    nextWeekEnd.setDate(nextWeekStart.getDate() + 6);

    const formatDate = (date) => date.toISOString().split('T')[0];

    this.fetchEarningsCalendar(formatDate(yesterday), formatDate(yesterday), 'yesterday');
    this.fetchEarningsCalendar(formatDate(today), formatDate(today), 'today');
    this.fetchEarningsCalendar(formatDate(tomorrow), formatDate(tomorrow), 'tomorrow');
    this.fetchEarningsCalendar(formatDate(thisWeekStart), formatDate(thisWeekEnd), 'thisWeek');
    this.fetchEarningsCalendar(formatDate(nextWeekStart), formatDate(nextWeekEnd), 'nextWeek');
  }
};
</script>
