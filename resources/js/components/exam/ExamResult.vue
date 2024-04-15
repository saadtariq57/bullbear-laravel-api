<template>
  <div class="container-lg exam-result-container p-0 my-4">
    <div class="card rounded-2 shadow-lg p-5">
      <h3 class="fw-4 m-0 py-4 text-capitalize fs-4">{{ examTitle }}</h3>
      <div class="row">
        <div class="table-responsive col-12 col-md-6">
          <table class="table table-borderless">
            <tbody>
              <tr>
                <th class="fw-bolder">Date:</th>
                <td>{{ examResult.exam_date }}</td>
              </tr>
              <tr>
                <th class="fw-bolder">Time Consumed:</th>
                <td>{{ examResult.time_consumed }}</td>
              </tr>
              <tr>
                <th class="fw-bolder">Total Questions:</th>
                <td>{{ examResult.total_questions }}</td>
              </tr>
              <tr>
                <th class="fw-bolder">Correct answers:</th>
                <td>{{ examResult.correct_answers }}</td>
              </tr>
              <tr>
                <th class="fw-bolder">Percentage:</th>
                <td>{{ examResult.percentage }}</td>
              </tr>
                <tr>
                  <th class="fw-bolder">Result:</th>
                  <td>
                    <span v-if="examResult.percentage > 70">Great</span>
                    <span v-else-if="examResult.percentage >= 60">Good</span>
                    <span v-else-if="examResult.percentage >= 50">Pass</span>
                    <span v-else>Fail</span>
                  </td>
                </tr>
            </tbody>
          </table>
        </div>
        <div class="d-none d-md-block col-md-6">
          <div class="d-flex justify-content-end align-items-center h-100 pe-5">
            <div class="overall-percentage d-flex justify-content-center align-items-center">
              <span class="Green fs-18 fw-">{{ examResult.percentage }}</span>
            </div>
          </div>
        </div>
      </div>
    </div>

    <div class="text-center my-5">
      <router-link to="/exams" class="btn-primary">
        &lt; Back to Exam Center
      </router-link>
    </div>
  </div>
</template>

<script>
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

</script>