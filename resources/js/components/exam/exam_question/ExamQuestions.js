import { Skeletor } from "vue-skeletor";
import axios from "axios";

export default {
  components: {
    Skeletor,
  },
  data() {
    return {
      examQuestion: null,
      selectedAnswer: null,
      timeLeft: { minutes: 0, seconds: 0 },
      examProgress: 10, // Assuming a default progress value
      totalQuestions: 15, // Assuming a total of 15 questions for the exam
    };
  },
  methods: {
    async getExamQuestionData(examId) {
      try {
        const response = await axios.get(`/questions/start-exam/${examId}`);
        this.examQuestion = response.data.examQuestions[0]; // Assuming fetching a single question
      } catch (error) {
        console.error("Error fetching exam question:", error);
      }
    },
    submitAnswer() {
      // Handle submitting the selected answer
      console.log("Selected answer:", this.selectedAnswer);
      // You can handle answer submission logic here
      // For instance, send the selected answer to the server and proceed to the next question
    },
  },
  mounted() {
    const examId = 'desired_exam_id'; // Replace with the actual exam ID from your application
    this.getExamQuestionData(examId);
  },
  watch: {
    // Example of a watcher for time left countdown
    timeLeft: {
      handler() {
        // Implement countdown logic if needed
        // For instance, decrease timeLeft.seconds every second
      },
      deep: true,
    },
  },
};