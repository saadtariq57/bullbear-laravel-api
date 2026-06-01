 <!-- footer html end  -->
<footer class="main-foot text-white main-foot-bottom-margin">
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
                             appearing on {{ config('app.name') }}
                             sourced from various 3rd party
                             data providers.
                         </p>
                     </div>
                 </div>
                 <div class="col-6 col-lg-2 col-md-6 mt-mobile">
                     <div class="footer-heading">
                         <h2 class="mb-3">{{ config('app.name') }}</h2>
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
                                 <li class="pb-3"><a href="/trading-history" aria-label="penny stock">Trading History</a></li>
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
                        <div class="email-trigger-container">
                            <input type="email" id="emailTriggerField" placeholder="Enter your email" class="form-control" readonly>
                            <button id="emailTriggerButton" class="position-absolute" style="right:5px;top:5px;background-color:var(--cta-btn);color:var(--white);border:none;padding:10px 20px;">
                                <i class="bi bi-arrow-right fw-6 footer-newsletter-icon"></i>
                            </button>
                            <script>
                                document.addEventListener('DOMContentLoaded', function() {
                                    const emailTriggerField = document.getElementById('emailTriggerField');
                                    const emailTriggerButton = document.getElementById('emailTriggerButton');
                                    if (!emailTriggerField || !emailTriggerButton) { return; }
                                    function triggerEmailPopup() {
                                        const email = emailTriggerField.value || '';
                                        const event = new CustomEvent('show-email-popup', {
                                            detail: { email: email }
                                        });
                                        window.dispatchEvent(event);
                                        emailTriggerField.value = '';
                                    }
                                    emailTriggerButton.addEventListener('click', triggerEmailPopup);
                                    emailTriggerField.addEventListener('click', triggerEmailPopup);
                                });
                            </script>
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
                         <a href="https://web.telegram.org/a/#-1001399691536" target="_blank" class="fs-18"
                             aria-label="Tiktok" rel="nofollow">
                             <i class="bi bi-telegram"></i>
                         </a>
                         <a href="https://in.tradingview.com/u/Richtv_official/" target="_blank" class="fs-18"
                             aria-label="Tiktok" rel="nofollow">
                             <img src="{{ URL::asset('build/images/Tradingview_icon.png') }}" alt="">
                         </a>
                     </div>
                 </div>
                 <div class="col-12 footer-bootem d-flex py-4 mt-5 border-top ">
                     <p class="mb-0 ">Copyright © <?php echo date('Y'); ?> {{ config('app.name') }}. All rights reserved</p>
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
