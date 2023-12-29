<template>
  <section class="container-lg mt-3 py-80">
    <!-- Exam Header with Timer -->
    <div class="exam-header bg-white shadow-sm p-4 mb-3">
      <p class="d-flex justify-content-end">
        <i class="bi bi-clock icon-bold me-1"></i> Time Left - <span class="fs-3 fw-6 align-self-center ms-2">{{ timeLeft.minutes }}:{{ timeLeft.seconds }}</span>
      </p>
      <div class="progress exam-progress">
        <div class="progress-bar exam-progress-bar" role="progressbar" aria-label="Basic example" :style="{ width: examProgress + '%' }"></div>
      </div>
    </div>

    <!-- Question Display -->
    <div class="exam-header bg-white shadow-sm p-4">
      <div v-if="examQuestion" class="container-lg exam-main my-2">
        <p class="fw-bold fs-18 text-start my-4 text-black">
          <b>Question </b>{{ currentQuestionIndex + 1 }} of {{ totalQuestions }}
        </p>
        <h3 class="fw-6 fs-18 text-uppercase text-start">{{ examQuestion.question_text }}</h3>
        <div class="text-center">
          <img v-if="examQuestion.featured_image" :src="examQuestion.featured_image" alt="" class="my-2" width="400">
        </div>

        <!-- Options Form -->
        <form @submit.prevent="submitAnswer" class="px-4">
          <div v-for="(option, optionKey) in getOptions(examQuestion)" :key="optionKey" class="form-check p-3">
            <input v-model="selectedAnswer" class="form-check-input" type="radio" :name="'option' + examQuestion.id" :id="'option' + optionKey" :value="option">
            <label class="form-check-label fw-5" :for="'option' + optionKey">{{ option }}</label>
          </div>
          <div class="text-center">
            <button v-if="!isLastQuestion" type="submit" class="btn-primary">Next Question</button>
            <button v-else @click="showResult" class="btn-primary">Show Result</button>
          </div>
        </form>
      </div>
      <div v-else>
        <p>No questions available</p>
      </div>
    </div>
  </section>
</template>

<script>
import axios from "axios";

export default {
  data() {
    return {
      examId: null,
      timeLimit: null,
      examQuestions: [],
      currentQuestionIndex: 0,
      examQuestion: null,
      selectedAnswer: null,
      timeLeft: { minutes: 0, seconds: 0 },
      userAnswers: [], // Track user answers
      timer: null, // Holds the timer interval
      questionStartTime: null, // Time when the question is loaded
      isLastQuestionSubmitted: false,
      resultSubmitted: false,
    };
  },
  computed: {
    totalQuestions() {
      return this.examQuestions.length;
    },
  },
  methods: {
    async fetchExamQuestions() {
      try {
        const response = await axios.get(`/api/exams/${this.examId}/questions`);
        this.examQuestions = response.data.questions;
        this.loadQuestion(this.currentQuestionIndex);
      } catch (error) {
        console.error("Error fetching exam questions:", error);
      }
    },
    loadQuestion(index) {
      this.examQuestion = this.examQuestions[index];
      this.selectedAnswer = null;
      this.questionStartTime = Date.now(); // Record start time
      this.startTimer();
    },

    startTimer() {
      this.timeLeft = { minutes: Math.floor(this.timeLimit / 60), seconds: this.timeLimit % 60 };
      clearInterval(this.timer);
      this.timer = setInterval(() => {
        if (this.timeLeft.seconds === 0) {
          if (this.timeLeft.minutes === 0) {
            clearInterval(this.timer);
            this.moveToNextQuestion();
          } else {
            this.timeLeft.minutes--;
            this.timeLeft.seconds = 59;
          }
        } else {
          this.timeLeft.seconds--;
        }
      }, 1000);
    },

    moveToNextQuestion() {
      this.currentQuestionIndex++;
      this.loadQuestion(this.currentQuestionIndex);
    },

    submitResults() {
      clearInterval(this.timer);
      axios.post(`/api/exam/submit/${this.examId}`, { userAnswers: this.userAnswers })
        .then(response => {
          this.$router.push(`/exam/result/${response.data.examResultId}`);
        })
        .catch(error => {
          console.error("Error submitting exam results:", error);
        });
    },

    submitAnswer() {
      const timeSpent = (Date.now() - this.questionStartTime) / 1000;
      const selectedOptionIdentifier = this.getOptionIdentifier(this.selectedAnswer, this.examQuestion);
      this.userAnswers.push({
        questionId: this.examQuestion.id,
        answer: selectedOptionIdentifier, // Send option identifier like 'A', 'B', 'C', or 'D'
        timeSpent,
      });

      if (this.isLastQuestion) {
        this.submitResults();
      } else {
        this.moveToNextQuestion();
      }
    },

    getOptionIdentifier(selectedOption, question) {
      const options = [question.option_a, question.option_b, question.option_c, question.option_d];
      return options.indexOf(selectedOption) >= 0 ? String.fromCharCode(65 + options.indexOf(selectedOption)) : null;
    },

    showResult() {
      if (this.resultSubmitted) {
        axios.post(`/api/exam/submit/${this.examId}`, { userAnswers: this.userAnswers })
          .then(response => {
            this.$router.push(`/exam/result/${response.data.examResultId}`);
          })
          .catch(error => {
            console.error("Error submitting exam results:", error);
          });
      }
    },

    getOptions(question) {
      return [question.option_a, question.option_b, question.option_c, question.option_d];
    },
  },
  computed: {
    isLastQuestion() {
      return this.currentQuestionIndex === this.examQuestions.length - 1;
    },
    examProgress() {
      return ((this.currentQuestionIndex + 1) / this.examQuestions.length) * 100;
    },
  },
  mounted() {
    this.examId = this.$route.query.examId;
    this.timeLimit = this.$route.query.timeLimit;
    this.fetchExamQuestions();
  },
  beforeDestroy() {
    clearInterval(this.timer);
  },
};
</script>