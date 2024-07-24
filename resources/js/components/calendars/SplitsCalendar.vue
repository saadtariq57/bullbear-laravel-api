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
                                            <li class="nav-item" role="presentation" v-for="(events, tabName) in filteredEvents" :key="tabName">
                                                <button class="nav-link btn btn-primary" :class="{ active: activeTab === tabName }" 
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
                                    <div v-for="(events, tabName) in filteredEvents" :key="tabName" 
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
                                                    <template v-for="(groupedEvents, date) in groupedEvents(events.slice(0, visibleRows[tabName]))" :key="date">
                                                        <tr class="crunt_date">
                                                            <td colspan="3" class="text-center">{{ formatDate(date) }}</td>
                                                        </tr>
                                                        <tr v-for="event in groupedEvents" :key="event.id">
                                                            <td class="text-start">{{ formatDate(event.date) }}</td>
                                                            <td class="text-start fw-5">
                                                                <span class="flagCur d-flex gap-1 align-items-center">
                                                                    <img :src="getFlagUrl(event.symbol_id)" alt="flag">
                                                                    {{ getCompanyName(event.symbol_id) }} (<a :href="getCompanyLink(event.symbol_id)">{{ event.symbol_id }}</a>)
                                                                </span>
                                                            </td>
                                                            <td class="text-end fw-5">{{ event.from_factor }}:{{ event.to_factor }}</td>
                                                        </tr>
                                                    </template>
                                                </tbody>
                                            </table>
                                            <div class="gap-3 d-flex align-items-center justify-content-center">
                                                <button v-if="events.length > visibleRows[tabName]" 
                                                        class="btn btn-primary" 
                                                        @click="toggleShowMore(tabName)">
                                                    Show More
                                                </button>
                                                <button v-if="visibleRows[tabName] > 50" 
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
      splitsEvents: [],
      visibleRows: {
        last30Days: 50,
        last7Days: 50,
        yesterday: 50
      },
      activeTab: 'last7Days',
      initialRowCount: 50
    };
  },
  computed: {
    filteredEvents() {
      const today = new Date();
      const last30Days = new Date(today);
      last30Days.setDate(today.getDate() - 30);
      const last7Days = new Date(today);
      last7Days.setDate(today.getDate() - 7);
      const yesterday = new Date(today);
      yesterday.setDate(today.getDate() - 1);

      return {
        last30Days: this.splitsEvents.filter(event => new Date(event.date) >= last30Days && new Date(event.date) <= today),
        last7Days: this.splitsEvents.filter(event => new Date(event.date) >= last7Days && new Date(event.date) <= today),
        yesterday: this.splitsEvents.filter(event => new Date(event.date).toDateString() === yesterday.toDateString())
      };
    }
  },
  methods: {
    async fetchSplitsCalendar() {
      try {
        const response = await axios.get('https://dev.stocks.richtv.io/api/splits-calendar');
        this.splitsEvents = response.data;
      } catch (error) {
        console.error('Error fetching splits calendar:', error);
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
    toggleShowMore(tab) {
      this.visibleRows[tab] += 50;
    },
    showLess(tab) {
      this.visibleRows[tab] = Math.max(this.initialRowCount, this.visibleRows[tab] - this.initialRowCount);
    },
    setActiveTab(tabName) {
      this.activeTab = tabName;
    },
    getFlagUrl(symbolId) {
      // Placeholder function to get flag URL based on symbol ID
      return `/build/images/flags/country_${symbolId}.jpg`;
    },
    getCompanyName(symbolId) {
      // Placeholder function to get company name based on symbol ID
      return `Company ${symbolId}`;
    },
    getCompanyLink(symbolId) {
      // Placeholder function to get company link based on symbol ID
      return `#${symbolId}`;
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
    this.fetchSplitsCalendar();
  }
};
</script>