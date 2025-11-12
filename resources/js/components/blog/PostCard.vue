<template>
  <div class="card h-100">
    <img :src="post.featured_media_url" class="card-img-top" alt="Post Image" v-if="post.featured_media_url">
    <div class="card-body d-flex flex-column">
      <h5 class="card-title">{{ cleanTitle }}</h5>
      <p class="card-text" v-if="cleanExcerpt" v-html="cleanExcerpt"></p>
      
      <!-- Author and Date Section -->
      <div class="mt-auto">
        <div class="d-flex justify-content-between align-items-center">
          <div class="author-date">
            <!-- Author Name with Dead Link -->
            <a :href="`/author/${post.author_info.id}/${formatAuthorName}`" class="text-decoration-none text-muted me-3">
              <i class="bi bi-person me-1"></i>{{ post.author_info.name }}
            </a>
            <!-- Published Date -->
            <span class="text-muted">
              <i class="bi bi-calendar-event me-1"></i>{{ formattedDate }}
            </span>
          </div>
          <!-- Read More Button with Icon -->
          <router-link :to="postLink" class="btn btn-primary btn-sm read-more-btn">
            Read More <i class="bi bi-arrow-right-circle"></i>
          </router-link>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import { decode } from 'html-entities';

export default {
  props: {
    post: {
      type: Object,
      required: true,
    },
    categorySlug: {
      type: String,
      required: true,
    },
  },
  computed: {
    /**
     * Clean the post title by decoding HTML entities.
     */
    cleanTitle() {
      if (!this.post.title) return '';
      return decode(this.post.title);
    },
    /**
     * Clean the excerpt by removing 'Read more' link.
     */
    cleanExcerpt() {
      if (!this.post.excerpt) return '';
      // Remove 'Read more' link using regex
      return this.post.excerpt.replace(/<a[^>]*>Read more<\/a>/i, '');
    },
    /**
     * Generate the router-link to the individual post.
     */
    postLink() {
      return `/blog/${this.categorySlug}/${this.post.slug}`;
    },
    /**
     * Format the published date.
     */
    formattedDate() {
      if (!this.post.date) return '';
      const options = { year: 'numeric', month: 'long', day: 'numeric' };
      return new Date(this.post.date).toLocaleDateString(undefined, options);
    },
    formatAuthorName() {
        return this.post.author_info.name.replace(/\s+/g, '-');
    },
  },
};
</script>

<style scoped>
.card-img-top {
  height: 200px;
  object-fit: cover;
}

.author-date a {
  display: inline-flex;
  align-items: center;
}

.author-date span {
  display: inline-flex;
  align-items: center;
}

.read-more-btn {
  display: inline-flex;
  align-items: center;
  justify-content: center;
  gap: 0.5rem;
  white-space: nowrap;
  padding-left: 1rem;
  padding-right: 1rem;
}
</style>
