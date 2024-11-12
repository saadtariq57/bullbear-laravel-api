<template>
  <div class="earnings-tab container-fluid tabContentMain">
    <ul class="inner-tabs-btn nav border-0 nav-tabs justify-content-between" id="course-content-tab" role="tablist">
      <li class="nav-item" role="presentation">
        <button
          class="nav-link border-0 fs-6 text-secondary fw-bold active m-auto"
          id="earnings-history-tab"
          data-bs-toggle="tab"
          data-bs-target="#earnings-history-tab-pane"
          type="button"
          role="tab"
          aria-controls="earnings-history-tab-pane"
          aria-selected="true"
        >
          Earnings History
        </button>
      </li>
      <!-- Other tabs can be added here if needed -->
    </ul>
    <div class="tab-content mt-4">
      <div
        class="tab-pane fade show active"
        id="earnings-history-tab-pane"
        role="tabpanel"
        aria-labelledby="earnings-history-tab"
        tabindex="0"
      >
        <div class="container">
          <form>
            <h4 class="fs-6 fw-bold text-black d-flex justify-content-between align-items-center">
              Earnings Trends
              <span class="fs-14 fw-4 d-flex align-items-center gap-3">
                <div class="form-check form-check-inline">
                  <input
                    class="form-check-input"
                    type="radio"
                    name="earnings-trends"
                    id="quarterly"
                    v-model="periodType"
                    value="quarterly"
                  />
                  <label class="form-check-label" for="quarterly">Quarterly</label>
                </div>
                <div class="form-check form-check-inline">
                  <input
                    class="form-check-input"
                    type="radio"
                    name="earnings-trends"
                    id="annual"
                    v-model="periodType"
                    value="annual"
                  />
                  <label class="form-check-label" for="annual">Annual</label>
                </div>
              </span>
            </h4>
          </form>

          <!-- Chart Section -->
          <div class="header-divider mt-3 pt-2">
            <div class="container pt-1">
              <div class="fs-14 fw-5 text-secondary mb-2">Earnings History & Projections</div>
              <div class="row">
                <div class="col-lg-9 col-md-9">
                  <div v-if="!dataLoaded" class="d-flex justify-content-center align-items-center" style="height: 300px;">
                    <div class="spinner-border text-primary" role="status">
                      <span class="visually-hidden">Loading...</span>
                    </div>
                  </div>
                  <div id="earningsChart" v-else style="width: 100%; height: 300px;"></div>
                  <div class="d-flex justify-content-between mt-3 fs-14">
                    <div class="d-flex align-items-center gap-2">
                      <!-- Replaced images with Bootstrap Icons -->
                      <i class="bi bi-circle-fill text-primary"></i>
                      <span>Actuals</span>
                      <i class="bi bi-circle-fill text-info"></i>
                      <span>Estimates</span>
                      <i class="bi bi-arrow-up text-success"></i>
                      <i class="bi bi-arrow-down text-danger"></i>
                      <span>Surprises</span>
                    </div>
                    <div data-bs-toggle="tooltip" title="Hover over the chart to see detailed information">
                      Mouse over chart for more details
                    </div>
                  </div>
                </div>
                <div class="col-lg-3 col-md-3">
                  <div class="card p-3">
                    <p class="fs-14 fw-5 border-bottom mb-2 lh-base" data-bs-toggle="tooltip" title="Latest Earnings Report">
                      {{ latestEarningsText }}
                    </p>
                    <p class="fs-14 fw-5 lh-base">
                      Surprise %: <span>{{ latestSurprisePercentage }}</span><br />
                      Surprise: <span>{{ latestSurprise }}</span>
                    </p>
                  </div>
                </div>
              </div>
            </div>
          </div>

          <!-- Earnings History Table -->
          <h4 class="fs-6 fw-bold text-black mt-4">Earnings History</h4>
          <div class="header-divider mt-1 pt-2">
            <div class="table-responsive">
              <table class="table table-borderless fw-4 fs-14 mb-3">
                <thead>
                  <tr class="border-bottom fs-13">
                    <th data-bs-toggle="tooltip" title="Date of Earnings Report">Date</th>
                    <th data-bs-toggle="tooltip" title="Time of Earnings Announcement">Time</th>
                    <th class="text-end" data-bs-toggle="tooltip" title="Estimated Earnings Per Share">EPS Estimate</th>
                    <th class="text-end" data-bs-toggle="tooltip" title="Actual Earnings Per Share">EPS Actual</th>
                    <th class="text-end" data-bs-toggle="tooltip" title="Surprise Percentage">Surprise</th>
                    <th class="text-end" data-bs-toggle="tooltip" title="Actual Revenue in Millions">Revenue (M)</th>
                    <th class="text-end" data-bs-toggle="tooltip" title="Estimated Revenue in Millions">Revenue Est. (M)</th>
                  </tr>
                </thead>
                <tbody>
                  <tr v-for="earning in paginatedEarnings" :key="earning.id">
                    <td>{{ formatDate(earning.date) }}</td>
                    <td>{{ earning.time }}</td>
                    <td class="text-end">{{ formatNumber(earning.eps_estimate) }}</td>
                    <td class="text-end">{{ formatNumber(earning.eps_actual) }}</td>
                    <td class="text-end" :class="getSurpriseClass(earning)">
                      {{ calculateSurprise(earning) }}
                    </td>
                    <td class="text-end">{{ formatNumber(earning.revenue / 1000000) }}</td>
                    <td class="text-end">{{ formatNumber(earning.revenue_estimated / 1000000) }}</td>
                  </tr>
                </tbody>
              </table>
            </div>
            <!-- Enhanced Pagination Controls -->
            <nav v-if="totalPages > 1" aria-label="Earnings table pagination" class="my-4">
              <ul class="pagination justify-content-center">
                <li class="page-item" :class="{ disabled: currentPage === 1 }">
                  <button class="page-link" @click="goToPage(currentPage - 1)" :disabled="currentPage === 1">
                    Previous
                  </button>
                </li>
                <li
                  class="page-item"
                  v-for="page in limitedPageNumbers"
                  :key="page"
                  :class="{ active: currentPage === page }"
                >
                  <button class="page-link" @click="goToPage(page)">{{ page }}</button>
                </li>
                <li class="page-item" :class="{ disabled: currentPage === totalPages }">
                  <button class="page-link" @click="goToPage(currentPage + 1)" :disabled="currentPage === totalPages">
                    Next
                  </button>
                </li>
              </ul>
            </nav>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import axios from 'axios';
import * as am5 from "@amcharts/amcharts5";
import * as am5xy from "@amcharts/amcharts5/xy";
import am5themes_Animated from "@amcharts/amcharts5/themes/Animated";
import { Tooltip } from 'bootstrap';

export default {
  props: {
    symbol: {
      type: String,
      required: true
    }
  },
  data() {
    return {
      earnings: [],
      periodType: 'annual',
      root: null,
      chart: null,
      xAxis: null,
      actualSeries: null,
      estimateSeries: null,
      dataLoaded: false,
      currentPage: 1,
      itemsPerPage: 10,
      tooltips: []
    };
  },
  computed: {
    sortedEarnings() {
      // Always sort descending to have latest first
      return [...this.earnings].sort((a, b) => new Date(b.date) - new Date(a.date));
    },
    filteredEarnings() {
      const today = new Date();
      const pastEarnings = this.sortedEarnings.filter(earning => new Date(earning.date) <= today);
      if (this.periodType === 'annual') {
        const annualEarnings = {};
        pastEarnings.forEach(earning => {
          const year = new Date(earning.date).getFullYear();
          if (!annualEarnings[year] || new Date(earning.date) > new Date(annualEarnings[year].date)) {
            annualEarnings[year] = earning;
          }
        });
        // Convert to array and sort descending
        return Object.values(annualEarnings).sort((a, b) => new Date(b.date) - new Date(a.date));
      }
      return pastEarnings;
    },
    latestEarnings() {
      return this.filteredEarnings[0] || {};
    },
    latestEarningsText() {
      const { date, eps_actual, eps_estimate } = this.latestEarnings;
      if (!date) return 'No earnings data available.';
      const reportDate = new Date(date);
      const quarter = Math.floor((reportDate.getMonth() + 3) / 3);
      const year = reportDate.getFullYear();
      const beatOrMissed = parseFloat(eps_actual) >= parseFloat(eps_estimate) ? 'beat' : 'missed';
      return `${this.symbol} reported ${quarter}${this.getOrdinal(quarter)} Q${quarter} earnings of $${eps_actual} per share on ${reportDate.toLocaleDateString()}. This ${beatOrMissed} the $${eps_estimate} consensus of analysts.`;
    },
    latestSurprisePercentage() {
      const { eps_actual, eps_estimate } = this.latestEarnings;
      if (!eps_actual || !eps_estimate) return '--';
      const surprise = ((parseFloat(eps_actual) - parseFloat(eps_estimate)) / Math.abs(parseFloat(eps_estimate))) * 100;
      return surprise.toFixed(2) + '%';
    },
    latestSurprise() {
      const { eps_actual, eps_estimate } = this.latestEarnings;
      if (!eps_actual || !eps_estimate) return '--';
      const surprise = parseFloat(eps_actual) - parseFloat(eps_estimate);
      return '$' + surprise.toFixed(2);
    },
    totalPages() {
      return Math.ceil(this.filteredEarnings.length / this.itemsPerPage);
    },
    paginatedEarnings() {
      const start = (this.currentPage - 1) * this.itemsPerPage;
      const end = start + this.itemsPerPage;
      return this.filteredEarnings.slice(start, end);
    },
    limitedPageNumbers() {
      const maxVisiblePages = 5;
      let startPage = Math.max(this.currentPage - Math.floor(maxVisiblePages / 2), 1);
      let endPage = startPage + maxVisiblePages - 1;

      if (endPage > this.totalPages) {
        endPage = this.totalPages;
        startPage = Math.max(endPage - maxVisiblePages + 1, 1);
      }

      const pages = [];
      for (let i = startPage; i <= endPage; i++) {
        pages.push(i);
      }
      return pages;
    }
  },
  methods: {
    async fetchEarningsData() {
      try {
        const baseUrl = import.meta.env.VITE_SYMBOL_LOOKUP_API;
        const response = await axios.get(`${baseUrl}/earnings/${this.symbol}`);
        const fetchedEarnings = Array.isArray(response.data) ? response.data : [];
        // Filter out future earnings
        const today = new Date();
        this.earnings = fetchedEarnings.filter(earning => new Date(earning.date) <= today);
        this.dataLoaded = true;
        this.$nextTick(() => {
          this.initChart();
          this.updateChart();
          this.initializeTooltips();
        });
      } catch (error) {
        console.error('Error fetching earnings data:', error);
      }
    },
    formatDate(dateString) {
      return new Date(dateString).toLocaleDateString('en-US', { year: 'numeric', month: 'short', day: 'numeric' });
    },
    formatNumber(num) {
      return num !== null && num !== undefined ? Number(num).toFixed(2) : '-';
    },
    calculateSurprise(earning) {
      if (earning.eps_actual && earning.eps_estimate) {
        const surprise = ((earning.eps_actual - earning.eps_estimate) / Math.abs(earning.eps_estimate)) * 100;
        return surprise.toFixed(2) + '%';
      }
      return '-';
    },
    getSurpriseClass(earning) {
      if (earning.eps_actual && earning.eps_estimate) {
        return earning.eps_actual > earning.eps_estimate ? 'text-success' : 'text-danger';
      }
      return '';
    },
    getOrdinal(n) {
      const s = ["th", "st", "nd", "rd"];
      const v = n % 100;
      return (s[(v - 20) % 10] || s[v] || s[0]);
    },
    initChart() {
      if (!document.getElementById("earningsChart")) {
        console.error("Chart container not found");
        return;
      }

      // Dispose existing chart if any
      if (this.root) {
        this.root.dispose();
      }

      let root = am5.Root.new("earningsChart");
      root.setThemes([am5themes_Animated.new(root)]);

      let chart = root.container.children.push(
        am5xy.XYChart.new(root, {
          panX: true,
          panY: true,
          paddingLeft: 0,
          layout: root.verticalLayout
        })
      );

      // X Axis
      let xRenderer = am5xy.AxisRendererX.new(root, {
        minGridDistance: 30,
        tooltip: am5.Tooltip.new(root, {})
      });
      let xAxis = chart.xAxes.push(
        am5xy.CategoryAxis.new(root, {
          categoryField: "date",
          renderer: xRenderer,
          tooltip: am5.Tooltip.new(root, {})
        })
      );
      xRenderer.labels.template.setAll({
        rotation: 45,
        centerY: am5.p50,
        centerX: am5.p100,
        paddingRight: 15
      });
      xRenderer.grid.template.setAll({
        location: 1,
        strokeOpacity: 0,
      });

      // Y Axis
      let yRenderer = am5xy.AxisRendererY.new(root, {});
      yRenderer.grid.template.set("strokeDasharray", [3]);
      let yAxis = chart.yAxes.push(
        am5xy.ValueAxis.new(root, {
          min: 0,
          extraMax: 0.1,
          renderer: yRenderer,
          numberFormat: "$#.##",
        })
      );
      yAxis.children.push(
        am5.Label.new(root, {
          text: "Earnings Per Share",
          rotation: -90,
          y: am5.p50,
          centerX: am5.p50,
        })
      );

      // Create series
      function createSeries(name, field, color) {
        let series = chart.series.push(
          am5xy.ColumnSeries.new(root, {
            name: name,
            xAxis: xAxis,
            yAxis: yAxis,
            valueYField: field,
            categoryXField: "date",
            tooltip: am5.Tooltip.new(root, {
              pointerOrientation: "horizontal",
              labelText: "{name} in {categoryX}: ${valueY}"
            }),
            fill: color,
            stroke: color,
          })
        );

        series.columns.template.setAll({
          tooltipY: am5.percent(10),
          templateField: "columnSettings",
        });

        // Add arrows to columns based on surprise
        series.columns.template.adapters.add("fill", function(fill, target) {
          const dataItem = target.dataItem;
          if (dataItem) {
            const surprise = dataItem.dataContext.eps_actual - dataItem.dataContext.eps_estimate;
            if (surprise > 0) {
              target.states.create("hover", {});
              target.set("fill", am5.color(0x28a745)); // Green for positive surprise
            } else if (surprise < 0) {
              target.set("fill", am5.color(0xdc3545)); // Red for negative surprise
            }
          }
          return fill;
        });

        return series;
      }

      let actualSeries = createSeries("Actual", "eps_actual", am5.color(0x4682B4));
      let estimateSeries = createSeries("Estimate", "eps_estimate", am5.color(0x87CEFA));

      // Add legend
      let legend = chart.children.push(
        am5.Legend.new(root, {
          centerX: am5.p50,
          x: am5.p50,
        })
      );
      legend.data.setAll(chart.series.values);

      // Add cursor
      chart.set("cursor", am5xy.XYCursor.new(root, {
        behavior: "zoomX"
      }));

      this.root = root;
      this.chart = chart;
      this.xAxis = xAxis;
      this.actualSeries = actualSeries;
      this.estimateSeries = estimateSeries;
    },
    updateChart() {
      if (this.chart && this.actualSeries && this.estimateSeries) {
        const formattedData = this.filteredEarnings.map(earning => ({
          date: this.formatDate(earning.date),
          eps_actual: parseFloat(earning.eps_actual),
          eps_estimate: parseFloat(earning.eps_estimate),
          columnSettings: {
            fillOpacity: earning.eps_actual > earning.eps_estimate ? 0.9 : 0.6,
          }
        }));

        this.xAxis.data.setAll(formattedData);
        this.actualSeries.data.setAll(formattedData);
        this.estimateSeries.data.setAll(formattedData);

        // Make series appear animation
        this.actualSeries.appear(1000, 100);
        this.estimateSeries.appear(1000, 100);
      }
    },
    goToPage(page) {
      if (page < 1) return;
      if (page > this.totalPages) return;
      this.currentPage = page;
      this.$nextTick(() => {
        this.initializeTooltips();
      });
    },
    initializeTooltips() {
      // Dispose existing tooltips
      this.tooltips.forEach(tooltip => tooltip.dispose());
      this.tooltips = [];

      // Initialize new tooltips
      const tooltipElements = document.querySelectorAll('[data-bs-toggle="tooltip"]');
      tooltipElements.forEach(el => {
        const tooltip = new Tooltip(el);
        this.tooltips.push(tooltip);
      });
    }
  },
  watch: {
    periodType() {
      this.currentPage = 1; // Reset to first page on period change
      this.$nextTick(() => {
        this.updateChart();
        this.initializeTooltips();
      });
    },
    filteredEarnings() {
      this.$nextTick(() => {
        this.updateChart();
        this.initializeTooltips();
      });
    }
  },
  mounted() {
    this.fetchEarningsData();
  },
  beforeUnmount() {
    if (this.root) {
      this.root.dispose();
    }
    // Dispose all tooltips
    this.tooltips.forEach(tooltip => tooltip.dispose());
  },
};
</script>

<style scoped>
.text-success {
  color: green;
}
.text-danger {
  color: red;
}
/* Add some spacing above and below pagination */
.pagination {
  margin-top: 1rem;
  margin-bottom: 1rem;
}
</style>