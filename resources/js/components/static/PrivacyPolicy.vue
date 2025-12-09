<template>
  <div class="container my-5" v-if="!loading">
    <div class="row">
      <!-- Table of Contents -->
      <div class="col-lg-4 col-xl-3 shadow-sm rounded-4 bg-custom p-4">
      <nav id="privacyTableOfContents">
        <h2 class="h4">Contents</h2>
        <ul class="nav flex-column">
          <li class="nav-item">
            <a
              class="nav-link"
              href="#introduction"
              :class="{ 'active-link': activeLink === '#introduction' }"
              @click="setActiveLink('#introduction')"
            >
              Introduction
            </a>
          </li>
          <li class="nav-item">
            <a
              class="nav-link"
              href="#information-collection"
              :class="{ 'active-link': activeLink === '#information-collection' }"
              @click="setActiveLink('#information-collection')"
            >
              Information Collection
            </a>
          </li>
          <li class="nav-item">
            <a
              class="nav-link"
              href="#cookies"
              :class="{ 'active-link': activeLink === '#cookies' }"
              @click="setActiveLink('#cookies')"
            >
              Cookies
            </a>
          </li>
          <li class="nav-item">
            <a
              class="nav-link"
              href="#opt-out"
              :class="{ 'active-link': activeLink === '#opt-out' }"
              @click="setActiveLink('#opt-out')"
            >
              Opt-Out
            </a>
          </li>
          <li class="nav-item">
            <a
              class="nav-link"
              href="#california-rights"
              :class="{ 'active-link': activeLink === '#california-rights' }"
              @click="setActiveLink('#california-rights')"
            >
              California Privacy Rights
            </a>
          </li>
          <li class="nav-item">
            <a
              class="nav-link"
              href="#security"
              :class="{ 'active-link': activeLink === '#security' }"
              @click="setActiveLink('#security')"
            >
              Security
            </a>
          </li>
          <li class="nav-item">
            <a
              class="nav-link"
              href="#data-retention"
              :class="{ 'active-link': activeLink === '#data-retention' }"
              @click="setActiveLink('#data-retention')"
            >
              Data Retention
            </a>
          </li>
          <li class="nav-item">
            <a
              class="nav-link"
              href="#contact"
              :class="{ 'active-link': activeLink === '#contact' }"
              @click="setActiveLink('#contact')"
            >
              Contact
            </a>
          </li>
        </ul>
      </nav>
    </div>

      <!-- Privacy Policy Content -->
      <div class="col-lg-9 col-md-12">
        <div class="privacy-heading mb-4">
          <h1 class="display-4">Privacy Policy</h1>
          <div class="border-heading"></div>
        </div>
        <div class="privacy-content">
          <!-- Introduction Section -->
          <section id="introduction" class="mb-5 anchor-section">
            <h2 class="h3 mb-3"><i class="bi bi-info-circle me-2"></i>Introduction</h2>
            <p>RICH TV. (“RICH TV”, “we,” or “us”) is committed to protecting your privacy. This Privacy Policy explains
              how your personal information is collected, used, and disclosed by RICH TV.</p>
            <p>This Privacy Policy applies to our website, RICH TV, and its associated subdomains (collectively, our
              “Service”). By accessing or using our Service, you signify that you have read, understood, and agree to
              our collection, storage, use, and disclosure of your personal information as described in this Privacy
              Policy and our Terms of Service.</p>
            <p class="mb-4">We will not disclose personal information about you to any third party without your express
              consent. Please read the following to learn more about our privacy policy. Our Privacy Policy is subject
              to change.</p>
          </section>

          <!-- Information Collection Section -->
          <section id="information-collection" class="mb-5 anchor-section">
            <h2 class="h3 mb-3"><i class="bi bi-collection me-2"></i>What Information Does RICH TV Collect?</h2>
            <p>By registering with Rich TV or signing up to receive a newsletter from Rich TV, we will automatically opt
              your email address into our email lists, where we will look to send you relevant content. You can
              opt-out at any time. Rich TV does not share your email address with any third-party advertisers.</p>
            <!-- Additional paragraphs and lists as per original content -->
            <ul class="list-group list-group-flush">
              <li class="list-group-item">
                <strong><i class="bi bi-phone me-2"></i>Device Information:</strong> We automatically track and collect data from the
                devices and applications you use to access our Services...
              </li>
              <!-- Repeat for other list items with appropriate icons -->
            </ul>
          </section>

          <!-- Cookies Section -->
          <section id="cookies" class="mb-5 anchor-section">
            <h2 class="h3 mb-3"><i class="bi bi-cup me-2"></i>Does RICH TV Use Cookies?</h2>
            <p class="mb-4">To optimize the user experience RICH TV may make use of cookies technology...</p>
          </section>

          <!-- Opt-Out Section -->
          <section id="opt-out" class="mb-5 anchor-section">
            <h2 class="h3 mb-3"><i class="bi bi-x-circle me-2"></i>How Do I Opt-Out?</h2>
            <p class="mb-4">Commercial email communications from RICH TV come with an unsubscribe link at the bottom...</p>
          </section>

          <!-- California Privacy Rights Section -->
          <section id="california-rights" class="mb-5 anchor-section">
            <h2 class="h3 mb-3"><i class="bi bi-flag-fill me-2"></i>Your California Privacy Rights</h2>
            <p class="mb-4">The California Consumer Privacy Act (CCPA), also known as AB-375, provides California residents...</p>
          </section>

          <!-- Security Section -->
          <section id="security" class="mb-5 anchor-section">
            <h2 class="h3 mb-3"><i class="bi bi-shield-lock-fill me-2"></i>How Does RICH TV Protect Your Information?</h2>
            <p class="mb-4">To prevent unauthorized access, maintain data accuracy, and ensure the appropriate use of
              information, we have put in place commercially reasonable physical, electronic, and managerial
              procedures to protect the information we collect online...</p>
          </section>

          <!-- Data Retention Section -->
          <section id="data-retention" class="mb-5 anchor-section">
            <h2 class="h3 mb-3"><i class="bi bi-hourglass-split me-2"></i>How Long Does RICH TV Store Your Data?</h2>
            <p class="mb-4">RICH TV can store usage data for the life of the service starting from its release date.
              Personal data can be stored indefinitely or until a request has been made to delete the data.</p>
          </section>

          <!-- Contact Section -->
          <section id="contact" class="mb-5 anchor-section">
            <h2 class="h3 mb-3"><i class="bi bi-envelope-fill me-2"></i>Contact Us</h2>
            <p>If you have any additional questions, please visit <a href="/contact-us" aria-label="Visit Contact Page">https://richtv.io/contact-us/</a></p>
            <ul class="list-unstyled">
              <li><i class="bi bi-envelope me-2"></i>Email: <a href="mailto:support@richtv.io">support@richtv.io</a></li>
              <li><i class="bi bi-telephone me-2"></i>Phone: +1 778-237-2402</li>
              <li><i class="bi bi-geo-alt-fill me-2"></i>Mail: 438 Seymour St, Vancouver, B.C, V6B6H4</li>
            </ul>
          </section>
        </div>
      </div>
    </div>
  </div>

  <!-- Skeleton Loader -->
  <div class="container my-5" v-else>
    <div class="row">
      <div class="col-lg-3 mb-4">
        <div class="skeleton skeleton-nav"></div>
      </div>
      <div class="col-lg-9">
        <div class="skeleton skeleton-heading"></div>
        <div class="skeleton skeleton-paragraph"></div>
        <div class="skeleton skeleton-paragraph"></div>
        <div class="skeleton skeleton-list"></div>
      </div>
    </div>
  </div>
</template>

<script>
import { ref, onMounted, onBeforeUnmount, nextTick } from 'vue';

export default {
  name: 'PrivacyPolicy',
  setup() {
    const loading = ref(true);
    const activeLink = ref('#introduction');
    let scrollHandler = null;

    onMounted(() => {
      // Simulate content loading
      setTimeout(() => {
        loading.value = false;

        // Wait for main content to render, then wire up scroll tracking
        nextTick(() => {
          const sections = Array.from(
            document.querySelectorAll('.anchor-section[id]')
          );
          if (!sections.length) return;

          const handleScroll = () => {
            const offset = 180;
            let bestSection = null;
            let bestTop = -Infinity;

            sections.forEach((section) => {
              const rect = section.getBoundingClientRect();
              if (rect.top <= offset && rect.top > bestTop) {
                bestTop = rect.top;
                bestSection = section;
              }
            });

            if (bestSection && bestSection.id) {
              const href = `#${bestSection.id}`;
              if (activeLink.value !== href) {
                activeLink.value = href;
              }
            }
          };

          scrollHandler = handleScroll;
          window.addEventListener('scroll', scrollHandler, { passive: true });
          handleScroll();
        });
      }, 1000); // Adjust the timeout as needed
    });

    onBeforeUnmount(() => {
      if (scrollHandler) {
        window.removeEventListener('scroll', scrollHandler);
      }
    });

    const setActiveLink = (href) => {
      activeLink.value = href;
    };

    return {
      loading,
      activeLink,
      setActiveLink,
    };
  },
};
</script>

<style scoped>
.anchor-section {
  scroll-margin-top: 180px;
}

@media (max-width: 768px) {
  /* Reduce large top margin from Bootstrap's my-5 on small screens */
  .container.my-5 {
    margin-top: 0.1rem !important;
  }
}

#privacyTableOfContents .nav-link.active-link {
  color: #0056b3;
  font-weight: 600;
}

.list-group-item strong {
  display: block;
  margin-bottom: 0.5rem;
}

/* Custom Skeleton Styles */
.skeleton {
  background-color: #e2e2e2;
  border-radius: 4px;
  margin-bottom: 1rem;
  position: relative;
  overflow: hidden;
}

.skeleton::after {
  content: '';
  position: absolute;
  top: 0;
  left: -150px;
  height: 100%;
  width: 150px;
  background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.4), transparent);
  animation: loading 1.5s infinite;
}

@keyframes loading {
  0% {
    left: -150px;
  }
  50% {
    left: 100%;
  }
  100% {
    left: 100%;
  }
}

.skeleton-nav {
  height: 200px;
}

.skeleton-heading {
  width: 60%;
  height: 40px;
  margin: 0 auto 20px;
}

.skeleton-paragraph {
  width: 100%;
  height: 20px;
}

.skeleton-list {
  width: 80%;
  height: 20px;
}

#privacyTableOfContents {
  position: sticky;
  top: 100px;
}

#privacyTableOfContents ul.nav-link {
  cursor: pointer;
}

#privacyTableOfContents ul.nav-link.active {
  color: #0d6efd;
  font-weight: bold;
}

@media (max-width: 991.99px) {
  #privacyTableOfContents {
    display: none;
  }
}
</style>
