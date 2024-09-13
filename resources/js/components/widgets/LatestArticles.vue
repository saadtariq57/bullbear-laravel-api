<template>
  <div class="latest-article-widget mt-4 mb-1 mx-auto text-start border-top border-2 border-warning widgets-border">
    <div class="latest-article-heading border-bottom border-2 pt-3 px-3">
      <h4 class="icon-heading fw-6 fs-5">LATEST ARTICLES</h4>
    </div>
    <div v-if="wordpressPosts.length > 0">
      <div v-for="post in wordpressPosts" :key="post.id" class="border-bottom border-2 pt-3 px-3">
        <h3 class="fs-13 fw-4 mb-1">
          <a :href="post.link" class="text-black">{{ truncate(post.title) }}</a>
        </h3>
        <div class="d-flex mb-2">
          <a :href="post.author_info.link" class="me-1 widgets-sm-heading">{{ post.author_info.name }}</a>
          <span class="border-start px-2 widgets-sm-heading">{{ formatDate(post.date) }}</span>
        </div>
      </div>
    </div>
    <div v-else>
      <div v-for="n in 6" :key="n" class="border-bottom border-2 pt-3 px-3 loading-div">
        <Skeletor width="100%" height="20px" />
        <div class="d-flex mb-2 mt-2">
          <Skeletor width="100px" height="15px" class="me-1" />
          <Skeletor width="100px" height="15px" class="ms-2" />
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import axios from 'axios';
import { Skeletor } from "vue-skeletor";

export default {
  components: {
    Skeletor
  },
  data() {
    return {
      wordpressPosts: [],
    };
  },
  mounted() {
    this.fetchLatestArticles();
  },
  methods: {
    fetchLatestArticles() {
      const categories = ['11439', '11438', '11441', '11445', '4341', '11442'];
      
      axios.get('/api/fetch-wordpress-posts', {
        params: {
          categories: categories.join(','),
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
      if (text.length > 102) {
        return text.substring(0, 102) + '...';
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

<style scoped>
  @import "vue-skeletor/dist/vue-skeletor.css";
.loading-div {
    position: relative;
}

.loading-animation {
    position: absolute; 
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background-color: rgba(255, 255, 255, 0.354); 
    background-repeat: no-repeat;
    background-position: center;
}
</style>