<template>
  <section class="container-lg mt-3 py-80">
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
    <div class="exam-header bg-white shadow-sm p-4">
      <div v-if="examQuestion" class="container-lg exam-main my-2">
        <p class="fw-bold fs-18 text-start my-4 text-black">
          <b>Question </b>{{ questionNumber }} of {{ totalQuestions }}
        </p>
        <h3 class="fw-6 fs-18 text-uppercase text-start">{{ examQuestion.question_text }}</h3>
        <div class="text-center">
          <img v-if="examQuestion.featured_image" :src="examQuestion.featured_image" alt="" class="my-2" width="400">
        </div>
        <form @submit.prevent="submitAnswer" class="px-4">
          <div v-for="(option, index) in examQuestion.options" :key="index" class="form-check p-3">
            <input v-model="selectedAnswer" class="form-check-input" type="radio" :name="'option' + examQuestion.id"
              :id="'flexRadioDefault' + index" :value="option">
            <label class="form-check-label fw-5" :for="'flexRadioDefault' + index">{{ option }}</label>
          </div>
          <div class="text-center">
            <button type="submit" class="btn-primary">Next >></button>
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
import ExamQuestions from "./ExamQuestions.js";
export default ExamQuestions;
</script>