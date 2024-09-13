<template>
  <section class="featured-video container-fluid py-80">
    <div class="container">
      <div class="row">
        <div class="col-12">
          <div class="btn-flex mb-5 px-10">
            <div class="main-heading-help ">
              <h2 class="icon-heading">Featured Videos</h2>
            </div>
          </div>
          
          <div class="video-slider">
            <div class="video-card" v-for="video in videos" :key="video.id">
              <div class="featured-video-1 shadow m-auto bg-white border border-light rounded-4 pb-2 mb-3">
                <div class="position-relative">
                  <form action="">
                    <input type="hidden" name="video_id" :value="video.id" tabindex="-1">
                    <div class="video-play-icon-small position-absolute">
                      <a :href="'https://www.youtube.com/watch?v=' + video.id"><img src="build/images/play-icon.png" alt="" width="50"></a>
                    </div>
                  </form>
                  <div class="video-featured position-relative">
                    <a :href="'https://www.youtube.com/watch?v=' + video.id">
                      <img :src="video.thumbnail" alt="thumbnail_card_img" class="thumbnail-card w-100">
                    </a>
                  </div>
                </div>
                <div class="video-bio px-3 pt-2 pb-1">
                  <div class="artical-au d-flex justify-content-between pb-3">
                    <a href="" class="by-name"><i><span>{{ video.channelTitle }}</span></i></a>
                    <div class="d-flex">
                      <span>{{ formatDate(video.publishedAt) }}</span>
                    </div>
                  </div>
                  <h3 class="fs-18 fw-bolder">{{ video.title }}</h3>
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

export default {
  data() {
    return {
      videos: [],
      apiKey: 'AIzaSyAPwfGhdaGIs9bO8NlYcInnAw04RE0bJ24',
      playlistId: 'PLiBGEhbXkQPAoX8JgMr6D-KeN5ZGmN8ct',
    };
  },
  methods: {
    async fetchVideos() {
      try {
        const response = await axios.get(`https://www.googleapis.com/youtube/v3/playlistItems`, {
          params: {
            part: 'snippet',
            maxResults: 10,
            playlistId: this.playlistId,
            key: this.apiKey,
          },
        });

        this.videos = response.data.items.map(item => ({
          id: item.snippet.resourceId.videoId,
          title: item.snippet.title,
          thumbnail: item.snippet.thumbnails.medium.url,
          channelTitle: item.snippet.channelTitle,
          publishedAt: item.snippet.publishedAt,
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
              slidesToShow: 2,
              swipeToSlide: true,
            }
          },
          {
            breakpoint: 1025,
            settings: {
              slidesToShow: 3,
              swipeToSlide: true,
            }
          },
          {
            breakpoint: 769,
            settings: {
              slidesToShow: 1,
              swipeToSlide: true,
              centerMode: true,
              centerPadding: '120px',
            }
          },
          {
            breakpoint: 430,
            settings: {
              slidesToShow: 1,
            }
          },
          {
            breakpoint: 325,
            settings: {
              slidesToShow: 1,
              centerPadding: '0px',
            }
          }
        ]
      });
    },
  },
  async mounted() {
    await this.fetchVideos();
    this.$nextTick(() => {
      this.initSlider();
    });
  },
}
</script>