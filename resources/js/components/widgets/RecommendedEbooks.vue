<template>
  <div class="recommended-ebooks-wrapper bg-white p-3 border-1 border rounded-2 shadow-sm">
    <div class="text-center">
      <h3 class="fw-bold text-uppercase">
        RECOMMENDED E-BOOKS <span class="videos-count fs-12 fw-light">({{ ebooks.length }})</span>
      </h3>
      <div class="border-heading d-inline-block mt-4 mb-3"></div>
    </div>
    <div v-if="ebooks.length > 0" class="recommended-ebooks-slider pb-3" ref="slider">
      <!-- Using Slick Slider -->
      <div
        v-for="(ebook, index) in ebooks"
        :key="ebook.id"
        class="ebooks-slider-wrapper px-0 py-3"
      >
        <div class="d-md-flex gap-3 align-items-center">
          <div class="ebook-img">
            <img :src="ebook.icon_url" alt="ebook cover" />
          </div>
          <div class="ebook-desc">
            <h2 class="fs-6 mb-0 lh-base">{{ ebook.title }}</h2>
            <!-- <p>ebook.description</p> -->
            <div class="text-center">
              <button
                class="btn btn-primary btn-sidebar fw-bold"
                @click="downloadEbook(ebook.id)"
              >
                Download Now
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><path d="M288 32c0-17.7-14.3-32-32-32s-32 14.3-32 32l0 242.7-73.4-73.4c-12.5-12.5-32.8-12.5-45.3 0s-12.5 32.8 0 45.3l128 128c12.5 12.5 32.8 12.5 45.3 0l128-128c12.5-12.5 12.5-32.8 0-45.3s-32.8-12.5-45.3 0L288 274.7 288 32zM64 352c-35.3 0-64 28.7-64 64l0 32c0 35.3 28.7 64 64 64l384 0c35.3 0 64-28.7 64-64l0-32c0-35.3-28.7-64-64-64l-101.5 0-45.3 45.3c-25 25-65.5 25-90.5 0L165.5 352 64 352zm368 56a24 24 0 1 1 0 48 24 24 0 1 1 0-48z"/></svg>
              </button>
            </div>
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
import { mapState, mapActions } from 'vuex';
import { registerVuexModule, unregisterVuexModule } from '@/stores/registerModule';
import subscriptionStatusModule from '@/stores/subscriptionStatus';

export default {
  name: "RecommendedEbooks",
  data() {
    return {
      ebooks: [],
      loading: false,
    };
  },
  computed: {
    // Map Vuex state to computed properties
    ...mapState({
      isAuthenticated: state => state.subscriptionStatus.isAuthenticated,
    }),
  },
  methods: {
    ...mapActions('subscriptionStatus', ['fetchSubscriptionStatus']),
    async fetchRecommendedEbooks() {
      this.loading = true;
      try {
        const response = await axios.get('/api/ebooks/recommended');
        this.ebooks = response.data;
      } catch (error) {
        console.error('Error fetching E-books:', error);
      } finally {
        this.loading = false;
      }
    },
    initSlickSlider() {
      if (this.$refs.slider) {
        $(this.$refs.slider).slick({
          dots: true,
          arrows: false,
          infinite: true,
          speed: 1000,
          slidesToShow: 1,
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
            window.location.href = '/upgrade';
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
  },
  mounted() {
    registerVuexModule('subscriptionStatus', subscriptionStatusModule);
    this.fetchSubscriptionStatus().then(() => {
      this.fetchRecommendedEbooks();
    });

    this.$nextTick(() => {
      this.initSlickSlider();
    });
  },
  beforeUnmount() {
    unregisterVuexModule('subscriptionStatus');
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
  }
};
</script>

<style scoped>
.recommended-ebooks-wrapper {
  /* Add any styles if necessary */
}
.ebook-img img {
  max-width: 90px;
  height: auto;
}
.ebook-desc {
  flex-grow: 1;
}
/* Override Slick default styles if necessary */
.slick-slide {
  margin: 0 10px;
}

.ebooks-slider-wrapper {
  /* Optional: Add any additional styling for the slider items */
}
.btn-sidebar{
  padding: 7px 15px;
  margin-top: 15px;
}
.btn-sidebar svg{
  width: 12px;
  margin-left: 7px;
}
.btn-sidebar svg path{
  fill: #ffffff;
}

</style>
