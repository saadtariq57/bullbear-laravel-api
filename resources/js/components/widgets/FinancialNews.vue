<template>
  <div class="col-xl-4 col-lg-6">
    <div class="main_section mb-40 border-grey border chat_output">
      <div class="heading-summary mb-3 chat-main-common-padding border-bottom border-grey pt-3 pb-1">
        <h3 class="fs-6 fw-bolder lh-base">LATEST FINANCIAL NEWS</h3>
      </div>

      <div class="market-news border-bottom border-1 border-grey" v-for="(post, index) in financialNews.slice(0, 6)" :key="index">
        <div class="d-flex">
          <div class="feature-img">
            <div class="stock-post-img">
              <img :src="post.thumbnail" alt="thumbnail-img">
            </div>
          </div>
          <div class="stock-post-content">
            <h4><a :href="`https://richtv.io${post.link}`" aria-label="title">{{ truncate(post.title) }}</a></h4>
            <a class="stock-author-meta" :href="post.authorLink" aria-label="author_link">{{ post.author }}</a>
            <span>{{ post.date }}</span>
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
      financialNews: [],
    };
  },
  mounted() {
    this.fetchFinancialNews();
  },
  methods: {
    fetchFinancialNews() {
      const categories = '224'; 
      axios.get(`/api/fetch-wordpress-posts/${categories}`, {
        withCredentials: true,
        
      })
      .then(response => {
        this.financialNews = response.data;
      })
      .catch(error => {
        console.error('Error fetching financial news:', error);
      });
    },
    truncate(text) {
      if (text.length > 75) {
        return text.substring(0, 75) + '...';
      } else {
        return text;
      }
    }
  }
}
</script>
