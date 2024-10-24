<template>
  <div class="container my-5">
    <!-- Custom Skeleton Loader -->
    <div v-if="isLoading" class="skeleton-loader-container">
      <div class="skeleton-loader">
        <div class="skeleton skeleton-heading"></div>
        <div class="skeleton skeleton-text"></div>
        <div class="skeleton skeleton-button"></div>
        <div class="skeleton skeleton-video"></div>
        <div class="skeleton skeleton-image"></div>
        <div class="skeleton skeleton-text"></div>
        <div class="skeleton skeleton-benefits"></div>
        <div class="skeleton skeleton-faq"></div>
      </div>
    </div>

    <!-- Main Content -->
    <div v-else>
      <!-- Main Heading Section -->
      <section class="text-center mb-5">
        <h1 class="display-4">Why Choose Rich TV?</h1>
        <div class="border-heading my-3"></div>
        <p class="lead">
          Rich TV is the traders’ favorite community for help, support, and guidance on investing smartly in stock and crypto markets. With an enormous pool of educational resources, penny stocks with huge upside, round-the-clock market data, latest news, in-depth analysis and insights, and tools that facilitate efficient trading, Rich TV remains a 360-degree platform for investors looking to grow their wealth significantly.
        </p>
        <router-link to="/register" class="btn btn-primary btn-lg mt-3" aria-label="Get Started Today">
          <i class="bi bi-people-fill me-2"></i> Get Started Today
        </router-link>
      </section>

      <!-- Video Section -->
      <section class="video-section mb-5">
        <div class="ratio ratio-16x9">
          <iframe
            :src="isVideoPlaying ? videoUrl + '?autoplay=1' : videoUrl"
            title="Rich TV Intro Video"
            frameborder="0"
            allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture"
            allowfullscreen
            @click="toggleVideo"
            @keydown.enter.space.prevent="toggleVideo"
            tabindex="0"
            role="button"
            aria-label="Play Video"
          ></iframe>
        </div>
      </section>

      <!-- Our Story Section -->
      <section class="our-story-section bg-offwhite py-5 shadow-custom">
        <div class="text-center mb-4">
          <h2 class="story-heading">Our Story</h2>
          <div class="border-heading mx-auto"></div>
        </div>
        <div class="row align-items-center">
          <div class="col-md-6 mb-4">
            <img
              src="https://s3.wasabisys.com/rpdapp1/upload/photos/2023/img/our-story-img.webp"
              alt="Our Story"
              class="img-fluid rounded shadow"
              loading="lazy"
            />
          </div>
          <div class="col-md-6 story-text">
            <p>
              Founded in 2016 by Richard De Sousa, a seasoned stock trader with years of investing experience, Rich TV has been equipping traders of different abilities and backgrounds with all the essential elements for making informed decisions throughout their trading journey.
            </p>
            <p>
              The platform mirrors the focused vision, steady investing strategy, and commitment to success that has enabled Richard to become a leading stock trader with unsurpassed service. Since the very beginning, Rich TV has been helping members in the most fruitful manner possible through new methods of thinking, modern technological tools, and innovative approaches to identifying the best trading opportunities.
            </p>
            <p class="mb-0">
              What started out as a small group of investors has today grown into a full-blown community where members benefit hugely from Richard’s experience and support one another to achieve collective success. With a growing footprint across social media and a remarkable online presence, Rich TV is the modern-day trader’s go-to source for all things investing—be it in stocks or cryptocurrencies.
            </p>
          </div>
        </div>
      </section>

      <!-- Benefits Section -->
      <section class="benefits-section py-5">
        <div class="text-center mb-4">
          <h2>Perks You Can Enjoy as a Member</h2>
          <div class="border-heading mx-auto"></div>
          <p class="lead">
            Our aim is to make a positive difference to the way you trade. For this purpose, we’ve got a wide range of benefits for you to avail, such as the ones stated below.
          </p>
          <router-link to="/register" class="btn btn-primary btn-lg mt-3" aria-label="Get Started Today">
            <i class="bi bi-people-fill me-2"></i> Get Started Today
          </router-link>
        </div>
        <div class="row">
          <div
            class="col-md-6 mb-4 benefit-item"
            v-for="benefit in benefits"
            :key="benefit.id"
            tabindex="0"
            @keydown.enter.space.prevent="() => {}"
          >
            <div class="d-flex align-items-start">
              <div class="me-3">
                <i :class="benefit.icon" aria-hidden="true"></i>
              </div>
              <div>
                <p class="mb-0">{{ benefit.text }}</p>
              </div>
            </div>
          </div>
        </div>
      </section>

      <!-- FAQ Section -->
      <section class="faq-section py-5 bg-light">
        <div class="text-center mb-4">
          <h2>Frequently Asked Questions</h2>
          <div class="border-heading mx-auto"></div>
        </div>
        <div class="accordion" id="faqAccordion">
          <div
            class="accordion-item"
            v-for="faq in faqs"
            :key="faq.id"
          >
            <h2 class="accordion-header" :id="'heading' + faq.id">
              <button
                class="accordion-button"
                :class="{ collapsed: activeFaq !== faq.id }"
                type="button"
                @click="toggleFaq(faq.id)"
                aria-expanded="activeFaq === faq.id"
                :aria-controls="'collapse' + faq.id"
              >
                {{ faq.question }}
              </button>
            </h2>
            <div
              :id="'collapse' + faq.id"
              class="accordion-collapse collapse"
              :class="{ show: activeFaq === faq.id }"
              :aria-labelledby="'heading' + faq.id"
            >
              <div class="accordion-body">
                {{ faq.answer }}
              </div>
            </div>
          </div>
        </div>
      </section>
    </div>
  </div>
</template>

<script>
import { ref, onMounted, onUnmounted } from 'vue';

export default {
  name: 'AboutPage',
  setup() {
    const isLoading = ref(true);
    const benefits = ref([
      { id: 1, text: 'Stay on top of the biggest penny stocks to have in your portfolio.', icon: 'bi bi-currency-dollar' },
      { id: 2, text: 'Educate yourself on how to trade stocks & crypto through books, videos and more.', icon: 'bi bi-book' },
      { id: 3, text: 'Attend live video sessions and see how pros trade in real-time.', icon: 'bi bi-camera-video' },
      { id: 4, text: 'Get the latest market data, news and analysis along with crucial email alerts.', icon: 'bi bi-newspaper' },
      { id: 5, text: 'Interact with experienced traders and get their feedback on investing ideas you may have in mind.', icon: 'bi bi-people' },
      { id: 6, text: 'Keep track of the major economic events that are about to unfold.', icon: 'bi bi-calendar-event' },
      { id: 7, text: 'Maintain a watchlist of stocks that are of interest to you.', icon: 'bi bi-list-task' },
      { id: 8, text: 'Approach Richard for one-to-one guidance on anything you seek clarity on.', icon: 'bi bi-person-lines-fill' },
    ]);

    const faqs = ref([
      {
        id: 1,
        question: 'What benefits do I get as a member?',
        answer:
          'With the monthly membership you get access to all of our private trading chats, educational resources on the website, one-on-one training if needed and Zoom training on Mondays and Thursdays at 8:00 pm PST every week.',
      },
      {
        id: 2,
        question: 'Do I have to sign a contract to become a member?',
        answer: 'No. You are charged for the membership on a month-to-month basis.',
      },
      {
        id: 3,
        question: 'Is this a scam?',
        answer:
          'No, this is a trading community where people share trade ideas as a group so that they can find good opportunities in the markets.',
      },
      {
        id: 4,
        question: 'How many stocks do you cover a week?',
        answer:
          'We cover multiple companies per day so that the community has access to a lot of information to be able to make an informed decision.',
      },
      {
        id: 5,
        question: 'Is there a membership cancellation fee?',
        answer:
          'There is no cancellation fee. You only pay the membership fee and then if you decide to cancel your membership, it ends upon completion of your membership period.',
      },
      {
        id: 6,
        question: 'Can I avail a one-week trial before buying my membership?',
        answer:
          'Please contact support and we will see if that’s possible. For starters, you can sign-up for FREE membership to get a feel of the basic features that our trading club has to offer. For advanced features, you can always sign-up for our monthly paid plan and then cancel if you don’t like the service. Once charged, you won’t be entitled to any refunds though.',
      },
    ]);

    const activeFaq = ref(null);

    const toggleFaq = (id) => {
      activeFaq.value = activeFaq.value === id ? null : id;
    };

    const isVideoPlaying = ref(false);
    const videoUrl = 'https://www.youtube.com/embed/1T-CXWWsFVM';

    const toggleVideo = () => {
      isVideoPlaying.value = !isVideoPlaying.value;
    };

    // Scroll-based animations using Intersection Observer
    const onScroll = () => {
      const elements = document.querySelectorAll('.benefit-item, .accordion-item, .our-story-section');
      elements.forEach((el) => {
        const rect = el.getBoundingClientRect();
        if (rect.top < window.innerHeight - 100) {
          el.classList.add('animate');
        }
      });
    };

    onMounted(() => {
      // Simulate data loading
      setTimeout(() => {
        isLoading.value = false;
      }, 1500);

      // Initialize scroll animations
      window.addEventListener('scroll', onScroll);
      onScroll(); // Trigger on mount
    });

    // Cleanup
    onUnmounted(() => {
      window.removeEventListener('scroll', onScroll);
    });

    return {
      benefits,
      faqs,
      isLoading,
      activeFaq,
      toggleFaq,
      isVideoPlaying,
      videoUrl,
      toggleVideo,
    };
  },
};
</script>

<style scoped>
/* General Styles */
.border-heading {
  width: 60px;
  height: 4px;
  background-color: #EDB043;
  margin: 0 auto;
}

.btn-primary {
  background: linear-gradient(45deg, #EDB043, #d4a133);
  border: none;
  border-radius: 25px;
  transition: background 0.3s ease, transform 0.3s ease;
}

.btn-primary:hover {
  background: linear-gradient(45deg, #d4a133, #c0952a);
  transform: translateY(-2px);
}

.btn-primary:focus {
  outline: none;
  box-shadow: 0 0 0 3px rgba(237, 176, 67, 0.5);
}

/* Video Section */
.video-section iframe {
  border-radius: 10px;
  transition: transform 0.3s ease;
}

.video-section iframe:hover {
  transform: scale(1.02);
}

/* Our Story Section */
.our-story-section {
  background-color: #f9f9f9; /* Off-white background */
  padding: 60px 30px;
  position: relative;
  overflow: hidden;
  border-radius: 10px;
}

.our-story-section::before {
  content: '';
  position: absolute;
  top: 0;
  left: -20px;
  width: 40px;
  height: 100%;
  box-shadow: 10px 0 20px rgba(0, 0, 0, 0.1);
  pointer-events: none;
}

.story-heading {
  font-size: 2.5rem;
  animation: fadeInUp 1s ease forwards;
}

.story-text p {
  font-size: 1.3rem;
  line-height: 1.6;
  animation: fadeInUp 1s ease forwards;
  animation-delay: 0.3s;
}

.shadow-custom {
  box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
}

/* Animations */
@keyframes fadeInUp {
  from {
    opacity: 0;
    transform: translateY(20px);
  }
  to {
    opacity: 1;
    transform: translateY(0);
  }
}

.animate {
  opacity: 1;
  transform: translateY(0);
  transition: opacity 0.6s ease, transform 0.6s ease;
}

/* Benefits Section Icons */
.benefit-item i {
  font-size: 1.8rem;
  color: #EDB043;
  transition: transform 0.3s ease, color 0.3s ease;
}

.benefit-item:hover i,
.benefit-item:focus i {
  transform: scale(1.3);
  color: #d4a133; /* Darker shade on hover */
}

.benefit-item {
  cursor: pointer;
  transition: background-color 0.3s ease;
}

.benefit-item:hover,
.benefit-item:focus {
  background-color: #fff3cd;
  border-radius: 8px;
  outline: none;
}

/* Accordion Styles */
.accordion-button {
  transition: background-color 0.3s ease, color 0.3s ease;
}

.accordion-button.collapsed {
  background-color: #f8f9fa;
}

.accordion-button:not(.collapsed) {
  background-color: #EDB043;
  color: #fff;
}

.accordion-button:focus {
  box-shadow: none;
}

/* Skeleton Loader */
.skeleton-loader-container {
  display: flex;
  justify-content: center;
  align-items: center;
  min-height: 500px; /* Adjust based on container size */
}

.skeleton-loader {
  width: 100%;
  max-width: 1200px;
}

.skeleton {
  background-color: #e2e2e2;
  border-radius: 4px;
  margin: 10px 0;
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
  background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.6), transparent);
  animation: shimmer 1.5s infinite;
}

@keyframes shimmer {
  100% {
    left: 100%;
  }
}

.skeleton-heading {
  width: 60%;
  height: 40px;
}

.skeleton-text {
  width: 80%;
  height: 20px;
}

.skeleton-button {
  width: 30%;
  height: 40px;
  border-radius: 20px;
}

.skeleton-video {
  width: 100%;
  height: 300px;
}

.skeleton-image {
  width: 100%;
  height: 200px;
}

.skeleton-benefits {
  width: 100%;
  height: 150px;
}

.skeleton-faq {
  width: 100%;
  height: 300px;
}

/* Responsive Adjustments */
@media (max-width: 767px) {
  .our-story-section {
    padding: 40px 20px;
  }

  .story-heading {
    font-size: 2rem;
  }

  .story-text p {
    font-size: 1rem;
  }
}
</style>
