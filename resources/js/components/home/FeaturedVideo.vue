<template>
  <section class="featured-video container-fluid py-80">
    <div class="container">
      <div class="row">
        <div class="col-12">
          <div class="btn-flex mb-5 px-10">
            <div class="main-heading-help">
              <h2 class="icon-heading">Featured Videos</h2>
            </div>
          </div>

          <div class="video-slider">
            <div class="video-card" v-for="video in videos" :key="video.youtube_id">
              <div class="featured-video-1 shadow m-auto bg-white border border-light rounded-4 pb-2 mb-3">
                <div class="position-relative">
                  <div class="video-play-icon-small position-absolute">
                    <button @click="openModal(video.youtube_id)" class="play-button" aria-label="Play Video">
                      <img src="build/images/play-icon.png" alt="Play Icon" width="50">
                    </button>
                  </div>
                  <div class="video-featured position-relative">
                    <img
                      :src="video.thumbnail"
                      alt="thumbnail_card_img"
                      class="thumbnail-card w-100"
                      @click="openModal(video.youtube_id)"
                    />
                  </div>
                </div>
                <div class="video-bio px-3 pt-2 pb-1">
                  <div class="artical-au d-flex justify-content-between pb-3">
                    <span class="by-name">
                      <i>{{ video.channelTitle }}</i>
                    </span>
                    <div class="d-flex">
                      <span>{{ formatDate(video.publishedAt) }}</span>
                    </div>
                  </div>
                  <h3 class="fs-18 fw-bolder">{{ video.title }}</h3>
                </div>
              </div>
            </div>
          </div>

          <!-- Modal -->
          <div v-if="showModal" class="modal-overlay" @click.self="closeModal">
            <div class="modal-content">
              <button class="close-button" @click="closeModal">&times;</button>
              <iframe
                :src="videoUrl"
                frameborder="0"
                allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture"
                allowfullscreen
                title="Video Player"
              ></iframe>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>
</template>

<script>
export default {
  props: {
    playlistId: {
      type: String,
      required: true,
    },
  },
  data() {
    return {
      videos: [],
      showModal: false,
      currentVideoId: null,
    };
  },
  computed: {
    videoUrl() {
      return this.currentVideoId
        ? `https://www.youtube.com/embed/${this.currentVideoId}?autoplay=1`
        : '';
    },
  },
  methods: {
    async fetchVideos() {
      try {
        const response = await axios.get('/api/videos', {
          params: {
            playlist_id: this.playlistId,
            limit: 7,
          },
        });

        this.videos = response.data.videos.map(item => ({
          youtube_id: item.youtube_id,
          title: item.title,
          thumbnail: item.thumbnail_url,
          channelTitle: item.channel_title,
          publishedAt: item.published_at,
        }));
      } catch (error) {
        console.error('Error fetching videos:', error);
      }
    },
    formatDate(dateString) {
      const date = new Date(dateString);
      return date.toLocaleDateString('en-US', { year: 'numeric', month: 'short', day: 'numeric' });
    },
    initSlider() {
      if ($('.video-slider').hasClass('slick-initialized')) {
        $('.video-slider').slick('unslick');
      }

      $('.video-slider').slick({
        centerMode: true,
        centerPadding: '20px',
        dots: true,
        infinite: true,
        speed: 2000,
        arrows: false,
        autoplaySpeed: 4500,
        autoplay: true,
        slidesToShow: 3,
        responsive: [
          {
            breakpoint: 1200,
            settings: {
              slidesToShow: 1,
              swipeToSlide: true,
              centerPadding: '120px',
            },
          },
          {
            breakpoint: 1025,
            settings: {
              slidesToShow: 1,
              swipeToSlide: true,
              centerPadding: '90px',
            },
          },
          {
            breakpoint: 769,
            settings: {
              slidesToShow: 1,
              swipeToSlide: true,
              centerMode: true,
              centerPadding: '70px',
            },
          },
          {
            breakpoint: 430,
            settings: {
              slidesToShow: 1,
              centerPadding: '0px',
            },
          },
          {
            breakpoint: 325,
            settings: {
              slidesToShow: 1,
              centerPadding: '0px',
            },
          },
        ],
      });
    },
    openModal(videoId) {
      this.currentVideoId = videoId;
      this.showModal = true;
      // Pause the slider autoplay
      $('.video-slider').slick('slickPause');
    },
    closeModal() {
      this.showModal = false;
      this.currentVideoId = null;
      // Resume the slider autoplay
      $('.video-slider').slick('slickPlay');
    },
  },
  async mounted() {
    await this.fetchVideos();
    this.$nextTick(() => {
      this.initSlider();
    });
  },
  beforeDestroy() {
    // Destroy Slick slider before component is destroyed to prevent memory leaks
    if ($('.video-slider').hasClass('slick-initialized')) {
      $('.video-slider').slick('unslick');
    }
  },
};
</script>

<style scoped>
/* Modal Styles */
.modal-overlay {
  position: fixed;
  top: 0;
  left: 0;
  width: 100%;
  height: 100%;
  background-color: rgba(0, 0, 0, 0.7);
  display: flex;
  align-items: center;
  justify-content: center;
  z-index: 1000;
}

.modal-content {
  position: relative;
  width: 80%;
  max-width: 800px;
  background-color: #000;
  padding-top: 56.25%; /* 16:9 Aspect Ratio */
  height: 0;
  overflow: hidden;
  border-radius: 8px;
}

.modal-content iframe {
  position: absolute;
  top: 0;
  left: 0;
  width: 100%;
  height: 100%;
}

.close-button {
  position: absolute;
  top: -40px;
  right: 0;
  background: transparent;
  border: none;
  font-size: 2rem;
  color: #fff;
  cursor: pointer;
}

.play-button {
  background: transparent;
  border: none;
  cursor: pointer;
}
</style>


