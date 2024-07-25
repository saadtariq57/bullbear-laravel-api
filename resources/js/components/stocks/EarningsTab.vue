<template>
  <div class="mt-4">
    <ul class="inner-tabs-btn nav border-0 nav-tabs justify-content-between" id="course-content-tab" role="tablist">
      <li class="nav-item" role="presentation">
        <button class="nav-link border-0 fs-6 text-secondary fw-bold active m-auto" id="earnings-history-tab" data-bs-toggle="tab" data-bs-target="#earnings-history-tab-pane" type="button" role="tab" aria-controls="earnings-history-tab-pane" aria-selected="true">
          Earnings History
        </button>
      </li>
      <!-- Other tabs can be added here if needed -->
    </ul>
    <div class="tab-content mt-4">
      <div class="tab-pane fade show active" id="earnings-history-tab-pane" role="tabpanel" aria-labelledby="earnings-history-tab" tabindex="0">
        <div class="container">
          <form action="">
            <h4 class="fs-6 fw-bold text-black">
              Earnings Trends
              <span class="ps-2 fs-14 fw-4">
                <input type="radio" name="earnings-trends" id="quarterly" v-model="periodType" value="quarterly" checked>
                <label for="quarterly">quarterly</label>
                <input type="radio" name="earnings-trends" id="annual" v-model="periodType" value="annual">
                <label for="annual">annual</label>
              </span>
            </h4>
          </form>
          <div class="header-divider mt-1 pt-2">
            <div class="container pt-1">
              <div class="fs-14 fw-5 text-secondary">
                <span>Earnings History & Projections</span>
              </div>
              <div class="row pt-1">
                <div class="col-lg-9 col-md-9">
                  <div id="earningsChart" v-if="dataLoaded" style="width: 100%; height: 300px;"></div>
                  <div class="d-flex justify-content-between mt-3 fs-14">
                    <div class="d-flex">
                      <div>
                        <img src="https://thomson.cache.wallst.com/img/blueChtKey.gif" alt="">
                        Actuals
                      </div>
                      <div class="px-2">
                        <img src="https://thomson.cache.wallst.com/img/ltblueChtKey.gif" alt="">
                        Estimates
                      </div>
                      <div>
                        <img src="https://thomson.cache.wallst.com/img/quoteUp.gif" alt="">
                        <img src="https://thomson.cache.wallst.com/img/quoteDown.gif" alt="">
                        Surprises
                      </div>
                    </div>
                    <div>Mouse over chart for more details</div>
                  </div>
                </div>
                <div class="col-lg-3 col-md-3">
                  <div>
                    <p class="fs-14 fw-5 border-bottom mb-2 lh-base">
                      {{ latestEarningsText }}
                    </p>
                    <p class="fs-14 fw-5 lh-base">
                      Surprise %: <span>{{ latestSurprisePercentage }}</span><br>
                      Surprise: <span>{{ latestSurprise }}</span>
                    </p>
                  </div>
                </div>
              </div>
            </div>
          </div>
        <h4 class="fs-6 fw-bold text-black">Earnings History</h4>
          <div class="header-divider mt-1 pt-2">
            <table class="table table-borderless fw-4 fs-14 mb-3">
              <thead>
                <tr class="border-bottom fs-13">
                  <th>Date</th>
                  <th>Time</th>
                  <th class="text-end">EPS Estimate</th>
                  <th class="text-end">EPS Actual</th>
                  <th class="text-end">Surprise</th>
                  <th class="text-end">Revenue (M)</th>
                  <th class="text-end">Revenue Est. (M)</th>
                </tr>
              </thead>
              <tbody>
                <tr v-for="earning in sortedEarnings" :key="earning.id">
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
        periodType: 'quarterly',
        root: null,
        chart: null,
        xAxis: null,
        actualSeries: null,
        estimateSeries: null,
        dataLoaded: false,
    };
  },
  computed: {
    sortedEarnings() {
      return [...this.earnings].sort((a, b) => new Date(b.date) - new Date(a.date));
    },
    filteredEarnings() {
      if (this.periodType === 'annual') {
        const annualEarnings = {};
        this.sortedEarnings.forEach(earning => {
          const year = new Date(earning.date).getFullYear();
          if (!annualEarnings[year] || new Date(earning.date) > new Date(annualEarnings[year].date)) {
            annualEarnings[year] = earning;
          }
        });
        return Object.values(annualEarnings);
      }
      return this.sortedEarnings;
    },
    latestEarnings() {
      return this.filteredEarnings[0] || {};
    },
    latestEarningsText() {
      const { date, eps_actual, eps_estimate } = this.latestEarnings;
      if (!date) return '';
      const reportDate = new Date(date);
      const quarter = Math.floor((reportDate.getMonth() + 3) / 3);
      const year = reportDate.getFullYear();
      const beatOrMissed = parseFloat(eps_actual) >= parseFloat(eps_estimate) ? 'beat' : 'missed';
      return `A reported ${quarter}${this.getOrdinal(quarter)} qtr ${year} earnings of $${eps_actual} per share on ${reportDate.toLocaleDateString()}. This ${beatOrMissed} the $${eps_estimate} consensus of the analysts covering the company.`;
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
  },
  methods: {
    async fetchEarningsData() {
      try {
        const baseUrl = import.meta.env.VITE_SYMBOL_LOOKUP_API;
        const response = await axios.get(`${baseUrl}/earnings/${this.symbol}`);
        this.earnings = Array.isArray(response.data) ? response.data : [];
        this.dataLoaded = true;
        this.$nextTick(() => {
          this.initChart();
          this.updateChart();
        });
      } catch (error) {
        console.error('Error fetching earnings data:', error);
      }
    },
    formatDate(dateString) {
      return new Date(dateString).toLocaleDateString('en-US', { year: 'numeric', month: 'short', day: 'numeric' });
    },
    formatNumber(num) {
      return num ? Number(num).toFixed(2) : '-';
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
        minorGridEnabled: false,
        minGridDistance: 30,
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
  },
  watch: {
    periodType() {
      this.$nextTick(() => {
        this.updateChart();
      });
    },
  },
  mounted() {
    this.fetchEarningsData();
  },
  beforeUnmount() {
      if (this.root) {
        this.root.dispose();
      }
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
</style>