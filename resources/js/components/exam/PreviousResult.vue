<template>
    <div class="previous-results container p-0 my-4">
      <div v-if="showAllResults">
        <div class="mb-4">
          <h2 class="fw-6 text-uppercase m-0">Previous Exam Results</h2>
          <div class="border border-bottom border-primary d-inline-block mb-2" style="width: 74px;"></div>
        </div>
        <div v-if="results.length === 0">No previous results available.</div>
        <div v-else>
          <div class="row">
            <div v-for="result in results" :key="result.id" class="result-item col-lg-6">
              <div class="card rounded-2 shadow-lg p-3 mb-3">
                <h3 class="fw-4 m-0 py-4 text-capitalize fs-4"></h3>
                <div class="">
                  <div class="table-responsive">
                    <table class="table table-borderless">
                        <tbody>
                            <tr>
                                <th class="fw-bolder">Date:</th>
                                <td class="text-end">{{ result.exam_date }}</td>
                            </tr>
                            <tr>
                                <th class="fw-bolder">Time Consumed:</th>
                                <td class="text-end">{{ formatTime(result.time_consumed) }}</td>
                            </tr>
                            <tr>
                                <th class="fw-bolder">Total Questions:</th>
                                <td class="text-end">{{ result.total_questions }}</td>
                            </tr>
                            <tr>
                                <th class="fw-bolder">Correct answers:</th>
                                <td class="text-end"> {{ result.correct_answers }}</td>
                            </tr>
                            <tr>
                                <th class="fw-bolder">Correct answers:</th>
                                <td class="text-end"> {{ result.correct_answers }}</td>
                            
                            </tr>
                            <tr>
                                <th class="fw-bolder">Percentage:</th>
                                <td class="text-end">{{ result.percentage }}%</td>
                            </tr>
                            <tr>
                            <th class="fw-bolder">Result:</th>
                            <td class="text-end">
                                <span v-if="result.percentage > 70">Great</span>
                                <span v-else-if="result.percentage >= 60">Good</span>
                                <span v-else-if="result.percentage >= 50">Pass</span>
                                <span v-else>Fail</span>
                            </td>
                            </tr>
                        </tbody>
                    </table>
                  </div>
                  <div class="text-center">
                    <a @click="showQuestionsFor(result)" class="btn btn-primary">See Correct Answers</a>
                  </div>
                </div>
              </div> 
            </div>
          </div>
        </div>
      </div>
      <div v-if="showQuestions" class="exams">
    <div class="result-questions">
        <h2>{{ exam.title }}</h2>
        <div v-if="questions.length === 0">No questions available for this result.</div>
        <div v-else>
            <div v-for="(question, index) in questions.questions" :key="index" class="question-item">
    <h3>Question: {{ question.question_text }}</h3>
    <div class="border border-bottom border-primary d-inline-block mb-2" style="width: 74px;"></div>
    <ul class="answer_sheet_list p-0 mb-4">
        <li :class="{ correct: isCorrectAnswer(question, 'A') }"> A. {{ question.option_a }}</li>
        <li :class="{ correct: isCorrectAnswer(question, 'B') }"> B. {{ question.option_b }}</li>
        <li :class="{ correct: isCorrectAnswer(question, 'C') }"> C. {{ question.option_c }}</li>
        <li :class="{ correct: isCorrectAnswer(question, 'D') }"> D. {{ question.option_d }}</li>
    </ul>
    <!-- <p class="correct_answer" >Correct Answer: {{ question.correct_answer }}</p> -->
</div>
        </div>
    </div>
</div>
      <div class="text-center my-5">
        <a href="/previous-results" class="btn-primary">&lt; Back to Previous Exam Results</a>
      </div>
    </div>
  </template>
  
  <script>
  import axios from 'axios';
  export default {
    data() {
      return {
        results: [],
        showAllResults: true,
        showQuestions: false,
        exam: null,
        questions: []
      };
    },
    methods: {
    async fetchPreviousResults() {
        try {
            const response = await axios.get('/api/exam/results');
            this.results = response.data;
        } catch (error) {
            console.error('Error fetching previous results:', error);
        }
    },
    async fetchQuestionsForResult(result) {
        try {
            // Assuming you have an API endpoint to fetch questions for a result ID
            const response = await axios.get(`/api/exams/${result.exam_id}/questions`);
            this.exam = result;
            this.questions = response.data;
            this.showQuestions = true;
            this.showAllResults = false;
        } catch (error) {
            console.error('Error fetching questions:', error);
        }
    },
    showQuestionsFor(result) {
        this.fetchQuestionsForResult(result);
    },
    formatTime(timeInSeconds) {
        if (timeInSeconds < 60) {
            return `${timeInSeconds} sec`;
        } else {
            const minutes = Math.floor(timeInSeconds / 60);
            const seconds = timeInSeconds % 60;
            return `${minutes} min ${seconds} sec`;
        }
    },
    isCorrectAnswer(question, selectedAnswer) {
        return question.correct_answer === selectedAnswer;
    }
},

    mounted() {
      this.fetchPreviousResults();
    },
  };
  </script>  
<style>
    .answer_sheet_list{
        list-style: none;
    display: flex;
    flex-direction: column;
    gap: 8px;
    }    
    .answer_sheet_list li.correct{
       color: green;
       font-weight: 600;
    } 
    .answer_sheet_list li{
        font: 400 20px / 32px Poppins;
        display: flex;
    align-items: center;
    justify-content: space-between;
    }   
    .answer_sheet_list li::after{
        content: url('');
        display: block;
        background-image: url(/build/images/close.png);
        background-size: contain;
    width: 18px;
    background-repeat: no-repeat;
    }
    .answer_sheet_list li.correct::after{
        background-image: url(/build/images/checkmark.png);
        width: 18px;
    }
    p.correct_answer{
        text-align: center;
    }
</style>