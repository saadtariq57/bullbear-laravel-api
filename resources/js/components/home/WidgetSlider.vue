<template>
  <div class="widgets-slide-section">
    <div v-if="widget" class="widgets-slide-wrapper position-relative z-3">
      <div class="widgets-slider mb-0">
        <div v-for="symbol in widget.symbols" :key="symbol.id" class="market-summary">
          <a :href="'/quotes/' + symbol.symbol" class="d-flex justify-content-center align-items-center gap-3">
            <div class="brand-icon">
              <img v-if="symbol.logo" :src="symbol.logo" :alt="symbol.name">
              <span v-else>{{ symbol.symbol }}</span>
            </div>
            <div class="market-data">
              <h3 class="lh-1">
                <span class="fw-bolder fs-16">{{ symbol.name }}</span><br>
                <span class="fw-bolder fs-16">{{ formatPrice(symbol.price) }}</span>
              </h3>
              <div :class="[
                { 'Green': isPositive(symbol.change), 'Red': isNegative(symbol.change) },
                'fs-14', 'fw-bolder', 'text-start'
              ]">
                <span>{{ formatChange(symbol.change) }}</span>
                <span>({{ formatChangePercent(symbol.change_percent) }})</span>
              </div>
            </div>
          </a>
        </div>
      </div>
    </div>
    <div v-else-if="error" class="error-message">
      {{ error }}
    </div>
    <div v-else class="widgets-slide-wrapper position-relative z-3">
      <div class="widgets-slider mb-0">
        <div v-for="n in 5" :key="n" class="market-summary">
          <div class="d-flex justify-content-center align-items-center gap-3">
            <div class="brand-icon loading-animation" style="width: 40px; height: 40px;"></div>
            <div class="market-data">
              <h3 class="lh-1">
                <span class="fw-bolder fs-16 loading-animation" style="width: 80px; height: 16px; display: inline-block;"></span><br>
                <span class="fw-bolder fs-16 loading-animation" style="width: 60px; height: 16px; display: inline-block;"></span>
              </h3>
              <div class="fs-14 fw-bolder text-start">
                <span class="loading-animation" style="width: 40px; height: 14px; display: inline-block;"></span>
                <span class="loading-animation" style="width: 50px; height: 14px; display: inline-block; margin-left: 4px;"></span>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import { ref, onMounted, nextTick } from 'vue';
import axios from 'axios';

export default {
    props: {
        widgetId: {
            type: Number,
            required: true
        }
    },
    setup(props) {
        const widget = ref(null);
        const error = ref(null);

        const fetchWidgetData = async () => {
            try {
                const response = await axios.get(`/api/widget/${props.widgetId}`);
                console.log("Hello");
                
                console.log("response.data", response.data);
                widget.value = response.data;
                await nextTick();
                initSlider();
            } catch (err) {
                console.error('Error fetching widget data:', err);
                if (err.response) {
                    error.value = err.response.data.error || 'An error occurred while fetching data';
                } else if (err.request) {
                    error.value = 'No response received from the server';
                } else {
                    error.value = 'An error occurred while setting up the request';
                }
            }
        };

        const initSlider = () => {
            $('.widgets-slider').slick({
                dots: false,
                infinite: true,
                speed: 1000,
                autoplay: true,
                slidesToShow: 4,
                slidesToScroll: 1,
                responsive: [
                    {
                        breakpoint: 1200,
                        settings: {
                            slidesToShow: 4,
                            slidesToScroll: 1,
                            infinite: true,
                            autoplay: true,
                            dots: false
                        }
                    },
                    {
                        breakpoint: 992,
                        settings: {
                            slidesToShow: 3,
                            slidesToScroll: 1,
                            autoplay: true,
                        }
                    },
                    {
                        breakpoint: 650,
                        settings: {
                            slidesToShow: 2,
                            slidesToScroll: 1,
                            autoplay: true,
                            arrows: false,
                        }
                    },
                    {
                        breakpoint: 400,
                        settings: {
                            slidesToShow: 1,
                            slidesToScroll: 1,
                            autoplay: true,
                            arrows: false,
                        }
                    }
                ]
            });
        };

        const formatPrice = (price) => {
            return price !== null && price !== undefined ? parseFloat(price).toFixed(2) : 'N/A';
        };

        const formatChange = (change) => {
            return change !== null && change !== undefined ? parseFloat(change).toFixed(2) : 'N/A';
        };

        const formatChangePercent = (changePercent) => {
            return changePercent !== null && changePercent !== undefined ? `${parseFloat(changePercent).toFixed(2)}%` : 'N/A';
        };

        const isPositive = (value) => {
            return value !== null && value !== undefined && parseFloat(value) > 0;
        };

        const isNegative = (value) => {
            return value !== null && value !== undefined && parseFloat(value) < 0;
        };

        onMounted(() => {
            fetchWidgetData();
        });

        return {
            widget,
            error,
            formatPrice,
            formatChange,
            formatChangePercent,
            isPositive,
            isNegative
        };
    }
}
</script>
<style scoped>
.loading-animation {
  background: linear-gradient(90deg, #e8e8e8 25%, #d8d8d8 50%, #e8e8e8 75%);
  background-size: 200% 100%;
  animation: loading 1.5s infinite;
}

@keyframes loading {
  0% { background-position: 200% 0; }
  100% { background-position: -200% 0; }
}

.market-summary {
  width: 200px; 
  margin: 0 10px;
}

</style>