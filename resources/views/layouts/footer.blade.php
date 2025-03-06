 <!-- footer html end  -->
 <footer class="main-foot text-white">
     <section class="main-footer container-fluid">
         <div class="container">
             <div class="row">
                 <div class="col-lg-4 col-md-6 ">
                     <div class="footer-logo">
                         <img src="{{ URL::asset('build/images/logo.svg') }}" alt="Footer logo">
                     </div>
                     <div class="footer-para">
                         <p class="mt-3">
                             Trading data in widgets
                             displayed with a 15-minute
                             delay. Prices available on stock
                             page updated in real time.
                             Market &amp; fundamental data
                             appearing on Rich Tv
                             sourced from various 3rd party
                             data providers.
                         </p>
                     </div>
                 </div>
                 <div class="col-6 col-lg-2 col-md-6 mt-mobile">
                     <div class="footer-heading">
                         <h2 class="mb-3">Rich Tv</h2>
                     </div>
                     <div class="footer-links">
                         <div class="menu-footer-navigation-one-container">
                             <ul id="menu-footer-navigation-one" class="menu  list-unstyled">
                                 <li class="pb-3"><a href="/about-us/" aria-label="about us">About
                                         Us</a></li>
                                 <li class="pb-3"><a href="/pricing">Pricing and Plans </a></li>
                                 <li class="pb-3"><a href="/contact-us/" aria-label="contact us">Contact
                                         us</a></li>
                                 {{-- <li class="pb-3"><a href="/register" aria-label="Join club">Join the Club</a></li> --}}
                             </ul>
                         </div>
                     </div>
                 </div>
                 <div class="col-6 col-lg-2 col-md-6 mt-mobile">
                     <div class="footer-heading">
                         <h2 class="mb-3"> Learning</h2>
                     </div>
                     <div class="footer-links">
                         <div class="menu-footer-navigation-two-container">
                             <ul id="menu-footer-navigation-two" class="menu list-unstyled">
                                 <li class="pb-3"><a href="/pro-picks" aria-label="Rich picks">Rich Picks</a></li>
                                 <li class="pb-3"><a href="/blog/investing/"aria-label="News">News</a></li>
                                 <li class="pb-3"><a href="/trading-education/" aria-label="trading school">Trading School</a></li>
                                 <li class="pb-3"><a href="/previous-performence" aria-label="penny stock">Previous Performence</a></li>
                             </ul>
                         </div>
                     </div>
                 </div>
                 <div class="col-lg-4 col-md-6 mt-mobile">
                    @guest
                     <div class="footer-contact-us footer-heading">
                         <h2 class="mb-3">Get Latest Stock Pick Alerts</h2>
                     </div>
                     
                     <div class="footer-searchbar mb-3 position-relative">
                        <script type="text/javascript">
                            /** This section is only needed once per page if manually copying **/
                            if (typeof MauticSDKLoaded == 'undefined') {
                                var MauticSDKLoaded = true;
                                var head            = document.getElementsByTagName('head')[0];
                                var script          = document.createElement('script');
                                script.type         = 'text/javascript';
                                script.src          = 'https://mailer.servicesground.com/media/js/mautic-form.js?v592b194e';
                                script.onload       = function() {
                                    MauticSDK.onLoad();
                                };
                                head.appendChild(script);
                                var MauticDomain = 'https://mailer.servicesground.com';
                                var MauticLang   = {
                                    'submittingMessage': "Please wait..."
                                }
                            }else if (typeof MauticSDK != 'undefined') {
                                MauticSDK.onLoad();
                            }
                        </script>
                        <style type="text/css" scoped>
                            .mauticform-field-hidden { display:none }
                            #mauticform_richtvleadmagnetfooter_submit{ position:absolute; right:5px;top: 5px;}
                            #mauticform_richtvleadmagnetfooter_email{margin-bottom:10px;}
                            button#mauticform_input_richtvleadmagnetfooter_submit{
                                background-color: var(--cta-btn) !important;
                                color: var(--white);
                                padding: 10px 20px;
                                border: none;
                                transition: .5s;
                            }
                            .mauticform-checkboxgrp-label{
                                font-size: 11px;
                                vertical-align: top;
                                padding-left: 7px;
                            }
                            .mauticform-errormsg, #mauticform_richtvleadmagnetfooter_error{color:red;font-size: 11px; margin-top: 10px;}
                            #mauticform_richtvleadmagnetfooter_message{color:#089d08;font-size: 11px; margin-top: 10px;}
                        </style>
                        <div id="mauticform_wrapper_richtvleadmagnetfooter" class="mauticform_wrapper">
                            <form autocomplete="false" role="form" method="post" action="https://mailer.servicesground.com/form/submit?formId=64" id="mauticform_richtvleadmagnetfooter" data-mautic-form="richtvleadmagnetfooter" enctype="multipart/form-data">
                                <div class="mauticform-innerform">
                                    <div class="mauticform-page-wrapper mauticform-page-1" data-mautic-form-page="1">
                                        <!-- Email Input -->
                                        <div id="mauticform_richtvleadmagnetfooter_email" data-validate="email" data-validation-type="email" class="mauticform-row mauticform-email mauticform-field-1 mauticform-required">
                                            <input id="mauticform_input_richtvleadmagnetfooter_email" name="mauticform[email]" value="" placeholder="Enter your email" class="mauticform-input" type="email">
                                            <!-- Honeypot Field -->
                                            <input type="text" name="mauticform[honeypot]" id="mauticform_honeypot" style="display:none;">
                                            
                                            <div id="mauticform_richtvleadmagnetfooter_submit" class="mauticform-row mauticform-button-wrapper mauticform-field-3">
                                                <button type="submit" name="mauticform[submit]" id="mauticform_input_richtvleadmagnetfooter_submit" value="" class="mauticform-button btn btn-default" disabled>
                                                    <i class="bi bi-arrow-right fw-6 footer-newsletter-icon"></i>
                                                </button>
                                            </div>
                                        </div>
                                        <span class="mauticform-errormsg" id="mauticform_email_error" style="display: none;">Enter a valid email</span>
                        
                                        <!-- Consent Checkbox -->
                                        <div id="mauticform_richtvleadmagnetfooter_consent_box" data-validate="consent_box" data-validation-type="checkboxgrp" class="mauticform-row mauticform-checkboxgrp mauticform-field-2 mauticform-required">
                                            <div class="mauticform-checkboxgrp-row">
                                                <input class="mauticform-checkboxgrp-checkbox" name="mauticform[consent_box][]" id="mauticform_checkboxgrp_checkbox_consent_box_00" type="checkbox" value="0">
                                                <label id="mauticform_checkboxgrp_label_consent_box_00" for="mauticform_checkboxgrp_checkbox_consent_box_00" class="mauticform-checkboxgrp-label">I agree to receive newsletters and email alerts.</label>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                        
                                <input type="hidden" name="mauticform[formId]" id="mauticform_richtvleadmagnetfooter_id" value="64">
                                <input type="hidden" name="mauticform[return]" id="mauticform_richtvleadmagnetfooter_return" value="">
                                <input type="hidden" name="mauticform[formName]" id="mauticform_richtvleadmagnetfooter_name" value="richtvleadmagnetfooter">
                            </form>
                        </div>
                        
                        <script>
                            document.addEventListener("DOMContentLoaded", function () {
                                const emailInput = document.getElementById("mauticform_input_richtvleadmagnetfooter_email");
                                const submitButton = document.getElementById("mauticform_input_richtvleadmagnetfooter_submit");
                                const errorMessage = document.getElementById("mauticform_email_error");
                                const honeypot = document.getElementById("mauticform_honeypot");
                        
                                function validateEmail() {
                                    const emailPattern = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
                                    if (emailInput.value.trim() === "" || !emailPattern.test(emailInput.value)) {
                                        errorMessage.style.display = "block";
                                        submitButton.disabled = true;
                                    } else {
                                        errorMessage.style.display = "none";
                                        submitButton.disabled = honeypot.value ? true : false;
                                    }
                                }
                        
                                emailInput.addEventListener("input", validateEmail);
                                honeypot.addEventListener("input", () => submitButton.disabled = true);
                            });
                        </script>                                                
                         <div class="err" id="err-f_email" style="display: none;"></div>
                         <div class="formsubmission" id="f_formsubmission">
                             <p class="formsubmission-text"></p>
                         </div>
                     </div>
                     @endguest
                     <div class="email mb-2">
                         <a href="mailto:support@richtv.io" class="d-flex gap-3 align-items-center" aria-label="email"
                             target="_blank" rel="nofollow">
                             <div class="d-inline-block fs-18"> <i class="bi bi-envelope"></i></div>
                             support@richtv.io
                         </a>
                     </div>
                     <div class="footer-num email mb-4">
                         <a href="tel:778-237-2402" target="_blank" class="d-flex gap-3 align-items-center"
                             aria-label="Phone" rel="nofollow">
                             <div class="d-inline-block fs-18"><i class="bi bi-telephone"></i></div>
                             778-237-2402
                         </a>
                     </div>
                     <div class="footer-icons d-flex gap-4">
                         <a href="https://www.facebook.com/richtv.io" class="fs-18" target="_blank"
                             aria-label="Facebook" rel="nofollow">
                             <i class="bi bi-facebook"></i>
                         </a>
                         <a href="https://www.youtube.com/c/RICHTVLIVE" class="fs-18" target="_blank"
                             aria-label="Youtube" rel="nofollow">
                             <i class="bi bi-youtube"></i>
                         </a>
                         <a href="https://www.instagram.com/richtv.io/" class="fs-18" target="_blank"
                             aria-label="Instagram" rel="nofollow">
                             <i class="bi bi-instagram"></i>
                         </a>
                         <a href="https://twitter.com/richtv_io" class="fs-18" target="_blank" aria-label="Twitter"
                             rel="nofollow">
                             <i class="bi bi-twitter"></i>
                         </a>
                         <a href="https://linkedin.com/company/richtv-io" class="fs-18" target="_blank"
                             aria-label="Linkdin" rel="nofollow">
                             <i class="bi bi-linkedin"></i>
                         </a>
                         <a href="https://www.tiktok.com/@richtv.io" target="_blank" class="fs-18"
                             aria-label="Tiktok" rel="nofollow">
                             <i class="bi bi-tiktok"></i>
                         </a>
                     </div>
                 </div>
                 <div class="col-12 footer-bootem d-flex py-4 mt-5 border-top ">
                     <p class="mb-0 ">Copyright © <?php echo date('Y'); ?> Rich Tv. All rights reserved</p>
                     <div class="">
                         <a href="/privacy-policy" class="policy-page px-2 mx-2 border-end border-start"
                             aria-label="Privacy Policy">Privacy Policy</a><a href="/terms-of-use"
                             aria-label="Terms">Terms
                             of Use</a>
                     </div>
                 </div>
             </div>
         </div>
     </section>
 </footer>
