<template>
  <div>
    <!-- Header Section -->
    <section class="container-fluid my-4">
      <div class="container">
        <div class="education-wrapper bg-white px-5 py-4 mt-4 border rounded-2 shadow-sm">
          <div class="text-center">
            <h1 class="fw-bold fs-1 text-uppercase">TRADING EDUCATION</h1>
            <div class="border-heading d-inline-block mt-4 mb-3"></div>
            <p>
              Enhance your trading knowledge with our extensive collection of E-books, Videos, and Courses.
            </p>
          </div>
        </div>
      </div>
    </section>

    <!-- E-books Section (Always Displayed) -->
    <section class="trading-books container-fluid mb-4">
      <div class="container">
        <TradingBooks :ebooks="ebooks" :is-authenticated="isAuthenticated" />
      </div>
    </section>

    <!-- Videos Section -->
    <section class="container-fluid position-relative mb-4">
      <div class="container">
        <div class="trading-videos-wrapper bg-white px-sm-4 py-4 border rounded-2 shadow-sm">
          <div class="text-center">
            <h1 class="fw-bold fs-1 text-uppercase">
              TRADING VIDEOS <span class="videos-count fs-12 fw-light">({{ videos.length }})</span>
            </h1>
            <div class="border-heading d-inline-block mt-4 mb-3"></div>
          </div>

          <!-- Content or Messages -->
          <div>
            <!-- If user can view videos -->
            <div v-if="canViewContent && hasEducationalContent" class="row gy-5">
              <div
                class="col-lg-4 col-md-6"
                v-for="(video, index) in displayedVideos"
                :key="video.id"
              >
                <div class="video-card h-100 cursor-pointer" @click="openVideo(video)">
                  <div class="featured-video-1 m-auto bg-white card-hover pb-2 h-100">
                    <div class="video-featured position-relative">
                      <div class="video-play-icon-small position-absolute top-50 start-50 translate-middle">
                        <img src="/build/images/play-icon.png" alt="Play Button" />
                      </div>
                      <img
                        :src="video.thumbnail_url"
                        alt="Video Thumbnail"
                        class="thumbnail-card w-100"
                      />
                    </div>
                    <div class="video-bio px-2 pt-2">
                      <div class="article-author d-flex justify-content-between pb-3">
                        <div class="by-name">
                          <i><span>{{ video.channel_title }}</span></i>
                        </div>
                        <div class="d-flex">
                          <span>{{ formatDate(video.published_at) }}</span>
                        </div>
                      </div>
                      <h3 class="fs-18 fw-bolder">{{ video.title }}</h3>
                    </div>
                  </div>
                </div>
              </div>
            </div>

            <!-- If user is authenticated but cannot view videos -->
            <div v-else-if="isAuthenticated" class="access-restricted-message text-center py-5">
              <i class="bi bi-video-fill fs-3 mb-3 text-danger"></i>
              <h2>You Do Not Have Permissions to View Trading Videos</h2>
              <p>
                Please
                <a href="#" @click.prevent="upgradePlan">Upgrade Your Plan</a>
                to access trading videos.
              </p>
            </div>

            <!-- If user is not authenticated -->
            <div v-else class="login-required-message text-center py-5">
              <i class="bi bi-lock-fill fs-3 mb-3 text-primary"></i>
              <h2>Login Required to View Trading Videos</h2>
              <p>
                You need to
                <button class="btn btn-link p-0" @click="showLogin">
                  <strong>Login</strong>
                </button>
                to view trading videos.
              </p>
            </div>
          </div>

          <!-- View More Videos Button -->
          <div class="text-center my-5" v-if="canViewContent && hasEducationalContent && displayedVideos.length < videos.length">
            <button class="btn btn-primary" @click="loadMore">VIEW MORE</button>
          </div>
        </div>
      </div>
    </section>

    <!-- Courses Section -->
    <section class="container-fluid position-relative mb-4">
      <div class="container">
        <div class="trading-courses-wrapper bg-white px-sm-4 py-4 border rounded-2 shadow-sm">
          <div class="text-center">
            <h1 class="fw-bold fs-1 text-uppercase">
              TRADING COURSES <span class="courses-count fs-12 fw-light">({{ courses.length }})</span>
            </h1>
            <div class="border-heading d-inline-block mt-4 mb-3"></div>
          </div>

          <!-- Content or Messages -->
          <div>
            <!-- If user can view courses -->
            <div v-if="canViewContent" class="row gy-5">
              <div
                class="col-lg-4 col-md-6"
                v-for="(course, index) in displayedCourses"
                :key="course.id"
              >
                <div class="course-card h-100 cursor-pointer" @click="openCourse(course)">
                  <div class="featured-course-1 m-auto bg-white card-hover pb-2 h-100">
                    <div class="course-featured position-relative">
                      <img
                        :src="course.icon_url"
                        alt="Course Icon"
                        class="thumbnail-card w-100"
                        v-if="course.icon_path"
                      />
                      <div v-else class="thumbnail-placeholder w-100 d-flex justify-content-center align-items-center">
                        <span>No Image</span>
                      </div>
                    </div>
                    <div class="course-bio px-2 pt-2">
                      <div class="course-author d-flex justify-content-between pb-3">
                        <div class="by-name">
                          <i><span>RichTv</span></i>
                        </div>
                        <div class="d-flex">
                          <span><!-- Additional Info --></span>
                        </div>
                      </div>
                      <h3 class="fs-18 fw-bolder">{{ course.title }}</h3>
                      <p class="course-description">{{ course.description }}</p>
                      <div class="mt-3">
                        <button class="btn btn-primary" @click="embedCourse(course)">View Course</button>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>

            <!-- If user is authenticated but cannot view courses -->
            <div v-else-if="isAuthenticated" class="access-restricted-message text-center py-5">
              <i class="bi bi-book-fill fs-3 mb-3 text-danger"></i>
              <h2>You Do Not Have Permissions to View Trading Courses</h2>
              <p>
                Please
                <a href="#" @click.prevent="upgradePlan">Upgrade Your Plan</a>
                to access trading courses.
              </p>
            </div>

            <!-- If user is not authenticated -->
            <div v-else class="login-required-message text-center py-5">
              <i class="bi bi-lock-fill fs-3 mb-3 text-primary"></i>
              <h2>Login Required to View Trading Courses</h2>
              <p>
                You need to
                <button class="btn btn-link p-0" @click="showLogin">
                  <strong>Login</strong>
                </button>
                to view trading courses.
              </p>
            </div>
          </div>

          <!-- View More Courses Button -->
          <div class="text-center my-5" v-if="canViewContent && hasExclusiveMarketIntelligence && displayedCourses.length < courses.length">
            <button class="btn btn-primary" @click="loadMoreCourses">VIEW MORE</button>
          </div>
        </div>
      </div>
    </section>

    <!-- Risk Disclaimer Section (Remains Unchanged) -->
    <section class="pre-footer container-fluid py-80 bg-smoke">
      <div class="container pb-120">
        <div class="row">
          <div class="col-12">
            <div class="risk-disclaimer p-4">
              <div class="risk-heading">
                <div class="disclaimer-icon-name d-flex align-items-end mb-4 gap-3">
                  <div>
                    <img
                      src="https://s3.wasabisys.com/rpdapp1/upload/photos/2023/img/alert-icon.png"
                      alt="Risk Icon"
                    />
                  </div>
                  <div>
                    <h2 class="fw-bolder fs-1 mb-0">Risk Disclaimer</h2>
                  </div>
                </div>
                <div>
                  <div class="risk-para">
                    <p class="margin-24 fs-18 lh-base">
                      Rich TV's company profiles and other investor relations materials, publications or presentations,
                      including web content, are based on data obtained from sources we believe to be reliable but
                      are not guaranteed as to be accuracy and are not purported to be complete. As such, the information
                      should not be construed as advice designed to meet the particular investment needs of any investor.
                      Any opinions expressed in Rich TV reports, company profiles, or other investor relations materials
                      and presentations are subject to change. Rich TV and its affiliates may buy and sell shares of
                      securities or options of the issuers mentioned on this website at any time.
                    </p>
                  </div>
                  <div class="slide-up-down">
                    <p>
                      Stock market investing is inherently risky. Rich TV is not responsible for any gains or losses
                      that result from the opinions expressed on this website, in its research reports, company profiles,
                      or in other investor relations materials or presentations that it publishes electronically or in
                      print. We strongly encourage all investors to conduct their own research before making any investment
                      decision. For more information on stock market investing, visit the Securities and Exchange Commission
                      ("SEC") at www.sec.gov.
                    </p>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </section>

    <!-- Video Modal -->
    <div
      class="modal fade"
      id="videoModal"
      tabindex="-1"
      aria-labelledby="videoModalLabel"
      aria-hidden="true"
      ref="videoModal"
    >
      <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="videoModalLabel">{{ iframeData?.title }}</h5>
            <button type="button" class="btn-close" @click="closeVideo" aria-label="Close"></button>
          </div>
          <div class="modal-body p-0">
            <div class="ratio ratio-16x9">
              <iframe
                v-if="iframeData"
                :src="'https://www.youtube.com/embed/' + iframeData.youtube_id"
                title="YouTube video player"
                allowfullscreen
                referrerpolicy="strict-origin-when-cross-origin"
              ></iframe>
            </div>
          </div>
        </div>
      </div>
    </div>

    <!-- Course Embed Modal -->
    <div
      class="modal fade"
      id="courseModal"
      tabindex="-1"
      aria-labelledby="courseModalLabel"
      aria-hidden="true"
      ref="courseModal"
    >
      <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="courseModalLabel">{{ selectedCourse?.title }}</h5>
            <button type="button" class="btn-close" @click="closeCourseEmbed" aria-label="Close"></button>
          </div>
          <div class="modal-body p-0">
            <div class="ratio ratio-16x9">
              <iframe
                v-if="selectedCourse"
                :src="selectedCourse.drive_link"
                title="Course Content"
                allowfullscreen
                referrerpolicy="no-referrer-when-downgrade"
              ></iframe>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import TradingBooks from './TradingBooks.vue';
import axios from 'axios';
import Swal from 'sweetalert2';
import { mapActions } from 'vuex';
import { isLoggedIn } from '@/stores';
import { Modal } from 'bootstrap';

export default {
  components: {
    TradingBooks,
  },
  data() {
    return {
      isAuthenticated: false,
      hasExclusiveMarketIntelligence: false,
      hasEducationalContent: false,
      ebooks: [],
      videos: [],
      courses: [],
      displayedVideos: [],
      displayedCourses: [],
      iframeData: null,
      selectedCourse: null,
      videoModalInstance: null,
      courseModalInstance: null,
      videosPerPage: 9,
      coursesPerPage: 6,
      currentVideoPage: 2,
      currentCoursePage: 2,
    };
  },
  computed: {
    canViewContent() {
      return this.hasExclusiveMarketIntelligence || this.hasEducationalContent;
    },
  },
  methods: {
    ...mapActions(['showLoginPopup', 'upgradePlan']),

    async fetchSubscriptionStatus() {
      try {
        const response = await axios.get('/api/subscriptionStatus');
        const data = response.data;
        this.isAuthenticated = data.authenticated;
        this.hasExclusiveMarketIntelligence =
          data.features['exclusive_market_intelligence']?.can_access || false;
        this.hasEducationalContent =
          data.features['educational_content']?.can_access || false;
      } catch (error) {
        console.error('Error fetching subscription status:', error);
        this.isAuthenticated = false;
      }
    },
    async fetchEbooks() {
      try {
        const response = await axios.get('/api/ebooks');
        this.ebooks = response.data;
      } catch (error) {
        console.error('Error fetching E-books:', error);
      }
    },
    async fetchVideos(playlist_id) {
      try {
        const response = await axios.get('/api/videos', {
          params: {
            playlist_id: playlist_id,
          },
        });
        this.videos = response.data.videos;
        this.displayedVideos = this.videos.slice(0, this.videosPerPage);
      } catch (error) {
        console.error('Error fetching videos:', error);
        // Handle error as needed
      }
    },
    async fetchCourses() {
      try {
        const response = await axios.get('/api/courses');
        this.courses = response.data;
        this.displayedCourses = this.courses.slice(0, this.coursesPerPage);
      } catch (error) {
        console.error('Error fetching courses:', error);
        // Handle error as needed
      }
    },
    formatDate(isoDate) {
      const date = new Date(isoDate);
      const months = [
        'Jan',
        'Feb',
        'Mar',
        'Apr',
        'May',
        'Jun',
        'Jul',
        'Aug',
        'Sep',
        'Oct',
        'Nov',
        'Dec',
      ];
      const month = months[date.getMonth()];
      const day = date.getDate();
      const year = date.getFullYear();
      return `${month} ${day}, ${year}`;
    },
    openVideo(video) {
      this.iframeData = video;
      this.videoModalInstance.show();
    },
    closeVideo() {
      this.iframeData = null;
      this.videoModalInstance.hide();
    },
    loadMore() {
      const startIndex = (this.currentVideoPage - 1) * this.videosPerPage;
      const endIndex = startIndex + this.videosPerPage;
      this.displayedVideos = this.videos.slice(0, endIndex);
      this.currentVideoPage++;
    },
    openCourse(course) {
      this.selectedCourse = course;
      this.courseModalInstance.show();
    },
    closeCourseEmbed() {
      this.selectedCourse = null;
      this.courseModalInstance.hide();
    },
    loadMoreCourses() {
      const startIndex = (this.currentCoursePage - 1) * this.coursesPerPage;
      const endIndex = startIndex + this.coursesPerPage;
      this.displayedCourses = this.courses.slice(0, endIndex);
      this.currentCoursePage++;
    },
    showLogin() {
      this.showLoginPopup();
    },
    upgradePlan() {
      this.$router.push('/pricing');
    },
    embedCourse(course) {
      // Open the course in the modal
      this.openCourse(course);
    },
  },
  mounted() {
    // Initialize modal instances with enhanced options
    this.videoModalInstance = new Modal(this.$refs.videoModal, {
      backdrop: true,
      keyboard: true,
    });
    this.courseModalInstance = new Modal(this.$refs.courseModal, {
      backdrop: true,
      keyboard: true,
    });

    // Fetch data
    this.fetchEbooks();
    if (isLoggedIn()) {
      this.fetchSubscriptionStatus().then(() => {
        if (this.canViewContent) {
          this.fetchVideos('PLSr6qDstKBtkEd9zsFFxWPDUlkjU1KR3H');
          this.fetchCourses();
        }
      });
    }
  },
};
</script>

<style scoped>
/* General Styles */
.container {
  max-width: 1200px;
  margin: 0 auto;
}

/* Access Restricted Messages */
.access-restricted-message,
.login-required-message {
  color: #555;
}

.access-restricted-message i,
.login-required-message i {
  font-size: 2rem;
}

.access-restricted-message h2,
.login-required-message h2 {
  margin-bottom: 1rem;
}

.access-restricted-message p,
.login-required-message p {
  font-size: 1.1rem;
}

.access-restricted-message a,
.login-required-message button {
  color: #007bff;
  text-decoration: none;
}

.access-restricted-message a:hover,
.login-required-message button:hover {
  text-decoration: underline;
}

/* Icons Styling */
.text-danger {
  color: #dc3545 !important;
}

.text-primary {
  color: #007bff !important;
}

/* Responsive Adjustments */
@media (max-width: 767px) {
  .education-wrapper h1 {
    font-size: 1.5rem;
  }
  /* Adjust other elements as needed */
}

/* Modal Overrides */
.modal-content {
  background-color: #f8f9fa;
  border: none;
  border-radius: 10px;
}

.modal-header {
  border-bottom: 1px solid #dee2e6;
  padding: 1.5rem;
}

.modal-title {
  font-size: 1.5rem;
}

.btn-close {
  border: none;
  font-size: 1rem;
  padding: 0;
  margin: -0.5rem -0.5rem -0.5rem auto;
}

/* Thumbnail Styles */
.thumbnail-card {
  border-radius: 5px;
}

.video-play-icon-small img {
  width: 40px;
  height: 40px;
}

.video-featured {
  position: relative;
  overflow: hidden;
  border-radius: 5px;
}

.video-featured img {
  transition: transform 0.3s ease;
}

.video-featured:hover img {
  transform: scale(1.05);
}

/* Course Description */
.course-description {
  font-size: 0.9rem;
  color: #666;
  height: 60px;
  overflow: hidden;
  text-overflow: ellipsis;
}

/* Thumbnail Placeholder */
.thumbnail-placeholder {
  background-color: #e9ecef;
  height: 200px;
  color: #6c757d;
  font-size: 1rem;
}

/* View More Button */
.btn-primary {
  background-color: #007bff;
  border-color: #007bff;
}

.btn-primary:hover {
  background-color: #0056b3;
  border-color: #0056b3;
}

/* Iframe Responsiveness */
.ratio {
  position: relative;
  width: 100%;
  padding-bottom: 56.25%; /* 16:9 Aspect Ratio */
  height: 0;
}

.ratio iframe {
  position: absolute;
  top: 0;
  left: 0;
  width: 100%;
  height: 100%;
  border: 0;
}

/* Spacing Adjustments */
.education-wrapper {
  padding: 2rem 1.5rem;
}

.trading-videos-wrapper,
.trading-courses-wrapper {
  padding: 2rem 1.5rem;
}

.risk-disclaimer {
  background-color: #fff;
  padding: 2rem;
  border-radius: 10px;
}

.risk-heading h2 {
  font-size: 2rem;
}

.risk-para p {
  margin-bottom: 1.5rem;
}

/* Enhanced Close Button Positioning */
.modal-header .btn-close {
  position: absolute;
  top: 1rem;
  right: 1rem;
}
</style>
