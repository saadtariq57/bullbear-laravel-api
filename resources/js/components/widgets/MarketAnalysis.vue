<template>
  <div class="col-xl-4 col-lg-6">
    <div class="main_section mb-40 border-grey border">
      <div class="heading-summary mb-3 chat-main-common-padding border-bottom border-grey pt-3 pb-1">
        <h3 class="fs-6 fw-bolder lh-base">IN-DEPTH MARKET ANALYSIS</h3>
      </div>

      <div class="chat_output">
        <div class="border-1 border-grey">
          <div v-if="wordpressPosts.length > 0">
            <div v-for="(post, index) in wordpressPosts.slice(0, 6)" :key="post.id" :class="['market-news', {'border-bottom-0': index === 5}]" class="d-flex align-items-center border-bottom border-1 border-grey">
              <div class="feature-img">
                <div class="stock-post-img">
                  <img :src="post.thumbnail" alt="thumbnail-img">
                </div>
              </div>
              <div class="stock-post-content ms-3">
                <h4 class="lh-0 mb-0"><a :href="`https://richtv.io${post.link}`" aria-label="title">{{ truncate(post.title) }}</a></h4>
                <a class="stock-author-meta border-end border-1 border-grey" :href="post.authorLink" aria-label="author_link">{{ post.author }}</a>
                <span>{{ post.date }}</span>
              </div>
            </div>
          </div>
          <div v-else>
            <div v-for="n in 6" :key="n" class="market-news d-flex align-items-center border-bottom border-1 border-grey ">
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
      const categories = ['11453', '11451', '11454', '11457', '3587', '11452'];
      const requests = categories.map(category => {
        return axios.get(`/api/fetch-wordpress-posts/${category}?numPosts=1`, {
          withCredentials: true,
        });
      });

      Promise.all(requests)
        .then(responses => {
          const uniquePosts = [];
          responses.forEach(response => {
            const post = response.data[0]; 
            if (post && !uniquePosts.some(p => p.id === post.id)) {
              uniquePosts.push(post); 
            }
          });
          uniquePosts.sort((a, b) => new Date(b.date) - new Date(a.date));
          this.wordpressPosts = uniquePosts.slice(0, 6);
        })
        .catch(error => {
          console.error('Error fetching WordPress posts:', error);
        });
    },

    truncate(text) {
      if (text.length > 40) {
        return text.substring(0,40) + '...';
      } else {
        return text;
      }
    }
  }
}
</script>

<style scoped>
.loading-animation {
    width: 60px;
    height: 60px;
    background-color: rgba(0, 0, 0, 0.1);
    animation: pulse 1.5s infinite;
}

@keyframes pulse {
    0% { opacity: 0.3; }
    50% { opacity: 0.8; }
    100% { opacity: 0.3; }
}
</style>
