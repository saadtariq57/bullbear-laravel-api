<template>

    <div class="container py-5">
      <div class="report-head text-center py-4">
        <span class="d-block mb-2">Our Trading History</span>
        <h1 class="display-6 ">See How Our Past Trades Performed – Real Trades, Real Results!</h1>
        <div class="border-heading mt-3 mb-4 m-auto"></div>
        <p>At RichTv, we believe in full transparency when it comes to trading. Our Past Performance page allows you to track how our trades have performed over time, with detailed Month-on-Month and Yearly reports. Explore the symbols, profit percentages, and links to the exact posts where we shared these trades. Stay informed, analyze trends, and see how our strategies have played out in real time!</p>
      </div>
      <div class="reports-main pb-5">
        <!-- Tabs for Categories -->
        <ul class="nav nav-tabs report-category-tab d-flex align-items-center justify-content-center py-4">
          <li class="nav-item" v-for="category in categories" :key="category.id">
            <a
              class="nav-link"
              :class="{ active: activeCategory === category.id }"
              @click="setActiveCategory(category.id)"
            >
              {{ category.name }}
            </a>
          </li>
        </ul>
        <div class="row mt-4">
            <!-- Report Navigation (Right Side) -->
            <div class="col-md-3">
              <div class="list-group">
                <button
                  v-for="report in activeReports"
                  :key="report.id"
                  @click="fetchReportProfits(report.id)"
                  class="list-group-item list-group-item-action"
                  :class="{ active: activeReport === report.id }"
                >
                  {{ report.title }}
                </button>
              </div>
            </div>
      
            <!-- Report Data Table (Left Side) -->
            <div class="col-md-9">
              <div class="table-responsive reports-table">
                <table class="table table-bordered">
                <thead>
                  <tr>
                    <th>Date</th>
                    <th>Symbol</th>
                    <th>Profit Percentage</th>
                    <th class="text-center">Links</th>
                  </tr>
                </thead>
                <tbody>
                  <tr v-for="(profit) in reportProfits" :key="profit.id">
                    <td>{{ profit.date }}</td>
                    <td>{{ profit.symbol }}</td>
                    <td>{{ profit.profit_percentage }}%</td>
                    <td>
                        <div class="report_links d-flex align-items-center gap-3 justify-content-center">
                            <!-- LinkedIn Link -->
                            <a
                            v-if="profit.linkedin_post_link"
                            :href="profit.linkedin_post_link"
                            target="_blank"
                            class="btn btn-sm border-btn d-flex align-items-center gap-1 fw-bolder report-link-btn"
                            style="line-height: 21px;"
                            >
                            <img src="/build/images/linkedin-icon.png" alt="linedin icon" width="13">
                            Linkedin
                            <!-- <i class="bi bi-box-arrow-in-up-right"></i> -->
                            </a>

                            <!-- TradingView Link -->
                            <a
                            v-if="profit.tradingview_post_link"
                            :href="profit.tradingview_post_link"
                            target="_blank"
                            class="btn btn-sm border-btn d-flex align-items-center gap-1 fw-bolder report-link-btn"
                            style="line-height: 21px;"
                            >
                            <img src="/build/images/tradingview-icon.png" alt="tradingview icon" width="13">
                            TradingView
                            <!-- <i class="bi bi-box-arrow-in-up-right"></i> -->
                            </a>

                            <!-- RichTV Link -->
                            <a
                            v-if="profit.web_post_link"
                            :href="profit.web_post_link"
                            target="_blank"
                            class="btn btn-sm border-btn d-flex align-items-center gap-1 fw-bolder report-link-btn"
                            style="line-height: 21px;"
                            >
                            <img src="/build/images/favicon.png" alt="richtv icon" width="13">
                            RichTV
                            <!-- <i class="bi bi-box-arrow-in-up-right"></i> -->
                            </a>
                        </div>
                        </td>
                  </tr>
                  <!-- Total Profit Percentage Row -->
                    <tr v-if="reportProfits.length > 0">
                    <td colspan="2" class="text-start"><strong>Total Profit:</strong></td>
                    <td><strong style="color: green;">{{ totalProfitPercentage }}%</strong></td>
                    <td></td> <!-- Empty cell for Links column -->
                    </tr>
                </tbody>
              </table>
              </div>
            </div>
          </div>
      </div>
      <div class="disclaimer my-5 px-4 py-5 rounded-3 text-center">
        <div class="disclaimer-icon-name d-flex align-items-end mb-4 gap-3">
          <div class=""><img src="https://s3.wasabisys.com/rpdapp1/upload/photos/2023/img/alert-icon.png" alt="icon" height="35"></div>
          <div><h2 class="fw-bolder fs-1 mb-0"> Disclaimer</h2></div>
        </div>
            <p class="margin-24 fs-18 lh-base"> <q>The information provided on this page is for educational and informational purposes only. Past performance is not a guarantee of future results. Trading involves risk, and you should always do your own research before making any financial decisions.</q> </p>
          </div>
    </div>
  </template>
  
  <script>
  export default {
    data() {
      return {
        categories: [], // All categories with their reports
        activeCategory: null, // Currently selected category
        activeReports: [], // Reports for the active category
        activeReport: null, // Currently selected report
        reportProfits: [], // Profits for the active report
      };
    },
    created() {
      this.fetchCategoriesWithReports();
    },
    computed: {
      // Calculate the total profit percentage
      totalProfitPercentage() {
        return this.reportProfits.reduce((total, profit) => {
          return total + parseFloat(profit.profit_percentage);
        }, 0).toFixed(2); // Round to 2 decimal places
      },
    },
    methods: {
      // Fetch all categories with their reports
      async fetchCategoriesWithReports() {
        const response = await axios.get('/api/categories-with-reports');
        // Sort categories by latest year
        this.categories = this.sortCategoriesByLatestYear(response.data);
        if (this.categories.length > 0) {
          // Set the latest year category as active by default
          this.setActiveCategory(this.categories[0].id);
        }
      },
      // Sort categories by latest year
      sortCategoriesByLatestYear(categories) {
        return categories.sort((a, b) => {
          const yearA = this.extractYearFromCategory(a.name);
          const yearB = this.extractYearFromCategory(b.name);
          return yearB - yearA; // Sort in descending order (latest year first)
        });
      },
      // Extract year from category name (assuming category name is in format "Year X")
      extractYearFromCategory(categoryName) {
        const yearMatch = categoryName.match(/\d{4}/); // Extract 4-digit year
        return yearMatch ? parseInt(yearMatch[0]) : 0;
      },
      // Sort reports by latest month
      sortReportsByLatest(reports) {
        return reports.sort((a, b) => {
          const dateA = this.extractDateFromTitle(a.title);
          const dateB = this.extractDateFromTitle(b.title);
          return dateB - dateA; // Sort in descending order (latest first)
        });
      },
      // Extract date from report title (assuming title is in format "Month Year")
      extractDateFromTitle(title) {
        const [month, year] = title.split(' ');
        const monthIndex = new Date(`${month} 1, ${year}`).getMonth();
        return new Date(year, monthIndex);
      },
      // Set the active category and update the reports list
      setActiveCategory(categoryId) {
        this.activeCategory = categoryId;
        const category = this.categories.find((cat) => cat.id === categoryId);
        this.activeReports = category ? this.sortReportsByLatest(category.reports) : [];
        if (this.activeReports.length > 0) {
          // Set the latest report as active by default
          this.fetchReportProfits(this.activeReports[0].id);
        }
      },
      // Fetch profits for the selected report
      async fetchReportProfits(reportId) {
        this.activeReport = reportId;
        const response = await axios.get(`/api/report-profits/${reportId}`);
        let profits = response.data;
  
        // Filter out profits that belong to different months
        if (profits.length > 0) {
          const firstProfitMonth = new Date(profits[0].date).getMonth();
          profits = profits.filter(profit => {
            const profitMonth = new Date(profit.date).getMonth();
            return profitMonth === firstProfitMonth;
          });
  
          // Sort profits by date (1 to 30)
          profits.sort((a, b) => {
            const dateA = new Date(a.date).getDate();
            const dateB = new Date(b.date).getDate();
            return dateA - dateB; // Sort in ascending order (1 to 30)
          });
        }
  
        this.reportProfits = profits;
      },
    },
  };
  </script>
  
  <style scoped>
  /* .report-link-btn:hover img{
    filter: invert(1);
  } */
   .reports-table table{
    min-width: 830px;
   }
   .report-link-btn.border-btn:hover {
    background-color: transparent!important;
    color:var(--Cinder);
    transform: translateX(3px);
}
  .report-category-tab{
    cursor: pointer;
  }
  .report-category-tab .nav-link{
    border: 0;
    border-bottom: 2px solid #dbdbdb !important;
    color: #525252;
  }
  .report-category-tab .nav-link.active{
    border-bottom: 2px solid var(--Cinder) !important;
    color: var(--Cinder);
  }
  </style>