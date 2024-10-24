<template>
  <div class="container-lg p-0 my-4">
    <div class="row">
      <!-- Main Content Area (8 Columns) -->
      <div class="col-lg-8">
        <div class="card rounded-2 shadow-lg p-5">
          <!-- Header Section with Tooltip -->
          <div class="d-flex align-items-center mb-4">
            <h3
              class="fw-6 text-uppercase m-0 me-3"
              data-bs-toggle="tooltip"
              data-bs-placement="top"
              title="Detailed results of your exam"
            >
              {{ examTitle }}
            </h3>
            <i
              class="bi bi-info-circle-fill text-primary"
              data-bs-toggle="tooltip"
              data-bs-placement="top"
              title="Review your performance and scores"
            ></i>
          </div>
          <div class="border border-bottom border-primary d-inline-block mb-4" style="width: 100px;"></div>

          <!-- Exam Details Table -->
          <div class="row">
            <div class="table-responsive col-12 col-md-6">
              <table class="table table-borderless">
                <tbody>
                  <tr>
                    <th class="fw-bolder" data-bs-toggle="tooltip" data-bs-placement="top" title="Date when the exam was taken">Date:</th>
                    <td>{{ formatDate(examResult.exam_date) }}</td>
                  </tr>
                  <tr>
                    <th class="fw-bolder" data-bs-toggle="tooltip" data-bs-placement="top" title="Total time you took to complete the exam">Time Consumed:</th>
                    <td>{{ formatTime(examResult.time_consumed) }}</td>
                  </tr>
                  <tr>
                    <th class="fw-bolder" data-bs-toggle="tooltip" data-bs-placement="top" title="Total number of questions in the exam">Total Questions:</th>
                    <td>{{ examResult.total_questions }}</td>
                  </tr>
                  <tr>
                    <th class="fw-bolder" data-bs-toggle="tooltip" data-bs-placement="top" title="Number of questions you answered correctly">Correct Answers:</th>
                    <td>{{ examResult.correct_answers }}</td>
                  </tr>
                  <tr>
                    <th class="fw-bolder" data-bs-toggle="tooltip" data-bs-placement="top" title="Your score percentage">Percentage:</th>
                    <td>{{ examResult.percentage }}%</td>
                  </tr>
                  <tr>
                    <th class="fw-bolder" data-bs-toggle="tooltip" data-bs-placement="top" title="Your result status based on your percentage">Result:</th>
                    <td>
                      <span :class="['badge', statusBadge(examResult.percentage)]">
                        {{ statusText(examResult.percentage) }}
                      </span>
                    </td>
                  </tr>
                </tbody>
              </table>
            </div>
            <!-- Visual Representation (Progress Bar) -->
            <div class="col-12 col-md-6 d-flex flex-column align-items-center justify-content-center">
              <div class="percentage-circle position-relative">
                <svg class="progress-circle" width="150" height="150">
                  <circle
                    class="progress-bg"
                    cx="75"
                    cy="75"
                    r="70"
                    stroke="#e6e6e6"
                    stroke-width="10"
                    fill="none"
                  />
                  <circle
                    class="progress-bar"
                    :stroke="percentageColor(examResult.percentage)"
                    cx="75"
                    cy="75"
                    r="70"
                    :stroke-dasharray="circumference"
                    :stroke-dashoffset="strokeOffset"
                    stroke-width="10"
                    fill="none"
                  />
                </svg>
                <div class="percentage-text position-absolute top-50 start-50 translate-middle">
                  {{ examResult.percentage }}%
                </div>
              </div>
            </div>
          </div>

          <!-- Action Buttons -->
          <div class="d-flex justify-content-between align-items-center mt-4">
            <button
              class="btn btn-primary"
              @click="viewPreviousResults"
              data-bs-toggle="tooltip"
              data-bs-placement="top"
              title="View All Previous Exam Results"
            >
              View Previous Results
            </button>
            <router-link
              to="/exams"
              class="btn btn-secondary"
              data-bs-toggle="tooltip"
              data-bs-placement="top"
              title="Go back to the Exam Center"
            >
              &lt; Back to Exam Center
            </router-link>
          </div>
        </div>
      </div>

      <!-- Sidebar Area (4 Columns) -->
      <div class="col-lg-4">
        <div class="sidebar-widgets mt-4 mt-lg-0">
          <!-- Recommended Exams Widget -->
          <RecommendedExams />

          <!-- Past Performance Widget -->
          <PastPerformance />

          <!-- Recommended E-books Widget -->
          <RecommendedEbooks />
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import axios from "axios";
import RecommendedExams from './RecommendedExams.vue';
import PastPerformance from './PastPerformance.vue';
import RecommendedEbooks from '../widgets/RecommendedEbooks.vue';

export default {
  name: "ExamResult",
  components: {
    RecommendedExams,
    PastPerformance,
    RecommendedEbooks
  },
  data() {
    return {
      examId: null,
      examTitle: '',
      examResult: {},
    };
  },
  computed: {
    circumference() {
      return 2 * Math.PI * 70;
    },
    // Calculate the stroke offset based on the percentage
    strokeOffset() {
      return this.circumference - (this.circumference * this.examResult.percentage) / 100;
    },
  },
  methods: {
    async fetchExamResult() {
      try {
        const response = await axios.get(`/api/exams/result/${this.examId}`);
        this.examResult = response.data;
        this.examTitle = this.examResult.exam_name || 'Exam Result';
        this.initializeTooltips();
      } catch (error) {
        console.error("Error fetching exam result:", error);
      }
    },
    formatTime(timeInSeconds) {
      if (timeInSeconds < 60) {
        return `${timeInSeconds} sec`;
      } else {
        const minutes = Math.floor(timeInSeconds / 60);
        const seconds = timeInSeconds % 60;
        return `${minutes} min ${seconds} sec`;
      }
    },
    formatDate(dateString) {
      const options = { year: 'numeric', month: 'long', day: 'numeric' };
      return new Date(dateString).toLocaleDateString(undefined, options);
    },
    statusText(percentage) {
      if (percentage > 80) return 'Excellent';
      if (percentage > 70) return 'Great';
      if (percentage >= 60) return 'Good';
      if (percentage >= 50) return 'Pass';
      return 'Fail';
    },
    statusBadge(percentage) {
      if (percentage > 80) return 'bg-success';
      if (percentage > 70) return 'bg-info';
      if (percentage >= 60) return 'bg-primary';
      if (percentage >= 50) return 'bg-warning';
      return 'bg-danger';
    },
    percentageColor(percentage) {
      if (percentage > 80) return '#28a745'; // Green
      if (percentage > 70) return '#17a2b8'; // Teal
      if (percentage >= 60) return '#007bff'; // Blue
      if (percentage >= 50) return '#ffc107'; // Yellow
      return '#dc3545'; // Red
    },
    viewPreviousResults() {
      // Navigate to the detailed feedback page
      this.$router.push(`/previous-results`);
    },
    initializeTooltips() {
      // Initialize Bootstrap tooltips
      const tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
      tooltipTriggerList.map((tooltipTriggerEl) => new bootstrap.Tooltip(tooltipTriggerEl));
    },
  },
  mounted() {
    this.examId = this.$route.params.id;
    this.fetchExamResult();
  },
};
</script>


<style scoped>
.percentage-circle {
  width: 150px;
  height: 150px;
}

.progress-circle {
  transform: rotate(-90deg);
}

.percentage-text {
  font-size: 1.5rem;
  font-weight: bold;
  color: #333;
}

.progress-bar {
  transition: stroke-dashoffset 1s ease;
}

.table th {
  width: 40%;
}

.badge {
  font-size: 1rem;
  padding: 0.5em 0.75em;
}

.sidebar-widgets .card {
  /* Styling for sidebar widgets */
}

.sidebar-widgets .card-header {
  display: flex;
  justify-content: space-between;
  align-items: center;
}

@media (max-width: 992px) {
  .sidebar-widgets {
    margin-top: 2rem;
  }
}
</style>