<template>
  <div class="recommended-exams-wrapper bg-white p-3 border-1 border rounded-2 shadow-sm mb-2">
      <div class="text-center">
        <h3 class="fw-bold text-uppercase">Recommended Exams</h3>
        <div class="border-heading d-inline-block mt-4 mb-3"></div>
      </div>
      <div class="card-body">
        <!-- Loading Spinner -->
        <div v-if="loading" class="text-center">
          <div class="spinner-border text-primary" role="status">
            <span class="visually-hidden">Loading...</span>
          </div>
        </div>

        <!-- Recommended Exams List -->
        <div v-else-if="recommendedExams.length > 0">
          <div class="list-group list-group-flush">
            <div
              v-for="exam in recommendedExams"
              :key="exam.id"
              class="list-group-item d-flex flex-column flex-md-row justify-content-between align-items-end px-0"
            >
              <!-- Exam Details -->
              <div class="col-8">
                <h5 class="mb-1 fs-5 fw-bold">{{ exam.title }}</h5>
                <p class="mb-1 fs-6 mb-3 text-muted">
                  {{ truncateDescription(exam.description) }}
                </p>
                
                <div class="d-flex align-items-center mb-2">
                  <span class="badge bg-secondary me-2">{{ capitalize(exam.type) }}</span>
                  <span class="me-2">
                    <i class="bi bi-list-ol me-1"></i>{{ exam.number_of_questions }} Questions
                  </span>
                  <span>
                    <i class="bi bi-stopwatch-fill me-1"></i>{{ exam.per_question_time_limit }} sec/Q
                  </span>
                </div>
              </div>

              <!-- Action Button -->
              <div class="col-4 mt-3 mt-md-0">
                <button
                  :class="['btn btn-sidebar fw-bold', buttonClass(exam)]"
                  @click="handleExamClick(exam)"
                  data-bs-toggle="tooltip"
                  :title="buttonTooltip(exam)"
                >
                  {{ buttonText(exam) }}
                  <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512"><path d="M438.6 278.6c12.5-12.5 12.5-32.8 0-45.3l-160-160c-12.5-12.5-32.8-12.5-45.3 0s-12.5 32.8 0 45.3L338.8 224 32 224c-17.7 0-32 14.3-32 32s14.3 32 32 32l306.7 0L233.4 393.4c-12.5 12.5-12.5 32.8 0 45.3s32.8 12.5 45.3 0l160-160z"/></svg>
                </button>
              </div>
            </div>
          </div>
        </div>

        <!-- No Exams Available -->
        <div v-else class="text-center">
          <p>No recommended exams available at the moment.</p>
        </div>
      </div>
  </div>
</template>

<script>
// Import necessary modules and dependencies
import axios from 'axios';
import Swal from 'sweetalert2';
import { mapState, mapActions, mapGetters } from 'vuex';
import { registerVuexModule, unregisterVuexModule } from '@/stores/registerModule';
import examStoreModule from '@/stores/examStore';
import subscriptionStatusModule from '@/stores/subscriptionStatus';

export default {
  name: "RecommendedExams",
  data() {
    return {
      recommendedExams: [],
      loading: false,
      tooltipInstances: [],
    };
  },
  computed: {
    // Map Vuex state to computed properties
    ...mapState({
      isAuthenticated: state => state.subscriptionStatus.isAuthenticated,
      isLoadingSubscription: state => state.subscriptionStatus.isLoading,
    }),
    ...mapGetters('subscriptionStatus', ['hasBasicExam', 'hasAdvanceExam']),
  },
  methods: {
    // Map Vuex actions
    ...mapActions('exam', ['initiateExam']),
    ...mapActions('subscriptionStatus', ['fetchSubscriptionStatus']),

    /**
     * Fetch recommended exams from the API.
     */
    async fetchRecommendedExams() {
      this.loading = true;
      try {
        const response = await axios.get('/api/exams/recommended');
        this.recommendedExams = response.data;
      } catch (error) {
        console.error('Error fetching recommended exams:', error);
        Swal.fire({
          title: "Error!",
          text: "There was an error fetching recommended exams. Please try again later.",
          icon: "error",
          confirmButtonText: "OK",
        });
      } finally {
        this.loading = false;
      }
    },

    /**
     * Truncate the exam description for better UI.
     * @param {String} description - The exam description.
     * @returns {String} - Truncated description.
     */
    truncateDescription(description) {
      if (!description) return "No Description Provided.";
      return description.length > 100 ? description.substring(0, 100) + "..." : description;
    },

    /**
     * Capitalize the first letter of a string.
     * @param {String} str - The string to capitalize.
     * @returns {String} - Capitalized string.
     */
    capitalize(str) {
      if (!str) return "";
      return str.charAt(0).toUpperCase() + str.slice(1);
    },

    /**
     * Determine the button text based on authentication and subscription status.
     * @param {Object} exam - The exam object.
     * @returns {String} - The button text.
     */
    buttonText(exam) {
      if (!this.isAuthenticated) {
        return "Login to Take Exam";
      }

      const hasAccess = this.checkExamAccess(exam.type);
      if (hasAccess) {
        return "Start Exam";
      } else {
        return "Upgrade to Take Exam";
      }
    },

    /**
     * Determine the button CSS class based on authentication and subscription status.
     * @param {Object} exam - The exam object.
     * @returns {String} - The button CSS classes.
     */
    buttonClass(exam) {
      if (!this.isAuthenticated) {
        return "btn-outline-primary";
      }

      const hasAccess = this.checkExamAccess(exam.type);
      if (hasAccess) {
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

      const hasAccess = this.checkExamAccess(exam.type);
      if (hasAccess) {
        return "Click to start the exam.";
      } else {
        return "Upgrade your subscription to access this exam.";
      }
    },

    /**
     * Check if the user has access to the exam based on its type.
     * @param {String} type - The type of the exam ('basic' or 'advanced').
     * @returns {Boolean} - Whether the user has access.
     */
    checkExamAccess(type) {
      if (type === "basic") {
        return this.hasBasicExam;
      }
      if (type === "advanced") {
        return this.hasAdvanceExam;
      }
      return false;
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

      const hasAccess = this.checkExamAccess(exam.type);
      if (hasAccess) {
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
        const { firstQuestionId, examName } = await this.initiateExam(examId);
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
      this.$store.dispatch("auth/showLoginPopup"); // Adjust based on your Vuex store
      // Assuming you want to redirect back to the current page after login
      this.$store.dispatch("auth/setRedirectPath", this.$route.fullPath);
    },

    /**
     * Redirect the user to the subscription upgrade page.
     */
    upgradeSubscription() {
      Swal.fire({
        title: 'Upgrade Required',
        text: 'You need to upgrade your subscription to access this exam.',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonText: 'Upgrade Now',
        cancelButtonText: 'Later'
      }).then((result) => {
        if (result.isConfirmed) {
          this.$router.push('/pricing');
        }
      });
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
  mounted() {
    // Register Vuex modules
    registerVuexModule('exam', examStoreModule);
    registerVuexModule('subscriptionStatus', subscriptionStatusModule);

    // Fetch subscription status first to ensure access checks are accurate
    this.fetchSubscriptionStatus().then(() => {
      // After fetching subscription status, fetch recommended exams
      this.fetchRecommendedExams();
    });

    this.$nextTick(() => {
      this.initTooltips();
    });
  },
  beforeUnmount() {
    // Keep exam module alive so ongoing exams retain state
    unregisterVuexModule('subscriptionStatus');
    this.disposeTooltips();
  },
  updated() {
    this.initTooltips();
  },
};
</script>

<style scoped>

.list-group-item {
  border: none;
  border-bottom: 1px solid #e9ecef;
}

.list-group-item:last-child {
  border-bottom: none;
}

.btn-sidebar{
  padding: 7px 15px;
}
.btn-sidebar svg{
  width: 12px;
  margin-left: 7px;
}
.btn-sidebar svg path{
  fill: #ffffff;
}
</style>
