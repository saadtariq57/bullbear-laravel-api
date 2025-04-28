<template>
  <div v-if="isVisible" class="email-popup-overlay">
    <div class="email-popup">
      <div class="popup-header">
        <h3>Get Latest Stock Pick Alerts</h3>
        <button @click="closePopup" class="close-btn"><i class="bi bi-x"></i></button>
      </div>
      <div class="popup-body">
        <div class="email-form-wrapper">
          <form autocomplete="off" role="form" @submit.prevent="submitForm">
            <!-- Email Input -->
            <div class="form-group">
              <input v-model="email" placeholder="Enter your email" class="form-control" type="email">
              <!-- Honeypot Field -->
              <input type="text" v-model="honeypot" style="display:none;">
            </div>

            <!-- Consent Checkbox -->
            <div class="form-group consent-group">
              <div class="checkbox-row">
                <input id="consent_checkbox" v-model="consentChecked" type="checkbox" value="1">
                <label for="consent_checkbox" class="consent-label">
                  I agree to receive newsletters and email alerts.
                </label>
              </div>
            </div>
            
            <!-- Submit Button -->
            <div class="button-wrapper">
              <button type="submit" :disabled="!isFormValid || isSubmitting" class="submit-button">
                <span v-if="!isSubmitting">Subscribe Now</span>
                <span v-else>Processing...</span>
              </button>
            </div>
            
            <!-- Success message -->
            <div v-if="submitSuccess" class="submit-success">
              Thank you for subscribing! You'll receive our stock pick alerts soon.
            </div>
            
            <!-- Error message -->
            <div v-if="errorMessage" class="submit-error">
              {{ errorMessage }}
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>
</template>
  
<script>
import axios from 'axios';

export default {
  data() {
    return {
      isVisible: false,
      email: '',
      honeypot: '',
      consentChecked: false,
      isSubmitting: false,
      submitSuccess: false,
      errorMessage: ''
    }
  },
  computed: {
    isFormValid() {
      const emailPattern = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
      return this.email.trim() !== '' && 
             emailPattern.test(this.email) && 
             this.consentChecked &&
             this.honeypot === '';
    }
  },
  mounted() {
    window.addEventListener('show-email-popup', this.showPopup);
  },
  beforeUnmount() {
    window.removeEventListener('show-email-popup', this.showPopup);
  },
  methods: {
    async showPopup(event) {
      console.log('Show popup method called', event);
      if (event.detail && event.detail.email) {
        this.email = event.detail.email;
      }
      this.isVisible = true;
      
      this.isSubmitting = false;
      this.submitSuccess = false;
      this.errorMessage = '';
    },
    closePopup() {
      this.isVisible = false;
      this.email = '';
      this.honeypot = '';
      this.consentChecked = false;
      this.isSubmitting = false;
      this.submitSuccess = false;
      this.errorMessage = '';
    },
    async submitForm() {
      if (!this.isFormValid || this.isSubmitting) {
        return;
      }
      
      this.isSubmitting = true;
      this.errorMessage = '';
      
      try {
        // Prepare form data
        const formData = new FormData();
        formData.append('mauticform[email]', this.email);
        formData.append('mauticform[consent_box]', this.consentChecked ? '1' : '0');
        formData.append('honeypot', this.honeypot);
        
        // Submit the form to your backend
        const response = await axios.post('/api/email-collector', formData);
        
        if (response.data.success) {
          this.submitSuccess = true;
          
          // Close the popup after a delay
          setTimeout(() => {
            this.closePopup();
          }, 3000);
        } else {
          this.errorMessage = response.data.message || 'An error occurred. Please try again.';
        }
      } catch (error) {
        console.error('Form submission error:', error);
        if (error.response && error.response.status === 422) {
          // Validation errors
          const errors = error.response.data.errors;
          if (errors) {
            // Check for specific error types
            if (errors['mauticform.email']) {
              this.errorMessage = errors['mauticform.email'][0];
            } else {
              // Get the first error message
              for (const field in errors) {
                if (errors[field] && errors[field].length > 0) {
                  this.errorMessage = errors[field][0];
                  break;
                }
              }
            }
          } else {
            this.errorMessage = 'Please check your input and try again.';
          }
        } else if (error.response && error.response.status === 429) {
          this.errorMessage = 'Too many attempts. Please try again later.';
        } else {
          this.errorMessage = 'An error occurred. Please try again later.';
        }
      } finally {
        this.isSubmitting = false;
      }
    }
  }
}
</script>
  
<style scoped>
.email-popup-overlay {
  position: fixed;
  top: 0;
  left: 0;
  width: 100%;
  height: 100%;
  background-color: rgba(0, 0, 0, 0.7);
  display: flex;
  justify-content: center;
  align-items: center;
  z-index: 9999;
}
  
.email-popup {
  background-color: white;
  border-radius: 8px;
  width: 90%;
  max-width: 500px;
  padding: 20px;
  box-shadow: 0 4px 20px rgba(0, 0, 0, 0.2);
}
  
.popup-header {
  display: flex;
  justify-content: space-between;
  align-items: center;
  margin-bottom: 20px;
}
  
.popup-header h3 {
  margin: 0;
  color: #333;
}
  
.close-btn {
  background: none;
  border: none;
  font-size: 24px;
  cursor: pointer;
  color: #999;
}

.form-group {
  margin-bottom: 15px;
}

.consent-group {
  margin-top: 10px;
}

.checkbox-row {
  display: flex;
  align-items: flex-start;
}

.consent-label {
  font-size: 13px;
  margin-left: 7px;
  line-height: 1.4;
}
  
.submit-button {
  background-color: var(--cta-btn) !important;
  color: var(--white);
  padding: 10px 20px;
  border: none;
  transition: .5s;
  width: 100%;
  margin-top: 15px;
  border-radius: 4px;
  cursor: pointer;
}

.submit-button:disabled {
  opacity: 0.7;
  cursor: not-allowed;
}
  
.form-control {
  width: 100%;
  padding: 10px;
  border: 1px solid #ddd;
  border-radius: 4px;
  font-size: 14px;
}

.submit-success {
  color: green;
  font-size: 14px;
  margin-top: 15px;
  text-align: center;
}

.submit-error {
  color: #d9534f;
  font-size: 14px;
  margin-top: 15px;
  text-align: center;
  padding: 8px;
  border-radius: 4px;
  background-color: #f8d7da;
  border: 1px solid #f5c6cb;
}
</style>