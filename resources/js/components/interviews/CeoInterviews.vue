<template>
  <div class="container my-4 position-relative">
    <!-- Heading Section -->
    <div class="text-center">
      <h1 class="fw-bold fs-1 text-uppercase">CEO Interviews</h1>
      <div class="border-heading d-inline-block mt-4 mb-5"></div>
    </div>

    <!-- Video Grid or Skeleton Loader -->
    <div class="row gy-5">
      <div
        class="col-lg-4 col-md-6"
        v-for="(video, index) in displayedVideos"
        :key="video.id"
      >
        <div
          class="video-card h-100 cursor-pointer"
          @click="openVideo(video)"
          data-bs-toggle="tooltip"
          :data-bs-title="video.title"
        >
          <div class="featured-video-1 m-auto bg-white card-hover pb-2 h-100">
            <div class="video-featured position-relative">
              <!-- Play Icon using Bootstrap Icon -->
              <div class="video-play-icon-small position-absolute">
                <i class="bi bi-play-circle-fill text-white fs-1"></i>
              </div>
              <!-- Video Thumbnail -->
              <img
                :src="video.thumbnail"
                :alt="video.title"
                class="thumbnail-card w-100"
              />
            </div>
            <div class="video-bio px-2 pt-2">
              <div class="artical-au d-flex justify-content-between pb-3">
                <div class="by-name">
                  <i>{{ video.channelTitle }}</i>
                </div>
                <div class="d-flex">
                  <span>{{ formatDate(video.publishedAt) }}</span>
                </div>
              </div>
              <h3 class="fs-18 fw-bolder">{{ video.title }}</h3>
            </div>
          </div>
        </div>
      </div>

      <!-- Skeleton Loader -->
      <div
        class="col-lg-4 col-md-6"
        v-if="loading"
        v-for="n in skeletonCount"
        :key="'skeleton-' + n"
      >
        <div class="featured-video-1 m-auto bg-white card-hover pb-2 h-100">
          <div class="video-featured position-relative skeleton">
            <div class="video-play-icon-small position-absolute">
              <i class="bi bi-play-circle-fill text-white fs-1"></i>
            </div>
          </div>
          <div class="video-bio px-2 pt-2">
            <div class="artical-au d-flex justify-content-between pb-3">
              <div class="by-name skeleton-text"></div>
              <div class="d-flex skeleton-text"></div>
            </div>
            <div class="skeleton-text h3"></div>
          </div>
        </div>
      </div>
    </div>

    <!-- Modal Overlay -->
    <transition name="fade">
      <div v-if="showIframe" class="modal-overlay" @click.self="closeVideo">
        <div class="modal-content">
          <button class="close-button" @click="closeVideo" aria-label="Close video">
            <i class="bi bi-x-circle-fill fs-3 text-white"></i>
          </button>
          <div class="video-container">
            <iframe
              :src="iframeSrc"
              class="video-iframe"
              allowfullscreen
              ref="videoIframe"
              referrerpolicy="strict-origin-when-cross-origin"
            ></iframe>
          </div>
        </div>
      </div>
    </transition>

    <!-- Load More Button -->
    <div class="text-center my-5" v-if="canLoadMore">
      <button class="btn btn-primary" @click="loadMore">
        <i class="bi bi-arrow-down-circle-fill me-2"></i>VIEW MORE
      </button>
    </div>
  </div>

  <!-- Pre-Footer Section (Unchanged) -->
  <section class="pre-footer container-fluid py-80 bg-smoke">
    <div class="container pb-120">
      <div class="row">
        <div class="col-12">
          <div class="risk-disclaimer p-4">
            <div class="risk-heading">
              <div class="disclaimer-icon-name d-flex align-items-end mb-4 gap-3">
                <div>
                  <img
                    src="/build/images/alert-icon.png"
                    alt="icon"
                  />
                </div>
                <div>
                  <h2 class="fw-bolder fs-1 mb-0">Risk Disclaimer</h2>
                </div>
              </div>
              <div>
                <div class="risk-para">
                  <p class="margin-24 fs-18 lh-base">
                    Rich TV's company profiles and other investor relations materials,
                    publications or presentations, including web content, are based on data
                    obtained from sources we believe to be reliable but are not guaranteed as
                    to accuracy and are not purported to be complete. As such, the information
                    should not be construed as advice designed to meet the particular investment
                    needs of any investor. Any opinions expressed in Rich TV reports, company
                    profiles, or other investor relations materials and presentations are subject
                    to change. Rich TV and its affiliates may buy and sell shares of securities or
                    options of the issuers mentioned on this website at any time.
                  </p>
                </div>
                <div class="slide-up-down">
                  <p class="fs-18 lh-base">
                    Stock market investing is inherently risky. Rich TV is not responsible for any
                    gains or losses that result from the opinions expressed on this website, in its
                    research reports, company profiles or in other investor relations materials or
                    presentations that it publishes electronically or in print. We strongly
                    encourage all investors to conduct their own research before making any
                    investment decision. For more information on stock market investing, visit
                    the Securities and Exchange Commission ("SEC") at www.sec.gov.
                  </p>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div> 
    </div>
  </section>
</template>

<script>
import axios from 'axios';
import { onMounted, ref, watch } from 'vue';

export default {
  data() {
    return {
      videos: [],
      displayedVideos: [],
      showIframe: false,
      iframeData: null,
      videosPerPage: 9,
      currentPage: 1,
      loading: true,
      skeletonCount: 9,
      playlistId: 'PLiBGEhbXkQPAoX8JgMr6D-KeN5ZGmN8ct',
    };
  },
  computed: {
    // Compute whether to show the load more button
    canLoadMore() {
      return this.displayedVideos.length < this.videos.length;
    },
    // Compute the iframe source with autoplay
    iframeSrc() {
      return this.iframeData
        ? `https://www.youtube.com/embed/${this.iframeData.youtube_id}?autoplay=1&rel=0`
        : '';
    },
  },
  methods: {
    async fetchVideos() {
      try {
        const response = await axios.get('/api/videos', {
          params: {
            playlist_id: this.playlistId,
            limit: 50,
          },
        });

        this.videos = response.data.videos.map((item) => ({
          id: item.id, // Ensure this matches your DB structure
          youtube_id: item.youtube_id,
          title: item.title,
          thumbnail: item.thumbnail_url,
          channelTitle: item.channel_title,
          publishedAt: item.published_at,
        }));

        // Initialize displayed videos
        this.displayedVideos = this.videos.slice(0, this.videosPerPage);

        this.loading = false;

        // Initialize Bootstrap tooltips
        this.$nextTick(() => {
          const tooltipTriggerList = [].slice.call(
            document.querySelectorAll('[data-bs-toggle="tooltip"]')
          );
          tooltipTriggerList.map(function (tooltipTriggerEl) {
            return new bootstrap.Tooltip(tooltipTriggerEl);
          });
        });
      } catch (error) {
        console.error('Error fetching videos:', error);
        this.loading = false;
      }
    },
    formatDate(isoDate) {
      const date = new Date(isoDate);
      const options = {
        year: 'numeric',
        month: 'short',
        day: 'numeric',
      };
      return date.toLocaleDateString('en-US', options);
    },
    openVideo(video) {
      this.iframeData = video;
      this.showIframe = true;
      // Add event listener for Esc key
      document.addEventListener('keydown', this.handleEsc);
    },
    closeVideo() {
      this.showIframe = false;
      this.iframeData = null;
      // Remove event listener for Esc key
      document.removeEventListener('keydown', this.handleEsc);
      // Stop the video by resetting the iframe src
      this.$refs.videoIframe.src = '';
    },
    handleEsc(event) {
      if (event.key === 'Escape') {
        this.closeVideo();
      }
    },
    loadMore() {
      const nextPage = this.currentPage + 1;
      const startIndex = (nextPage - 1) * this.videosPerPage;
      const endIndex = startIndex + this.videosPerPage;
      this.displayedVideos = this.videos.slice(0, endIndex);
      this.currentPage = nextPage;
    },
  },
  mounted() {
    this.fetchVideos();
  },
};
</script>

<style scoped>
/* Skeleton Loader Styles */
.skeleton {
  background-color: #e0e0e0;
  animation: pulse 1.5s infinite;
}

.skeleton-text {
  height: 1em;
  background-color: #e0e0e0;
  border-radius: 4px;
}

@keyframes pulse {
  0% {
    background-color: #e0e0e0;
  }
  50% {
    background-color: #cfcfcf;
  }
  100% {
    background-color: #e0e0e0;
  }
}

/* Modal Overlay Styles */
.modal-overlay {
  position: fixed;
  top: 0;
  left: 0;
  width: 100%;
  height: 100%;
  background-color: rgba(0, 0, 0, 0.8);
  z-index: 1050; /* Higher than other elements */
  display: flex;
  align-items: center;
  justify-content: center;
  padding: 20px;
  box-sizing: border-box;
}

/* Modal Content Styles */
.modal-content {
  position: relative;
  width: 100%;
  max-width: 900px;
  width: 100%;
  background: transparent;
  border: none;
  border-radius: 8px;
  overflow: hidden;
  animation: scaleIn 0.3s ease-out;
}

/* Close Button Styles */
.close-button {
  position: absolute;
  top: 10px;
  right: 10px;
  background: transparent;
  border: none;
  cursor: pointer;
  outline: none;
  z-index: 1;
  color: #ffffff;
}

.close-button:hover {
  color: #ff4d4d;
}

/* Video Container */
.video-container {
  position: relative;
  padding-bottom: 56.25%; /* 16:9 Aspect Ratio */
  height: 0;
  overflow: hidden;
  border-radius: 8px;
  box-shadow: 0 4px 10px rgba(0, 0, 0, 0.3);
}

.video-iframe {
  position: absolute;
  top: 0;
  left: 0;
  width: 100%;
  height: 100%;
  border: none;
}

/* Animations */
@keyframes scaleIn {
  from {
    transform: scale(0.8);
    opacity: 0;
  }
  to {
    transform: scale(1);
    opacity: 1;
  }
}

@keyframes fadeIn {
  from {
    opacity: 0;
  }
  to {
    opacity: 1;
  }
}

.fade-enter-active, .fade-leave-active {
  transition: opacity 0.3s;
}

.fade-enter, .fade-leave-to{
  opacity: 0;
}

/* Hover Effects */
.card-hover {
  transition: transform 0.3s, box-shadow 0.3s;
}

.card-hover:hover {
  transform: translateY(-8px);
  box-shadow: 0 12px 24px rgba(0, 0, 0, 0.2);
}

/* Tooltip Adjustments */
[data-bs-toggle="tooltip"] {
  cursor: pointer;
}

/* Responsive Adjustments */
@media (max-width: 768px) {
  .video-container {
    padding-bottom: 56.25%; /* Maintain 16:9 ratio */
  }

  .close-button {
    top: 10px;
    right: 10px;
    z-index: 1;
    color: #ffffff;
  }
}
</style>
