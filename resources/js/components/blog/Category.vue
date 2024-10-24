<template>
  <div class="container my-4">
    <div class="row">
      <!-- Left Column: Post Cards -->
      <div class="col-lg-8">
        <!-- Category Header with Icon -->
        <div class="mb-5 border-bottom d-flex align-items-center">
          <i :class="categoryIcon" class="me-2 fs-1 text-primary"></i>
          <h1 class="fs-1 fw-bold">{{ category.name }}</h1>
        </div>

        <!-- Posts Section -->
        <div class="posts">

          <!-- Skeleton Loader for Initial Loading -->
          <div v-if="loading && posts.length === 0" class="mb-4">
            <div class="row">
              <div class="col-md-6 mb-4" v-for="n in 6" :key="n">
                <PostCardSkeleton />
              </div>
            </div>
          </div>

          <!-- No Posts Available -->
          <div class="text-center" v-else-if="!loading && posts.length === 0">
            <p>No posts available in this category.</p>
          </div>

          <!-- Actual Posts -->
          <div class="row" v-else>
            <div class="col-md-6 mb-4" v-for="post in posts" :key="post.id">
              <PostCard :post="post" :category-slug="category.slug" />
            </div>
          </div>

          <!-- Load More Button -->
          <div class="text-center mt-4" v-if="!loading && currentPage < totalPages">
            <button class="btn btn-primary" @click="loadMorePosts">
              <i class="bi bi-arrow-down-circle me-2"></i> Load More
            </button>
          </div>

          <!-- Loading More Posts Indicator -->
          <div class="text-center" v-if="loading && posts.length > 0">
            <p><i class="bi bi-arrow-repeat spin"></i> Loading more posts...</p>
          </div>
        </div>
      </div>

      <!-- Right Column: Widgets -->
      <div class="col-lg-4">
        <Markets />
        <LatestArticles />
      </div>
    </div>
  </div>
</template>

<script>
import axios from 'axios';
import { categories } from '../../categories'; 
import Markets from '../widgets/Markets.vue';
import LatestArticles from '../widgets/LatestArticles.vue';
import PostCard from './PostCard.vue';
import PostCardSkeleton from './PostCardSkeleton.vue';

export default {
  components: {
    Markets,
    LatestArticles,
    PostCard,
    PostCardSkeleton,
  },
  props: {
    slug: {
      type: String,
      required: true,
    },
  },
  data() {
    return {
      category: {},
      posts: [],
      loading: true,
      currentPage: 1,
      totalPages: 1,
      categoryIcons: {
        technology: 'bi bi-cpu',
      },
    };
  },
  computed: {
    // Determine the icon based on the category slug
    categoryIcon() {
      return this.categoryIcons[this.category.slug] || 'bi bi-folder';
    },
  },
  methods: {
    /**
     * Find the category based on the slug prop.
     */
    getCategory() {
      this.category = categories.find(cat => cat.slug === this.slug);
      if (!this.category) {
        // Handle category not found by redirecting to 404
        window.location.href = '/404';
      }
    },
    
    /**
     * Fetch posts from the backend API.
     * @param {Number} page - The page number to fetch.
     * @param {Boolean} append - Whether to append the fetched posts to existing posts.
     */
    async fetchPosts(page = 1, append = false) {
      if (!this.category.wp_id) return;

      this.loading = true;
      try {
        const response = await axios.get('/api/fetch-wordpress-posts', {
          params: {
            categories: this.category.wp_id,
            per_page: 10,
            page: page,
          },
          withCredentials: true,
        });
        
        if (response.data.posts) {
          if (append) {
            this.posts = [...this.posts, ...response.data.posts];
          } else {
            this.posts = response.data.posts;
          }
          this.totalPages = parseInt(response.data.total_pages, 10);
          this.currentPage = page;
        } else {
          this.posts = [];
        }
      } catch (error) {
        console.error(`Error fetching posts for category ${this.category.name}:`, error);
        this.posts = [];
      } finally {
        this.loading = false;
      }
    },
    
    /**
     * Load more posts by fetching the next page.
     */
    loadMorePosts() {
      if (this.currentPage < this.totalPages && !this.loading) {
        this.fetchPosts(this.currentPage + 1, true);
      }
    },
  },
  watch: {
    /**
     * Watch for changes in the slug prop to fetch new category posts.
     */
    slug(newSlug, oldSlug) {
      if (newSlug !== oldSlug) {
        this.getCategory();
        this.posts = [];
        this.currentPage = 1;
        this.totalPages = 1;
        this.fetchPosts();
      }
    },
  },
  created() {
    this.getCategory();
    this.fetchPosts();
  },
};
</script>

<style scoped>
.icon-heading {
  display: flex;
  align-items: center;
}

.spin {
  animation: spin 1s linear infinite;
}

@keyframes spin {
  100% {
    transform: rotate(360deg);
  }
}
</style>
