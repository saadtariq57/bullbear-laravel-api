<template>
  <div class="container my-5">
    <div class="row">
      <!-- Google Map Section -->
      <div class="col-12 mb-4">
        <section class="cont-map-sec">
          <div v-if="loadingMap" class="skeleton skeleton-map"></div>
          <div v-else class="map">
            <iframe
              src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d2602.589858327793!2d-123.11566388411956!3d49.28416837858611!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x54867178ed620821%3A0xc69e563a77dcb312!2s438%20Seymour%20St%2C%20Vancouver%2C%20BC%20V6B6H4%2C%20Canada!5e0!3m2!1sen!2s!4v1657214876060!5m2!1sen!2s"
              width="100%"
              height="461"
              style="border:0;"
              allowfullscreen=""
              loading="lazy"
              referrerpolicy="no-referrer-when-downgrade"
            ></iframe>
          </div>
        </section>
      </div>

      <!-- Contact Information and Form -->
      <div class="col-lg-5 mb-4">
        <section class="contact-info">
          <div v-if="loadingInfo" class="skeleton skeleton-info"></div>
          <div v-else>
            <h3>Get in touch with us.</h3>
            <div class="mb-3">
              <i class="bi bi-geo-alt-fill text-primary me-2"></i>
              438 Seymour St, Vancouver, B.C, V6B6H4
            </div>
            <div class="mb-3">
              <i class="bi bi-telephone-fill text-success me-2"></i>
              <a href="tel:+17782372402" class="text-decoration-none">(778) 237-2402</a>
            </div>
            <div class="mb-3">
              <i class="bi bi-envelope-fill text-danger me-2"></i>
              <a href="mailto:support@richtv.io" class="text-decoration-none">support@richtv.io</a>
            </div>
            <div class="social-icons d-flex mt-4">
              <a href="https://www.facebook.com/richtv.io" target="_blank" class="me-3 text-primary">
                <i class="bi bi-facebook fs-4"></i>
              </a>
              <a href="https://www.youtube.com/c/RICHTVLIVE" target="_blank" class="me-3 text-danger">
                <i class="bi bi-youtube fs-4"></i>
              </a>
              <a href="https://www.instagram.com/richtv.io/" target="_blank" class="me-3 text-warning">
                <i class="bi bi-instagram fs-4"></i>
              </a>
              <a href="https://twitter.com/richtv_io" target="_blank" class="me-3 text-info">
                <i class="bi bi-twitter fs-4"></i>
              </a>
              <a href="https://linkedin.com/company/richtv-io" target="_blank" class="me-3 text-primary">
                <i class="bi bi-linkedin fs-4"></i>
              </a>
              <a href="https://vm.tiktok.com/ZMRaSo4tY/" target="_blank" class="text-pink">
                <i class="bi bi-tiktok fs-4"></i>
              </a>
            </div>
          </div>
        </section>
      </div>

      <div class="col-lg-7">
        <section class="contact-form-section">
          <h3>Have a query or comment?</h3>
          <p>Feel free to drop us a line and we’ll respond as soon as possible.</p>

          <form @submit.prevent="submitForm" class="needs-validation" :class="{ 'was-validated': submitted }" novalidate>
            <div class="row">
              <div class="col-md-6 mb-4">
                <label for="name" class="form-label visually-hidden">Name*</label>
                <input
                  type="text"
                  class="form-control"
                  id="name"
                  v-model="form.name"
                  placeholder="Name*"
                  required
                />
                <div class="invalid-feedback">
                  Please enter your name.
                </div>
              </div>

              <div class="col-md-6 mb-4">
                <label for="email" class="form-label visually-hidden">Email*</label>
                <input
                  type="email"
                  class="form-control"
                  id="email"
                  v-model="form.email"
                  placeholder="Email*"
                  required
                />
                <div class="invalid-feedback">
                  Please enter a valid email.
                </div>
              </div>

              <div class="col-md-6 mb-4">
                <label for="address" class="form-label visually-hidden">Address</label>
                <input
                  type="text"
                  class="form-control"
                  id="address"
                  v-model="form.address"
                  placeholder="Address"
                />
              </div>

              <div class="col-md-6 mb-4">
                <label for="phone" class="form-label visually-hidden">Phone</label>
                <input
                  type="tel"
                  class="form-control"
                  id="phone"
                  v-model="form.phone"
                  placeholder="Phone"
                />
              </div>

              <div class="col-12 mb-4">
                <label for="subject" class="form-label visually-hidden">Subject*</label>
                <input
                  type="text"
                  class="form-control"
                  id="subject"
                  v-model="form.subject"
                  placeholder="Subject*"
                  required
                />
                <div class="invalid-feedback">
                  Please enter a subject.
                </div>
              </div>

              <div class="col-12 mb-4">
                <label for="message" class="form-label visually-hidden">Message</label>
                <textarea
                  class="form-control"
                  id="message"
                  rows="5"
                  v-model="form.message"
                  placeholder="Message"
                ></textarea>
              </div>

              <!-- reCAPTCHA -->
              <div class="col-12 mb-4">
                <button type="button" class="btn btn-secondary" @click="handleRecaptcha">
                  Verify I'm not a robot
                </button>
                <div v-if="captchaError" class="text-danger mt-2">
                  Please verify that you are not a robot.
                </div>
              </div>

              <div class="col-12 text-center">
                <button type="submit" class="btn btn-primary" :disabled="submitting || !captchaToken">
                  <span v-if="submitting" class="spinner-border spinner-border-sm me-2" role="status" aria-hidden="true"></span>
                  Submit
                </button>
              </div>
            </div>
          </form>

          <!-- Success Message -->
          <div v-if="successMessage" class="alert alert-success mt-3" role="alert">
            Your message has been sent successfully!
          </div>

          <!-- Error Message -->
          <div v-if="errorMessage" class="alert alert-danger mt-3" role="alert">
            There was an error sending your message. Please try again later.
          </div>
        </section>
      </div>
    </div>
  </div>
</template>

<script>
import axios from 'axios';
import { ref, reactive } from 'vue';
import { useReCaptcha } from 'vue-recaptcha-v3';

export default {
  name: 'ContactUs',
  setup() {
    const { executeRecaptcha } = useReCaptcha();

    const loadingMap = ref(true);
    const loadingInfo = ref(true);

    // Simulate loading
    setTimeout(() => {
      loadingMap.value = false;
      loadingInfo.value = false;
    }, 1000);

    const form = reactive({
      name: '',
      email: '',
      address: '',
      phone: '',
      subject: '',
      message: '',
    });

    const submitted = ref(false);
    const submitting = ref(false);
    const successMessage = ref('');
    const errorMessage = ref('');
    const captchaToken = ref('');
    const captchaError = ref(false);

    // Renamed to handleRecaptcha to avoid conflict
    const handleRecaptcha = async () => {
      try {
        const token = await executeRecaptcha('contact_form');
        captchaToken.value = token;
      } catch (error) {
        console.error('reCAPTCHA Error:', error);
        captchaError.value = true;
      }
    };

    const submitForm = async () => {
      submitted.value = true;
      captchaError.value = false;

      // Form validation
      const formElement = document.querySelector('form');
      if (!formElement.checkValidity()) {
        formElement.classList.add('was-validated');
        return;
      }

      if (!captchaToken.value) {
        captchaError.value = true;
        return;
      }

      submitting.value = true;

      try {
        const response = await axios.post('/api/contact', {
          ...form,
          'g-recaptcha-response': captchaToken.value, // Send the token to the backend
        });

        if (response.data.success) {
          successMessage.value = 'Your message has been sent successfully!';
          errorMessage.value = '';
          // Reset form
          Object.keys(form).forEach((key) => {
            form[key] = '';
          });
          submitted.value = false;
          captchaToken.value = '';
        } else {
          errorMessage.value = 'There was an error sending your message. Please try again later.';
          successMessage.value = '';
        }
      } catch (error) {
        errorMessage.value = 'There was an error sending your message. Please try again later.';
        successMessage.value = '';
      } finally {
        submitting.value = false;
      }
    };

    return {
      loadingMap,
      loadingInfo,
      form,
      submitted,
      submitting,
      successMessage,
      errorMessage,
      captchaToken,
      captchaError,
      submitForm,
      handleRecaptcha, // Updated handler name
    };
  },
};
</script>

<style scoped>
/* Skeleton Loaders */
.skeleton {
  background-color: #e2e2e2;
  border-radius: 4px;
  animation: shimmer 1.5s infinite;
}

@keyframes shimmer {
  0% {
    background-position: -500px 0;
  }
  100% {
    background-position: 500px 0;
  }
}

.skeleton-map {
  width: 100%;
  height: 461px;
}

.skeleton-info {
  width: 100%;
  height: 300px;
}

/* Additional Styling */
.contact-info i {
  font-size: 1.2rem;
}

.social-icons a {
  transition: transform 0.3s;
}

.social-icons a:hover {
  transform: scale(1.2);
}

/* Button Styles */
.btn-primary {
  background-color: #007bff;
  border: none;
  transition: background-color 0.3s ease;
}

.btn-primary:hover {
  background-color: #0056b3;
}

.btn-secondary {
  background-color: #6c757d;
  border: none;
  transition: background-color 0.3s ease;
}

.btn-secondary:hover {
  background-color: #5a6268;
}

/* Form Control Enhancements */
.form-control {
  transition: border-color 0.3s ease, box-shadow 0.3s ease;
  border: 1px solid #efefef;
}

.form-control:focus {
  border-color: #80bdff;
  box-shadow: 0 0 0 0.2rem rgba(0, 123, 255, 0.25);
}

/* Even Spacing for Form Fields */
.mb-4 {
  margin-bottom: 1.5rem !important;
}

/* Responsive Adjustments */
@media (max-width: 767.98px) {
  .social-icons a {
    margin-bottom: 10px;
  }
}
</style>