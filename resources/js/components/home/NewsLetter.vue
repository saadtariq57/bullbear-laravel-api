<template>
  <section class="newsletter container-fluid py-80">
    <div class="container text-center">
      <div class="newsletter-wrapper">
        <h2 class="text-uppercase">Sign up for our free newsletter</h2>
        <p class="fs-24 mt-1">Simply drop in your email address to never miss an update from Rich TV.</p>
        <div id="mauticform_wrapper_richtvhomepageemailcollector">
          <form class="mt-4" autocomplete="false" role="form" @submit.prevent="openPopup">
            <div class="form-group d-flex flex-wrap gap-3">
              <div class="flex-fill position-relative">
                <!-- Email Input - Now readonly and clickable -->
                <input type="email" class="form-control form-control-lg px-3 py-3 fs-6 newsletter-input border"
                  id="mauticform_input_richtvhomepageemailcollector_enter_your_email" 
                  name="mauticform[enter_your_email]" 
                  placeholder="Enter your Email"
                  v-model="email"
                  readonly
                  @click="openPopup">
                
                <!-- Submit Button - Now just opens the popup -->
                <button type="button" class="btn btn-primary fw-5 newsletter-btn position-absolute" 
                        @click="openPopup">
                  Submit
                </button>
              </div>
            </div>
          </form>
        </div>
      </div>
    </div>
  </section>
</template>

<script>
export default {
  data() {
    return {
      email: ''
    };
  },
  methods: {
    openPopup() {
      // Dispatch the custom event to show the popup
      window.dispatchEvent(new CustomEvent('show-email-popup', {
        detail: { email: this.email }
      }));
    }
  }
};
</script>

<style scoped>
/* Add pointer cursor to indicate clickability */
#mauticform_input_richtvhomepageemailcollector_enter_your_email {
  cursor: pointer;
}

/* Remove focus styles since it's not editable */
#mauticform_input_richtvhomepageemailcollector_enter_your_email:focus {
  outline: none;
  box-shadow: none;
}

.mauticform-field-hidden { display: none; }
.mauticform-errormsg, #mauticform_richtvhomepageemailcollector_error { color: red; font-size: 11px; margin-top: 10px; }
#mauticform_richtvhomepageemailcollector_message { color: #089d08; font-size: 11px; margin-top: 10px; }
@media (max-width: 440px) {
  .newsletter-wrapper { padding: 50px 35px; }
}
@media (max-width: 350px) {
  .newsletter-wrapper { padding: 30px 20px; }
}
</style>