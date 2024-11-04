<template>
  <div id="chartcontrols" class="chart-controls">
    <div class="period-selector">
      <button
        v-for="period in availablePeriods"
        :key="period.name"
        :class="{ active: currentRange === period.name }"
        @click="selectPeriod(period.name)"
        :disabled="isloading"
      >
        {{ period.name }}
      </button>
    </div>

    <div class="interval-selector">
      <select v-model="currentInterval" @change="selectInterval" :disabled="isloading">
        <option
          v-for="interval in availableIntervals"
          :key="interval.id"
          :value="interval.id"
        >
          {{ interval.label }}
        </option>
      </select>
    </div>
  </div>
  
    <div style="position: relative; width: 100%; height: 500px;">
        <ChartSkeleton v-if="isloading" />
        <div ref="chartdiv" style="width: 100%; height: 500px;" v-show="!isloading"></div>
  </div>
</template>

<script>
import * as am5 from "@amcharts/amcharts5";
import * as am5xy from "@amcharts/amcharts5/xy";
import am5themes_Animated from "@amcharts/amcharts5/themes/Animated";
import * as am5stock from "@amcharts/amcharts5/stock";
import * as am5plugins_exporting from "@amcharts/amcharts5/plugins/exporting";
import axios from 'axios';
import ChartSkeleton from './ChartSkeleton.vue'; 

export default {
  props: {
    symbol: {
      type: String,
      required: true
    }
  },
  components: {
    ChartSkeleton
  },
  data() {
    return {
      chartdata: [],
      rawChartData: [],
      isloading: false,
      exporting: null,
      currentRange: '1D',
      currentInterval: '1min',
      availablePeriods: [
        { timeUnit: "day", count: 1, name: "1D" },
        { timeUnit: "day", count: 5, name: "5D" },
        { timeUnit: "month", count: 1, name: "1M" },
        { timeUnit: "month", count: 3, name: "3M" },
        { timeUnit: "month", count: 6, name: "6M" },
        { timeUnit: "ytd", name: "YTD" },
        { timeUnit: "year", count: 1, name: "1Y" },
        { timeUnit: "year", count: 5, name: "Max" }
      ],
      periodIntervalMapping: {
        '1D': ['1min', '5min', '10min', '15min', '30min', '1h'],
        '5D': ['5min', '10min', '15min', '30min', '1h'],
        '1M': ['1D', '1W'],
        '3M': ['1D', '1W', '1Mo'],
        '6M': ['1D', '1W', '1Mo'],
        'YTD': ['1D', '1W', '1Mo'],
        '1Y': ['1D', '1W', '1Mo'],
        'Max': ['1Mo']
      },
      intervalMapping: {
        '1min': { id: "1min", label: "1 Min", interval: { timeUnit: "minute", count: 1 } },
        '5min': { id: "5min", label: "5 Min", interval: { timeUnit: "minute", count: 5 } },
        '10min': { id: "10min", label: "10 Min", interval: { timeUnit: "minute", count: 10 } },
        '15min': { id: "15min", label: "15 Min", interval: { timeUnit: "minute", count: 15 } },
        '30min': { id: "30min", label: "30 Min", interval: { timeUnit: "minute", count: 30 } },
        '1h': { id: "1h", label: "1 Hour", interval: { timeUnit: "hour", count: 1 } },
        '1D': { id: "1D", label: "1 Day", interval: { timeUnit: "day", count: 1 } },
        '1W': { id: "1W", label: "1 Week", interval: { timeUnit: "week", count: 1 } },
        '1Mo': { id: "1Mo", label: "1 Month", interval: { timeUnit: "month", count: 1 } },
      },
      availableIntervals: []
    };
  },
  mounted() {
    //console.log('[ohlc] component mounted');
    this.$nextTick(() => {
      this.updateAvailableIntervals();
      this.fetchohlcdata(this.currentRange, this.currentInterval);
    });
  },
  created() {
    this.root = null;
  },
  methods: {
    /**
     * Fetches OHLC data based on the selected range and interval.
     * Determines the API endpoint based on the range.
     */
    async fetchohlcdata(range = '1D', interval = '1min') {
      //console.log(`[ohlc] fetching ohlc data for symbol: ${this.symbol}, range: ${range}, interval: ${interval}`);
      
      if (this.isloading) {
        //console.log('[ohlc] data fetch already in progress, skipping');
        return;
      }
      this.isloading = true;
      
      try {
        // Define ranges that use intraday data
        const intradayRanges = ['1D', '5D'];
        
        // Determine if the selected range requires intraday data
        const isIntraday = intradayRanges.includes(range);
        
        // Set the appropriate API endpoint and parameters
        const apiEndpoint = isIntraday ? `/api/ohlc-data/intraday/${this.symbol}` : `/api/ohlc-data/daily/${this.symbol}`;
        const params = { range };
        
        if (isIntraday) {
          params.interval = interval;
        }
        
        const response = await axios.get(apiEndpoint, { params });
        
        //console.log(`[ohlc] data received for ${this.symbol}:`, response.data.length, 'items');
        let fetchedData = response.data.map(item => ({
          date: new Date(item.date).getTime(),
          open: Number(item.open),
          high: Number(item.high),
          low: Number(item.low),
          close: Number(item.close),
          volume: Number(item.volume)
        })).sort((a, b) => a.date - b.date);
        
        //console.log('[ohlc] processed chart data:', fetchedData.length, 'items');
        
        // If the data is daily and the user selected a higher interval, aggregate it
        if (!isIntraday && ['1W', '1Mo'].includes(interval)) {
          fetchedData = this.processDataForInterval(fetchedData, interval);
          //console.log('[ohlc] aggregated chart data:', fetchedData.length, 'items');
        }
        
        this.rawChartData = fetchedData;
        this.chartdata = fetchedData;
        
        // Dispose existing chart if it exists
        if (this.root) {
          //console.log('[ohlc] disposing existing chart');
          this.root.dispose();
          this.root = null;
        }
        
        // Initialize a new chart with the new data
        //console.log(this.root);
        this.initchart();
        
      } catch (error) {
        console.error('[ohlc] error fetching ohlc data:', error);
        this.errorMessage = 'Failed to load data. Please try again later.';
      } finally {
        this.isloading = false;
      }
    },

    /**
     * Validates the received chart data.
     */
    validatedata(data) {
      //console.log('[ohlc] validating data:', data.length, 'items');
      if (!Array.isArray(data) || data.length === 0) {
        console.error('[ohlc] data validation failed: not an array or empty');
        return false;
      }
      const requiredfields = ['date', 'open', 'high', 'low', 'close', 'volume'];
      const isvalid = data.every(item => requiredfields.every(field => item[field] != null && !isNaN(item[field])));
      //console.log('[ohlc] data validation result:', isvalid);
      return isvalid;
    },

    /**
     * Initializes the amCharts chart.
     */
    initchart() {
      //console.log('[ohlc] initializing chart');
      
      if (!this.$refs.chartdiv) {
        console.error("[ohlc] chart div not found");
        return;
      }

      if (!this.validatedata(this.chartdata)) {
        console.error("[ohlc] invalid chart data");
        return;
      }

      // Create a new root for the chart
      //console.log('[ohlc] creating new root');
      let root = am5.Root.new(this.$refs.chartdiv);
      this.root = root;
      //console.log('[ohlc] new root initialized:', this.root);
      const myTheme = am5.Theme.new(root);
      myTheme.rule("Grid", ["scrollbar", "minor"]).setAll({
        visible: false
      });

      root.setThemes([
        am5themes_Animated.new(root),
        myTheme
      ]);
      

      // Create a stock chart
      let stockChart = root.container.children.push(am5stock.StockChart.new(root, {
        stockPositiveColor: am5.color(0x19cd5f),
        stockNegativeColor: am5.color(0xf82d65),
        volumePositiveColor: am5.color(0x19cd5f),
        volumeNegativeColor: am5.color(0xf82d65)
      }));

      // Set global number format
      root.numberFormatter.set("numberFormat", "#,###.00");

      // Create a main stock panel (chart)
      let mainPanel = stockChart.panels.push(am5stock.StockPanel.new(root, {
        wheelY: "zoomX",
        panX: true,
        panY: true,
      }));

      // Create value axis
      let valueAxis = mainPanel.yAxes.push(am5xy.ValueAxis.new(root, {
        renderer: am5xy.AxisRendererY.new(root, {
          pan: "zoom",
          opposite:false
        }),
        extraMin: 0.1,
        tooltip: am5.Tooltip.new(root, {}),
        numberFormat: "#,###.00",
        extraTooltipPrecision: 2
      }));

      valueAxis.children.moveValue(am5.Label.new(root, { 
        text: "Price", 
        rotation: -90, 
        x: 0,
        y: am5.p50, 
        centerX: am5.p50,
        fill: am5.color(0x252f4a),
        fontSize: 12,
      }), 0);

      // Create date axis with dynamic baseInterval
      let dateAxis = mainPanel.xAxes.push(am5xy.GaplessDateAxis.new(root, {
        baseInterval: this.intervalMapping[this.currentInterval].interval,
        renderer: am5xy.AxisRendererX.new(root, {
          minorGridEnabled: true
        }),
        tooltip: am5.Tooltip.new(root, {})
      }));

      dateAxis.get("renderer").grid.template.set("strokeDasharray", [5]);
      dateAxis.get("renderer").grid.template.set("stroke", am5.color(0x252f4a));
      valueAxis.get("renderer").grid.template.set("strokeDasharray", [5]);
      valueAxis.get("renderer").grid.template.set("stroke", am5.color(0x252f4a));
      // Add candlestick series
      let valueSeries = mainPanel.series.push(am5xy.CandlestickSeries.new(root, {
        name: this.symbol,
        clustered: false,
        valueXField: "date",
        valueYField: "close",
        highValueYField: "high",
        lowValueYField: "low",
        openValueYField: "open",
        calculateAggregates: true,
        xAxis: dateAxis,
        yAxis: valueAxis,
        legendValueText: "open: [bold]{openValueY}[/] high: [bold]{highValueY}[/] low: [bold]{lowValueY}[/] close: [bold]{valueY}[/]",
        legendRangeValueText: ""
      }));

      // Set main value series
      stockChart.set("stockSeries", valueSeries);

      // Add a stock legend
      let valueLegend = mainPanel.plotContainer.children.push(am5stock.StockLegend.new(root, {
        stockChart: stockChart
      }));

      // Create volume axis
      let volumeAxisRenderer = am5xy.AxisRendererY.new(root, {});
      volumeAxisRenderer.labels.template.set("forceHidden", true);
      volumeAxisRenderer.grid.template.set("forceHidden", true);

      let volumeValueAxis = mainPanel.yAxes.push(am5xy.ValueAxis.new(root, {
        numberFormat: "#.#a",
        height: am5.percent(20),
        y: am5.percent(100),
        centerY: am5.percent(100),
        renderer: volumeAxisRenderer
      }));

      // Add volume series
      let volumeSeries = mainPanel.series.push(am5xy.ColumnSeries.new(root, {
        name: "Volume",
        clustered: false,
        valueXField: "date",
        valueYField: "volume",
        xAxis: dateAxis,
        yAxis: volumeValueAxis,
        legendValueText: "[bold]{valueY.formatNumber('#,###.0a')}[/]"
      }));

      volumeSeries.columns.template.setAll({
        strokeOpacity: 0,
        fillOpacity: 0.5
      });

      // Color columns by stock rules
      volumeSeries.columns.template.adapters.add("fill", function(fill, target) {
        let dataItem = target.dataItem;
        if (dataItem) {
          return stockChart.getVolumeColor(dataItem);
        }
        return fill;
      });

      // Set main series
      stockChart.set("volumeSeries", volumeSeries);
      valueLegend.data.setAll([valueSeries, volumeSeries]);

      // Add cursor
      mainPanel.set("cursor", am5xy.XYCursor.new(root, {
        yAxis: valueAxis,
        xAxis: dateAxis,
        snapToSeries: [valueSeries],
        snapToSeriesBy: "y!"
      }));

      // Add scrollbar
      let scrollbar = mainPanel.set("scrollbarX", am5xy.XYChartScrollbar.new(root, {
        orientation: "horizontal",
        height: 50
      }));
      stockChart.toolsContainer.children.push(scrollbar);

      let sbDateAxis = scrollbar.chart.xAxes.push(am5xy.GaplessDateAxis.new(root, {
        baseInterval: this.intervalMapping[this.currentInterval].interval,
        renderer: am5xy.AxisRendererX.new(root, {
          minorGridEnabled: true
        })
      }));

      let sbValueAxis = scrollbar.chart.yAxes.push(am5xy.ValueAxis.new(root, {
        renderer: am5xy.AxisRendererY.new(root, {})
      }));

      let sbSeries = scrollbar.chart.series.push(am5xy.LineSeries.new(root, {
        valueYField: "close",
        valueXField: "date",
        xAxis: sbDateAxis,
        yAxis: sbValueAxis
      }));

      sbSeries.fills.template.setAll({
        visible: true,
        fillOpacity: 0.3
      });

      // Set up series type switcher
      let seriesSwitcher = am5stock.SeriesTypeControl.new(root, {
        stockChart: stockChart
      });

      seriesSwitcher.events.on("selected", function(ev) {
        setSeriesType(ev.item.id);
      });

      function getNewSettings(series) {
        let newSettings = {};
        ["name", "valueYField", "highValueYField", "lowValueYField", "openValueYField", "calculateAggregates", "valueXField", "xAxis", "yAxis", "legendValueText", "legendRangeValueText", "stroke", "fill"].forEach(setting => {
          newSettings[setting] = series.get(setting);
        });
        return newSettings;
      }

      function setSeriesType(seriesType) {
        // Get current series and its settings
        let currentSeries = stockChart.get("stockSeries");
        let newSettings = getNewSettings(currentSeries);

        // Remove previous series
        let data = currentSeries.data.values;
        mainPanel.series.removeValue(currentSeries);

        // Create new series
        let series;
        switch (seriesType) {
          case "line":
            series = mainPanel.series.push(am5xy.LineSeries.new(root, newSettings));
            break;
          case "candlestick":
          case "procandlestick":
            newSettings.clustered = false;
            series = mainPanel.series.push(am5xy.CandlestickSeries.new(root, newSettings));
            if (seriesType == "procandlestick") {
              series.columns.template.get("themeTags").push("pro");
            }
            break;
          case "ohlc":
            newSettings.clustered = false;
            series = mainPanel.series.push(am5xy.OHLCSeries.new(root, newSettings));
            break;
        }

        // Set new series as stockSeries
        if (series) {
          valueLegend.data.removeValue(currentSeries);
          series.data.setAll(data);
          stockChart.set("stockSeries", series);
          let cursor = mainPanel.get("cursor");
          if (cursor) {
            cursor.set("snapToSeries", [series]);
          }
          valueLegend.data.insertIndex(0, series);
        }
      }

      // Function to map intervalId to label and interval object
      const mapInterval = (intervalId) => {
        return this.intervalMapping[intervalId] || null;
      };

      // Function to update IntervalSwitcher based on selected period
      const updateAvailableIntervals = () => {
        const intervalIds = this.periodIntervalMapping[this.currentRange] || [];
        this.availableIntervals = intervalIds.map(id => mapInterval(id)).filter(item => item !== null);
        
        // If currentInterval is not available in the new set, reset it
        if (!this.availableIntervals.find(item => item.id === this.currentInterval)) {
          this.currentInterval = this.availableIntervals.length > 0 ? this.availableIntervals[0].id : '1min';
        }
      };

      // Initialize available intervals
      updateAvailableIntervals();

      let toolbar = am5stock.StockToolbar.new(root, {
        container: document.getElementById("chartcontrols"),
        stockChart: stockChart,
        controls: [
          am5stock.IndicatorControl.new(root, {
            stockChart: stockChart,
            legend: valueLegend
          }),
          seriesSwitcher,
          am5stock.DrawingControl.new(root, {
            stockChart: stockChart
          }),
          am5stock.ResetControl.new(root, {
            stockChart: stockChart
          }),
          am5stock.SettingsControl.new(root, {
            stockChart: stockChart
          })
        ]
      });

      // Set chart data
      //console.log('[ohlc] setting chart data');
      valueSeries.data.setAll(this.chartdata);
      volumeSeries.data.setAll(this.chartdata);
      sbSeries.data.setAll(this.chartdata);

      //console.log('[ohlc] chart initialization complete');
      //console.log('[ohlc] first few data points:', this.chartdata.slice(0, 5));
      this.exporting = am5plugins_exporting.Exporting.new(this.root, {
        title: 'Stock Chart',
        filePrefix: "stock-chart",
        jpgOptions: { disabled: false },
        pngOptions: { disabled: true },
        xlsxOptions: { disabled: true },
        csvOptions: { disabled: true },
        jsonOptions: { disabled: true },
        htmlOptions: { disabled: true },
        pdfdataOptions: { disabled: true },
        pdfOptions: { disabled: true },
        printOptions: { disabled: true },
        dataSource: this.chartdata
      });
    },

    exportChart() {
      if (this.exporting) {
        this.exporting.exportImage("jpg", { maintainPixelRatio: true })
          .then((dataURL) => {
            const fileName = `${this.symbol}-chart-richtv.jpg`;
            this.downloadAllFiles(dataURL, fileName);
          })
          .catch((error) => {
            console.error('[OHLCChart] Export Image error:', error);
          });
      } else {
        console.warn('[OHLCChart] Exporting plugin not initialized.');
      }
    },

    downloadAllFiles(dataURL, fileName) {
      const link = document.createElement("a");
      link.href = dataURL;
      link.download = fileName;
      document.body.appendChild(link);
      link.click();
      document.body.removeChild(link);
    },

    /**
     * Aggregates daily data into weekly data
     */
    aggregateWeekly(data) {
      const aggregated = [];
      let weekData = null;
      let weekStart = null;
      
      data.forEach(item => {
        const date = new Date(item.date);
        const day = date.getDay();
        if (day === 1 && weekData) {
          aggregated.push(weekData);
          weekData = { 
            date: date.getTime(), 
            open: item.open, 
            high: item.high, 
            low: item.low, 
            close: item.close, 
            volume: item.volume 
          };
        } else {
          if (!weekData) {
            weekData = { 
              date: item.date,
              open: item.open, 
              high: item.high, 
              low: item.low, 
              close: item.close, 
              volume: item.volume 
            };
          } else {
            weekData.high = Math.max(weekData.high, item.high);
            weekData.low = Math.min(weekData.low, item.low);
            weekData.close = item.close;
            weekData.volume += item.volume;
          }
        }
      });
      
      if (weekData) {
        aggregated.push(weekData);
      }
      
      return aggregated;
    },
    
    /**
     * Aggregates daily data into monthly data
     */
    aggregateMonthly(data) {
      const aggregated = [];
      let monthData = null;
      let currentMonth = null;
      
      data.forEach(item => {
        const date = new Date(item.date);
        const month = date.getMonth(); // 0 (Jan) - 11 (Dec)
        const year = date.getFullYear();
        if (currentMonth !== `${year}-${month}`) {
          if (monthData) {
            aggregated.push(monthData);
          }
          currentMonth = `${year}-${month}`;
          monthData = { 
            date: item.date,
            open: item.open, 
            high: item.high, 
            low: item.low, 
            close: item.close, 
            volume: item.volume 
          };
        } else {
          if (monthData) {
            monthData.high = Math.max(monthData.high, item.high);
            monthData.low = Math.min(monthData.low, item.low);
            monthData.close = item.close;
            monthData.volume += item.volume;
          }
        }
      });
      
      if (monthData) {
        aggregated.push(monthData);
      }
      
      return aggregated;
    },

    /**
     * Process data based on selected interval
     */
    processDataForInterval(data, interval) {
      if (interval === '1D') {
        return data;
      } else if (interval === '1W') {
        return this.aggregateWeekly(data);
      } else if (interval === '1Mo') {
        return this.aggregateMonthly(data);
      } else {
        // For other intervals, return data as-is or implement additional aggregations
        return data;
      }
    },

    /**
     * Handle period selection via custom buttons
     */
    selectPeriod(selectedPeriodName) {
      if (this.currentRange === selectedPeriodName) {
        return; // No change
      }
      this.currentRange = selectedPeriodName;
      //console.log(`[ohlc] Period changed to: ${selectedPeriodName}`);
      
      // Update available intervals based on the new period
      this.updateAvailableIntervals();
      
      // Reset the interval if it's no longer available
      if (!this.availableIntervals.find(item => item.id === this.currentInterval)) {
        this.currentInterval = this.availableIntervals.length > 0 ? this.availableIntervals[0].id : '1min';
      }
      
      // Fetch new data based on the new period and interval
      this.fetchohlcdata(this.currentRange, this.currentInterval);
    },

    /**
     * Handle interval selection via custom dropdown
     */
    selectInterval() { // 3. Modified selectInterval method
      //console.log(`[ohlc] Interval changed to: ${this.currentInterval}`);
      
      if (this.rawChartData.length === 0) {
        console.warn('[ohlc] No raw data available to aggregate.');
        return;
      }
      
      // Aggregate data based on the selected interval
      const aggregatedData = this.processDataForInterval(this.rawChartData, this.currentInterval);
      this.chartdata = aggregatedData;
      
      console.log('[ohlc] Aggregated chart data:', this.chartdata.length, 'items');
      
      // 4. Dispose root and initialize chart again
      if (this.root) {
        console.log('[ohlc] disposing existing chart');
        this.root.dispose();
        this.root = null;
      }
      
      // Initialize a new chart with the aggregated data
      this.initchart();
    },

    /**
     * Update available intervals based on selected period
     */
    updateAvailableIntervals() {
      const intervalIds = this.periodIntervalMapping[this.currentRange] || [];
      this.availableIntervals = intervalIds.map(id => this.intervalMapping[id]).filter(item => item !== null);

      this.currentInterval = this.availableIntervals.length > 0 ? this.availableIntervals[0].id : '1min';
    }
  },
  beforeUnmount() {
    //console.log('[ohlc] component unmounting');
    if (this.root) {
      //console.log('[ohlc] disposing root');
      this.root.dispose();
    }
  },
}
</script>


<style scoped>
/* Chart Controls Container */
.chart-controls {
    display: flex;
    flex-wrap: wrap;
    justify-content: space-between;
    align-items: center;
    gap: 8px;
    margin-bottom: 20px;
    font-family: "Poppins", sans-serif;
    color: #555961;
    background-color: #f5f5f5;
    padding: 10px;
    border-radius: 8px;
    box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
}

/* Period Selector Styles */
.period-selector {
    display: flex;
    flex-wrap: wrap;
    gap: 5px;
}

.period-selector button {
    padding: 8px 12px;
    font-size: 14px;
    border: none;
    border-radius: 4px;
    background-color: #f3f3f3; /* Light Grey */
    color: #555961; /* Dark Grey */
    cursor: pointer;
    transition: background-color 0.3s, color 0.3s;
}

.period-selector button.active {
    background-color: #EDB043; /* Gold */
    color: #ffffff; /* White */
}

.period-selector button:hover:not(:disabled) {
    background-color: #003566; /* CTA Hover */
    color: #ffffff; /* White */
}

.period-selector button:disabled {
    background-color: #cccccc;
    color: #666666;
    cursor: not-allowed;
}

/* Interval Selector Styles */
.interval-selector select {
    padding: 8px 12px;
    font-size: 14px;
    border: 1px solid #f3f3f3; /* Light Grey */
    border-radius: 4px;
    background-color: #ffffff; /* White */
    color: #555961; /* Dark Grey */
    cursor: pointer;
    transition: border-color 0.3s;
}

.interval-selector select:focus {
    border-color: #EDB043; /* Gold */
    outline: none;
}

/* Dropdown Controls Styles */
.am5stock-control-dropdown {
    position: relative; /* Ensure dropdowns are positioned relative to their container */
}

.am5stock-control-list-container {
    position: absolute;
    top: 100%; /* Position below the button */
    left: 0;
    z-index: 1000; /* Ensure it appears above other elements */
    background-color: #ffffff; /* White */
    border: 1px solid #f3f3f3; /* Light Grey */
    border-radius: 4px;
    box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
    width: max-content;
    min-width: 150px;
    padding: 10px 0;
    display: none; /* Initially hidden */
}

.am5stock-control-dropdown:hover .am5stock-control-list-container {
    display: block; /* Show on hover */
}

.am5stock-control-list-container ul.am5stock-control-list li label {
    font-family: "Poppins", sans-serif;
    color: #555961; /* Dark Grey */
    padding: 8px 16px;
    display: block;
    cursor: pointer;
    transition: background-color 0.2s, color 0.2s;
}

.am5stock-control-list-container ul.am5stock-control-list li label:hover {
    background-color: #f3f3f3; /* Light Grey */
}

/* Stock Control Icons */
.am5stock-control-icon {
    width: 24px;
    height: 24px;
    display: flex;
    align-items: center;
    justify-content: center;
}

.am5stock-control-button {
    display: flex;
    align-items: center;
    gap: 8px;
    padding: 8px 12px;
    font-size: 14px;
    background-color: #f3f3f3; /* Light Grey */
    color: #555961; /* Dark Grey */
    border: none;
    border-radius: 4px;
    cursor: pointer;
    transition: background-color 0.3s, color 0.3s;
}

.am5stock-control-button:hover {
    background-color: #003566; /* CTA Hover */
    color: #ffffff; /* White */
}

.am5stock-control-button-active {
    background-color: #EDB043; /* Gold */
    color: #ffffff; /* White */
}

.am5stock-control-color {
    display: flex;
    align-items: center;
    justify-content: center;
}

.am5stock-control-color-bg {
    width: 100%;
    height: 100%;
    border-radius: 50%;
    opacity: 0.7;
}

/* Responsive Adjustments */
@media (max-width: 768px) {
    .chart-controls {
        flex-direction: column;
        align-items: stretch;
    }

    .period-selector, .interval-selector {
        width: 100%;
    }

    .period-selector button, .interval-selector select {
        width: 100%;
    }

    .am5stock-control-button {
        width: 100%;
        justify-content: center;
    }
}

/* Loader Styles */
.loader {
    position: absolute;
    top: 50%;
    left: 50%;
    transform: translate(-50%, -50%);
    font-family: "Poppins", sans-serif;
    color: #EDB043; /* Gold */
    font-size: 16px;
}

/* Error Message Styles */
.error-message {
    color: #f23645; /* Red */
    font-family: "Poppins", sans-serif;
    margin-top: 10px;
    text-align: center;
}
</style>


