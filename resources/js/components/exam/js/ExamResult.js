import axios from "axios";

export default {
  data() {
    return {
      examId: null,
      examTitle: '',
      examResult: {},
    };
  },
  methods: {
    async fetchExamResult() {
      try {
        const response = await axios.get(`/api/exam/result/${this.examId}`);
        this.examResult = response.data;
      } catch (error) {
        console.error("Error fetching exam result:", error);
      }
    },
  },
  mounted() {
    this.examId = this.$route.params.id;
    this.fetchExamResult();
    // You might also want to fetch the exam title based on the examId
  },
};
