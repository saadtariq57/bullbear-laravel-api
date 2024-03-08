<template>
  <section class="newsletter container-fluid py-80">
    <div class="container text-center">
      <div class="newsletter-wrapper">
        <h2 class="text-uppercase">Sign up for our free newsletter</h2>
        <p class="fs-24 mt-1">Simply drop in your email address to never miss an update from Rich TV.</p>
        <div class="">
          <form class="mt-4">
            <div class="form-group d-flex flex-wrap  gap-3">
              <div class="flex-fill position-relative">
                <input type="email" class="form-control form-control-lg px-3 py-3 fs-6 newsletter-input border"
                  id="exampleFormControlInput1" placeholder="Enter your Email">
                <button type="submit" class="btn btn-primary fw-5 newsletter-btn position-absolute">Submit</button>
              </div>
            </div>
            <div class="d-flex gap-2 align-items-center mt-3 justify-content-center">
              <input class="form-checkboxgrp-checkbox" name="home_form_check" id="home_form_check" type="checkbox"
                value="0" required="true">
              <label for="home_form_check" class="fs-6 text-start m-0">I agree to receive
                newsletter and
                email alerts.</label>
            </div>
          </form>
        </div>
      </div>
    </div>
  </section>
</template>
<style>
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