<template>
  <div v-if="showAllExams" >

    <div v-for="(category, index) in categories" :key="index" class="my-3 exam-cards mt-5 pb-4">
      <div class="mb-4">
        <h2 class="fw-6 text-uppercase m-0">{{ category.name }}</h2>
        <div class="border border-bottom border-primary d-inline-block mb-2" style="width: 74px;"></div>
      </div>
      <div class="exam-card-wrapper row gy-4">
        <div v-for="(exam, examIndex) in category.exams" :key="examIndex" class="col-lg-4 col-md-6 col-12">
          <div class="exam-content bg-white">
            <div class="exam-image">
              <img :src="'uploads/' + exam.featured_img" class="" :alt="'exam-image-' + exam.id">
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
  <div  v-if="!showAllExams" class="exams">
    <div class="mb-4">
      <h2 class="fw-6 text-uppercase m-0">Exams</h2>
      <div class="border border-bottom border-primary d-inline-block mb-2" style="width: 74px;"></div>
    </div>
    <div class="exam-card-wrapper row gy-4">
      <div class="col-lg-6 col-md-6 col-12">
        <div class="exam-content bg-white">
          <div class="exam-image">
            <img :src="basicImage" class="">
          </div>
          <div class="exam-info px-3 py-4">
            <h3 class="text-uppercase fw-6 fs-5 align-self-center mb-3">Basic Exams</h3>
            <div class="time-quastion d-flex justify-content-between mb-3">
              <span class="questions">
                <i class="bi bi-list-ol"></i>
                30 Emaxms
              </span>
              <span class="time">
                <i class="bi bi-stopwatch-fill"></i>
                10 plus Question Per Exam
              </span>
            </div>
            <p>Assesses understanding of stock structure fundamentals, including shares, floats, and their impacts on financial metrics like earnings-per-share and volatility. Suitable for those seeking foundational knowledge in trading and corporate finance.</p>
            <div class="exam-btn d-block">
              <button @click="toggleAllExams" class="btn-primary d-block w-100">SEE ALL</button>
            </div>
          </div>
        </div>
      </div>
      <div class="col-lg-6 col-md-6 col-12">
        <div class="exam-content bg-white">
          <div class="exam-image">
            <img :src="advanceImage" class="">
          </div>
          <div class="exam-info px-3 py-4">
            <h3 class="text-uppercase fw-6 fs-5 align-self-center mb-3">Advance Exams</h3>
            <div class="time-quastion d-flex justify-content-between mb-3">
              <span class="questions">
                <i class="bi bi-list-ol"></i>
                30 Emaxms
              </span>
              <span class="time">
                <i class="bi bi-stopwatch-fill"></i>
                10 plus Question Per Exam
              </span>
            </div>
            <p>Explores advanced trading concepts such as resistance levels, Fibonacci retracement, and strategies like stop buy orders. Designed for individuals with a solid grasp of basic trading principles, aiming to enhance expertise in navigating financial markets intricacies.</p>
            <div class="exam-btn d-block">
              <button @click="toggleAllExams" class="btn-primary d-block w-100">SEE ALL</button>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import axios from "axios";
import ConfirmationPopup from "./ConfirmationPopup.vue"
import LoginPopup from "../login/LoginPopup.vue"
import basicImage from '../../../images/basic_exam.png';
import advanceImage from '../../../images/advance_exam.jpg';

export default {
  components: {
    ConfirmationPopup,
    LoginPopup,
  },
  data() {
    return {
      categories: [],
      basicImage: basicImage,
      advanceImage: advanceImage,
      hideSkeletor: false,
      showAllExams: false // Add this boolean property
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
        this.hideSkeletor = true;
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
    
    // Method to toggle the visibility of all exams section
    toggleAllExams() {
      this.showAllExams = !this.showAllExams;
    }
  },
  mounted() {
    this.getExamData();
  },
};
</script>