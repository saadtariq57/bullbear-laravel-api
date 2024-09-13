<template>
  <div class="col-xl-4 col-lg-6">
    <div class="main_section mb-40 border-grey border border-top border-2 border-warning widgets-border">
      <div class="heading-summary mb-3 chat-main-common-padding border-bottom border-grey pt-3 pb-1">
        <h3 class="fs-6 fw-bolder lh-base icon-short-heading">IN-DEPTH MARKET ANALYSIS</h3>
      </div>

      <div class="chat_output">
        <div class="border-1 border-grey">
          <div v-if="wordpressPosts.length > 0">
            <div v-for="(post, index) in wordpressPosts" :key="post.id" :class="['market-news', {'border-bottom-0': index === wordpressPosts.length - 1}]" class="d-flex align-items-center border-bottom border-1 border-grey">
              <div class="feature-img">
                <div class="stock-post-img">
                  <img :src="post.featured_media_url" alt="thumbnail-img">
                </div>
              </div>
              <div class="stock-post-content ms-3">
                <h4 class="lh-0 mb-0"><a :href="post.link" target="_blank" rel="noopener noreferrer" aria-label="title">{{ truncate(post.title) }}</a></h4>
                <a class="stock-author-meta border-end border-1 border-grey" :href="post.author_info.link" target="_blank" rel="noopener noreferrer" aria-label="author_link">{{ post.author_info.name }}</a>
                <span>{{ formatDate(post.date) }}</span>
              </div>
            </div>
          </div>
          <div v-else>
            <div v-for="n in 10" :key="n" class="market-news d-flex align-items-center border-bottom border-1 border-grey ">
              <div class="feature-img">
                <div class="stock-post-img loading-animation"></div>
              </div>
              <div class="stock-post-content ms-3">
                <h4 class="fs-13 fw-4 mb-1"><a href="#" class="text-black">Loading Title...</a></h4>
                <a href="#" class="me-1 widgets-sm-heading">Loading Author...</a>
                <span class="border-start px-2 widgets-sm-heading">Loading Date...</span>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
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
    this.fetchMarketAnalysis();
  },
  methods: {
    fetchMarketAnalysis() {
      axios.get('/api/fetch-wordpress-posts', {
        params: {
          categories: 962,
          per_page: 6,
        },
        withCredentials: true,
      })
      .then(response => {
        this.wordpressPosts = response.data.posts;
      })
      .catch(error => {
        console.error('Error fetching WordPress posts:', error);
      });
    },

    truncate(text) {
      if (text.length > 40) {
        return text.substring(0, 40) + '...';
      } else {
        return text;
      }
    },

    formatDate(dateString) {
      const options = { year: 'numeric', month: 'short', day: 'numeric' };
      return new Date(dateString).toLocaleDateString('en-US', options);
    }
  }
}
</script>