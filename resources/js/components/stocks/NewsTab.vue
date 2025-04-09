<template>
  <div class="news-tab container-fluid tabContentMain">
    <!-- Header Section -->
    <header class="header-divider mt-4 pt-2 d-flex justify-content-between align-items-center">
      <h3 class="text-black">Latest Updates for {{ symbol }}</h3>
      <!-- Icons for External, Internal News, and Technical Analysis -->
      <div class="icons d-flex align-items-center">
        <i class="bi bi-newspaper me-3" title="External News" aria-label="External News"></i>
        <i class="bi bi-bookmark-heart me-3" title="Internal News" aria-label="Internal News"></i>
        <i class="bi bi-graph-up me-3" title="Technical Analysis" aria-label="Technical Analysis"></i>
      </div>
    </header>
    
    <!-- Widgets Section -->
    <div class="widgets my-4">
      
      <!-- Technical Analysis Widget -->
      <div class="widget technical-analysis-widget mb-4">
        <h3 class="widget-title mb-3">
          <i class="bi bi-graph-up me-2"></i> Technical Analysis
        </h3>
        <ul class="list-unstyled">
          <!-- Content Loader -->
          <template v-if="loadingTechnicalAnalysis">
            <li v-for="n in 5" :key="'technical-skeleton-' + n" class="mb-3 d-flex align-items-start">
              <div class="skeleton-image me-3 rounded"></div>
              <div style="flex: 1;">
                <div class="skeleton-text title mb-1"></div>
                <div class="skeleton-text subtitle"></div>
              </div>
            </li>
          </template>
          <!-- Error Message -->
          <template v-else-if="errorTechnicalAnalysis">
            <li class="mb-3">
              <div class="alert alert-danger" role="alert">
                Failed to load technical analysis.
              </div>
            </li>
          </template>
          <!-- Actual Content -->
          <template v-else>
            <li v-for="analysis in technicalAnalysis" :key="analysis.id" class="mb-3 d-flex align-items-start">
              <img :src="analysis.featured_media_url" alt="Featured Image" class="me-3 rounded" style="width: 100px; height: 60px; object-fit: cover;">
              <div class="w-100">
                <a :href="`/blog/${analysis.link}`" target="_blank" class="text-black text-decoration-none fs-5">
                  {{ cleanTitle(analysis) }}
                </a>
                <div class="text-muted fs-6 dateName">
                  <time>{{ formatDate(analysis.date) }}</time>  <a href="#" target="_blank">{{ analysis.author_info.name }}</a>
                </div>
              </div>
            </li>
          </template>
        </ul>
      </div>
      
      <!-- Internal News Widget -->
      <div class="widget internal-news-widget mb-4">
        <h3 class="widget-title mb-3">
          <i class="bi bi-bookmark-heart me-2"></i> Financial News
        </h3>
        <ul class="list-unstyled">
          <!-- Content Loader -->
          <template v-if="loadingInternalNews">
            <li v-for="n in 5" :key="'internal-skeleton-' + n" class="mb-3">
              <div class="skeleton-text title mb-1"></div>
              <div class="skeleton-text subtitle"></div>
            </li>
          </template>
          <!-- Error Message -->
          <template v-else-if="errorInternalNews">
            <li class="mb-3">
              <div class="alert alert-danger" role="alert">
                Failed to load financial news.
              </div>
            </li>
          </template>
          <!-- Actual Content -->
          <template v-else>
            <li v-for="post in internalNews" :key="post.id" class="mb-3">
              <a :href="`/blog/${post.link.replace(/^\/+/, '')}`" target="_blank" class="text-black text-decoration-none fs-5">
                {{ cleanTitle(post) }}
              </a>
              <div class="text-muted fs-6 dateName">
                <time>{{ formatDate(post.date) }}</time>  <a href="#" target="_blank">{{ post.author_info.name }}</a>
              </div>
            </li>
          </template>
        </ul>
      </div>
      
      <!-- External News Widget -->
      <div class="widget external-news-widget mb-4">
        <h3 class="widget-title mb-3">
          <i class="bi bi-newspaper me-2"></i> External News
        </h3>
        <ul class="list-unstyled">
          <!-- Content Loader -->
          <template v-if="loadingExternalNews">
            <li v-for="n in 5" :key="'external-skeleton-' + n" class="mb-3 d-flex align-items-start">
              <div class="skeleton-text title mb-1"></div>
              <div class="skeleton-text subtitle me-3"></div>
              <div class="skeleton-text short-text mt-2"></div>
            </li>
          </template>
          <!-- Error Message -->
          <template v-else-if="errorExternalNews">
            <li class="mb-3">
              <div class="alert alert-danger" role="alert">
                Failed to load external news.
              </div>
            </li>
          </template>
          <!-- Actual Content -->
          <template v-else>
            <li v-for="news in externalNews" :key="news.url" class="mb-3 d-flex align-items-start">
              <img :src="news.image" alt="Featured Image" class="me-3 rounded" style="width: 100px; height: 60px; object-fit: cover;">
              <div class="w-100">
                <a :href="news.url" target="_blank" class="text-black text-decoration-none fs-5">
                  {{ news.title }}
                </a>
                <div class="text-muted fs-6 dateName">
                  <time>{{ formatDate(news.publishedDate) }}</time>  <span>{{ news.site }}</span>
                </div>
                <p class="mt-1">{{ truncateText(news.text, 15) }}</p>
              </div>
            </li>
          </template>
        </ul>
      </div>
      
    </div>
  </div>
</template>

<script>
import axios from 'axios';
import { decode } from 'html-entities';

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
      internalNews: [],
      technicalAnalysis: [],
      loadingExternalNews: true,
      loadingInternalNews: true,
      loadingTechnicalAnalysis: true,
      errorExternalNews: false,
      errorInternalNews: false,
      errorTechnicalAnalysis: false,
    };
  },
  mounted() {
    this.fetchExternalNews();
    this.fetchInternalNews();
    this.fetchTechnicalAnalysis();
  },
  methods: {
    /**
     * Helper method to decode post titles
     * @param {Object} post - The post object
     * @returns {String} - Decoded title
     */
    cleanTitle(post) {
      if (!post.title) return '';
      return decode(post.title);
    },
    truncateText(text, wordLimit) {
        if (!text) return '';
        const words = text.split(' ');
        return words.length > wordLimit
          ? words.slice(0, wordLimit).join(' ') + '...'
          : text;
      },
    /**
     * Helper method to decode post excerpts
     * @param {Object} post - The post object
     * @returns {String} - Decoded excerpt
     */
    cleanExcerpt(post) {
      if (!post.excerpt) return '';
      // Remove HTML tags and decode
      const tempDiv = document.createElement('div');
      tempDiv.innerHTML = post.excerpt;
      const text = tempDiv.textContent || tempDiv.innerText || '';
      return decode(text.trim());
    },

    /**
     * Fetch external news from the API
     */
    async fetchExternalNews() {
      try {
        const response = await axios.get(`/api/external-news/${this.symbol}`);
        this.externalNews = response.data || [];
      } catch (error) {
        console.error('Error fetching external news:', error);
        this.errorExternalNews = true;
      } finally {
        this.loadingExternalNews = false;
      }
    },

    /**
     * Fetch internal news from the API
     */
    async fetchInternalNews() {
      try {
        const response = await axios.get('/api/fetch-prioritized-internal-news', {
          params: { symbol: this.symbol }
        });
        this.internalNews = response.data.posts || [];
      } catch (error) {
        console.error('Error fetching internal news:', error);
        this.errorInternalNews = true;
      } finally {
        this.loadingInternalNews = false;
      }
    },

    /**
     * Fetch technical analysis from the API
     */
    async fetchTechnicalAnalysis() {
      try {
        const response = await axios.get('/api/fetch-prioritized-technical-analysis', {
          params: { symbol: this.symbol }
        });
        this.technicalAnalysis = response.data.posts || [];
      } catch (error) {
        console.error('Error fetching technical analysis:', error);
        this.errorTechnicalAnalysis = true;
      } finally {
        this.loadingTechnicalAnalysis = false;
      }
    },

    /**
     * Format the date string
     * @param {String} dateString - The date string
     * @returns {String} - Formatted date
     */
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

<style scoped>
.dateName time,.dateName span,.dateName a{
border-bottom:1px solid;
}
.dateName{
display: flex;
    align-items: center;
    justify-content: space-between;
    font-weight: 500;
}
.news-tab {
  /* Container styling */
}

.header-divider {
  border-bottom: 2px solid #e0e0e0;
  border-top: 1px solid #000000;
}

.header-divider h3 {
  font-weight: 600;
}

.icons i {
  font-size: 1.5rem;
  cursor: pointer;
  color: #555;
  transition: color 0.3s;
}

.icons i:hover {
  color: #000;
}

.widgets {
  /* Each widget occupies full width */
}

.widget {
  background-color: #ffffff; /* Changed to white for better contrast */
  padding: 1.5rem;
  border-radius: 8px;
  box-shadow: 0 2px 8px rgba(0, 0, 0, 0.05); /* Slightly more pronounced shadow */
  transition: transform 0.3s, box-shadow 0.3s;
}

.widget:hover {
  transform: translateY(-5px);
  box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
}

.widget-title {
  font-size: 1.25rem;
  font-weight: 600;
  margin-bottom: 1rem;
  display: flex;
  align-items: center;
  border-bottom: 1px solid #ddd;
  padding-bottom: 0.5rem;
}

.widget-title i {
  color: #007bff; /* Icon color matching theme */
}

.list-unstyled li a {
  display: block;
  transition: color 0.3s;
}

.list-unstyled li a:hover {
  text-decoration: underline;
  color: #007bff;
}

.text-muted time {
  display: block;
  margin-top: 0.25rem;
}

.text-muted a {
  color: #6c757d;
  text-decoration: none;
}

.text-muted a:hover {
  text-decoration: underline;
}

.rounded {
  border-radius: 8px;
}

.alert {
  margin: 0;
}

/* Skeleton Styles */
.skeleton-image {
  width: 100px;
  height: 60px;
  background-color: #e0e0e0; /* Light gray background */
  border-radius: 4px;
}

.skeleton-text {
  height: 16px;
  background-color: #e0e0e0; /* Light gray background */
  border-radius: 4px;
}

.skeleton-text.title {
  width: 70%;
  height: 24px;
  margin-bottom: 0.25rem;
}

.skeleton-text.subtitle {
  width: 50%;
  height: 16px;
}

.skeleton-text.short-text {
  width: 80%;
  height: 18px;
  margin-top: 0.5rem;
}

.skeleton-button {
  width: 40%;
  height: 30px;
  background-color: #e0e0e0; /* Light gray background */
  border-radius: 4px;
}

@keyframes pulse {
  0% {
    opacity: 1;
    background-color: #f0f0f0;
  }
  50% {
    opacity: 0.4;
    background-color: #e0e0e0;
  }
  100% {
    opacity: 1;
    background-color: #f0f0f0;
  }
}

/* Responsive Styles */
@media (max-width: 768px) {
  .widget {
    padding: 1rem;
  }

  .technical-analysis-widget li,
  .external-news-widget li {
    flex-direction: column;
    align-items: flex-start;
  }

  .technical-analysis-widget img,
  .external-news-widget img {
    width: 100%;
    height: auto;
    margin-bottom: 0.5rem;
  }

  .external-news-widget li {
    align-items: flex-start;
  }

  .skeleton-image {
    width: 100%;
    height: 60px;
  }
}
</style>
