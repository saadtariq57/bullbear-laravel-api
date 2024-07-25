<template>
<div class="container my-4">
    <div class="row">
        <div class="col-lg-8">
            <div class="mb-5 border-bottom">
                <h1 class="fs-1 fw-bold icon-heading">Dividend Calendar</h1>
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
                            <li class="nav-item" role="presentation">
                                <button class="nav-link btn btn-primary" id="yesterday-tab" data-bs-toggle="tab" data-bs-target="#yesterday_calendar_tab" type="button" role="tab" aria-controls="yesterday_calendar_tab" aria-selected="true">Yesterday</button>
                            </li>
                            <li class="nav-item" role="presentation">
                                <button class="nav-link active btn btn-primary" id="today-tab" data-bs-toggle="tab" data-bs-target="#today_calendar_tab" type="button" role="tab" aria-controls="today_calendar_tab" aria-selected="false">Today</button>
                            </li>
                            <li class="nav-item" role="presentation">
                                <button class="nav-link btn btn-primary" id="tomorrow-tab" data-bs-toggle="tab" data-bs-target="#tomorrow_calendar_tab" type="button" role="tab" aria-controls="tomorrow_calendar_tab" aria-selected="false">Tomorrow</button>
                            </li>
                            <li class="nav-item" role="presentation">
                                <button class="nav-link btn btn-primary" id="this_week_tab" data-bs-toggle="tab" data-bs-target="#this_week_calendar_tab" type="button" role="tab" aria-controls="this_week_calendar_tab" aria-selected="false">This Week</button>
                            </li>
                            <li class="nav-item" role="presentation">
                                <button class="nav-link btn btn-primary" id="next_week_tab" data-bs-toggle="tab" data-bs-target="#next_week_calendar_tab" type="button" role="tab" aria-controls="next_week_calendar_tab" aria-selected="false">Next Week</button>
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
                        <div class="tab-pane fade" id="yesterday_calendar_tab" role="tabpanel" aria-labelledby="yesterday-tab" tabindex="0">
                            <div class="overflow-auto market-table-wapper">
                            <table class="table table-width border">
                                <thead>
                                <tr>
                                    <th class="fw-6">Company</th>
                                    <th class="text-end fw-6">Ex-Dividend Date</th>
                                    <th class="text-end fw-6">Dividend</th>
                                    <th class="text-end fw-6">Payment Date</th>
                                    <th class="text-end fw-6">Yield</th>
                                </tr>
                                </thead>
                                <tbody>
                                <tr class="crunt_date">
                                    <td colspan="7" class="text-center">{{ formatDate(date) }}</td>
                                </tr>
                                <tr v-for="(item, index) in yesterdayDividends.slice(0, displayLimit.yesterday)" :key="item.id">
                                    <td class="fw-5">
                                    <span class="flagCur d-flex gap-1 align-items-center">
                                        <img :src="getFlagUrl(item.symbol_id)" alt="flag"> {{ getCompanyName(item.symbol_id) }}
                                    </span>
                                    </td>
                                    <td class="text-end">{{ item.record_date }}</td>
                                    <td class="text-end fw-5">{{ item.amount }}</td>
                                    <td class="text-end fw-5">{{ item.payment_date }}</td>
                                    <td class="text-end fw-5">2.95%</td>
                                </tr>
                                </tbody>
                            </table>
                            <div class="text-center">
                                <button v-if="yesterdayDividends.length > displayLimit.yesterday" @click="showMore('yesterday')" class="btn btn-primary mt-2">Show More</button>
                            </div>
                            </div>
                        </div>
                        <div class="tab-pane fade show active" id="today_calendar_tab" role="tabpanel" aria-labelledby="today-tab" tabindex="0">
                            <div class="overflow-auto market-table-wapper">
                            <table class="table table-width border">
                                <thead>
                                <tr>
                                    <th class="fw-6">Company</th>
                                    <th class="text-end fw-6">Ex-Dividend Date</th>
                                    <th class="text-end fw-6">Dividend</th>
                                    <th class="text-end fw-6">Payment Date</th>
                                    <th class="text-end fw-6">Yield</th>
                                </tr>
                                </thead>
                                <tbody>
                                <tr class="crunt_date">
                                    <td colspan="7" class="text-center">{{ currentDate }}</td>
                                </tr>
                                <tr v-for="(item, index) in todayDividends.slice(0, displayLimit.today)" :key="item.id">
                                    <td class="fw-5">
                                    <span class="flagCur d-flex gap-1 align-items-center">
                                        <img :src="getFlagUrl(item.symbol_id)" alt="flag"> {{ getCompanyName(item.symbol_id) }}
                                    </span>
                                    </td>
                                    <td class="text-end">{{ item.record_date }}</td>
                                    <td class="text-end fw-5">{{ item.amount }}</td>
                                    <td class="text-end fw-5">{{ item.payment_date }}</td>
                                    <td class="text-end fw-5">2.95%</td>
                                </tr>
                                </tbody>
                            </table>
                            <div class="text-center">
                                <button v-if="todayDividends.length > displayLimit.today" @click="showMore('today')" class="btn btn-primary mt-2">Show More</button>
                            </div>
                            </div>
                        </div>
                        <div class="tab-pane fade" id="tomorrow_calendar_tab" role="tabpanel" aria-labelledby="tomorrow-tab" tabindex="0">
                            <div class="overflow-auto market-table-wapper">
                            <table class="table table-width border">
                                <thead>
                                <tr>
                                    <th class="fw-6">Company</th>
                                    <th class="text-end fw-6">Ex-Dividend Date</th>
                                    <th class="text-end fw-6">Dividend</th>
                                    <th class="text-end fw-6">Payment Date</th>
                                    <th class="text-end fw-6">Yield</th>
                                </tr>
                                </thead>
                                <tbody>
                                <tr class="crunt_date">
                                    <td colspan="7" class="text-center">{{ formatDate(date) }}</td>
                                </tr>
                                <tr v-for="(item, index) in tomorrowDividends.slice(0, displayLimit.tomorrow)" :key="item.id">
                                    <td class="fw-5">
                                    <span class="flagCur d-flex gap-1 align-items-center">
                                        <img :src="getFlagUrl(item.symbol_id)" alt="flag"> {{ getCompanyName(item.symbol_id) }}
                                    </span>
                                    </td>
                                    <td class="text-end">{{ item.record_date }}</td>
                                    <td class="text-end fw-5">{{ item.amount }}</td>
                                    <td class="text-end fw-5">{{ item.payment_date }}</td>
                                    <td class="text-end fw-5">2.95%</td>
                                </tr>
                                </tbody>
                            </table>
                            <div class="text-center">
                                <button v-if="tomorrowDividends.length > displayLimit.tomorrow" @click="showMore('tomorrow')" class="btn btn-primary mt-2">Show More</button>
                            </div>
                            </div>
                        </div>
                        <div class="tab-pane fade" id="this_week_calendar_tab" role="tabpanel" aria-labelledby="this_week_tab" tabindex="0">
                            <div class="overflow-auto market-table-wapper">
                            <table class="table table-width border">
                                <thead>
                                <tr>
                                    <th class="fw-6">Company</th>
                                    <th class="text-end fw-6">Ex-Dividend Date</th>
                                    <th class="text-end fw-6">Dividend</th>
                                    <th class="text-end fw-6">Payment Date</th>
                                    <th class="text-end fw-6">Yield</th>
                                </tr>
                                </thead>
                                <tbody>
                                <tr class="crunt_date">
                                    <td colspan="7" class="text-center">{{ formatDate(date) }}</td>
                                </tr>
                                <tr v-for="(item, index) in thisWeekDividends.slice(0, displayLimit.thisWeek)" :key="item.id">
                                    <td class="fw-5">
                                    <span class="flagCur d-flex gap-1 align-items-center">
                                        <img :src="getFlagUrl(item.symbol_id)" alt="flag"> {{ getCompanyName(item.symbol_id) }}
                                    </span>
                                    </td>
                                    <td class="text-end">{{ item.record_date }}</td>
                                    <td class="text-end fw-5">{{ item.amount }}</td>
                                    <td class="text-end fw-5">{{ item.payment_date }}</td>
                                    <td class="text-end fw-5">2.95%</td>
                                </tr>
                                </tbody>
                            </table>
                            <div class="text-center">
                                <button v-if="thisWeekDividends.length > displayLimit.thisWeek" @click="showMore('thisWeek')" class="btn btn-primary mt-2">Show More</button>
                            </div>
                            </div>
                        </div>
                        <div class="tab-pane fade" id="next_week_calendar_tab" role="tabpanel" aria-labelledby="next_week_tab" tabindex="0">
                            <div class="overflow-auto market-table-wapper">
                            <table class="table table-width border">
                                <thead>
                                <tr>
                                    <th class="fw-6">Company</th>
                                    <th class="text-end fw-6">Ex-Dividend Date</th>
                                    <th class="text-end fw-6">Dividend</th>
                                    <th class="text-end fw-6">Payment Date</th>
                                    <th class="text-end fw-6">Yield</th>
                                </tr>
                                </thead>
                                <tbody>
                                <tr class="crunt_date">
                                    <td colspan="7" class="text-center">{{ formatDate(date) }}</td>
                                </tr>
                                <tr v-for="(item, index) in nextWeekDividends.slice(0, displayLimit.nextWeek)" :key="item.id">
                                    <td class="fw-5">
                                    <span class="flagCur d-flex gap-1 align-items-center">
                                        <img :src="getFlagUrl(item.symbol_id)" alt="flag"> {{ getCompanyName(item.symbol_id) }}
                                    </span>
                                    </td>
                                    <td class="text-end">{{ item.record_date }}</td>
                                    <td class="text-end fw-5">{{ item.amount }}</td>
                                    <td class="text-end fw-5">{{ item.payment_date }}</td>
                                    <td class="text-end fw-5">2.95%</td>
                                </tr>
                                </tbody>
                            </table>
                            <div class="text-center">
                                <button v-if="nextWeekDividends.length > displayLimit.nextWeek" @click="showMore('nextWeek')" class="btn btn-primary mt-2">Show More</button>
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
      yesterdayDividends: [],
      todayDividends: [],
      tomorrowDividends: [],
      thisWeekDividends: [],
      nextWeekDividends: [],
      displayLimit: {
        yesterday: 50,
        today: 50,
        tomorrow: 50,
        thisWeek: 50,
        nextWeek: 50
      }
    };
  },
  methods: {
    selectAll() {
      this.selectedCategories = this.categories.map(category => category.value);
    },
    clearAll() {
      this.selectedCategories = [];
    },
    async fetchDividendsCalendar(startDate, endDate, targetArray) {
      try {
        const response = await axios.get(`https://dev.stocks.richtv.io/api/dividends-calendar?startDate=${startDate}&endDate=${endDate}`);
        this[targetArray] = response.data;
      } catch (error) {
        console.error('Error fetching dividends calendar:', error);
      }
    },
    formatDate(dateString) {
      const options = { weekday: 'long', year: 'numeric', month: 'long', day: 'numeric' };
      return new Date(dateString).toLocaleDateString('en-US', options);
    },
    showMore(tab) {
      this.displayLimit[tab] += 50;
    },
    getFlagUrl(symbolId) {
      // Placeholder function to get flag URL based on symbol ID
      return `/build/images/flags/country_${symbolId}.jpg`;
    },
    getCompanyName(symbolId) {
      // Placeholder function to get company name based on symbol ID
      return `Company ${symbolId}`;
    }
  },
  mounted() {
    const today = new Date().toISOString().split('T')[0];
    const yesterday = new Date(Date.now() - 86400000).toISOString().split('T')[0];
    const tomorrow = new Date(Date.now() + 86400000).toISOString().split('T')[0];
    const thisWeekStart = new Date(Date.now() - (new Date().getDay() * 86400000)).toISOString().split('T')[0];
    const thisWeekEnd = new Date(Date.now() + ((6 - new Date().getDay()) * 86400000)).toISOString().split('T')[0];
    const nextWeekStart = new Date(Date.now() + ((7 - new Date().getDay()) * 86400000)).toISOString().split('T')[0];
    const nextWeekEnd = new Date(Date.now() + ((13 - new Date().getDay()) * 86400000)).toISOString().split('T')[0];

    this.fetchDividendsCalendar(yesterday, yesterday, 'yesterdayDividends');
    this.fetchDividendsCalendar(today, today, 'todayDividends');
    this.fetchDividendsCalendar(tomorrow, tomorrow, 'tomorrowDividends');
    this.fetchDividendsCalendar(thisWeekStart, thisWeekEnd, 'thisWeekDividends');
    this.fetchDividendsCalendar(nextWeekStart, nextWeekEnd, 'nextWeekDividends');
    this.currentDate = this.formatDate(today);
  }
};
</script>
<style>
.iconQuarterly,.iconAnnual,.iconMonthly {
    width: 24px;
    height: 15px;
    background-image: url(/build/images/site_icons/SiteIcons.png);
    display: inline-block;
}
.iconMonthly{
    background-position: -3px -2049px;
}
.iconQuarterly{
    background-position: -29px -2049px;
}
.iconAnnual{
    background-position: -85px -2049px;
}
</style>