<template>
  <div class="container my-4">
    <!-- Exam Header with Timer and Cancel Button -->
    <div class="exam-header bg-white shadow-sm p-4 mb-3 d-flex justify-content-between align-items-center">
      <div class="d-flex align-items-center">
        <h2 class="exam-title">{{ formattedExamName }}</h2>
        <button
          class="btn btn-outline-danger ms-4"
          @click="cancelExam"
          data-bs-toggle="tooltip"
          data-bs-placement="bottom"
          title="Cancel the exam and return to exams page"
        >
          <i class="bi bi-x-circle me-2"></i> Cancel Exam
        </button>
      </div>
      <div class="d-flex align-items-center">
        <i
          class="bi bi-clock icon-bold me-1"
          data-bs-toggle="tooltip"
          data-bs-placement="bottom"
          title="Time remaining"
        ></i>
        <span class="fs-3 fw-6 align-self-center ms-2">{{ formattedTimeLeft }}</span>
      </div>
    </div>

    <!-- Do Not Refresh Note -->
    <div class="alert alert-warning d-flex align-items-center" role="alert">
      <i class="bi bi-exclamation-triangle-fill me-2"></i>
      <div>
        Please do not refresh the page during the exam to prevent losing your progress.
      </div>
    </div>

    <!-- Progress Bar -->
    <div class="progress exam-progress mb-3">
      <div
        class="progress-bar exam-progress-bar"
        role="progressbar"
        :style="{ width: examProgress + '%' }"
        :aria-valuenow="examProgress"
        aria-valuemin="0"
        aria-valuemax="100"
      ></div>
    </div>

    <!-- Additional Introductory Text -->
    <div class="intro-text mb-4">
      <p>
        Welcome to the <strong>{{ formattedExamName }}</strong>! Please read each question carefully and select the best answer. You have a limited time to complete the exam, so manage your time wisely.
      </p>
    </div>

    <!-- Question Display -->
    <div class="exam-question bg-white shadow-sm p-4">
      <!-- Skeleton Loader -->
      <div v-if="isLoading" class="skeleton-loader">
        <div class="skeleton-title"></div>
        <div class="skeleton-text"></div>
        <div class="skeleton-options">
          <div class="skeleton-option"></div>
          <div class="skeleton-option"></div>
          <div class="skeleton-option"></div>
          <div class="skeleton-option"></div>
        </div>
        <div class="skeleton-button"></div>
      </div>

      <!-- Actual Content -->
      <div v-else>
        <div v-if="currentQuestion" class="container-lg exam-main my-2">
          <p class="fw-bold fs-5 text-start my-4 text-black">
            <strong>Question {{ currentQuestionIndex + 1 }} of {{ totalQuestions }}</strong>
          </p>
          <h3 class="fw-6 fs-4 text-uppercase text-start mb-3">{{ currentQuestion.question_text }}</h3>
          <div class="text-center mb-4">
            <img
              v-if="currentQuestion.featured_image"
              :src="currentQuestion.featured_image"
              alt="Question Image"
              class="my-2 img-fluid animated-img"
              style="max-width: 400px;"
            />
          </div>

          <!-- Options Form -->
          <form @submit.prevent="submitAnswer">
            <div
              v-for="(option, optionKey) in getOptions(currentQuestion)"
              :key="optionKey"
              class="form-check mb-3 option-container"
            >
              <input
                v-model="selectedAnswer"
                class="form-check-input custom-radio-btn radio"
                type="radio"
                :name="'option' + currentQuestion.id"
                :id="'option' + optionKey"
                :value="option"
                data-bs-toggle="tooltip"
                data-bs-placement="right"
                :title="'Select option ' + String.fromCharCode(65 + optionKey)"
                @mouseenter="showTooltip($event)"
                @mouseleave="hideTooltip($event)"
              />
              <label
                class="form-check-label fw-5 mb-0 fs-5 option-label"
                :for="'option' + optionKey"
              >
                <span class="option-letter">{{ String.fromCharCode(65 + optionKey) }}.</span>
                {{ option }}
              </label>
            </div>
            <div class="d-flex justify-content-between mt-4">
              <button
                v-if="!isFirstQuestion"
                type="button"
                class="btn btn-secondary"
                @click="goToPreviousQuestion"
                data-bs-toggle="tooltip"
                data-bs-placement="top"
                title="Go to previous question"
              >
                <i class="bi bi-arrow-left"></i> Previous
              </button>
              <button
                v-if="!isLastQuestion"
                type="submit"
                class="btn btn-primary"
                :disabled="!selectedAnswer"
                data-bs-toggle="tooltip"
                data-bs-placement="top"
                title="Submit your answer and go to next question"
              >
                Next Question <i class="bi bi-arrow-right"></i>
              </button>
              <button
                v-else
                type="submit"
                class="btn btn-success"
                :disabled="!selectedAnswer"
                data-bs-toggle="tooltip"
                title="Submit your final answer and view results"
              >
                Show Results <i class="bi bi-check-circle"></i>
              </button>
            </div>
          </form>
        </div>
        <div v-else class="no-questions">
          <p>No questions available.</p>
        </div>
      </div>
    </div>

    <!-- Footer with Additional Information -->
    <div class="exam-footer mt-4 text-center">
      <p>
        Good luck! Ensure you have a stable internet connection before starting the exam. If you encounter any issues, please contact support.
      </p>
    </div>
  </div>
</template>

<script>
import { mapState, mapActions, mapGetters } from 'vuex';
import Swal from 'sweetalert2';

export default {
  name: 'ExamQuestions',
  data() {
    return {
      selectedAnswer: null,
      timeLeft: { minutes: 0, seconds: 0 },
      timer: null,
      questionStartTime: null,
      tooltips: [],
      isLoading: true,
    };
  },
  computed: {
    // Map Vuex state
    ...mapState('exam', [
      'examId',
      'timeLimit',
      'examName',
      'examQuestions',
      'currentQuestionIndex',
      'userAnswers',
    ]),
    ...mapGetters('exam', [
      'totalQuestions',
      'isLastQuestion',
      'currentQuestion',
      'examProgress',
    ]),

    isFirstQuestion() {
      return this.currentQuestionIndex === 0;
    },
    formattedTimeLeft() {
      const minutes = this.timeLeft.minutes;
      const seconds = this.timeLeft.seconds < 10 ? `0${this.timeLeft.seconds}` : this.timeLeft.seconds;
      return `${minutes}:${seconds}`;
    },
    formattedExamName() {
      return this.examName ? this.examName.replace(/-/g, ' ').toUpperCase() : 'EXAM';
    },
  },
  methods: {
    // Map Vuex actions
    ...mapActions('exam', [
      'fetchExamQuestions',
      'submitExam',
      'addAnswer',
      'resetExamState',
    ]),
    getOptions(question) {
      return [question.option_a, question.option_b, question.option_c, question.option_d];
    },
    async submitAnswer() {
      if (!this.selectedAnswer) {
        Swal.fire({
          title: 'No Answer Selected',
          text: 'Please select an answer before proceeding.',
          icon: 'warning',
          confirmButtonText: 'OK',
        });
        return;
      }

      const timeSpent = (Date.now() - this.questionStartTime) / 1000;
      const selectedOptionIdentifier = this.getOptionIdentifier(this.selectedAnswer, this.currentQuestion);
      this.addAnswer({
        questionId: this.currentQuestion.id,
        answer: selectedOptionIdentifier,
        timeSpent,
      });

      if (this.isLastQuestion) {
        if (this.userAnswers.length === 0) {
          Swal.fire({
            title: 'No Answers Provided',
            text: 'You have not answered any questions. Please answer at least one question to view results.',
            icon: 'info',
            confirmButtonText: 'OK',
          });
          return;
        }
        await this.submitResults();
      } else {
        this.moveToNextQuestion();
      }
    },
    getOptionIdentifier(selectedOption, question) {
      const options = [question.option_a, question.option_b, question.option_c, question.option_d];
      const index = options.indexOf(selectedOption);
      return index >= 0 ? String.fromCharCode(65 + index) : null;
    },
    async submitResults() {
      clearInterval(this.timer);
      try {
        const response = await this.submitExam();
        // Navigate to results page
        this.$router.push(`/exam/result/${response.data.examResultId}`);
      } catch (error) {
        console.error('Error submitting exam results:', error);
        Swal.fire({
          title: 'Error!',
          text: 'There was an error submitting exam results. Please try again later.',
          icon: 'error',
          confirmButtonText: 'OK',
        });
      }
    },
    moveToNextQuestion() {
      if (this.currentQuestionIndex < this.examQuestions.length - 1) {
        this.$store.commit('exam/setCurrentQuestionIndex', this.currentQuestionIndex + 1);
        this.loadQuestion(this.currentQuestionIndex + 1);
      } else {
        this.submitResults();
      }
    },
    goToPreviousQuestion() {
      if (this.currentQuestionIndex > 0) {
        this.$store.commit('exam/setCurrentQuestionIndex', this.currentQuestionIndex - 1);
        this.loadQuestion(this.currentQuestionIndex - 1);
      }
    },
    loadQuestion(index) {
      this.isLoading = true; // Start loading
      setTimeout(() => { // Simulate loading delay
        const previousAnswer = this.userAnswers.find(
          (ans) => ans.questionId === this.currentQuestion.id
        );
        this.selectedAnswer = previousAnswer
          ? this.getOptionText(previousAnswer.answer, this.currentQuestion)
          : null;
        this.questionStartTime = Date.now();
        this.startTimer();
        this.isLoading = false; // End loading
      }, 500); // Adjust the delay as needed
    },
    getOptionText(optionIdentifier, question) {
      const mapping = {
        A: question.option_a,
        B: question.option_b,
        C: question.option_c,
        D: question.option_d,
      };
      return mapping[optionIdentifier] || null;
    },
    startTimer() {
      this.timeLeft = {
        minutes: Math.floor(this.timeLimit / 60),
        seconds: this.timeLimit % 60,
      };
      clearInterval(this.timer);
      this.timer = setInterval(() => {
        if (this.timeLeft.seconds === 0) {
          if (this.timeLeft.minutes === 0) {
            clearInterval(this.timer);
            this.autoSubmitQuestion();
          } else {
            this.timeLeft.minutes--;
            this.timeLeft.seconds = 59;
          }
        } else {
          this.timeLeft.seconds--;
        }
      }, 1000);
    },
    autoSubmitQuestion() {
      Swal.fire({
        title: 'Time Up!',
        text: 'Time for this question has expired. Moving to the next question.',
        icon: 'info',
        timer: 3000,
        showConfirmButton: false,
      });
      this.addAnswer({
        questionId: this.currentQuestion.id,
        answer: null,
        timeSpent: this.timeLimit,
      });
      this.moveToNextQuestion();
    },
    showTooltip(event) {
      const tooltip = bootstrap.Tooltip.getInstance(event.target);
      if (tooltip) {
        tooltip.show();
      }
    },
    hideTooltip(event) {
      const tooltip = bootstrap.Tooltip.getInstance(event.target);
      if (tooltip) {
        tooltip.hide();
      }
    },
    cancelExam() {
      Swal.fire({
        title: 'Cancel Exam',
        text: 'Are you sure you want to cancel the exam? All progress will be lost.',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonText: 'Yes, cancel it',
        cancelButtonText: 'No, continue',
      }).then((result) => {
        if (result.isConfirmed) {
          clearInterval(this.timer);
          this.resetExamState();
          this.$router.push('/exams');
          Swal.fire({
            title: 'Exam Cancelled',
            text: 'Your exam has been cancelled and you have been redirected to the exams page.',
            icon: 'success',
            timer: 3000,
            showConfirmButton: false,
          });
        }
      });
    },
  },
  watch: {
    // Watch for changes in examProgress to update tooltips if necessary
  },
  async mounted() {
    // Fetch exam questions
    if (!this.examId || !this.timeLimit || !this.examName) {
      Swal.fire({
        title: 'Error!',
        text: 'Exam data is missing or incomplete. Please start the exam again.',
        icon: 'error',
        confirmButtonText: 'OK',
      }).then(() => {
        this.$router.push('/exams');
      });
      return;
    }

    try {
      await this.fetchExamQuestions();
      if (this.examQuestions.length > 0) {
        this.loadQuestion(this.currentQuestionIndex);
      } else {
        Swal.fire({
          title: 'No Questions',
          text: 'There are no questions available for this exam.',
          icon: 'info',
          confirmButtonText: 'OK',
        }).then(() => {
          this.$router.push('/exams');
        });
      }
    } catch (error) {
      Swal.fire({
        title: 'Error!',
        text: 'There was an error fetching exam questions. Please try again later.',
        icon: 'error',
        confirmButtonText: 'OK',
      }).then(() => {
        this.$router.push('/exams');
      });
    }

    // Initialize Bootstrap tooltips with proper triggers
    if (typeof bootstrap !== 'undefined') {
      const tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
      tooltipTriggerList.forEach((tooltipTriggerEl) => {
        const tooltip = new bootstrap.Tooltip(tooltipTriggerEl, {
          trigger: 'hover',
          delay: { hide: 100 },
        });
        this.tooltips.push(tooltip);
      });
    }

    // Start the timer for the first question
    this.questionStartTime = Date.now();
    this.startTimer();

    // Set loading to false if data is already loaded
    this.isLoading = false;
  },
  beforeUnmount() {
    clearInterval(this.timer);
    this.resetExamState();
    // Dispose all tooltips to prevent memory leaks
    this.tooltips.forEach((tooltip) => tooltip.dispose());
  },
};
</script>

<style scoped>
.exam-header {
  /* Custom styles for the exam header */
}

.exam-title {
  font-size: 1.5rem;
  font-weight: bold;
}

.exam-progress-bar {
  background-color: #4caf50; /* Customize as needed */
}

.exam-question {
  /* Custom styles for the question container */
}

.btn-primary,
.btn-secondary,
.btn-success,
.btn-outline-danger {
  min-width: 150px;
  transition: transform 0.2s, box-shadow 0.2s;
}

.btn-primary:hover,
.btn-secondary:hover,
.btn-success:hover,
.btn-outline-danger:hover {
  transform: translateY(-2px);
  box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
}

.option-container {
  position: relative;
  transition: transform 0.2s;
}

.option-container:hover {
  transform: scale(1.02);
}

.radio:checked + .option-label {
  background-color: #e0f7fa;
  border-radius: 5px;
  padding: 10px;
  transition: background-color 0.3s, box-shadow 0.3s;
  box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
}

.option-label {
  cursor: pointer;
  display: flex;
  align-items: center;
  transition: background-color 0.3s, box-shadow 0.3s;
}

.option-letter {
  font-weight: bold;
  margin-right: 8px;
}

.animated-img {
  animation: fadeIn 1s ease-in-out;
}

.no-questions {
  text-align: center;
  padding: 20px;
  font-size: 1.2rem;
  color: #777;
}

/* Fade-in animation for images */
@keyframes fadeIn {
  from {
    opacity: 0;
    transform: scale(0.95);
  }
  to {
    opacity: 1;
    transform: scale(1);
  }
}

/* Button animations */
.btn {
  position: relative;
  overflow: hidden;
}

.btn::after {
  content: '';
  position: absolute;
  top: 50%;
  left: 50%;
  width: 300%;
  height: 300%;
  background: rgba(255, 255, 255, 0.3);
  transition: all 0.6s ease;
  opacity: 0;
  transform: translate(-50%, -50%) rotate(45deg);
}

.btn:active::after {
  opacity: 1;
  width: 0;
  height: 0;
  transition: 0s;
}

/* Disable button styles */
.btn:disabled {
  opacity: 0.6;
  cursor: not-allowed;
}

/* Responsive adjustments */
@media (max-width: 576px) {
  .exam-title {
    font-size: 1.25rem;
  }
  .fs-5 {
    font-size: 1rem;
  }
}

/* Skeleton Loader Styles */
.skeleton-loader {
  display: flex;
  flex-direction: column;
  gap: 1rem;
}

.skeleton-title {
  width: 60%;
  height: 24px;
  background-color: #e0e0e0;
  border-radius: 4px;
  animation: pulse 1.5s infinite;
}

.skeleton-text {
  width: 80%;
  height: 20px;
  background-color: #e0e0e0;
  border-radius: 4px;
  animation: pulse 1.5s infinite;
}

.skeleton-options {
  display: flex;
  flex-direction: column;
  gap: 0.5rem;
}

.skeleton-option {
  width: 100%;
  height: 36px;
  background-color: #e0e0e0;
  border-radius: 4px;
  animation: pulse 1.5s infinite;
}

.skeleton-button {
  width: 150px;
  height: 40px;
  background-color: #e0e0e0;
  border-radius: 4px;
  animation: pulse 1.5s infinite;
}

/* Pulse animation for skeleton loaders */
@keyframes pulse {
  0% {
    background-color: #e0e0e0;
  }
  50% {
    background-color: #f0f0f0;
  }
  100% {
    background-color: #e0e0e0;
  }
}

/* Introductory Text Styles */
.intro-text p {
  font-size: 1.1rem;
  color: #555;
}

/* Footer Styles */
.exam-footer p {
  font-size: 0.95rem;
  color: #777;
}

/* Additional Enhancements for Better Aesthetics */
.container.my-4 {
  max-width: 800px;
  margin: auto;
}

/* Alert Styles */
.alert-warning {
  display: flex;
  align-items: center;
  font-size: 0.95rem;
  background-color: #fff3cd;
  color: #856404;
  border: 1px solid #ffeeba;
  border-radius: 0.25rem;
  padding: 0.75rem 1.25rem;
}

.alert-warning i {
  font-size: 1.5rem;
}
</style>