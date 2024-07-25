<template>
  <div>
    <header class="header-divider mt-4 pt-2">
      <h2 class="text-black">Latest On {{ symbol }}</h2>
    </header>
    
    <ul class="ul-dics fw-bold ps-4 m-0">
      <!-- External News -->
      <li v-for="news in externalNews" :key="news.url" class="border-bottom pb-3 mb-1">
        <div class="d-flex flex-wrap align-items-center">
          <div>
            <a :href="news.url" target="_blank" class="text-black fs-14">
              {{ news.title }}
            </a>
          </div>
          <span class="text-secondary fs-12 ps-2 pt-1">
            <time>{{ formatDate(news.publishedDate) }}</time> - <span>{{ news.site }}</span>
          </span>
        </div>
      </li>
      
      <!-- Internal News -->
      <li v-for="post in internalNews" :key="post.id" class="border-bottom pb-3 mb-1">
        <div class="d-flex flex-wrap align-items-center">
          <div>
            <a :href="post.link" target="_blank" class="text-black fs-14">
              {{ post.title.rendered }}
            </a>
          </div>
          <span class="text-secondary fs-12 ps-2 pt-1">
            <time>{{ formatDate(post.date) }}</time> - <span>Internal</span>
          </span>
        </div>
      </li>
    </ul>
  </div>
</template>

<script>
import axios from 'axios';

export default {
  props: {
    symbol: {
      type: String,
      required: true
    }
  },
  data() {
    return {
      externalNews: [],
      internalNews: []
    };
  },
  mounted() {
    this.fetchExternalNews();
    this.fetchInternalNews();
  },
  methods: {
    async fetchExternalNews() {
      try {
        const response = await axios.get(`/api/external-news/${this.symbol}`);
        this.externalNews = response.data;
      } catch (error) {
        console.error('Error fetching external news:', error);
      }
    },
    async fetchInternalNews() {
      try {
        const response = await axios.get(`/api/fetch-wordpress-posts/${this.symbol}`);
        this.internalNews = response.data;
      } catch (error) {
        console.error('Error fetching internal news:', error);
      }
    },
    formatDate(dateString) {
      const date = new Date(dateString);
      const now = new Date();
      const diffInHours = Math.floor((now - date) / (1000 * 60 * 60));

      if (diffInHours < 24) {
        return `${diffInHours} HOURS AGO`;
      } else {
        return date.toLocaleDateString('en-US', { month: 'short', day: 'numeric', year: 'numeric' });
      }
    }
  }
};
</script>