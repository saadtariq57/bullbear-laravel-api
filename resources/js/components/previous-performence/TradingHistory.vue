<template>
  <div class="container py-5">
    <div class="report-head text-center py-4">
      <span class="d-block mb-2">Our Trading History</span>
      <h1 class="display-6 ">See How Our Past Trades Performed – Real Trades, Real Results!</h1>
      <div class="border-heading mt-3 mb-4 m-auto"></div>
      <p>At RichTv, we believe in full transparency when it comes to trading. Our Past Performance page allows you to track how our trades have performed over time, with detailed Month-on-Month and Yearly reports. Explore the symbols, profit percentages, and links to the exact posts where we shared these trades. Stay informed, analyze trends, and see how our strategies have played out in real time!</p>
    </div>
    <div class="reports-main pb-5">
      <!-- Tabs for Categories (Years) -->
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
          <!-- Report Navigation (Months - Right Side) -->
          <div class="col-md-3">
            <div class="list-group">
              <button
                v-for="report in activeReports"
                :key="report.id"
                @click="fetchReportProfits(report.id)"
                class="list-group-item list-group-item-action"
                :class="{ active: activeReport === report.id }"
              >
                {{ report.title }} <!-- e.g., "February 2025" -->
              </button>
            </div>
          </div>
    
          <!-- Report Data Table (ALL Profits for the selected reportId - Left Side) -->
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
                <tr v-if="reportProfits.length === 0 && activeReport !== null">
                    <td colspan="4" class="text-center">No profit data available for this report.</td>
                </tr>
                <tr v-else-if="reportProfits.length === 0 && activeReport === null && activeCategory !== null">
                    <td colspan="4" class="text-center">Select a month to view its report data.</td>
                </tr>
                 <tr v-else-if="categories.length === 0">
                    <td colspan="4" class="text-center">Loading report data or no reports available.</td>
                </tr>
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
        <div class=""><img src="/build/images/alert-icon.png" alt="icon" height="35"></div>
        <div><h2 class="fw-bolder fs-1 mb-0"> Disclaimer</h2></div>
      </div>
          <p class="margin-24 fs-18 lh-base"> <q>The information provided on this page is for educational and informational purposes only. Past performance is not a guarantee of future results. Trading involves risk, and you should always do your own research before making any financial decisions.</q> </p>
        </div>
  </div>
</template>

<script>
// Assuming you have axios imported globally or you'll import it here
// import axios from 'axios'; 

export default {
  data() {
    return {
      categories: [], // All categories (Years) with their reports (Months)
      activeCategory: null, // Currently selected category (Year) ID
      activeReports: [], // Reports (Months) for the active category (Year)
      activeReport: null, // Currently selected report (Month) ID - used for highlighting
      reportProfits: [], // All profits for the API response of the activeReport ID
    };
  },
  created() {
    this.fetchCategoriesWithReports();
  },
  computed: {
    // Calculate the total profit percentage for the displayed data
    totalProfitPercentage() {
      return this.reportProfits.reduce((total, profit) => {
        return total + parseFloat(profit.profit_percentage || 0); // Ensure profit_percentage is a number
      }, 0).toFixed(2); // Round to 2 decimal places
    },
  },
  methods: {
    async fetchCategoriesWithReports() {
      try {
        const response = await axios.get('/api/categories-with-reports');
        this.categories = this.sortCategoriesByLatestYear(response.data || []);
        if (this.categories.length > 0) {
          this.setActiveCategory(this.categories[0].id);
        } else {
            this.reportProfits = []; // Ensure table is cleared if no categories
        }
      } catch (error) {
        console.error("Error fetching categories with reports:", error);
        this.categories = [];
        this.reportProfits = [];
      }
    },

    sortCategoriesByLatestYear(categories) {
      return [...categories].sort((a, b) => { // Create a shallow copy before sorting
        const yearA = this.extractYearFromCategoryName(a.name);
        const yearB = this.extractYearFromCategoryName(b.name);
        return yearB - yearA;
      });
    },

    extractYearFromCategoryName(categoryName) {
      if (!categoryName) return 0;
      const yearMatch = categoryName.toString().match(/\d{4}/);
      return yearMatch ? parseInt(yearMatch[0]) : 0;
    },

    sortReportsByLatestMonth(reports) {
      return [...reports].sort((a, b) => { // Create a shallow copy before sorting
        const dateA = this.extractDateFromReportTitle(a.title);
        const dateB = this.extractDateFromReportTitle(b.title);
        return dateB - dateA;
      });
    },

    extractDateFromReportTitle(title) {
      if (!title || typeof title !== 'string') return new Date(0);
      const parts = title.split(' ');
      if (parts.length < 2) return new Date(0);
      
      const month = parts[0];
      const year = parts[parts.length -1];
      const date = new Date(`${month} 1, ${year}`);
      return isNaN(date.getTime()) ? new Date(0) : date;
    },

    setActiveCategory(categoryId) {
      this.activeCategory = categoryId;
      const category = this.categories.find((cat) => cat.id === categoryId);
      this.activeReports = category ? this.sortReportsByLatestMonth(category.reports || []) : [];
      
      this.reportProfits = []; // Clear profits when year changes
      this.activeReport = null; 

      if (this.activeReports.length > 0) {
        // Automatically select the latest month report and fetch ALL data associated with it
        this.fetchReportProfits(this.activeReports[0].id);
      }
    },

    // Fetch profits for the selected report (identified by reportId).
    // Display ALL data returned by the API for this reportId, without any date-based filtering.
    async fetchReportProfits(reportId) {
      this.activeReport = reportId; // Highlight the selected "month" in the UI

      try {
        const response = await axios.get(`/api/report-profits/${reportId}`);
        let profitsData = response.data;

        // Ensure profitsData is an array before trying to sort or assign
        if (!Array.isArray(profitsData)) {
            console.warn(`Data received for reportId '${reportId}' is not an array. Received:`, profitsData);
            profitsData = []; // Default to an empty array to prevent runtime errors
        }

        // Sort the fetched profits by their date property, chronologically.
        // This is generally good practice for display consistency.
        this.reportProfits = profitsData.sort((a, b) => {
          // Robust date comparison
          const dateAVal = a.date ? new Date(a.date).getTime() : 0;
          const dateBVal = b.date ? new Date(b.date).getTime() : 0;

          if (isNaN(dateAVal) && isNaN(dateBVal)) return 0;
          if (isNaN(dateAVal)) return 1; // Push invalid/missing dates to the end
          if (isNaN(dateBVal)) return -1; // Push invalid/missing dates to the end

          return dateAVal - dateBVal; // Ascending order (earliest first)
        });

      } catch (error) {
        console.error(`Error fetching report profits for report ID ${reportId}:`, error);
        this.reportProfits = []; // Clear profits on error
      }
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