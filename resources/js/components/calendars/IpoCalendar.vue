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
                            <tr v-for="event in filteredIpoEvents[tabName]" :key="event.id">
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
                        <button v-if="pagination[tabName]?.hasMore && filteredIpoEvents[tabName] && filteredIpoEvents[tabName].length" 
                                class="btn btn-primary" 
                                :disabled="isLoadingMore[tabName]"
                                @click="showMore(tabName)">
                          <span v-if="isLoadingMore[tabName]">Loading...</span>
                          <span v-else>Show More</span>
                        </button>
                        <button v-if="pagination[tabName]?.page > 1" 
                                class="btn btn-border" 
                                :disabled="isLoading[tabName]"
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

const createPaginationState = () => ({
  page: 1,
  nextPage: 2,
  hasMore: true,
  chunkStart: null,
  chunkEnd: null,
});

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
      activeTab: 'recent',
      tabNames: ['upcoming', 'recent'],
      loadedTabs: new Set(),
      selectedIpoType: 'all',
      contentLoaded: false,
      chunkDays: 10,
      pagination: {
        upcoming: createPaginationState(),
        recent: createPaginationState()
      },
      isLoading: {
        upcoming: false,
        recent: false
      },
      isLoadingMore: {
        upcoming: false,
        recent: false
      },
    };
  },
  methods: {
    async fetchIpoCalendar(tabName, options = {}) {
      const { page = 1, append = false, force = false } = options;

      if (!append && !force && this.loadedTabs.has(tabName)) return;

      const { startDate, endDate } = this.buildDateRange(tabName);
      const params = new URLSearchParams({
        startDate: this.formatDateParam(startDate),
        endDate: this.formatDateParam(endDate),
        page,
        chunkDays: this.chunkDays,
      });

      const loadingKey = append ? 'isLoadingMore' : 'isLoading';
      this[loadingKey][tabName] = true;

      try {
        const response = await axios.get(`/api/calendar/ipo?${params.toString()}`);
        const payload = response.data;
        const events = Array.isArray(payload) ? payload : (payload.data || []);

        if (append) {
          this.ipoEvents[tabName] = [...this.ipoEvents[tabName], ...events];
        } else {
          this.ipoEvents[tabName] = events;
        }

        this.updatePagination(tabName, payload.pagination, page);
        this.filterIpoEvents();

        if (!append) {
          this.loadedTabs.add(tabName);
        }
      } catch (error) {
        console.error(`Error fetching IPO calendar for ${tabName}:`, error);
        if (!append) {
          this.ipoEvents[tabName] = [];
          this.filteredIpoEvents[tabName] = [];
          this.pagination[tabName] = createPaginationState();
          this.loadedTabs.add(tabName);
        }
      } finally {
        this[loadingKey][tabName] = false;
      }
    },
    buildDateRange(tabName) {
      const today = new Date();
      let startDate;
      let endDate;

      if (tabName === 'upcoming') {
        startDate = today;
        endDate = new Date(today);
        endDate.setDate(today.getDate() + 30);
      } else {
        endDate = today;
        startDate = new Date(today);
        startDate.setDate(today.getDate() - 30);
      }

      return { startDate, endDate };
    },
    formatDateParam(date) {
      return date.toISOString().split('T')[0];
    },
    updatePagination(tabName, paginationMeta, fallbackPage = 1) {
      const currentState = this.pagination[tabName] || createPaginationState();

      const pageValue = paginationMeta?.page ?? fallbackPage ?? 1;
      const hasMore = paginationMeta?.has_more ?? false;
      const nextPage = paginationMeta?.next_page ?? (hasMore ? pageValue + 1 : null);

      this.pagination[tabName] = {
        ...currentState,
        page: pageValue,
        nextPage,
        hasMore,
        chunkStart: paginationMeta?.chunk_start ?? null,
        chunkEnd: paginationMeta?.chunk_end ?? null,
      };
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
    async showMore(tabName) {
      const paginationState = this.pagination[tabName];
      if (!paginationState?.hasMore || this.isLoadingMore[tabName]) {
        return;
      }

      const nextPage = paginationState.nextPage ?? (paginationState.page + 1);
      await this.fetchIpoCalendar(tabName, { page: nextPage, append: true, force: true });
    },
    async showLess(tabName) {
      if (this.isLoading[tabName]) {
        return;
      }

      this.pagination[tabName] = createPaginationState();
      this.ipoEvents[tabName] = [];
      this.filteredIpoEvents[tabName] = [];
      this.loadedTabs.delete(tabName);

      await this.fetchIpoCalendar(tabName, { page: 1, force: true });
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
        const events = this.ipoEvents[tabName] || [];
        this.filteredIpoEvents[tabName] = this.selectedIpoType === 'all'
          ? events
          : events.filter(event => event.ipo_type === this.selectedIpoType);
      }
    }
  },
  mounted() {
    this.fetchIpoCalendar(this.activeTab);
    this.contentLoaded = true;
  }
};
</script>
