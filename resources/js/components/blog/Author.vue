<template>
  <div class="container my-4">
    <div class="row">
      <!-- Left Column: Author Profile and Posts -->
      <div class="col-lg-8">
        <!-- Author Profile Header -->
        <div class="mb-5 border-bottom d-flex align-items-center">
          <img
            v-if="author.avatar_url"
            :src="author.avatar_url"
            alt="Author Avatar"
            class="me-3 rounded-circle"
            width="80"
            height="80"
          />
          <div>
            <h1 class="fs-1 fw-bold">{{ author.name }}</h1>
            <p class="text-muted">{{ author.description }}</p>
          </div>
        </div>

        <!-- Posts Section -->

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
          <p>No posts available for this author.</p>
        </div>

        <!-- Actual Posts -->
        <div class="row" v-else>
          <div class="col-md-6 mb-4" v-for="post in posts" :key="post.id">
            <PostCard :post="post" :category-slug="post.category_slug" />
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
    id: {
      type: String,
      required: true,
    },
    name: {
      type: String,
      required: true,
    },
  },
  data() {
    return {
      author: {
        name: '',
        description: '',
        avatar_url: '',
      },
      posts: [],
      loading: true,
      currentPage: 1,
      totalPages: 1,
    };
  },
  methods: {
    /**
     * Fetch author information and their posts.
     */
    async fetchAuthorData(page = 1, append = false) {
      this.loading = true;
      try {
        const response = await axios.get('/api/fetch-author-posts', {
          params: {
            author_id: this.id,
            per_page: 10,
            page: page,
          },
          withCredentials: true,
        });

        if (response.data.author) {
          this.author = response.data.author;
        }

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
        console.error(`Error fetching posts for author ID ${this.authorId}:`, error);
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
        this.fetchAuthorData(this.currentPage + 1, true);
      }
    },
  },
  watch: {
    /**
     * Watch for changes in the authorId prop to fetch new author data.
     */
    authorId(newId, oldId) {
      if (newId !== oldId) {
        this.posts = [];
        this.currentPage = 1;
        this.totalPages = 1;
        this.fetchAuthorData();
      }
    },
  },
  created() {
    this.fetchAuthorData();
  },
};
</script>

<style scoped>
.spin {
  animation: spin 1s linear infinite;
}

@keyframes spin {
  100% {
    transform: rotate(360deg);
  }
}
</style>
