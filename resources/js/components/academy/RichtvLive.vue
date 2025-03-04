<template>
  <div class="container">
    <!-- Live Stream Section -->
    <div class="live_stream">
      <div class="text-center pt-4">
        <h1 class="fw-bold fs-1 text-uppercase">Live Stream</h1>
        <div class="border-heading d-inline-block mt-3 mb-4"></div>
      </div>
      <div class="richtv-live mt-4 mb-4">
        <!-- Loading Skeleton for Live Stream -->
        <div v-if="loadingLive" class="live-skeleton">
          <div class="skeleton skeleton-iframe"></div>
        </div>

        <!-- Embedded Stream -->
        <div v-else-if="embeddedStream">
          <div class="frame_embeded">
            <iframe
              :src="embeddedStream.src"
              class="w-100 rounded-2 richtvlive-iframe"
              title="Live Stream"
              frameborder="0"
              allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share"
              referrerpolicy="strict-origin-when-cross-origin"
              allowfullscreen
            ></iframe>
          </div>
        </div>

        <!-- No Live Stream Available -->
        <div v-else-if="liveError" class="not_live">
          <p>{{ liveErrorMessage }}</p>
        </div>

        <!-- Not Live at the Moment -->
        <div v-else class="not_live">
          <p>
            We are not live at the moment. Check out our previous live sessions.
          </p>
        </div>
      </div>
    </div>

    <!-- previous live session Section -->
    <div class="latest_videos mt-5 pt-2">
      <div class="my-4 position-relative">
        <div class="text-center">
          <h1 class="fw-bold fs-1 text-uppercase">Previous Live Sessions</h1>
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
                  <!-- Play Icon -->
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

          <!-- Skeleton Loader for Videos -->
          <div
            class="col-lg-4 col-md-6"
            v-if="loadingVideos"
            v-for="n in skeletonCount"
            :key="'skeleton-' + n"
          >
            <div class="featured-video-1 m-auto bg-white card-hover pb-2 h-100">
              <div class="video-featured position-relative skeleton">
                <div class="video-play-icon-small position-absolute">
                  <i class="bi bi-play-circle-fill text-white fs-1"></i>
                </div>
                <div class="skeleton thumbnail-skeleton"></div>
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

        <!-- Video Modal Overlay -->
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
        <div class="text-center my-5" v-if="canLoadMore && !loadingVideos">
          <button class="btn btn-primary" @click="loadMore">
            <i class="bi bi-arrow-down-circle-fill me-2"></i>VIEW MORE
          </button>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import axios from "axios";
import { ref, onMounted, nextTick } from "vue";

export default {
  data() {
    return {
      embeddedStream: null,
      liveError: false,
      liveErrorMessage: "We are not live at the moment. Check out our Live Sessions.",
      loadingLive: true,
      videos: [],
      displayedVideos: [],
      showIframe: false,
      iframeData: null,
      videosPerPage: 9,
      currentPage: 1,
      loadingVideos: true,
      skeletonCount: 9,
      playlistId: "PLiBGEhbXkQPAoX8JgMr6D-KeN5ZGmN8ct",
      apiEndpoint: "/api/videos",
      limit: 50,
    };
  },
  computed: {
    // Determine if more videos can be loaded
    canLoadMore() {
      return this.displayedVideos.length < this.videos.length;
    },
    // Compute iframe source with autoplay
    iframeSrc() {
      return this.iframeData
        ? `https://www.youtube.com/embed/${this.iframeData.youtube_id}?autoplay=1&rel=0`
        : "";
    },
  },
  methods: {
    // Fetch Embedded Stream
    async fetchEmbeddedStream() {
      try {
        const response = await axios.get("/api/richtv-live");
        if (response.data && response.data.embedded_code) {
          this.embeddedStream = {
            title: response.data.title || "Embedded Live Stream",
            src: response.data.embedded_code,
          };
          this.loadingLive = false;
        } else {
          console.error("No embedded live stream found.");
          this.liveError = true;
          this.loadingLive = false;
        }
      } catch (error) {
        console.error("Error fetching embedded live stream:", error);
        this.liveError = true;
        this.loadingLive = false;
      }
    },

    // Fetch Videos from Playlist
    async fetchVideos() {
      try {
        const response = await axios.get(this.apiEndpoint, {
          params: {
            playlist_id: this.playlistId,
            limit: this.limit,
          },
        });

        if (response.data && response.data.videos) {
          this.videos = response.data.videos.map((item) => ({
            id: item.id,
            youtube_id: item.youtube_id,
            title: item.title,
            thumbnail: item.thumbnail_url,
            channelTitle: item.channel_title,
            publishedAt: item.published_at,
          }));
          this.displayedVideos = this.videos.slice(0, this.videosPerPage);
        } else {
          console.error("Invalid videos API response:", response.data);
        }
      } catch (error) {
        console.error("Error fetching videos:", error);
      } finally {
        this.loadingVideos = false;
      }
    },

    // Format ISO Date to Readable Format
    formatDate(isoDate) {
      const date = new Date(isoDate);
      const options = {
        year: "numeric",
        month: "short",
        day: "numeric",
      };
      return date.toLocaleDateString("en-US", options);
    },

    // Open Video Modal
    openVideo(video) {
      this.iframeData = video;
      this.showIframe = true;
      // Add event listener for Esc key
      document.addEventListener("keydown", this.handleEsc);
    },

    // Close Video Modal
    closeVideo() {
      this.showIframe = false;
      this.iframeData = null;
      // Remove event listener for Esc key
      document.removeEventListener("keydown", this.handleEsc);
      // Stop the video by resetting the iframe src
      if (this.$refs.videoIframe) {
        this.$refs.videoIframe.src = "";
      }
    },

    // Handle Esc Key to Close Modal
    handleEsc(event) {
      if (event.key === "Escape") {
        this.closeVideo();
      }
    },

    // Load More Videos
    loadMore() {
      const nextPage = this.currentPage + 1;
      const startIndex = (nextPage - 1) * this.videosPerPage;
      const endIndex = startIndex + this.videosPerPage;
      this.displayedVideos = this.videos.slice(0, endIndex);
      this.currentPage = nextPage;
    },
  },
  mounted() {
    // Fetch Live Streams and Videos on Mount
    this.fetchEmbeddedStream();
    this.fetchVideos();

    // Initialize Bootstrap tooltips after DOM updates
    nextTick(() => {
      const tooltipTriggerList = [].slice.call(
        document.querySelectorAll('[data-bs-toggle="tooltip"]')
      );
      tooltipTriggerList.map(function (tooltipTriggerEl) {
        return new bootstrap.Tooltip(tooltipTriggerEl);
      });
    });
  },
};
</script>

<style scoped>
.frame_embeded{
  position: relative;
    height: 0;
    overflow: hidden;
    padding-bottom: 56.25%;
}
.frame_embeded iframe{
  position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
}
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

.thumbnail-skeleton {
  width: 100%;
  height: 180px;
}

.skeleton-iframe {
  width: 100%;
  height: 400px;
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

.fade-enter-active,
.fade-leave-active {
  transition: opacity 0.3s;
}

.fade-enter,
.fade-leave-to {
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

  .skeleton-iframe {
    height: 250px;
  }
}

/* Live Stream Skeleton Styles */
.live-skeleton .skeleton-iframe {
  width: 100%;
  height: 400px;
  border-radius: 8px;
}

/* Not Live Styles */
.not_live p {
  font-size: 22px;
  line-height: 32px;
  font-weight: 500;
  margin: 0;
}

.not_live {
  text-align: center;
  padding: 40px;
  border: 1px solid #ccc;
  border-radius: 10px;
  margin-bottom: 60px;
}
</style>
