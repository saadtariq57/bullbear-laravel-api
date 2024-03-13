<template>
  <div class="modal-content">
    <div class="modal-header">
      <h1 class="modal-title fs-5" id="pollpostModal">Create a poll</h1>
    </div>
    <div class="modal-body">
      <form @submit.prevent="submitPoll">
        <div class="mb-3">
          <label for="pollQuestion" class="form-label">Your question</label>
          <textarea class="form-control border border-dark" id="pollQuestion" rows="3" v-model="pollQuestion" placeholder="E.g., How do you commute to work?"></textarea>
        </div>

        <div class="options-container">
          <div class="mb-3 option-group" v-for="(option, index) in pollOptions" :key="index">
            <label class="form-label">Option {{ index + 1 }}</label>
            <input type="text" class="form-control border border-dark" v-model="pollOptions[index]" placeholder="Enter option">
            <button type="button" class="deleteOptionBtn btn text-danger" @click="deleteOption(index)" v-if="pollOptions.length > 2">Delete</button>
          </div>
        </div>
        <div class="mb-3">
          <button type="button" class="btn btn-primary" @click="addOption">Add Option</button>
        </div>
        <div class="mb-3">
          <select class="form-select border border-dark" v-model="pollDuration" aria-label="Poll Duration">
            <option value="1">1 day</option>
            <option value="3">3 days</option>
            <option value="7">1 week</option>
            <option value="14">2 weeks</option>
          </select>
        </div>
      </form>
    </div>
    <div class="modal-footer">
      <button type="button" class="btn rounded-2 border-btn px-4" @click="backToPostModalAndReset">Back</button>
      <button type="button" class="btn btn-primary" @click="submitPoll" :disabled="!isPollValid">Done</button>
    </div>
  </div>
</template>

<script>
export default {
  emits: ['backFromPoll', 'pollCreated'],
  data() {
    return {
      pollQuestion: '',
      pollOptions: ['', ''],
      pollDuration: '1'
    };
  },
  computed: {
    isPollValid() {
      return this.pollQuestion.trim() !== '' &&
             this.pollOptions[0].trim() !== '' &&
             this.pollOptions[1].trim() !== '';
    }
  },
  methods: {
    addOption() {
      this.pollOptions.push('');
    },
    deleteOption(index) {
      this.pollOptions.splice(index, 1);
    },
    backToPostModalAndReset() {
      this.resetPoll();
      this.$emit('backFromPoll');
    },
    submitPoll() {
      if (this.isPollValid) {
        const textarea = document.getElementById('textarea-modalpost');
      if (textarea) {
        textarea.style.height = '100px';
      }
        const pollData = {
          question: this.pollQuestion,
          options: this.pollOptions.filter(option => option.trim() !== ''),
          duration: this.pollDuration
        };
        this.$emit('pollCreated', pollData);
      }
    },
    resetPoll() {
      this.pollQuestion = '';
      this.pollOptions = ['', ''];
      this.pollDuration = '1';
    }
  }
};
</script>