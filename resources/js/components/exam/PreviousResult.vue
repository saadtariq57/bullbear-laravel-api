<template>
  <div class="previous-results container my-4">
    <div class="row">
      <!-- Main Content Area (8 Columns) -->
      <div class="col-lg-8">
        <div v-if="showAllResults">
          <!-- Header Section with Tooltip -->
          <div class="mb-4 d-flex align-items-center">
            <h2 class="fw-6 text-uppercase m-0 me-3" data-bs-toggle="tooltip" data-bs-placement="top" title="View your previous exam results">
              Previous Exam Results
            </h2>
            <i class="bi bi-info-circle-fill text-primary" data-bs-toggle="tooltip" data-bs-placement="top" title="Check detailed results of your past exams"></i>
          </div>
          <div class="border border-bottom border-primary d-inline-block mb-4" style="width: 100px;"></div>

          <!-- No Results Message -->
          <div v-if="results.length === 0" class="alert alert-warning" role="alert">
            No previous results available.
          </div>

          <!-- Results List with Pagination -->
          <div v-else>
            <div class="row">
              <div
                v-for="result in paginatedResults"
                :key="result.id"
                class="result-item col-lg-6 mb-4"
                @mouseover="showTooltip = true"
                @mouseleave="showTooltip = false"
              >
                <div class="card rounded-2 shadow-lg h-100">
                  <div class="card-body d-flex flex-column">
                    <div class="d-flex justify-content-between align-items-center mb-3">
                      <h5 class="card-title text-capitalize">{{ result.exam_name }}</h5>
                      <span :class="['badge', statusBadge(result.percentage)]">
                        {{ statusText(result.percentage) }}
                      </span>
                    </div>
                    <div class="table-responsive flex-grow-1">
                      <table class="table table-borderless mb-0">
                        <tbody>
                          <tr>
                            <th class="fw-bolder">Date:</th>
                            <td class="text-end">{{ formatDate(result.exam_date) }}</td>
                          </tr>
                          <tr>
                            <th class="fw-bolder">Time Consumed:</th>
                            <td class="text-end">{{ formatTime(result.time_consumed) }}</td>
                          </tr>
                          <tr>
                            <th class="fw-bolder">Total Questions:</th>
                            <td class="text-end">{{ result.total_questions }}</td>
                          </tr>
                          <tr>
                            <th class="fw-bolder">Correct Answers:</th>
                            <td class="text-end">{{ result.correct_answers }}</td>
                          </tr>
                          <tr>
                            <th class="fw-bolder">Percentage:</th>
                            <td class="text-end">{{ result.percentage }}%</td>
                          </tr>
                        </tbody>
                      </table>
                    </div>
                    <!-- Progress Bar -->
                    <div class="progress my-3">
                      <div
                        class="progress-bar"
                        role="progressbar"
                        :style="{ width: result.percentage + '%' }"
                        :aria-valuenow="result.percentage"
                        aria-valuemin="0"
                        aria-valuemax="100"
                      ></div>
                    </div>
                    <!-- Action Button -->
                    <div class="mt-auto text-center">
                      <button
                        class="btn btn-primary"
                        @click="showQuestionsFor(result)"
                        data-bs-toggle="tooltip"
                        data-bs-placement="top"
                        title="View correct answers and explanations"
                      >
                        See Correct Answers
                      </button>
                    </div>
                  </div>
                </div>
              </div>
            </div>

            <!-- Pagination Controls -->
            <nav aria-label="Results pagination" class="mt-3">
              <ul class="pagination justify-content-center">
                <li class="page-item" :class="{ disabled: currentPage === 1 }">
                  <a class="page-link" href="#" @click.prevent="changePage(currentPage - 1)">Previous</a>
                </li>
                <li
                  class="page-item"
                  v-for="page in totalPages"
                  :key="page"
                  :class="{ active: currentPage === page }"
                >
                  <a class="page-link" href="#" @click.prevent="changePage(page)">{{ page }}</a>
                </li>
                <li class="page-item" :class="{ disabled: currentPage === totalPages }">
                  <a class="page-link" href="#" @click.prevent="changePage(currentPage + 1)">Next</a>
                </li>
              </ul>
            </nav>
          </div>
        </div>

        <!-- Questions View -->
        <div v-if="showQuestions" class="exams">
          <div class="result-questions">
            <h2>{{ exam.exam_name }}</h2>
            <div class="border border-bottom border-primary d-inline-block mb-4" style="width: 100px;"></div>
            <div v-if="questions.length === 0" class="alert alert-info" role="alert">
              No questions available for this result.
            </div>
            <div v-else>
              <div v-for="(question, index) in questions.questions" :key="index" class="question-item mb-4">
                <h5>Question {{ index + 1 }}: {{ question.question_text }}</h5>
                <ul class="answer_sheet_list p-0 mb-3">
                  <li :class="{ correct: isCorrectAnswer(question, 'A'), incorrect: !isCorrectAnswer(question, 'A') && userAnswered(question, 'A') }">
                    A. {{ question.option_a }}
                  </li>
                  <li :class="{ correct: isCorrectAnswer(question, 'B'), incorrect: !isCorrectAnswer(question, 'B') && userAnswered(question, 'B') }">
                    B. {{ question.option_b }}
                  </li>
                  <li :class="{ correct: isCorrectAnswer(question, 'C'), incorrect: !isCorrectAnswer(question, 'C') && userAnswered(question, 'C') }">
                    C. {{ question.option_c }}
                  </li>
                  <li :class="{ correct: isCorrectAnswer(question, 'D'), incorrect: !isCorrectAnswer(question, 'D') && userAnswered(question, 'D') }">
                    D. {{ question.option_d }}
                  </li>
                </ul>
                <p class="correct_answer">Correct Answer: {{ question.correct_answer }}</p>
              </div>
            </div>
          </div>
          <div class="text-center my-4">
            <button class="btn btn-secondary" @click="backToResults" data-bs-toggle="tooltip" data-bs-placement="top" title="Go back to the results list">
              &lt; Back to Previous Exam Results
            </button>
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
import axios from 'axios';
import { onMounted, ref, computed } from 'vue';
import RecommendedExams from './RecommendedExams.vue';
import PastPerformance from './PastPerformance.vue';
import RecommendedEbooks from '../widgets/RecommendedEbooks.vue';

export default {
  name: 'PreviousResultsExam',
  components: {
    RecommendedExams,
    PastPerformance,
    RecommendedEbooks
  },
  data() {
    return {
      results: [],
      showAllResults: true,
      showQuestions: false,
      exam: null,
      questions: [],
      currentPage: 1,
      perPage: 5,
      showTooltip: false,
      tooltipInstances: [],
    };
  },
  computed: {
    totalPages() {
      return Math.ceil(this.results.length / this.perPage);
    },
    paginatedResults() {
      const start = (this.currentPage - 1) * this.perPage;
      return this.results.slice(start, start + this.perPage);
    },
  },
  methods: {
    async fetchPreviousResults() {
      try {
        const response = await axios.get('/api/exams/results');
        this.results = response.data;
      } catch (error) {
        console.error('Error fetching previous results:', error);
      }
    },
    async fetchQuestionsForResult(result) {
      try {
        const response = await axios.get(`/api/exams/${result.exam_id}/questions`);
        this.exam = result;
        this.questions = response.data;
        this.showQuestions = true;
        this.showAllResults = false;
        this.initializeTooltips();
      } catch (error) {
        console.error('Error fetching questions:', error);
      }
    },
    showQuestionsFor(result) {
      this.fetchQuestionsForResult(result);
    },
    backToResults() {
      this.showQuestions = false;
      this.showAllResults = true;
      this.initializeTooltips();
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
    isCorrectAnswer(question, selectedAnswer) {
      return question.correct_answer === selectedAnswer;
    },
    userAnswered(question, selectedAnswer) {
      // Implement logic to check if the user selected this answer
      // Placeholder implementation:
      return question.user_answer === selectedAnswer;
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
    changePage(page) {
      if (page < 1 || page > this.totalPages) return;
      this.currentPage = page;
      this.initializeTooltips();
    },
    initializeTooltips() {
      if (typeof window.bootstrap === 'undefined') {
        return;
      }

      this.disposeTooltips();

      const tooltipTriggerList = Array.from(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
      this.tooltipInstances = tooltipTriggerList.map(
        (tooltipTriggerEl) => new window.bootstrap.Tooltip(tooltipTriggerEl)
      );
    },
    disposeTooltips() {
      if (!this.tooltipInstances?.length) {
        return;
      }
      this.tooltipInstances.forEach((instance) => {
        if (instance && typeof instance.dispose === 'function') {
          instance.dispose();
        }
      });
      this.tooltipInstances = [];
    },
  },
  mounted() {
    this.fetchPreviousResults();
    this.$nextTick(() => {
      this.initializeTooltips();
    });
  },
  beforeUnmount() {
    this.disposeTooltips();
  },
};
</script>

<style scoped>
.previous-results {
  /* General container styling */
}

.result-item {
  transition: transform 0.2s, box-shadow 0.2s;
}

.result-item:hover {
  transform: translateY(-5px);
  box-shadow: 0 8px 16px rgba(0, 0, 0, 0.2);
}

.badge {
  font-size: 0.9em;
}

.answer_sheet_list {
  list-style: none;
  padding: 0;
  display: flex;
  flex-direction: column;
  gap: 8px;
}

.answer_sheet_list li {
  position: relative;
  padding-left: 25px;
  font-size: 1rem;
  line-height: 1.5;
}

.answer_sheet_list li.correct {
  color: green;
  font-weight: 600;
}

.answer_sheet_list li.incorrect {
  color: red;
  font-weight: 600;
}

.answer_sheet_list li::before {
  content: '';
  position: absolute;
  left: 0;
  top: 50%;
  transform: translateY(-50%);
  width: 18px;
  height: 18px;
  background-size: contain;
  background-repeat: no-repeat;
}

.answer_sheet_list li.correct::before {
  background-image: url('/build/images/checkmark.png');
}

.answer_sheet_list li.incorrect::before {
  background-image: url('/build/images/close.png');
}

.correct_answer {
  text-align: center;
  font-weight: bold;
  color: #333;
}

.sidebar-widgets .card {
  /* Styling for sidebar widgets */
}

@media (max-width: 992px) {
  /* Responsive adjustments */
  .sidebar-widgets {
    margin-top: 2rem;
  }
}
</style>