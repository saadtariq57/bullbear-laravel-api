<template>
  <div id="chartcontrols"></div>
  <div ref="chartdiv" style="width: 100%; height: 500px;"></div>
</template>

<script>
import * as am5 from "@amcharts/amcharts5";
import * as am5xy from "@amcharts/amcharts5/xy";
import am5themes_Animated from "@amcharts/amcharts5/themes/Animated";
import * as am5stock from "@amcharts/amcharts5/stock";
import axios from 'axios';

export default {
  props: {
    symbol: {
      type: String,
      required: true
    }
  },
  data() {
    return {
      root: null,
      // stockchart: null,
      chartdata: [],
      isloading: false,
      rendercount: 0,
    };
  },
  mounted() {
    console.log('[ohlc] component mounted');
    this.$nextTick(() => {
      this.fetchohlcdata().then(() => {
        if (this.chartdata.length > 0) {
          this.initchart();
        }
      });
    });
  },
  methods: {
    async fetchohlcdata() {
      console.log(`[ohlc] fetching ohlc data for symbol: ${this.symbol}`);
      if (this.isloading || this.chartdata.length > 0) {
        console.log('[ohlc] data fetch already in progress or data already loaded, skipping');
        return;
      }
      this.isloading = true;
      try {
        const response = await axios.get(`/api/ohlc-data/${this.symbol}`);
        console.log(`[ohlc] data received for ${this.symbol}:`, response.data.length, 'items');
        this.chartdata = response.data.map(item => ({
          date: new Date(item.date).getTime(),
          open: Number(item.open),
          high: Number(item.high),
          low: Number(item.low),
          close: Number(item.close),
          volume: Number(item.volume)
        })).sort((a, b) => a.date - b.date);
        console.log('[ohlc] processed chart data:', this.chartdata.length, 'items');
      } catch (error) {
        console.error('[ohlc] error fetching ohlc data:', error);
      } finally {
        this.isloading = false;
      }
    },

    validatedata(data) {
      console.log('[ohlc] validating data:', data.length, 'items');
      if (!Array.isArray(data) || data.length === 0) {
        console.error('[ohlc] data validation failed: not an array or empty');
        return false;
      }
      const requiredfields = ['date', 'open', 'high', 'low', 'close', 'volume'];
      const isvalid = data.every(item => requiredfields.every(field => item[field] != null && !isNaN(item[field])));
      console.log('[ohlc] data validation result:', isvalid);
      return isvalid;
    },
initchart() {
  console.log('[ohlc] initializing chart');
  this.rendercount++;
  console.log(`[ohlc] render count: ${this.rendercount}`);

  if (!this.$refs.chartdiv) {
    console.error("[ohlc] chart div not found");
    return;
  }

  if (!this.validatedata(this.chartdata)) {
    console.error("[ohlc] invalid chart data");
    return;
  }

  if (this.root) {
    console.log('[ohlc] disposing existing root');
    this.root.dispose();
  }

  // Check if there's already a root on this DOM node
  if (this.$refs.chartdiv._am5root) {
    console.error("[ohlc] A root already exists on this DOM node");
    return;
  }

  console.log('[ohlc] creating new root');
  let root = am5.Root.new(this.$refs.chartdiv);

  const myTheme = am5.Theme.new(root);
  myTheme.rule("Grid", ["scrollbar", "minor"]).setAll({
    visible: false
  });

  root.setThemes([
    am5themes_Animated.new(root),
    myTheme
  ]);

  // Create a stock chart
  let stockChart = root.container.children.push(am5stock.StockChart.new(root, {}));

  // Set global number format
  root.numberFormatter.set("numberFormat", "#,###.00");

  // Create a main stock panel (chart)
  let mainPanel = stockChart.panels.push(am5stock.StockPanel.new(root, {
    wheelY: "zoomX",
    panX: true,
    panY: true
  }));

  // Create value axis
  let valueAxis = mainPanel.yAxes.push(am5xy.ValueAxis.new(root, {
    renderer: am5xy.AxisRendererY.new(root, {
      pan: "zoom"
    }),
    extraMin: 0.1,
    tooltip: am5.Tooltip.new(root, {}),
    numberFormat: "#,###.00",
    extraTooltipPrecision: 2
  }));

  let dateAxis = mainPanel.xAxes.push(am5xy.GaplessDateAxis.new(root, {
    baseInterval: {
      timeUnit: "minute",
      count: 1
    },
    renderer: am5xy.AxisRendererX.new(root, {
      minorGridEnabled: true
    }),
    tooltip: am5.Tooltip.new(root, {})
  }));

  // Add series
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

  // Add series
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

  // color columns by stock rules
  volumeSeries.columns.template.adapters.add("fill", function(fill, target) {
    let dataItem = target.dataItem;
    if (dataItem) {
      return stockChart.getVolumeColor(dataItem);
    }
    return fill;
  })

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
    baseInterval: {
      timeUnit: "minute",
      count: 1
    },
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

  // Function that dynamically loads data
  function loadData(ticker, series, granularity) {
    // In your case, you might want to replace this with your own data loading logic
    // For now, we'll just use the existing chartdata
    am5.array.each(series, function(item) {
      item.data.setAll(this.chartdata);
    }.bind(this));
  }

  // Set up series type switcher
  let seriesSwitcher = am5stock.SeriesTypeControl.new(root, {
    stockChart: stockChart
  });

  seriesSwitcher.events.on("selected", function(ev) {
    setSeriesType(ev.item.id);
  });

  function getNewSettings(series) {
    let newSettings = [];
    am5.array.each(["name", "valueYField", "highValueYField", "lowValueYField", "openValueYField", "calculateAggregates", "valueXField", "xAxis", "yAxis", "legendValueText", "legendRangeValueText", "stroke", "fill"], function(setting) {
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

  // Interval switcher
  let intervalSwitcher = am5stock.IntervalControl.new(root, {
    stockChart: stockChart,
    items: [
      { id: "1 minute", label: "1 minute", interval: { timeUnit: "minute", count: 1 } },
      { id: "1 day", label: "1 day", interval: { timeUnit: "day", count: 1 } },
      { id: "1 week", label: "1 week", interval: { timeUnit: "week", count: 1 } },
      { id: "1 month", label: "1 month", interval: { timeUnit: "month", count: 1 } }
    ]
  });

  intervalSwitcher.events.on("selected", function(ev) {
    // Determine selected granularity
    let granularity = ev.item.interval.timeUnit;
    
    // Get series
    let valueSeries = stockChart.get("stockSeries");
    let volumeSeries = stockChart.get("volumeSeries");

    // Set up zoomout
    valueSeries.events.once("datavalidated", function() {
      mainPanel.zoomOut();
    });

    // Load data for all series (main series + comparisons)
    let promises = [];
    promises.push(loadData(this.symbol, [valueSeries, volumeSeries, sbSeries], granularity));
    am5.array.each(stockChart.getPrivate("comparedSeries", []), function(series) {
      promises.push(loadData(series.get("name"), [series], granularity));
    });

    // Once data loading is done, set `baseInterval` on the DateAxis
    Promise.all(promises).then(function() {
      dateAxis.set("baseInterval", ev.item.interval);
      sbDateAxis.set("baseInterval", ev.item.interval);

      stockChart.indicators.each(function(indicator){
        if(indicator instanceof am5stock.ChartIndicator){
          indicator.xAxis.set("baseInterval", ev.item.interval);
        }
      });
    });
  }.bind(this));

  // Stock toolbar
  let toolbar = am5stock.StockToolbar.new(root, {
    container: document.getElementById("chartcontrols"),
    stockChart: stockChart,
    controls: [
      am5stock.IndicatorControl.new(root, {
        stockChart: stockChart,
        legend: valueLegend
      }),
      am5stock.DateRangeSelector.new(root, {
        stockChart: stockChart
      }),
      am5stock.PeriodSelector.new(root, {
        stockChart: stockChart
      }),
      intervalSwitcher,
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

  // set chart data
  console.log('[ohlc] setting chart data');
  valueSeries.data.setAll(this.chartdata);
  volumeSeries.data.setAll(this.chartdata);
  sbSeries.data.setAll(this.chartdata);

  console.log('[ohlc] chart initialization complete');
  console.log('[ohlc] first few data points:', this.chartdata.slice(0, 5));

  // Save root to component instance
  this.root = root;
}
  },
  beforeUnmount() {
    console.log('[ohlc] component unmounting');
    if (this.root) {
      console.log('[ohlc] disposing root');
      this.root.dispose();
    }
  },
}
</script>