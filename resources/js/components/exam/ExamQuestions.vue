<template>
  <!-- Exam Header with Timer -->
  <div class="exam-header bg-white shadow-sm p-4 mb-3">
    <p class="d-flex justify-content-end">
      <i class="bi bi-clock icon-bold me-1"></i> Time Left - <span class="fs-3 fw-6 align-self-center ms-2">{{
        timeLeft.minutes }}:{{ timeLeft.seconds }}</span>
    </p>
    <div class="progress exam-progress">
      <div class="progress-bar exam-progress-bar" role="progressbar" aria-label="Basic example"
        :style="{ width: examProgress + '%' }"></div>
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
      <form @submit.prevent="submitAnswer">
        <div v-for="(option, optionKey) in getOptions(examQuestion)" :key="optionKey"
          class="form-check px-0 py-3 d-flex align-items-center gap-2 position-relative">
          <input v-model="selectedAnswer" class="form-check-input custom-radio-btn radio" type="radio"
            :name="'option' + examQuestion.id" :id="'option' + optionKey" :value="option">
          <span class="custom-radio-label position-relative"></span>
          <label class="form-check-label fw-5 mb-0 fs-5" :for="'option' + optionKey">{{ option }}</label>
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
<style>
@keyframes checked-radio {
  0% {
    transform: rotate(0) translateY(-3px) scale(0.5);
  }

  83% {
    transform: rotate(360deg) translateY(0px) scale(1);
    transform-origin: 15px;
  }

  88% {
    transform: translateY(1px) scale(1);
  }

  93% {
    transform: translateY(2px) scale(1);
  }

  100% {
    transform: translateY(0) scale(1);
  }
}

@keyframes unchecked-radio {
  0% {
    width: 20px;
    height: 20px;
    left: 5px;
    top: 5px;
    background: white;
  }

  25% {
    width: 15px;
    height: 15px;
    left: 7.5px;
    top: 7.5px;
    background: var(--cta-btn);
  }

  50% {
    width: 10px;
    height: 10px;
    left: 10px;
    top: 10px;
    background: var(--cta-btn);
  }

  75% {
    width: 5px;
    height: 5px;
    left: 15px;
    top: 15px;
    background: var(--cta-btn);
  }

  100% {
    width: 0px;
    height: 0px;
    left: 20px;
    top: 20px;
  }
}

.custom-radio-label,
.custom-radio-label:before,
.custom-radio-label:after {
  /* margin: 0; */
  padding: 0;
  outline: 0;
  overflow: hidden;
  box-sizing: border-box;
}

.custom-radio-label,
.custom-radio-label:before,
.custom-radio-label:after {
  position: absolute;
  top: 0;
  bottom: 0;
  left: 0;
  right: 0;
}

.custom-radio-label {
  display: inline-block;
  width: 30px;
  height: 30px;
  border-radius: 50%;
}

.custom-radio-label:before {
  content: "";
  position: absolute;
  border-radius: 50%;
  animation-name: unchecked-radio;
  animation-duration: 2s;
}

.custom-radio-btn+.custom-radio-label {
  position: relative;
  background: var(--cta-btn);
  border-color: var(--cta-btn) !important;
}

.custom-radio-btn:checked+.custom-radio-label {
  background: white;
  border: 5px solid;
  transition: all .2s;
}

.custom-radio-btn:checked+.custom-radio-label:before {
  width: 10px;
  height: 10px;
  background: var(--cta-btn);
  transition: all .4s;
  top: 5px;
  left: 5px;
}


.custom-radio-btn:checked+.custom-radio-label:before {
  animation-name: checked-radio;
  animation-duration: 1s;
  animation-timing-function: cubic-bezier(0.22, 0.61, 0.36, 1);
  animation-fill-mode: both;
}

.custom-radio-btn[type="radio"] {
  position: absolute;
  z-index: 1;
  top: 21px;
  left: 29px;
  opacity: 0;
  -ms-transform: scale(2);
  -webkit-transform: scale(2);
  transform: scale(2)
}
</style>