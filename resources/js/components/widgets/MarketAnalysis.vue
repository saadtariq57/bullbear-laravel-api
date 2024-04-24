<template>
  <div class="col-xl-4 col-lg-6">
    <div class="main_section mb-40 border-grey border">
      <div class="heading-summary mb-3 chat-main-common-padding border-bottom border-grey pt-3 pb-1">
        <h3 class="fs-6 fw-bolder lh-base">IN-DEPTH MARKET ANALYSIS</h3>
      </div>

      <div class="chat_output">
        <div class="market-news border-bottom border-1 border-grey" v-for="(post, index) in wordpressPosts.slice(0, 6)" :key="post.id">
          <div class="d-flex align-items-center">
            <div class="feature-img">
              <div class="stock-post-img">
                <img :src="post.thumbnail" alt="thumbnail-img">
              </div>
            </div>
            <div class="stock-post-content">
              <h4 class="lh-0 mb-0"><a :href="`https://richtv.io${post.link}`" aria-label="title">{{ truncate(post.title) }}</a></h4>
              <a class="stock-author-meta border-end border-1 border-grey" :href="post.authorLink" aria-label="author_link">{{ post.author }}</a>
              <span>{{ post.date }}</span>
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
    this.fetchWordPressPosts();
  },
  methods: {
    fetchWordPressPosts() {
      const categories = '962';
      axios.get(`/api/fetch-wordpress-posts/${categories}`, {
        withCredentials: true,
        headers: {
          'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
        },
      })
      .then(response => {
        this.wordpressPosts = response.data;
      })
      .catch(error => {
        console.error('Error fetching WordPress posts:', error);
      });
    },
    truncate(text) {
      if (text.length > 86) {
        return text.substring(0, 86) + '...';
      } else {
        return text;
      }
    }
  }
}
</script>
