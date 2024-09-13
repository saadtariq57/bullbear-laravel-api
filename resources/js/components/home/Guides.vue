<template>
  <section class="Guides-section container-fluid py-80">
    <div class="container">
      <div class="heading-summary">
        <h2 class="icon-heading mb-4 px-10 ">How To Guides</h2>
        <div class="guide-slider" v-if="wordpressPosts.length === 0">
          <div class="guide-content-slider">
            <p>Loading...</p>
          </div>
        </div>
        <div v-else class="guide-slider">
          <div class="guide-content-slider" v-for="(post, index) in wordpressPosts" :key="post.id">
            <a :href="post.link" class="guide-card-hover d-block">
              <div class="guide-card-wrapper" :style="{ 'background-image': 'url(' + post.featured_media_url + ')', 'background-size': 'cover', 'background-position': 'center center' }">
                <div class="overlay-guide"></div>
                <div class="post-count position-relative">
                  <span>{{ index + 1 }}.</span>
                </div>
                <div class="guide-content position-relative">
                  <h4>{{ post.title }}</h4>
                  <p class="text-white" v-html="truncate(getExcerpt(post))"></p>
                  <div class="read-more-link-artical d-inline-flex align-items-center gap-2">
                    <span>Read more</span><i class="bi bi-arrow-right"></i>
                  </div>
                </div>
              </div>
            </a>
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
      wordpressPosts: [],
    };
  },
  mounted() {
    this.fetchGuidesPosts();
  },
  methods: {
    fetchGuidesPosts() {
      axios.get('/api/fetch-wordpress-posts', {
        params: {
          categories: 4341,
          per_page: 6,
        },
        withCredentials: true,
      })
      .then(response => {
        this.wordpressPosts = response.data.posts;
        this.initializeSlider();
      })
      .catch(error => {
        console.error('Error fetching WordPress posts:', error);
      });
    },
    initializeSlider() {
      this.$nextTick(() => {
        $('.guide-slider').slick({
          dots: false,
          infinite: true,
          speed: 1000,
          arrows: true,
          autoplay: true, 
          autoplaySpeed: 3000, 
          slidesToShow: 3,
          responsive: [{
            breakpoint: 992,
            settings: {
              slidesToShow: 2,
              swipeToSlide: true,
            }
          }, {
            breakpoint: 768,
            settings: {
              slidesToShow: 1,
              swipeToSlide: true,
            }
          }]
        });
      });
    },
    getExcerpt(post) {
      if (post.excerpt && typeof post.excerpt === 'object' && post.excerpt.rendered) {
        return post.excerpt.rendered;
      } else if (typeof post.excerpt === 'string') {
        return post.excerpt;
      } else {
        return '';
      }
    },
    truncate(text) {
      const strippedText = text.replace(/<[^>]*>/g, '');
      if (strippedText.length > 100) {
        return strippedText.substring(0, 100) + '...';
      } else {
        return strippedText;
      }
    }
  }
}
</script>