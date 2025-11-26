<template>
  <div class="container my-4">
    <!-- Enhanced Exams Header -->
    <div class="mb-5 text-center">
      <h1 class="fw-bold text-uppercase">Trading Exams Become A Batter Trader</h1>
      <p class="text-muted mx-w800 m-auto mt-3">
        Test your knowledge and skills with our comprehensive Basic and Advanced exams. Whether you're just starting or looking to deepen your expertise, our exams are designed to challenge and validate your understanding.
      </p>
      <div v-if="showPreviousResultsButton" class="mt-3">
        <a
          href="/previous-results"
          class="btn btn-primary"
          data-bs-toggle="tooltip"
          title="View your previous exam results"
        >
          <i class="bi bi-clipboard-check me-2"></i> Previous Results
        </a>
      </div>
    </div>

    <!-- Exams Grouped by Type and Category -->
    <div v-for="(categories, type) in groupedExams" :key="type" class="my-4">
      <!-- Type Header -->
      <div class="d-flex align-items-center mb-3">
        <h2 class="fw-bold text-capitalize me-2 mb-0">{{ capitalize(type) }} Exams</h2>
        <span
          class="badge ms-2"
          :class="typeBadgeClass(type)"
          data-bs-toggle="tooltip"
          :title="typeTooltip(type)"
        >
          {{ type.toUpperCase() }}
        </span>
      </div>
      <div class="border border-bottom border-primary d-inline-block mb-4 Titleborder" style="width: 120px;"></div>

      <!-- Categories within Type -->
      <div v-for="(exams, category) in categories" :key="category" class="mt-3 mb-5 examCategories">
        <!-- Category Header -->
        <div class="d-flex align-items-center mb-4">
          <h4 class="fw-semibold me-2 mb-0">{{ category }}</h4>
          <span
            class="badge bg-secondary"
            data-bs-toggle="tooltip"
            title="Number of Exams in this Category"
          >
            {{ exams.length }}
          </span>
        </div>

        <!-- Exams Grid -->
        <div class="row gy-4">
          <div
            v-for="exam in limitedExams(exams, category)"
            :key="exam.id"
            class="col-lg-4 col-md-6 col-12"
          >
            <div class="exam-content bg-white shadow-sm rounded h-100 d-flex flex-column card m-0">
              <div class="exam-image position-relative">
                <img
                  :src="`/uploads/${exam.featured_img}`"
                  class="img-fluid rounded-top"
                  :alt="`Exam Image ${exam.title}`"
                  data-bs-toggle="tooltip"
                  :title="`Exam: ${exam.title}`"
                  loading="lazy"
                />
                <span
                  class="badge position-absolute top-0 end-0 m-2"
                  :class="typeBadgeClass(exam.type)"
                  data-bs-toggle="tooltip"
                  :title="`This is a ${capitalize(exam.type)} exam`"
                >
                  {{ exam.type.toUpperCase() }}
                </span>
              </div>
              <div class="exam-info px-3 py-4 d-flex flex-column flex-grow-1">
                <h5
                  class="text-uppercase fw-semibold fs-5 mb-3"
                  data-bs-toggle="tooltip"
                  :title="exam.description || 'No Description Provided'"
                >
                  {{ exam.title }}
                </h5>
                <div class="time-question d-flex justify-content-between mb-3">
                  <span
                    class="questions"
                    data-bs-toggle="tooltip"
                    title="Number of Questions"
                  >
                    <i class="bi bi-list-ol me-1"></i>
                    {{ exam.number_of_questions }} Questions
                  </span>
                  <span
                    class="time"
                    data-bs-toggle="tooltip"
                    title="Time Limit per Question"
                  >
                    <i class="bi bi-stopwatch-fill me-1"></i>
                    {{ exam.per_question_time_limit }} sec/Q
                  </span>
                </div>
                <p
                  class="text-muted flex-grow-1"
                  data-bs-toggle="tooltip"
                  :title="exam.description || 'No Description Provided'"
                >
                  {{ exam.description
                    ? exam.description.length > 100
                      ? exam.description.substring(0, 100) + "..."
                      : exam.description
                    : "No Description Provided." }}
                </p>
                <div class="exam-btn mt-3 text-center">
                  <button
                    :class="['btn', buttonClass(exam)]"
                    @click="handleExamClick(exam)"
                    :disabled="isAuthenticated ? (!exam.canAttempt || !canAccessExam(exam)) : false"
                    data-bs-toggle="tooltip"
                    :title="buttonTooltip(exam)"
                  >
                    {{ buttonText(exam) }}
                  </button>
                </div>
              </div>
            </div>
          </div>
          <!-- If there are more exams and showAllExams is false, show "See More" button for each category -->
          <div v-if="canSeeMore(exams, category)" class="col-12 text-center mt-3">
            <button
              @click="toggleSeeMore(category)"
              class="btn btn-outline-secondary"
              data-bs-toggle="tooltip"
              :data-category-see-more="category"
              title="See more exams in this category"
            >
              {{ seeMoreText(category) }}
            </button>
          </div>
        </div>
      </div>
    </div>

    <!-- Global Load More Button (Optional) -->
    <div v-if="canLoadMoreGlobal" class="text-center my-4">
      <button
        @click="loadMoreExams"
        class="btn btn-secondary"
        data-bs-toggle="tooltip"
        title="Load more exams"
      >
        <i class="bi bi-arrow-down-circle me-1"></i> Load More Exams
      </button>
    </div>

    <!-- No Exams Found -->
    <div v-if="!isLoading && Object.keys(groupedExams).length === 0" class="text-center my-5">
      <h4>No exams found.</h4>
      <p>Please adjust your search criteria or check back later.</p>
    </div>

    <!-- Loading Spinner -->
    <div v-if="isLoadingExams" class="text-center my-5">
      <div class="spinner-border text-primary" role="status">
        <span class="visually-hidden">Loading...</span>
      </div>
    </div>
  </div>
</template>

<script>
import axios from "axios";
import { mapGetters, mapActions } from "vuex";
import Swal from "sweetalert2";
import { registerVuexModule, unregisterVuexModule } from "@/stores/registerModule";
import examStoreModule from "@/stores/examStore";
import subscriptionStatusModule from "@/stores/subscriptionStatus";

export default {
  data() {
    return {
      groupedExams: {},
      showAllExams: {},
      currentPage: 1,
      lastPage: 1,
      isLoadingExams: false,
      tooltipInstances: [],
    };
  },
  computed: {
    ...mapGetters("subscriptionStatus", [
      "isAuthenticated",
      "isLoading",
      "hasBasicExam",
      "hasAdvanceExam",
    ]),

    /**
     * Determine if more exams can be loaded globally (for the "Load More Exams" button).
     */
    canLoadMoreGlobal() {
      return this.currentPage < this.lastPage;
    },

    /**
     * Determine if the "Previous Results" button should be shown.
     */
    showPreviousResultsButton() {
      return this.hasBasicExam || this.hasAdvanceExam;
    },
  },
  methods: {
    ...mapActions("exam", ["initiateExam"]),
    ...mapActions("subscriptionStatus", ["fetchSubscriptionStatus"]),

    /**
     * Fetch exams data from the API.
     * @param {Number} page - The page number to fetch.
     */
    async fetchExams(page = 1) {
      this.isLoadingExams = true;
      try {
        const response = await axios.get("/api/exams", {
          params: {
            page: page,
            // Include any other query parameters if needed (e.g., search, type)
          },
        });

        const { data, pagination } = response.data;
        // Merge the new data into groupedExams
        this.mergeGroupedExams(data);

        // Update pagination info
        this.currentPage = pagination.current_page;
        this.lastPage = pagination.last_page;

      } catch (error) {
        console.error("Error fetching exams:", error);
        // Display an error message to the user
        Swal.fire({
          title: "Error!",
          text: "There was an error fetching exams. Please try again later.",
          icon: "error",
          confirmButtonText: "OK",
        });
      } finally {
        this.isLoadingExams = false;
      }
    },

    /**
     * Merge new grouped exams data into the existing groupedExams.
     * @param {Object} newData - The new exams data grouped by type and category.
     */
    mergeGroupedExams(newData) {
      for (const [type, categories] of Object.entries(newData)) {
        if (!this.groupedExams[type]) {
          this.groupedExams[type] = {};
        }

        for (const [category, exams] of Object.entries(categories)) {
          if (!this.groupedExams[type][category]) {
            this.groupedExams[type][category] = [];
            // Newly loaded categories should show all exams immediately
            this.showAllExams[category] = true;
          }

          // Push new exams into the category array
          this.groupedExams[type][category].push(...exams);
        }
      }
    },

    /**
     * Handle the "Load More Exams" button click.
     */
    loadMoreExams() {
      if (this.canLoadMoreGlobal && !this.isLoadingExams) {
        this.fetchExams(this.currentPage + 1);
      }
    },

    /**
     * Determine the button text based on user authentication and subscription status.
     * @param {Object} exam - The exam object.
     * @returns {String} - The button text.
     */
    buttonText(exam) {
      if (!this.isAuthenticated) {
        return "Login to Take Exam";
      }

      if (!exam.canAttempt) {
        return "Cannot Attempt Now";
      }
      if (exam.type === "basic" && this.hasBasicExam) {
        return "Start Exam";
      } else if (exam.type === "advanced" && this.hasAdvanceExam) {
        return "Start Exam";
      } else {
        return "Upgrade to Take Exam";
      }
    },

    /**
     * Determine if the user can access the exam based on subscription status.
     * @param {Object} exam - The exam object.
     * @returns {Boolean} - Whether the user can access the exam.
     */
    canAccessExam(exam) {
      if (exam.type === "basic") {
        return this.hasBasicExam;
      } else if (exam.type === "advanced") {
        return this.hasAdvanceExam;
      }
      return false;
    },

    /**
     * Determine the button CSS class based on user authentication and subscription status.
     * @param {Object} exam - The exam object.
     * @returns {String} - The button CSS classes.
     */
    buttonClass(exam) {
      if (!this.isAuthenticated) {
        return "btn-outline-primary";
      }

      if (
        (exam.type === "basic" && this.hasBasicExam) ||
        (exam.type === "advanced" && this.hasAdvanceExam)
      ) {
        return "btn-primary";
      } else {
        return "btn-warning";
      }
    },

    /**
     * Provide tooltip text for buttons based on their state.
     * @param {Object} exam - The exam object.
     * @returns {String} - The tooltip text.
     */
    buttonTooltip(exam) {
      if (!this.isAuthenticated) {
        return "Please log in to take the exam.";
      }

      if (exam.type === "basic" && this.hasBasicExam) {
        return "Click to start the exam.";
      } else if (exam.type === "advanced" && this.hasAdvanceExam) {
        return "Click to start the exam.";
      } else {
        return "Upgrade your subscription to access this exam.";
      }
    },

    /**
     * Handle exam button click based on authentication and subscription status.
     * @param {Object} exam - The exam object.
     */
    handleExamClick(exam) {
      if (!this.isAuthenticated) {
        this.handleSignIn();
        return;
      }

      if (exam.type === "basic" && this.hasBasicExam) {
        this.startExam(exam.id);
      } else if (exam.type === "advanced" && this.hasAdvanceExam) {
        this.startExam(exam.id);
      } else {
        this.upgradeSubscription();
      }
    },

    /**
     * Initiate the exam by navigating to the first question.
     * @param {Number} examId - The ID of the exam to start.
     */
    async startExam(examId) {
      try {
        const { firstQuestionId, examName, timeLimit } = await this.initiateExam(examId);
        this.$router.push({
          name: "exam.question",
          params: { examName: examName, questionId: firstQuestionId },
        });
      } catch (error) {
        console.error("Error initiating exam:", error);
        Swal.fire({
          title: "Error!",
          text: "There was an error starting the exam. Please try again later.",
          icon: "error",
          confirmButtonText: "OK",
        });
      }
    },

    /**
     * Handle user sign-in by showing the login popup and setting the redirect path.
     */
    handleSignIn() {
      this.$store.dispatch("showLoginPopup");
      this.$store.dispatch("setRedirectPath", "/exams");
    },

    /**
     * Redirect the user to the subscription upgrade page.
     */
    upgradeSubscription() {
      window.location.href = "/pricing";
    },

    /**
     * Determine the CSS class for the exam type badge.
     * @param {String} type - The type of the exam ('basic' or 'advanced').
     * @returns {String} - The badge CSS class.
     */
    typeBadgeClass(type) {
      return type === "basic" ? "bg-primary" : "bg-success";
    },

    /**
     * Provide tooltip text for exam type badges.
     * @param {String} type - The type of the exam ('basic' or 'advanced').
     * @returns {String} - The tooltip text.
     */
    typeTooltip(type) {
      return type === "basic" ? "Basic Exam" : "Advanced Exam";
    },

    /**
     * Capitalize the first letter of a string.
     * @param {String} str - The string to capitalize.
     * @returns {String} - The capitalized string.
     */
    capitalize(str) {
      if (!str) return "";
      return str.charAt(0).toUpperCase() + str.slice(1);
    },

    /**
     * Limit the number of exams displayed initially or show all based on showAllExams flag.
     * @param {Array} exams - The array of exam objects.
     * @param {String} category - The category name.
     * @returns {Array} - The limited or full array of exams.
     */
    limitedExams(exams, category) {
      // Check if 'showAllExams' is true for this category
      if (this.showAllExams[category]) {
        return exams;
      }
      return exams.slice(0, 3); // Show up to 3 exams per category initially
    },

    /**
     * Determine if more exams can be seen in a specific category.
     * @param {Array} exams - The array of exam objects.
     * @param {String} category - The category name.
     * @returns {Boolean} - Whether more exams can be seen.
     */
    canSeeMore(exams, category) {
      return exams.length > 3 && !this.showAllExams[category];
    },

    /**
     * Toggle the 'show all' state for a specific category.
     * @param {String} category - The category name.
     */
    toggleSeeMore(category) {
      // Dispose tooltip for the See More button before hiding it
      if (!this.showAllExams[category]) {
        const seeMoreButton = document.querySelector(
          `[data-category-see-more="${category}"]`
        );
        if (seeMoreButton && typeof window.bootstrap !== "undefined") {
          const tooltipInstance = window.bootstrap.Tooltip.getInstance(seeMoreButton);
          if (tooltipInstance) {
            tooltipInstance.dispose();
          }
        }
      }
      this.showAllExams[category] = !this.showAllExams[category];
    },

    /**
     * Get the text for the "See More" button based on current state.
     * @param {String} category - The category name.
     * @returns {String} - The button text.
     */
    seeMoreText(category) {
      return this.showAllExams[category] ? "See Less" : "See More";
    },

    /**
     * Initialize Bootstrap tooltips.
     */
    initTooltips() {
      if (typeof window.bootstrap === "undefined") {
        return;
      }

      this.disposeTooltips();

      const tooltipTriggerList = Array.from(
        document.querySelectorAll('[data-bs-toggle="tooltip"]')
      );
      this.tooltipInstances = tooltipTriggerList.map(
        (tooltipTriggerEl) => new window.bootstrap.Tooltip(tooltipTriggerEl)
      );
    },

    disposeTooltips() {
      if (!this.tooltipInstances?.length) {
        return;
      }
      this.tooltipInstances.forEach((instance) => {
        if (instance && typeof instance.dispose === "function") {
          instance.dispose();
        }
      });
      this.tooltipInstances = [];
    },
  },
  created() {
    if (!this.$store.hasModule("subscriptionStatus")) {
      registerVuexModule("subscriptionStatus", subscriptionStatusModule);
      
    }
    if (!this.$store.hasModule("exam")) {
      registerVuexModule("exam", examStoreModule);
    }

    this.fetchSubscriptionStatus();
    this.fetchExams();
  },
  updated() {
    // Re-initialize tooltips after component updates
    this.initTooltips();
  },
  beforeUnmount() {
    this.disposeTooltips();
    unregisterVuexModule("subscriptionStatus");
    //unregisterVuexModule("exam");
  },
};
</script>

<style scoped>
.mx-w800{
  max-width: 800px;
}
.Titleborder{
  width: 85px;
  height: 3px;
  background: var(--primary-color) !important;
}
.examCategories{
  background: #f6f6f6ba;
  padding: 35px 40px;
  border-radius: 8px;
  box-shadow: 0px 0px 8px 3px #0000001a;
}
.exam-content {
  transition: transform 0.3s;
  display: flex;
  flex-direction: column;
  border: 1px solid #ddd!important;
}
.exam-content:hover {
  transform: translateY(-5px);
}
.exam-image img {
  height: 200px;
  object-fit: cover;
  width: 100%;
}
.exam-info h5 {
  font-size: 1rem;
  cursor: pointer;
}
.exam-info p {
  font-size: 0.875rem;
}
.badge-primary {
  background-color: #0d6efd !important;
}
.badge-success {
  background-color: #198754 !important;
}
.badge-secondary {
  background-color: #6c757d !important;
}
.btn-outline-primary {
  border-color: #0d6efd;
  color: #0d6efd;
}
.btn-outline-primary:hover {
  background-color: #0d6efd;
  color: #fff;
}
.btn-warning {
  background-color: #ffc107;
  border-color: #ffc107;
  color: #212529;
}
.btn-warning:hover {
  background-color: #e0a800;
  border-color: #d39e00;
  color: #fff;
}
</style>