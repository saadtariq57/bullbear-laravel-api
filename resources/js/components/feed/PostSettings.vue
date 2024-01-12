<template>
	<div class="modal-content">
	<div class="modal-header">
	  <h5 class="modal-title" id="postSettingModalLabel">Post Settings</h5>
	</div>
	<div class="modal-body">
	  <!-- Post Visibility Settings -->
	  <div class="mb-3">
	    <h5>Who can see your post?</h5>
	    <div class="d-flex align-items-center">
	      <i class="bi bi-globe fs-5 me-2"></i>
	      <label class="form-check-label" for="Radioanyone">Anyone</label>
	      <input class="form-check-input ms-auto" type="radio" name="postPrivacy" id="Radioanyone" value="public" :checked="post_privacy === 'public'" @change="handlePostPrivacyChange">
	    </div>
	    <div class="d-flex align-items-center">
	      <i class="bi bi-people fs-5 me-2"></i>
	      <label class="form-check-label" for="Radioconnectiononly">Followers only</label>
	      <input class="form-check-input ms-auto" type="radio" name="postPrivacy" id="Radioconnectiononly" value="followers" :checked="post_privacy === 'followers'" @change="handlePostPrivacyChange">
	    </div>
	  </div>

	  <!-- Comments Control Settings -->
	  <div class="mb-3">
	    <h5>Comments Control</h5>
	    <div class="d-flex align-items-center">
	      <i class="bi bi-chat-left-text fs-5 me-2"></i>
	      <label class="form-check-label" for="enableComments">Enable Comments</label>
	      <input class="form-check-input ms-auto" type="radio" name="commentStatus" id="enableComments" value="enableComments" :checked="comment_status" @change="handleCommentStatusChange">
	    </div>
	    <div class="d-flex align-items-center">
	      <i class="bi bi-chat-left-text-fill fs-5 me-2"></i>
	      <label class="form-check-label" for="disableComments">Disable Comments</label>
	      <input class="form-check-input ms-auto" type="radio" name="commentStatus" id="disableComments" value="disableComments" :checked="!comment_status" @change="handleCommentStatusChange">
	    </div>
	  </div>
	</div>
    <div class="modal-footer">
      <button type="button" class="btn rounded-2 border-btn px-3" @click="emitBack">Back</button>
      <button type="button" class="btn btn-primary" :disabled="!settingsChanged" @click="emitNext">Next</button>
    </div>
	</div>
</template>
<script>
export default {
  data() {
    return {
      post_privacy: 'public',
      comment_status: 1,
      settingsChanged: false
    };
  },
  emits: ['backFromSettings', 'updateFromSettings'],
  methods: {
    handlePostPrivacyChange(event) {
      this.post_privacy = event.target.value;
      this.settingsChanged = true;
    },
    handleCommentStatusChange(event) {
      this.comment_status = event.target.value === 'enableComments';
      this.settingsChanged = true;
    },
    emitBack() {
      this.$emit('backFromSettings');
    },
    emitNext() {
      this.$emit('updateFromSettings', {
        post_privacy: this.post_privacy,
        comment_status: this.comment_status
      });
    }
  }
};
</script>