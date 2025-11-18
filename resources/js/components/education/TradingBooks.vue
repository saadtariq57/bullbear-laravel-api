<template>
  <div class="trading-books-wrapper bg-white px-5 pt-3 pb-4 border-1 border rounded-2 shadow-sm">
    <div class="text-center">
      <h1 class="fw-bold fs-1 text-uppercase">
        TRADING BOOKS <span class="videos-count fs-12 fw-light">({{ ebooks.length }})</span>
      </h1>
      <div class="border-heading d-inline-block mt-4 mb-3"></div>
    </div>
    <div v-if="ebooks.length > 0" class="trading-books-slider" ref="slider">
      <!-- Using Slick Slider -->
      <div
        v-for="(ebook, index) in ebooks"
        :key="ebook.id"
        class="books-slider-wrapper card px-2 py-3"
      >
        <div class="d-md-flex gap-4 align-items-center">
          <div class="book-img">
            <img :src="ebook.icon_url" alt="book cover" />
          </div>
          <div class="book-dic">
            <h2 class="pt-2 fs-6 mb-0 lh-base">{{ ebook.title }}</h2>
            <p>{{ ebook.description }}</p>
            <button
              class="btn btn-primary"
              @click="downloadEbook(ebook.id)"
            >
              Download Now
            </button>
          </div>
        </div>
      </div>
    </div>
    <div v-else class="text-center">
      <p>No E-books available.</p>
    </div>
  </div>
</template>

<script>
import axios from 'axios';
import Swal from 'sweetalert2';

export default {
  props: {
    ebooks: {
      type: Array,
      required: true
    },
    isAuthenticated: {
      type: Boolean,
      default: false,
    },
  },
  mounted() {
    this.$nextTick(() => {
      this.initSlickSlider();
    });
  },
  watch: {
    ebooks(newEbooks, oldEbooks) {
      if (newEbooks.length !== oldEbooks.length) {
        this.$nextTick(() => {
          this.refreshSlickSlider();
        });
      }
    }
  },
  beforeDestroy() {
    this.destroySlickSlider();
  },
  methods: {
    initSlickSlider() {
      if (this.$refs.slider) {
        $(this.$refs.slider).slick({
          dots: false,
          infinite: true,
          speed: 1000,
          slidesToShow: 2,
          slidesToScroll: 1,
          responsive: [
            {
              breakpoint: 1024,
              settings: {
                slidesToShow: 1,
                slidesToScroll: 1,
                infinite: true,
                dots: true
              }
            },
            {
              breakpoint: 600,
              settings: {
                slidesToShow: 1,
                slidesToScroll: 1
              }
            }
          ]
        });
      }
    },
    refreshSlickSlider() {
      this.destroySlickSlider();
      this.initSlickSlider();
    },
    destroySlickSlider() {
      if (this.$refs.slider && $(this.$refs.slider).hasClass('slick-initialized')) {
        $(this.$refs.slider).slick('unslick');
      }
    },
    async downloadEbook(ebookId) {
      if (!this.isAuthenticated) {
        // Prompt user to login
        Swal.fire({
          title: 'Login Required',
          text: 'You need to login to download E-books.',
          icon: 'info',
          showCancelButton: true,
          confirmButtonText: 'Login',
          cancelButtonText: 'Cancel'
        }).then((result) => {
          if (result.isConfirmed) {
            window.location.href = '/login';
          }
        });
        return;
      }

      try {
        const response = await axios.get(`/api/ebooks/download/${ebookId}`, {
          responseType: 'blob'
        });
        const url = window.URL.createObjectURL(new Blob([response.data]));
        const link = document.createElement('a');
        link.href = url;

        // Extract filename from headers if available
        const contentDisposition = response.headers['content-disposition'];
        let filename = 'ebook.pdf';
        if (contentDisposition) {
          const match = contentDisposition.match(/filename="?(.+)"?/);
          if (match) filename = match[1];
        }

        link.setAttribute('download', filename);
        document.body.appendChild(link);
        link.click();
        link.remove();
      } catch (error) {
        console.error('Error downloading E-book:', error);
        this.handleDownloadError(error);
      }
    },
    handleDownloadError(error) {
      if (error.response && error.response.status === 403) {
        Swal.fire({
          title: 'Access Denied',
          text: 'You do not have permission to download this E-book. Please upgrade your subscription.',
          icon: 'warning',
          confirmButtonText: 'Upgrade',
          showCancelButton: true,
          cancelButtonText: 'Cancel'
        }).then((result) => {
          if (result.isConfirmed) {
            window.location.href = '/pricing';
          }
        });
      } else if (error.response && error.response.status === 401) {
        Swal.fire({
          title: 'Login Required',
          text: 'You need to login to download E-books.',
          icon: 'info',
          showCancelButton: true,
          confirmButtonText: 'Login',
          cancelButtonText: 'Cancel'
        }).then((result) => {
          if (result.isConfirmed) {
            window.location.href = '/login';
          }
        });
      } else {
        Swal.fire({
          title: 'Error',
          text: 'Failed to download E-book.',
          icon: 'error',
          confirmButtonText: 'OK'
        });
      }
    }
  }
};
</script>

<style scoped>
.trading-books-wrapper {
  max-width: 1200px;
  margin: 0 auto;
}
.book-img img {
  max-width: 100px;
  height: auto;
}
.book-dic {
  flex-grow: 1;
}
/* Override Slick default styles if necessary */
.slick-slide {
  margin: 0 10px;
}
.slick-prev:before,
.slick-next:before {
  color: #000;
}
.books-slider-wrapper {
  /* Optional: Add any additional styling for the slider items */
}
</style>
