// Exam.js
import { Skeletor } from "vue-skeletor";
import examImage from '../../../../images/exam1.jpg';
import axios from "axios";

export default {
  components: {
    Skeletor,
  },
  data() {
    return {
      categories: [],
      examImage: examImage,
    };
  },
  methods: {
    async getExamData() {
      try {
        const response = await axios.get('/api/exams');
        this.categories = response.data.categories.map(category => {
          return {
            ...category,
            exams: response.data.exams.data.filter(exam => exam.category === category.name),
          };
        });
      } catch (error) {
        console.error("Error fetching exams:", error);
      }
    },
  },
  mounted() {
    this.getExamData();
  },
};