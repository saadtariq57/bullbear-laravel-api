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
      this.userAnswers.push({
        questionId: this.examQuestion.id,
        answer: this.selectedAnswer,
        timeSpent,
      });

      if (this.isLastQuestion) {
        this.submitResults();
      } else {
        this.moveToNextQuestion();
      }
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