<template>
  <section class="hero-section container-fluid position-relative">
    <WidgetSlider :widgetId="2" />
    
    <div class="container-fluid hero-wrapper">
      <div class="row m-0">
        <div class="col-lg-7 px-0">
          <div class="main-heading">
            <h1 class="text-black fw-bolder mb-3">NAVIGATE MARKETS <br>TOGETHER!</h1>
            <p class="mb-5 lh-base text-black">JOIN THE BEST NEWSLETTER: SAVVY INSIGHTS AND DYNAMIC CHATS
            </p>
          </div>
          
          <div class="hero-foem-wrapper">
            <form class="hero-form mt-0" @submit.prevent="initiateSignUp">
              <div class="row gy-3">
                <div class="form-group col-md-5">
                  <input type="text"
                    class="form-control bg-transparent text-black py-3 border border-1 border-black hero-form-input"
                    v-model="form.name" name="name" id="name" placeholder="Your Name" required>
                </div>
                <div class="form-group col-md-5">
                  <input type="email"
                    class="form-control bg-transparent text-black py-3 border border-1 border-black hero-form-input"
                    v-model="form.email" name="email" id="email" placeholder="Your Email" required>
                </div>
                <div class="submit-form col-md-2">
                  <button type="submit" class="btn btn-hero btn-primary fw-bolder hero-sign-up">Sign Up</button>
                </div>
              </div>
            </form>
          </div>
        </div>
        <div class="col-lg-5 hero-graph">
          <img src="build/images/hero_mobile.png" alt="Graph" class="scroll-image d-lg-block d-none">
        </div>
      </div>
    </div>
  </section>
</template>

<script>
import axios from 'axios';
import WidgetSlider from './WidgetSlider.vue';
import Swal from 'sweetalert2';

export default {
  components: {
    WidgetSlider
  },
  data() {
    return {
      form: {
        name: '',
        email: ''
      }
    }
  },
  methods: {
    async initiateSignUp() {
      try {
        const response = await axios.post('/api/initiate-signup', this.form);
        
        if (response.data.token) {
          Swal.fire({
            icon: 'success',
            title: 'Sign Up Initiated',
            text: 'Please complete your registration.',
            toast: true,
            position: 'top-end',
            showConfirmButton: false,
            timer: 3000
          });
          window.location.href = `/complete-registration/${response.data.token}`;
        } else {
          Swal.fire({
            icon: 'error',
            title: 'Sign Up Failed',
            text: 'An error occurred. Please try again.',
            toast: true,
            position: 'top-end',
            showConfirmButton: false,
            timer: 3000
          });
        }
      } catch (error) {
        console.error('Sign Up error:', error);
        Swal.fire({
          icon: 'error',
          title: 'Sign Up Failed',
          text: error.response?.data?.message || 'An unexpected error occurred',
          toast: true,
          position: 'top-end',
          showConfirmButton: false,
          timer: 3000
        });
      }
    }
  }
}
</script>
<style>
.oil-widget-icon {
  filter: invert(1);
}

.market-summary:hover .oil-widget-icon {
  filter: invert(0);
}
</style>