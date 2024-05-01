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
          <div class="guide-content-slider" v-for="(post, index) in wordpressPosts.slice(0, 6)" :key="index">
            <a :href="post.link" class="guide-card-hover d-block">
              <div class="guide-card-wrapper" :style="{ 'background-image': 'url(' + post.thumbnail + ')', 'background-size': 'cover', 'background-position': 'center center' }">
                <div class="overlay-guide"></div>
                <div class="post-count position-relative">
                  <span>{{ index + 1 }}.</span>
                </div>
                <div class="guide-content position-relative">
                  <h4>{{ post.title }}</h4>
                  <p class="text-white">{{ post.excerpt }}</p>
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
    const categories = '4341';
    axios.get(`/api/fetch-wordpress-posts/${categories}`, {
      withCredentials: true,
      headers: {
        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
      },
    })
    .then(response => {
      this.wordpressPosts = response.data;
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
}
}

}
</script>
