<template>
  <div class="container-xxl pt-4 position-relative">
    <!-- Coming Soon Overlay -->
    <div v-if="showComingSoonOverlay" class="coming-soon-overlay">
      <div class="coming-soon-content">
        <div class="coming-soon-icon">
          <i class="bi bi-gear-fill"></i>
        </div>
        <h2 class="coming-soon-title">Coming Soon</h2>
        <p class="coming-soon-text">
          We're working hard to bring you real-time deep analysis data.<br>
          Stay tuned for dynamic insights and live market intelligence.
        </p>
        <div class="coming-soon-features">
          <button 
                class="btn btn-outline-primary fw-6 me-2 fs-12"
                @click="goBackToQuote"
                data-bs-toggle="tooltip" 
                data-bs-placement="top" 
                title="Back to stock quote"
              >
                <i class="bi bi-arrow-left me-2"></i>Back to Quote
              </button>
          <!-- <div class="feature-item">
            <i class="bi bi-check-circle-fill"></i>
            <span>Real-time Technical Indicators</span>
          </div>
          <div class="feature-item">
            <i class="bi bi-check-circle-fill"></i>
            <span>Live Fundamental Analysis</span>
          </div>
          <div class="feature-item">
            <i class="bi bi-check-circle-fill"></i>
            <span>Dynamic Market Sentiment</span>
          </div>
          <div class="feature-item">
            <i class="bi bi-check-circle-fill"></i>
            <span>Personalized Risk Assessment</span>
          </div> -->
        </div>
      </div>
    </div>

    <div class="row" :class="{ 'content-blur': showComingSoonOverlay }">
      <div class="col-lg-8 col-md-12">
        <!-- Header Section -->
        <div class="deep-analysis-header card shadow p-4 mb-4">
          <div class="d-flex justify-content-between align-items-center">
            <div>
              <h1 class="mb-3">
                <i class="bi bi-graph-up-arrow me-2 text-primary"></i>
                <span class="text-black fs-2 fw-bolder">Deep Analysis</span>
              </h1>
              <h2 class="text-secondary fs-4">{{ symbol }}</h2>
              <p class="text-muted mb-0">Comprehensive analytical insights and advanced metrics</p>
            </div>
            <div>
              <button 
                class="btn btn-outline-primary fw-6 me-2 fs-12"
                @click="goBackToQuote"
                data-bs-toggle="tooltip" 
                data-bs-placement="top" 
                title="Back to stock quote"
              >
                <i class="bi bi-arrow-left me-2"></i>Back to Quote
              </button>
            </div>
          </div>
        </div>

        <!-- Analysis Sections -->
        <div class="analysis-sections">
          <!-- Technical Analysis Section -->
          <div class="analysis-card card shadow mb-4">
            <div class="card-header bg-primary text-white">
              <h3 class="card-title mb-0">
                <i class="bi bi-bar-chart-line me-2"></i>Technical Analysis
              </h3>
            </div>
            <div class="card-body">
              <div class="row g-4">
                <div class="col-lg-6">
                  <div class="metric-widget p-3 bg-light rounded">
                    <h5 class="fw-bold text-primary">RSI (14)</h5>
                    <div class="d-flex align-items-center">
                      <span class="fs-2 fw-bold me-3">67.3</span>
                      <span class="badge bg-warning">Neutral</span>
                    </div>
                    <div class="progress mt-2" style="height: 8px;">
                      <div class="progress-bar bg-warning" style="width: 67.3%"></div>
                    </div>
                  </div>
                </div>
                <div class="col-lg-6">
                  <div class="metric-widget p-3 bg-light rounded">
                    <h5 class="fw-bold text-primary">MACD</h5>
                    <div class="d-flex align-items-center">
                      <span class="fs-2 fw-bold me-3">+2.14</span>
                      <span class="badge bg-success">Bullish</span>
                    </div>
                    <small class="text-muted">Signal: +1.87</small>
                  </div>
                </div>
                <div class="col-lg-6">
                  <div class="metric-widget p-3 bg-light rounded">
                    <h5 class="fw-bold text-primary">Bollinger Bands</h5>
                    <div class="text-center">
                      <div class="text-muted">Upper: $156.78</div>
                      <div class="fw-bold fs-5">Middle: $152.34</div>
                      <div class="text-muted">Lower: $147.90</div>
                    </div>
                  </div>
                </div>
                <div class="col-lg-6">
                  <div class="metric-widget p-3 bg-light rounded">
                    <h5 class="fw-bold text-primary">Moving Averages</h5>
                    <div class="small">
                      <div class="d-flex justify-content-between">
                        <span>SMA 20:</span>
                        <span class="fw-bold">$151.23</span>
                      </div>
                      <div class="d-flex justify-content-between">
                        <span>SMA 50:</span>
                        <span class="fw-bold">$148.90</span>
                      </div>
                      <div class="d-flex justify-content-between">
                        <span>EMA 12:</span>
                        <span class="fw-bold">$152.75</span>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>

          <!-- Fundamental Analysis Section -->
          <!-- <div class="analysis-card card shadow mb-4">
            <div class="card-header bg-success text-white">
              <h3 class="card-title mb-0">
                <i class="bi bi-calculator me-2"></i>Fundamental Analysis
              </h3>
            </div>
            <div class="card-body">
              <div class="row g-4">
                <div class="col-lg-4">
                  <div class="fundamental-metric text-center p-3 border rounded">
                    <i class="bi bi-pie-chart-fill fs-1 text-success mb-2"></i>
                    <h6 class="fw-bold">P/E Ratio</h6>
                    <div class="fs-4 fw-bold text-success">24.5</div>
                    <small class="text-muted">Industry Avg: 22.1</small>
                  </div>
                </div>
                <div class="col-lg-4">
                  <div class="fundamental-metric text-center p-3 border rounded">
                    <i class="bi bi-cash-stack fs-1 text-primary mb-2"></i>
                    <h6 class="fw-bold">EPS (TTM)</h6>
                    <div class="fs-4 fw-bold text-primary">$6.23</div>
                    <small class="text-success">+12.5% YoY</small>
                  </div>
                </div>
                <div class="col-lg-4">
                  <div class="fundamental-metric text-center p-3 border rounded">
                    <i class="bi bi-graph-up fs-1 text-warning mb-2"></i>
                    <h6 class="fw-bold">ROE</h6>
                    <div class="fs-4 fw-bold text-warning">18.7%</div>
                    <small class="text-muted">Excellent</small>
                  </div>
                </div>
              </div>
              
              <hr class="my-4">
              
              <div class="row g-3">
                <div class="col-md-6">
                  <div class="d-flex justify-content-between border-bottom pb-2">
                    <span>Revenue (TTM):</span>
                    <span class="fw-bold">$394.3B</span>
                  </div>
                </div>
                <div class="col-md-6">
                  <div class="d-flex justify-content-between border-bottom pb-2">
                    <span>Gross Margin:</span>
                    <span class="fw-bold">43.3%</span>
                  </div>
                </div>
                <div class="col-md-6">
                  <div class="d-flex justify-content-between border-bottom pb-2">
                    <span>Debt to Equity:</span>
                    <span class="fw-bold">1.73</span>
                  </div>
                </div>
                <div class="col-md-6">
                  <div class="d-flex justify-content-between border-bottom pb-2">
                    <span>Current Ratio:</span>
                    <span class="fw-bold">1.06</span>
                  </div>
                </div>
              </div>
            </div>
          </div> -->

          <!-- Sentiment Analysis Section -->
          <!-- <div class="analysis-card card shadow mb-4">
            <div class="card-header bg-info text-white">
              <h3 class="card-title mb-0">
                <i class="bi bi-chat-dots me-2"></i>Market Sentiment
              </h3>
            </div>
            <div class="card-body">
              <div class="row g-4">
                <div class="col-lg-4">
                  <div class="sentiment-widget text-center">
                    <div class="sentiment-circle mx-auto mb-3" style="width: 120px; height: 120px; background: conic-gradient(#28a745 0deg 216deg, #dc3545 216deg 360deg); border-radius: 50%; display: flex; align-items: center; justify-content: center;">
                      <div class="bg-white rounded-circle d-flex align-items-center justify-content-center" style="width: 90px; height: 90px;">
                        <div class="text-center">
                          <div class="fs-5 fw-bold text-success">60%</div>
                          <small class="text-muted">Bullish</small>
                        </div>
                      </div>
                    </div>
                    <h6 class="fw-bold">Overall Sentiment</h6>
                  </div>
                </div>
                <div class="col-lg-8">
                  <div class="sentiment-breakdown">
                    <h6 class="fw-bold mb-3">Analyst Recommendations</h6>
                    <div class="recommendation-item d-flex justify-content-between mb-2">
                      <span>Strong Buy:</span>
                      <span class="fw-bold text-success">8</span>
                    </div>
                    <div class="recommendation-item d-flex justify-content-between mb-2">
                      <span>Buy:</span>
                      <span class="fw-bold text-success">12</span>
                    </div>
                    <div class="recommendation-item d-flex justify-content-between mb-2">
                      <span>Hold:</span>
                      <span class="fw-bold text-warning">5</span>
                    </div>
                    <div class="recommendation-item d-flex justify-content-between mb-2">
                      <span>Sell:</span>
                      <span class="fw-bold text-danger">2</span>
                    </div>
                    <div class="recommendation-item d-flex justify-content-between">
                      <span>Strong Sell:</span>
                      <span class="fw-bold text-danger">1</span>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div> -->

          <!-- Risk Analysis Section -->
          <!-- <div class="analysis-card card shadow mb-4">
            <div class="card-header bg-warning text-dark">
              <h3 class="card-title mb-0">
                <i class="bi bi-exclamation-triangle me-2"></i>Risk Analysis
              </h3>
            </div>
            <div class="card-body">
              <div class="row g-4">
                <div class="col-lg-6">
                  <div class="risk-metric">
                    <h6 class="fw-bold">Beta (5Y Monthly)</h6>
                    <div class="d-flex align-items-center">
                      <span class="fs-3 fw-bold me-3">1.28</span>
                      <span class="badge bg-warning">High Volatility</span>
                    </div>
                    <small class="text-muted">28% more volatile than market</small>
                  </div>
                </div>
                <div class="col-lg-6">
                  <div class="risk-metric">
                    <h6 class="fw-bold">52-Week Volatility</h6>
                    <div class="d-flex align-items-center">
                      <span class="fs-3 fw-bold me-3">31.2%</span>
                      <span class="badge bg-secondary">Moderate</span>
                    </div>
                    <small class="text-muted">Historical volatility measure</small>
                  </div>
                </div>
              </div>
              
              <hr class="my-4">
              
              <div class="risk-factors">
                <h6 class="fw-bold mb-3">Key Risk Factors</h6>
                <div class="row g-3">
                  <div class="col-md-6">
                    <div class="risk-factor-item p-2 border-start border-warning border-3">
                      <strong>Market Risk:</strong> High correlation with tech sector
                    </div>
                  </div>
                  <div class="col-md-6">
                    <div class="risk-factor-item p-2 border-start border-info border-3">
                      <strong>Liquidity Risk:</strong> Low - highly liquid stock
                    </div>
                  </div>
                  <div class="col-md-6">
                    <div class="risk-factor-item p-2 border-start border-danger border-3">
                      <strong>Credit Risk:</strong> Medium - moderate debt levels
                    </div>
                  </div>
                  <div class="col-md-6">
                    <div class="risk-factor-item p-2 border-start border-success border-3">
                      <strong>Operational Risk:</strong> Low - stable operations
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div> -->
        </div>
      </div>
      
      <!-- Sidebar -->
      <div class="col-lg-4">
        <div class="analysis-sidebar">
          <!-- Quick Stats Widget -->
          <div class="card shadow mb-4">
            <div class="card-header">
              <h5 class="card-title mb-0">
                <i class="bi bi-speedometer2 me-2"></i>Quick Stats
              </h5>
            </div>
            <div class="card-body">
              <div class="quick-stat mb-3">
                <div class="d-flex justify-content-between">
                  <span>Analysis Score:</span>
                  <span class="fw-bold text-success">8.2/10</span>
                </div>
                <div class="progress mt-1" style="height: 6px;">
                  <div class="progress-bar bg-success" style="width: 82%"></div>
                </div>
              </div>
              <div class="quick-stat mb-3">
                <div class="d-flex justify-content-between">
                  <span>Growth Potential:</span>
                  <span class="fw-bold text-primary">High</span>
                </div>
              </div>
              <div class="quick-stat mb-3">
                <div class="d-flex justify-content-between">
                  <span>Risk Level:</span>
                  <span class="fw-bold text-warning">Medium</span>
                </div>
              </div>
              <div class="quick-stat">
                <div class="d-flex justify-content-between">
                  <span>Time Horizon:</span>
                  <span class="fw-bold">Long-term</span>
                </div>
              </div>
            </div>
          </div>

          <!-- Price Targets Widget -->
          <div class="card shadow mb-4">
            <div class="card-header">
              <h5 class="card-title mb-0">
                <i class="bi bi-bullseye me-2"></i>Price Targets
              </h5>
            </div>
            <div class="card-body">
              <div class="price-target mb-3">
                <div class="d-flex justify-content-between">
                  <span>High Target:</span>
                  <span class="fw-bold text-success">$175.00</span>
                </div>
              </div>
              <div class="price-target mb-3">
                <div class="d-flex justify-content-between">
                  <span>Average Target:</span>
                  <span class="fw-bold">$165.50</span>
                </div>
              </div>
              <div class="price-target mb-3">
                <div class="d-flex justify-content-between">
                  <span>Low Target:</span>
                  <span class="fw-bold text-danger">$145.00</span>
                </div>
              </div>
              <div class="price-target">
                <div class="d-flex justify-content-between">
                  <span>Current Price:</span>
                  <span class="fw-bold">$152.34</span>
                </div>
              </div>
            </div>
          </div>

          <!-- Recent Analysis Widget -->
          <div class="card shadow mb-4">
            <div class="card-header">
              <h5 class="card-title mb-0">
                <i class="bi bi-clock-history me-2"></i>Recent Updates
              </h5>
            </div>
            <div class="card-body">
              <div class="timeline">
                <div class="timeline-item mb-3">
                  <div class="timeline-marker bg-primary"></div>
                  <div class="timeline-content">
                    <strong>Technical Signal:</strong> Golden Cross formed
                    <div class="text-muted small">2 hours ago</div>
                  </div>
                </div>
                <div class="timeline-item mb-3">
                  <div class="timeline-marker bg-success"></div>
                  <div class="timeline-content">
                    <strong>Earnings Beat:</strong> Q4 results exceeded expectations
                    <div class="text-muted small">1 day ago</div>
                  </div>
                </div>
                <div class="timeline-item">
                  <div class="timeline-marker bg-info"></div>
                  <div class="timeline-content">
                    <strong>Analyst Upgrade:</strong> Morgan Stanley raised to Buy
                    <div class="text-muted small">3 days ago</div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import { defineComponent, ref, onMounted } from 'vue';
import { useRoute, useRouter } from 'vue-router';

export default defineComponent({
  name: 'DeepAnalysis',
  setup() {
    const route = useRoute();
    const router = useRouter();
    const symbol = ref('');
    const showComingSoonOverlay = ref(true); // Set to false when implementing dynamic data

    const goBackToQuote = () => {
      router.push(`/quotes/${symbol.value}`);
    };

    const initializeTooltips = () => {
      // Initialize Bootstrap tooltips
      if (typeof bootstrap !== 'undefined') {
        const tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
        tooltipTriggerList.map(function (tooltipTriggerEl) {
          return new bootstrap.Tooltip(tooltipTriggerEl, {
            trigger: 'hover focus',
            fallbackPlacements: ['top', 'right', 'bottom', 'left'],
          });
        });
      }
    };

    onMounted(() => {
      symbol.value = route.params.symbol;
      initializeTooltips();
    });

    return {
      symbol,
      goBackToQuote,
      showComingSoonOverlay
    };
  }
});
</script>

<style scoped>
/* Deep Analysis Specific Styles */
.deep-analysis-header {
  background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);
  border-radius: 10px;
}

.analysis-card {
  border-radius: 10px;
  overflow: hidden;
}

.analysis-card .card-header {
  border: none;
  padding: 1rem 1.5rem;
}

.metric-widget {
  transition: transform 0.2s ease, box-shadow 0.2s ease;
  border-radius: 8px;
}

.metric-widget:hover {
  transform: translateY(-2px);
  box-shadow: 0 4px 12px rgba(0,0,0,0.1);
}

.fundamental-metric {
  transition: transform 0.2s ease;
}

.fundamental-metric:hover {
  transform: scale(1.02);
}

.sentiment-circle {
  position: relative;
}

.sentiment-widget .sentiment-circle::before {
  content: '';
  position: absolute;
  top: 10px;
  left: 10px;
  right: 10px;
  bottom: 10px;
  background: white;
  border-radius: 50%;
}

.risk-factor-item {
  background: rgba(248, 249, 250, 0.5);
  border-radius: 5px;
  font-size: 0.9rem;
}

.timeline {
  position: relative;
}

.timeline::before {
  content: '';
  position: absolute;
  left: 8px;
  top: 0;
  bottom: 0;
  width: 2px;
  background: #e9ecef;
}

.timeline-item {
  position: relative;
  padding-left: 30px;
}

.timeline-marker {
  position: absolute;
  left: 0;
  top: 5px;
  width: 16px;
  height: 16px;
  border-radius: 50%;
  border: 3px solid white;
  box-shadow: 0 0 0 1px #dee2e6;
}

.timeline-content {
  font-size: 0.9rem;
}

.quick-stat, .price-target {
  padding: 0.5rem 0;
  border-bottom: 1px solid #f1f3f4;
}

.quick-stat:last-child, .price-target:last-child {
  border-bottom: none;
}

/* Responsive Design */
@media (max-width: 768px) {
  .deep-analysis-header .d-flex {
    flex-direction: column;
    text-align: center;
  }
  
  .deep-analysis-header .btn {
    margin-top: 1rem;
  }
  
  .metric-widget {
    margin-bottom: 1rem;
  }
}

/* Additional UI Enhancements */
.card {
  border: none;
  box-shadow: 0 2px 10px rgba(0,0,0,0.08);
}

.progress {
  background-color: #f8f9fa;
}

.badge {
  font-size: 0.75rem;
  padding: 0.35em 0.65em;
}

.text-success { color: #198754 !important; }
.text-danger { color: #dc3545 !important; }
.text-primary { color: #0d6efd !important; }
.text-warning { color: #fd7e14 !important; }
.text-info { color: #0dcaf0 !important; }

.bg-success { background-color: #198754 !important; }
.bg-danger { background-color: #dc3545 !important; }
.bg-primary { background-color: #0d6efd !important; }
.bg-warning { background-color: #ffc107 !important; }
.bg-info { background-color: #0dcaf0 !important; }

/* Coming Soon Overlay Styles */
.coming-soon-overlay {
  position: absolute;
  top: 0;
  left: 0;
  right: 0;
  bottom: 0;
  background: rgba(255, 255, 255, 0.95);
  backdrop-filter: blur(3px);
  z-index: 1000;
  display: flex;
  align-items: center;
  justify-content: center;
  min-height: 100vh;
}

.coming-soon-content {
  text-align: center;
  max-width: 500px;
  padding: 3rem 2rem;
  background: white;
  border-radius: 20px;
  box-shadow: 0 20px 60px rgba(0, 0, 0, 0.1);
  border: 1px solid #e9ecef;
}

.coming-soon-icon {
  font-size: 4rem;
  color: #0d6efd;
  margin-bottom: 1.5rem;
  animation: spin 2s linear infinite;
}

.coming-soon-title {
  font-size: 2.5rem;
  font-weight: 700;
  color: #212529;
  margin-bottom: 1rem;
  background: linear-gradient(135deg, #0d6efd, #6f42c1);
  -webkit-background-clip: text;
  -webkit-text-fill-color: transparent;
  background-clip: text;
}

.coming-soon-text {
  font-size: 1.1rem;
  color: #6c757d;
  margin-bottom: 2rem;
  line-height: 1.6;
}

.coming-soon-features {
  max-width: 350px;
  margin: 0 auto;
}

.feature-item {
  display: flex;
  align-items: center;
  margin-bottom: 0.75rem;
  font-size: 0.95rem;
  color: #495057;
}

.feature-item i {
  color: #28a745;
  margin-right: 0.75rem;
  font-size: 1.1rem;
}

.content-blur {
  filter: blur(2px);
  pointer-events: none;
  user-select: none;
}

@keyframes spin {
  from {
    transform: rotate(0deg);
  }
  to {
    transform: rotate(360deg);
  }
}

/* Responsive adjustments for overlay */
@media (max-width: 768px) {
  .coming-soon-content {
    margin: 1rem;
    padding: 2rem 1.5rem;
  }
  
  .coming-soon-title {
    font-size: 2rem;
  }
  
  .coming-soon-text {
    font-size: 1rem;
  }
  
  .coming-soon-icon {
    font-size: 3rem;
  }
}
</style> 