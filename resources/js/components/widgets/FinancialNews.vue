<template>
  <div class="col-xl-4 col-lg-6">
    <div class="main_section mb-40 border-grey border chat_output border-top border-2 border-warning widgets-border">
      <div class="heading-summary mb-3 chat-main-common-padding border-bottom border-grey pt-3 pb-1">
        <h3 class="fs-6 fw-bolder lh-base icon-short-heading">LATEST FINANCIAL NEWS</h3>
      </div>

      <div class="border-1 border-grey">
        <div v-if="latestFinancialNews.length > 0">
          <div v-for="(post, index) in latestFinancialNews.slice(0, 6)" :key="index" :class="['market-news', {'border-bottom-0': index === 5}]" class="border-bottom market-news d-flex  border-1 border-grey ">
            <div class="feature-img">
              <div class="stock-post-img">
                <img :src="post.thumbnail" alt="thumbnail-img">
              </div>
            </div>
            <div class="stock-post-content ms-3">
              <h4><a :href="`https://richtv.io${post.link}`" aria-label="title">{{ truncate(post.title) }}</a></h4>
              <a class="stock-author-meta" :href="post.authorLink" aria-label="author_link">{{ post.author }}</a>
              <span>{{ post.date }}</span>
            </div>
          </div>
        </div>
        <div v-else>
          <div v-for="n in 6" :key="n" class="market-news d-flex border-bottom border-1 border-grey ">
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
</template>

<script>
import axios from 'axios';

export default {
  data() {
    return {
      latestFinancialNews: [],
    };
  },
  mounted() {
    this.fetchFinancialNews();
  },
  methods: {
    fetchFinancialNews() {
      const categories = ['224', '961', '963', '962', '3591'];
      const requests = categories.map(category => {
        return axios.get(`/api/fetch-wordpress-posts/${category}?numPosts=1`, {
          withCredentials: true,
        });
      });

      Promise.all(requests)
        .then(responses => {
          const allPosts = responses.flatMap(response => response.data);
          this.latestFinancialNews = allPosts.sort((a, b) => new Date(b.date) - new Date(a.date));
        })
        .catch(error => {
          console.error('Error fetching financial news:', error);
        });
    },
    truncate(text) {
      if (text.length > 40) {
        return text.substring(0, 40) + '...';
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
