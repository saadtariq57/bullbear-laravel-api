<template>
  <div>
    <div v-for="(category, index) in categories" :key="index" class="my-3 exam-cards mt-5 pb-4">
      <div class="mb-4">
        <h2 class="fw-6 text-uppercase m-0">{{ category.name }}</h2>
        <div class="border border-bottom border-primary d-inline-block mb-2" style="width: 74px;"></div>
      </div>
      <div class="exam-card-wrapper row gy-4">
        <div v-for="(exam, examIndex) in category.exams" :key="examIndex" class="col-lg-4 col-md-6 col-12">
          <div class="exam-content bg-white">
            <div class="exam-image">
              <img :src="exam.image || examImage" class="" :alt="'exam-image-' + exam.id">
            </div>
            <div class="exam-info px-3 py-4">
              <h3 class="text-uppercase fw-6 fs-5 align-self-center mb-3">{{ exam.title }}</h3>
              <div class="time-quastion d-flex justify-content-between mb-3">
                <span class="questions">
                  <i class="bi bi-list-ol"></i>
                  {{ exam.number_of_questions }} Questions
                </span>
                <span class="time">
                  <i class="bi bi-stopwatch-fill"></i>
                  {{ exam.per_question_time_limit }} Seconds Per Question
                </span>
              </div>
              <p>{{ exam.description }}</p>
              <div class="exam-btn d-inline-block">
                <button @click="startExam(exam.id)" class="btn-primary d-inline-block">Start Exam</button>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import { Skeletor } from "vue-skeletor";
import axios from "axios";
import ConfirmationPopup from "./ConfirmationPopup.vue"
import LoginPopup from "../login/LoginPopup.vue"
import examImage from '../../../images/exam1.jpg';

export default {
  components: {
    Skeletor,
    ConfirmationPopup,
    LoginPopup,
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

    async startExam(examId) {
      try {
        const response = await axios.get(`/api/exams/initiate/${examId}`);
        const { firstQuestionId, examName, timeLimit } = response.data;
        this.$router.push({
          name: 'exam.question',
          params: { examName, questionId: firstQuestionId },
          query: { examId, timeLimit }
        });
      } catch (error) {
        console.error("Error initiating exam:", error);
      }
    },
  },
  mounted() {
    this.getExamData();
  },
};
</script>