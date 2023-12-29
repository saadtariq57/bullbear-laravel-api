<template>
  <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#ConfirmationPopup">
    Launch Exam Confirmation MOdel
  </button>
  <div class="modal fade" id="ConfirmationPopup" tabindex="-1" aria-labelledby="ConfirmationPopupLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
      <div class="modal-content">
        <div class="modal-header">
          <h1 class="modal-title fs-5" id="ConfirmationPopupLabel">Exam Confirmation</h1>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          <p>Are you sure you want to start the exam?</p>
          <p>This exam consists of 15 questions.</p>
          <p>Please note: Once started, do not skip the exam.</p>
          <p>You'll have 40 seconds to answer each question.</p>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
          <button type="button" class="btn btn-primary" onclick="startExam()">Start Exam</button>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  // Existing code...
};
</script>