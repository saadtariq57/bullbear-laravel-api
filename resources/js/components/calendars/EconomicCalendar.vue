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
                            <div class="">
                                    <p class="m-0 fs-6 text-center py-2 border-top border-bottom">All data are streaming and updated automatically.</p>
                            </div>
                            <div class="tab-content" id="myTabContent">
                                <div class="tab-pane fade " id="yesterday_calendar_tab" role="tabpanel" aria-labelledby="yesterday-tab" tabindex="0">
                                    <div class=" overflow-auto market-table-wapper">
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
                                                <tr class="crunt_date">
                                                    <td colspan="7" class="text-center">Wednesday, June 12, 2024</td>
                                                </tr>
                                                <tr>
                                                    <td class="fw-5">All Day</td>
                                                    <td class="text-end fw-5"><span class="flagCur d-flex gap-1 align-items-center justify-content-end"><img src="/build/images/flags/country_1.jpg" alt="flag"> USD</span></td>
                                                    <td class="text-end fw-5">Holiday</td>
                                                    <td class="text-end fw-5">Russia - National Day</td>
                                                </tr>
                                                <tr>
                                                    <td class="fw-5">01:00</td>
                                                    <td class="text-end fw-5"><span class="flagCur d-flex gap-1 align-items-center justify-content-end"><img src="/build/images/flags/country_2.jpg" alt="flag"> GBP</span></td>
                                                    <td class="text-end fw-5">
                                                        <span class="sentiment d-flex gap-1 justify-content-end">
                                                            <i class="bi bi-star-fill"></i>
                                                            <i class="bi bi-star"></i>
                                                            <i class="bi bi-star"></i>
                                                        </span>
                                                    </td>
                                                    <td class="text-end fw-5">U.K. Construction Output (YoY) (Apr)</td>
                                                    <td class="text-end fw-5 Red">-3.3%</td>
                                                    <td class="text-end fw-5 Red negative-arrow-icon-after">-1.8%</td>
                                                    <td class="text-end fw-5">-2.2%</td>
                                                </tr>
                                                <tr>
                                                    <td class="fw-5">01:00</td>
                                                    <td class="text-end fw-5"><span class="flagCur d-flex gap-1 align-items-center justify-content-end"><img src="/build/images/flags/country_2.jpg" alt="flag"> GBP</span></td>
                                                    <td class="text-end fw-5">
                                                        <span class="sentiment d-flex gap-1 justify-content-end">
                                                            <i class="bi bi-star-fill"></i>
                                                            <i class="bi bi-star-fill"></i>
                                                            <i class="bi bi-star-fill"></i>
                                                        </span>
                                                    </td>
                                                    <td class="text-end fw-5">GDP (MoM) (Apr)</td>
                                                    <td class="text-end fw-5">0.0%</td>
                                                    <td class="text-end fw-5">0.0%</td>
                                                    <td class="text-end fw-5">0.4%</td>
                                                </tr>
                                                <tr>
                                                    <td class="fw-5">01:00</td>
                                                    <td class="text-end fw-5"><span class="flagCur d-flex gap-1 align-items-center justify-content-end"><img src="/build/images/flags/country_2.jpg" alt="flag"> GBP</span></td>
                                                    <td class="text-end fw-5">
                                                        <span class="sentiment d-flex gap-1 justify-content-end">
                                                            <i class="bi bi-star-fill"></i>
                                                            <i class="bi bi-star"></i>
                                                            <i class="bi bi-star"></i>
                                                        </span>
                                                    </td>
                                                    <td class="text-end fw-5">	GDP (YoY) (Apr)</td>
                                                    <td class="text-end fw-5">0.6%</td>
                                                    <td class="text-end fw-5">0.6%</td>
                                                    <td class="text-end fw-5">0.7%</td>
                                                </tr>
                                                <tr>
                                                    <td class="fw-5">01:00</td>
                                                    <td class="text-end fw-5"><span class="flagCur d-flex gap-1 align-items-center justify-content-end"><img src="/build/images/flags/country_2.jpg" alt="flag"> GBP</span></td>
                                                    <td class="text-end fw-5">
                                                        <span class="sentiment d-flex gap-1 justify-content-end">
                                                            <i class="bi bi-star-fill"></i>
                                                            <i class="bi bi-star"></i>
                                                            <i class="bi bi-star"></i>
                                                        </span>
                                                    </td>
                                                    <td class="text-end fw-5">Index of Services</td>
                                                    <td class="text-end fw-5 Green">0.9%</td>
                                                    <td class="text-end fw-5">0.8%</td>
                                                    <td class="text-end fw-5">0.7%</td>
                                                </tr>
                                                <tr>
                                                    <td class="fw-5">01:00</td>
                                                    <td class="text-end fw-5"><span class="flagCur d-flex gap-1 align-items-center justify-content-end"><img src="/build/images/flags/country_2.jpg" alt="flag"> GBP</span></td>
                                                    <td class="text-end fw-5">
                                                        <span class="sentiment d-flex gap-1 justify-content-end">
                                                            <i class="bi bi-star-fill"></i>
                                                            <i class="bi bi-star-fill"></i>
                                                            <i class="bi bi-star"></i>
                                                        </span>
                                                    </td>
                                                    <td class="text-end fw-5">Industrial Production (MoM) (Apr)</td>
                                                    <td class="text-end fw-5 Red">-0.9%</td>
                                                    <td class="text-end fw-5">-0.1%	</td>
                                                    <td class="text-end fw-5">0.2%</td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                                <div class="tab-pane fade show active" id="today_calendar_tab" role="tabpanel" aria-labelledby="today-tab" tabindex="0">
                                    <div class=" overflow-auto market-table-wapper">
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
                                                <tr class="crunt_date">
                                                    <td colspan="7" class="text-center">Wednesday, June 12, 2024</td>
                                                </tr>
                                                <tr>
                                                    <td class="fw-5">01:00</td>
                                                    <td class="text-end fw-5"><span class="flagCur d-flex gap-1 align-items-center justify-content-end"><img src="/build/images/flags/country_2.jpg" alt="flag"> GBP</span></td>
                                                    <td class="text-end fw-5">
                                                        <span class="sentiment d-flex gap-1 justify-content-end">
                                                            <i class="bi bi-star-fill"></i>
                                                            <i class="bi bi-star-fill"></i>
                                                            <i class="bi bi-star"></i>
                                                        </span>
                                                    </td>
                                                    <td class="text-end fw-5">Industrial Production (MoM) (Apr)</td>
                                                    <td class="text-end fw-5 Red">-0.9%</td>
                                                    <td class="text-end fw-5">-0.1%	</td>
                                                    <td class="text-end fw-5">0.2%</td>
                                                </tr>
                                                <tr>
                                                    <td class="fw-5">01:00</td>
                                                    <td class="text-end fw-5"><span class="flagCur d-flex gap-1 align-items-center justify-content-end"><img src="/build/images/flags/country_2.jpg" alt="flag"> GBP</span></td>
                                                    <td class="text-end fw-5">
                                                        <span class="sentiment d-flex gap-1 justify-content-end">
                                                            <i class="bi bi-star-fill"></i>
                                                            <i class="bi bi-star"></i>
                                                            <i class="bi bi-star"></i>
                                                        </span>
                                                    </td>
                                                    <td class="text-end fw-5">U.K. Construction Output (YoY) (Apr)</td>
                                                    <td class="text-end fw-5 Red">-3.3%</td>
                                                    <td class="text-end fw-5 Red negative-arrow-icon-after">-1.8%</td>
                                                    <td class="text-end fw-5">-2.2%</td>
                                                </tr>
                                                <tr>
                                                    <td class="fw-5">01:00</td>
                                                    <td class="text-end fw-5"><span class="flagCur d-flex gap-1 align-items-center justify-content-end"><img src="/build/images/flags/country_2.jpg" alt="flag"> GBP</span></td>
                                                    <td class="text-end fw-5">
                                                        <span class="sentiment d-flex gap-1 justify-content-end">
                                                            <i class="bi bi-star-fill"></i>
                                                            <i class="bi bi-star-fill"></i>
                                                            <i class="bi bi-star-fill"></i>
                                                        </span>
                                                    </td>
                                                    <td class="text-end fw-5">GDP (MoM) (Apr)</td>
                                                    <td class="text-end fw-5">0.0%</td>
                                                    <td class="text-end fw-5">0.0%</td>
                                                    <td class="text-end fw-5">0.4%</td>
                                                </tr>
                                                <tr>
                                                    <td class="fw-5">01:00</td>
                                                    <td class="text-end fw-5"><span class="flagCur d-flex gap-1 align-items-center justify-content-end"><img src="/build/images/flags/country_2.jpg" alt="flag"> GBP</span></td>
                                                    <td class="text-end fw-5">
                                                        <span class="sentiment d-flex gap-1 justify-content-end">
                                                            <i class="bi bi-star-fill"></i>
                                                            <i class="bi bi-star"></i>
                                                            <i class="bi bi-star"></i>
                                                        </span>
                                                    </td>
                                                    <td class="text-end fw-5">	GDP (YoY) (Apr)</td>
                                                    <td class="text-end fw-5">0.6%</td>
                                                    <td class="text-end fw-5">0.6%</td>
                                                    <td class="text-end fw-5">0.7%</td>
                                                </tr>
                                                <tr>
                                                    <td class="fw-5">01:00</td>
                                                    <td class="text-end fw-5"><span class="flagCur d-flex gap-1 align-items-center justify-content-end"><img src="/build/images/flags/country_2.jpg" alt="flag"> GBP</span></td>
                                                    <td class="text-end fw-5">
                                                        <span class="sentiment d-flex gap-1 justify-content-end">
                                                            <i class="bi bi-star-fill"></i>
                                                            <i class="bi bi-star"></i>
                                                            <i class="bi bi-star"></i>
                                                        </span>
                                                    </td>
                                                    <td class="text-end fw-5">Index of Services</td>
                                                    <td class="text-end fw-5 Green">0.9%</td>
                                                    <td class="text-end fw-5">0.8%</td>
                                                    <td class="text-end fw-5">0.7%</td>
                                                </tr>
                                                
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                                <div class="tab-pane fade" id="tomorrow_calendar_tab" role="tabpanel" aria-labelledby="tomorrow-tab" tabindex="0">Tomorrow</div>
                                <div class="tab-pane fade" id="this_week_calendar_tab" role="tabpanel" aria-labelledby="this_week_tab" tabindex="0">This Week</div>
                                <div class="tab-pane fade" id="next_week_calendar_tab" role="tabpanel" aria-labelledby="next_week_tab" tabindex="0">Next Week</div>
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
import Markets from "../widgets/Markets.vue";
import LatestArticles from "../widgets/LatestArticles.vue";
export default {
  components: {
    LatestArticles,
    Markets,
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
      selectedCategories: []
    };
  },
  methods: {
    selectAll() {
      this.selectedCategories = this.categories.map(category => category.value);
    },
    clearAll() {
      this.selectedCategories = [];
    }
  }
};
</script>
