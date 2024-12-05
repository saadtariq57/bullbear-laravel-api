<template>
  <section class="newsletter container-fluid py-80">
    <div class="container text-center">
      <div class="newsletter-wrapper">
        <h2 class="text-uppercase">Sign up for our free newsletter</h2>
        <p class="fs-24 mt-1">Simply drop in your email address to never miss an update from Rich TV.</p>
       <div class=""  id="mauticform_wrapper_richtvhomepageemailcollector">
           <form class="mt-4" autocomplete="false" role="form" method="post" action="https://mailer.servicesground.com/form/submit?formId=87" id="mauticform_richtvhomepageemailcollector" data-mautic-form="richtvhomepageemailcollector" enctype="multipart/form-data">
            <div class="form-group d-flex flex-wrap  gap-3">
              <div class="flex-fill position-relative">
                <input type="email" class="form-control form-control-lg px-3 py-3 fs-6 newsletter-input border"
                  id="mauticform_input_richtvhomepageemailcollector_enter_your_email" name="mauticform[enter_your_email]" placeholder="Enter your Email">
                <button type="submit" class="btn btn-primary fw-5 newsletter-btn position-absolute" name="mauticform[submit]" id="mauticform_input_richtvhomepageemailcollector_submit">Submit</button>
              </div>
            </div>
            <div class="d-flex gap-2 align-items-center mt-3 justify-content-center">
              <input class="form-checkboxgrp-checkbox" name="mauticform[consent_box][]" id="home_form_check" type="checkbox" value="0">
              <label for="home_form_check" class="fs-6 text-start m-0">I agree to receive
                newsletter and
                email alerts.</label>
            </div>
            <span class="mauticform-errormsg" style="display: none;">please check the consent box</span>
            <span class="mauticform-errormsg" style="display: none;">Email Field is required</span>
            <div class="mauticform-error" id="mauticform_richtvhomepageemailcollector_error"></div>
            <div class="mauticform-message" id="mauticform_richtvhomepageemailcollector_message"></div>
            <input type="hidden" name="mauticform[formId]" id="mauticform_richtvhomepageemailcollector_id" value="87">
            <input type="hidden" name="mauticform[return]" id="mauticform_richtvhomepageemailcollector_return" value="">
            <input type="hidden" name="mauticform[formName]" id="mauticform_richtvhomepageemailcollector_name" value="richtvhomepageemailcollector">
          </form>
        </div>
      </div>
    </div>
  </section>
</template>
<style>
  .mauticform-field-hidden { display:none }
  .mauticform-errormsg, #mauticform_richtvhomepageemailcollector_error{color:red;font-size: 11px; margin-top: 10px;}
  #mauticform_richtvhomepageemailcollector_message{color:#089d08;font-size: 11px; margin-top: 10px;}
@media (max-width: 440px) {
  .newsletter-wrapper{
    padding: 50px 35px;
  }
}
@media (max-width: 350px) {
  .newsletter-wrapper{
    padding: 30px 20px;
  }
}
</style>