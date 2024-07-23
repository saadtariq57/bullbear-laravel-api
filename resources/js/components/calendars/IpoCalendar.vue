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
                                            <li class="nav-item" role="presentation">
                                                <button class="nav-link btn btn-primary" id="upcoming-tab" data-bs-toggle="tab" data-bs-target="#upcoming_calendar_tab" type="button" role="tab" aria-controls="upcoming_calendar_tab" aria-selected="false">upcoming</button>
                                            </li>
                                            <li class="nav-item" role="presentation">
                                                <button class="nav-link active btn btn-primary" id="recent-tab" data-bs-toggle="tab" data-bs-target="#recent_calendar_tab" type="button" role="tab" aria-controls="recent_calendar_tab" aria-selected="false">Recent</button>
                                            </li>
                                        </ul>
                                    </div>
                                    <div class="other_filters">
                                        <a class="" data-bs-toggle="collapse" href="#collapseFilters" role="button" aria-expanded="false" aria-controls="collapseFilters">
                                            <i class="bi bi-sliders2"></i>  Filters 
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
                                    <div class="tab-pane fade" id="upcoming_calendar_tab" role="tabpanel" aria-labelledby="upcoming-tab" tabindex="0">
                                        <div class="overflow-auto market-table-wapper">
                                        <table class="table table-width border">
                                            <thead>
                                            <tr>
                                                <th class="fw-6">IPO Listing</th>
                                                <th class="text-start fw-6">Company</th>
                                                <th class="text-end fw-6">Exchange</th>
                                                <th class="text-end fw-6">IPO Value</th>
                                                <th class="text-end fw-6">IPO Price</th>
                                                <th class="text-end fw-6">Last</th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                            <tr v-for="event in filteredUpcomingIpoEvents" :key="event.id">
                                                <td class="text-start">{{ formatDate(event.effectiveness_date) }}</td>
                                                <td class="text-start fw-5">
                                                <span class="flagCur d-flex gap-1 align-items-center">
                                                    <img src="/build/images/flags/country_1.jpg" alt="flag">{{ event.symbol_id }} (<a :href="event.url">{{ event.symbol_id }}</a>)
                                                </span>
                                                </td>
                                                <td class="text-end fw-5">NYSE</td>
                                                <td class="text-end fw-5">945.0M</td>
                                                <td class="text-end fw-5">18.00-21.00</td>
                                                <td class="text-end fw-5">125.68</td>
                                            </tr>
                                            </tbody>
                                        </table>
                                        <div class="text-center">
                                            <button class="btn btn-primary" @click="showMoreUpcoming">Show More</button>
                                        </div>
                                        </div>
                                    </div>
                                    <div class="tab-pane fade show active" id="recent_calendar_tab" role="tabpanel" aria-labelledby="recent-tab" tabindex="0">
                                        <div class="overflow-auto market-table-wapper">
                                        <table class="table table-width border">
                                            <thead>
                                            <tr>
                                                <th class="fw-6">IPO Listing</th>
                                                <th class="text-start fw-6">Company</th>
                                                <th class="text-end fw-6">Exchange</th>
                                                <th class="text-end fw-6">IPO Value</th>
                                                <th class="text-end fw-6">IPO Price</th>
                                                <th class="text-end fw-6">Last</th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                            <tr v-for="event in filteredRecentIpoEvents" :key="event.id">
                                                <td class="text-start">{{ formatDate(event.effectiveness_date) }}</td>
                                                <td class="text-start fw-5">
                                                <span class="flagCur d-flex gap-1 align-items-center">
                                                    <img src="/build/images/flags/country_1.jpg" alt="flag">{{ event.symbol_id }} (<a :href="event.url">{{ event.symbol_id }}</a>)
                                                </span>
                                                </td>
                                                <td class="text-end fw-5">NYSE</td>
                                                <td class="text-end fw-5">945.0M</td>
                                                <td class="text-end fw-5">18.00-21.00</td>
                                                <td class="text-end fw-5">125.68</td>
                                            </tr>
                                            </tbody>
                                        </table>
                                        <div class="text-center">
                                            <button class="btn btn-primary" @click="showMoreRecent">Show More</button>
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
        { id: 'category_employment', value: '_employment', label: 'Employment' },
        { id: 'category_economicActivity', value: '_economicActivity', label: 'Economic Activity' },
        { id: 'category_inflation', value: '_inflation', label: 'Inflation' },
        { id: 'category_credit', value: '_credit', label: 'Credit' },
        { id: 'category_centralBanks', value: '_centralBanks', label: 'Central Banks' },
        { id: 'category_confidenceIndex', value: '_confidenceIndex', label: 'Confidence Index' },
        { id: 'category_balance', value: '_balance', label: 'Balance' },
        { id: 'category_Bonds', value: '_Bonds', label: 'Bonds' }
      ],
      selectedCategories: [],
      ipoEvents: [],
      upcomingIpoEvents: [],
      recentIpoEvents: [],
      upcomingDisplayCount: 50,
      recentDisplayCount: 50
    };
  },
  computed: {
    filteredUpcomingIpoEvents() {
      return this.upcomingIpoEvents.slice(0, this.upcomingDisplayCount);
    },
    filteredRecentIpoEvents() {
      return this.recentIpoEvents.slice(0, this.recentDisplayCount);
    }
  },
  methods: {
    selectAll() {
      this.selectedCategories = this.categories.map(category => category.value);
    },
    clearAll() {
      this.selectedCategories = [];
    },
    async fetchIpoCalendar() {
      try {
        const response = await axios.get('https://dev.stocks.richtv.io/api/ipo-calendar');
        this.ipoEvents = response.data;
        this.filterIpoEvents();
      } catch (error) {
        console.error('Error fetching IPO calendar:', error);
      }
    },
    filterIpoEvents() {
      const today = new Date();
      const past25Days = new Date(today);
      past25Days.setDate(today.getDate() - 25);

      this.upcomingIpoEvents = this.ipoEvents.filter(event => new Date(event.effectiveness_date) >= today);
      this.recentIpoEvents = this.ipoEvents.filter(event => new Date(event.effectiveness_date) >= past25Days && new Date(event.effectiveness_date) <= today);
    },
    formatDate(dateString) {
      const options = { year: 'numeric', month: 'short', day: 'numeric' };
      return new Date(dateString).toLocaleDateString('en-US', options);
    },
    showMoreUpcoming() {
      this.upcomingDisplayCount += 50;
    },
    showMoreRecent() {
      this.recentDisplayCount += 50;
    }
  },
  mounted() {
    this.fetchIpoCalendar();
  }
};
</script>