<template>
    <div>
      <h5 class="fs-5 fw-6 px-3 pt-4 d-flex align-items-center">Download The Corporate Presentation</h5>
      <div class="px-3 py-2 pb-3 text-center">
        <button class="btn btn-primary fs-5 w-100" @click="showDownloadModal">
          <i class="bi bi-file-earmark-pdf-fill me-1"></i> Download Here
        </button>
      </div>
      
      <!-- Modal -->
      <div class="modal fade" id="downloadModal" tabindex="-1" aria-labelledby="downloadModalLabel" aria-hidden="true">
        <div class="modal-dialog">
          <div class="modal-content">
            <div class="modal-header">
              <div class="text-center w-100">
                <img class="header-image is-logo-image" alt="Rich TV" src="/build/images/logo.svg" title="Rich TV">
              </div>
              <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
              <h5 class="modal-title fs-1 fw-bolder mb-2 text-center" id="downloadModalLabel">Download Corporate Presentation</h5>
              <p class="text-center fs-5 fw-bold">Stay Ahead of the Market with Real-Time Alerts on Trending Stocks—Absolutely FREE! Sign up now to receive <span class="themetxtclr">100% FREE</span> email and text alerts, keeping you informed about the <span class="themetxtclr">hottest stock</span> trends as they happen!</p>
              
              <!-- Mautic form will be loaded here -->
              <div :id="mauticFormWrapperId" class="mauticform_wrapper mt-4">
                <form autocomplete="false" role="form" method="post" :action="formAction" :id="mauticFormId" :data-mautic-form="mauticFormName" enctype="multipart/form-data">
                  <div class="mauticform-error text-danger" :id="mauticFormId + '_error'"></div>
                  <div class="mauticform-message text-success mb-3" :id="mauticFormId + '_message'"></div>
                  <div class="mauticform-innerform">
                    <div class="mauticform-page-wrapper mauticform-page-1" data-mautic-form-page="1">
      
                      <div class="form-group d-flex flex-wrap gap-3">
                        <div class="flex-fill position-relative mauticform-required" :id="mauticFormId + '_enter_your_email'" data-validate="enter_your_email" data-validation-type="email">
                          <input :id="'mauticform_input_' + mauticFormId + '_enter_your_email'" :name="'mauticform[enter_your_email]'" value="" placeholder="Enter Your Email" class="form-control form-control-lg px-3 py-3 fs-6 newsletter-input border" type="email">
                          <div :id="mauticFormId + '_submit'" class="msubmitbutton">
                            <button type="submit" :name="'mauticform[submit]'" :id="'mauticform_input_' + mauticFormId + '_submit'" value="" class="btn btn-primary fw-5 newsletter-btn position-absolute">Get Access</button>
                          </div>
                          
                          <span class="mauticform-errormsg text-danger fs-6" style="display: none;">Email field is required</span>
                        </div>
                      </div>
                      
                      <div :id="mauticFormId + '_you_consent_to_receive_em'" data-validate="you_consent_to_receive_em" data-validation-type="checkboxgrp" class="mauticform-row mauticform-checkboxgrp mauticform-field-2 mauticform-required">
                        
                        <div class="mauticform-checkboxgrp-row d-flex align-items-start mt-3 gap-2">
                          <input data-v-34de2070="" class="mauticform-checkboxgrp-checkbox mt-1" :name="'mauticform[you_consent_to_receive_em][]'" :id="'mauticform_checkboxgrp_checkbox_you_consent_to_receive_em_' + postId + '0'" type="checkbox" value="0">
                          <label :id="'mauticform_checkboxgrp_label_you_consent_to_receive_em_' + postId + '0'" :for="'mauticform_checkboxgrp_checkbox_you_consent_to_receive_em_' + postId + '0'" class="mauticform-checkboxgrp-label2">You consent to receive emails from Rich Tv and agree to our <a href="https://richtv.io/terms-of-use" target="blank">Terms</a> and <a href="https://richtv.io/privacy-policy" target="_blank">Privacy Policy</a></label>
                        </div>
                        <span class="mauticform-errormsg text-danger fs-6" style="display: none;">please check the consent box</span>
                      </div>
                      <input :id="'mauticform_input_' + mauticFormId + '_honeypot'" :name="'mauticform[honeypot]'" value="" type="hidden">
                      
                    </div>
                  </div>
                  
                  <input type="hidden" name="mauticform[formId]" :id="mauticFormId + '_id'" :value="formId">
                  <input type="hidden" name="mauticform[return]" :id="mauticFormId + '_return'" value="">
                  <input type="hidden" name="mauticform[formName]" :id="mauticFormId + '_name'" :value="mauticFormName">
                  <input type="hidden" name="mauticform[ajax]" :id="mauticFormId + '_ajax'" value="1">
                </form>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </template>
  
  <script>
  import { Modal } from 'bootstrap';
  
  export default {
    props: {
      postId: {
        type: Number,
        required: true
      },
      loggedIn: {
        type: Boolean,
        default: false
      }
    },
    data() {
      return {
        modal: null,
        mauticLoaded: false,
        isSubmitting: false
      };
    },
    computed: {
      formId() {
        // Return different form IDs based on post ID
        return this.postId === 433883 ? '92' : '93';
      },
      mauticFormName() {
        return this.postId === 433883 ? 'jackpotdigitalincreport' : 'zefiromethanecorpreport';
      },
      mauticFormId() {
        return 'mauticform_' + this.mauticFormName;
      },
      mauticFormWrapperId() {
        return this.mauticFormId + '_wrapper';
      },
      formAction() {
        return `https://mailer.servicesground.com/form/submit?formId=${this.formId}`;
      },
      downloadFileUrl() {
        // Different download URLs for each post
        return this.postId === 433883 
          ? 'https://mailer.servicesground.com/asset/21:jackpot-digital-investor-presentation-q1-20250pdf'
          : 'https://mailer.servicesground.com/asset/22:zefiro-deck-roadshow-version-v46pdf';
      }
    },
    methods: {
      showDownloadModal() {
        if (this.loggedIn) {
          this.downloadFile();
          return;
        }
        
        if (!this.mauticLoaded) {
          this.loadMauticScript();
        }
        
        if (!this.modal) {
          this.modal = new Modal(document.getElementById('downloadModal'));
        }
        
        this.modal.show();
  
        this.isSubmitting = false;
        this.$nextTick(() => {
          this.setupMauticForm();
        });
      },
      
      downloadFile() {
        const fileUrl = this.downloadFileUrl;
        const downloadLink = document.createElement('a');
        downloadLink.href = fileUrl;
        downloadLink.download = 'Corporate-Presentation.pdf';
        document.body.appendChild(downloadLink);
      
        downloadLink.click();
        
        document.body.removeChild(downloadLink);
      },
      
      loadMauticScript() {
        if (this.mauticLoaded) return;
        
        // Load Mautic script
        const script = document.createElement('script');
        script.type = 'text/javascript';
        script.src = 'https://mailer.servicesground.com/media/js/mautic-form.js?v592b194e';
        script.onload = () => {
          window.MauticSDK.onLoad();
          this.mauticLoaded = true;
        };
        
        // Set Mautic global variables
        window.MauticDomain = 'https://mailer.servicesground.com';
        window.MauticLang = {
          'submittingMessage': "Please wait..."
        };
        
        document.head.appendChild(script);
      },
      
      setupMauticForm() {
        this.$nextTick(() => {
          const form = document.getElementById(this.mauticFormId);
          if (form) {
            form.addEventListener('submit', this.handleMauticSubmit);
            this.setupHoneypot();
          }
        });
      },
      
      setupHoneypot() {
        const form = document.getElementById(this.mauticFormId);
        if (form) {
          const returnInput = document.getElementById(`${this.mauticFormId}_return`);
          if (returnInput) {
            returnInput.value = '';
          }
          form.addEventListener('submit', this.checkHoneypot);
        }
      },
      
      checkHoneypot(event) {
        const honeypotField = document.getElementById(`mauticform_input_${this.mauticFormId}_honeypot`);
        if (honeypotField && honeypotField.value.trim() !== '') {
          event.preventDefault();
          console.log('Honeypot triggered - form submission blocked');
          return false;
        }
      },
      
      handleMauticSubmit(event) {
        if (this.isSubmitting) {
          event.preventDefault();
          return;
        }
        this.isSubmitting = true;
        const submitButton = document.getElementById(`mauticform_input_${this.mauticFormId}_submit`);
        if (submitButton) {
          const originalText = submitButton.innerHTML;
          submitButton.disabled = true;
          submitButton.innerHTML = '<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Processing...';
          setTimeout(() => {
            try {
              const buttonElement = document.getElementById(`mauticform_input_${this.mauticFormId}_submit`);
              if (buttonElement) {
                buttonElement.disabled = false;
                buttonElement.innerHTML = originalText;
              }
              this.isSubmitting = false;
            } catch (e) {
              console.log('Button reset attempted after form submission');
            }
          }, 3000);
        }
      }
    },
    mounted() {
      this.setupHoneypot();
    },
    beforeDestroy() {
      if (this.modal) {
        this.modal.dispose();
      }
    }
  };
  </script>
  
  <style scoped>
  .themetxtclr {
    color: #edb043;
  }
  .mauticform-input{
  width: 100%;
  padding: 10px;
  border: 1px solid #ccc;
}
.modal-dialog{
  max-width: 992px;
  transform: translateY(50%)!important;
}
  .newsletter-btn {
    border-radius: 0 25px 25px 0;
    right: 0;
    bottom: 0;
    top: 0;
  }
  .newsletter-input {
    border-radius: 25px;
    border-color: #dddcdc !important;
  }
  .msubmitbutton + .mauticform-errormsg{
    position: absolute;
    bottom: 0px;
    left: 16px;
}
  </style>