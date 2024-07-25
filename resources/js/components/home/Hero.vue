<template>
  <section class="hero-section container-fluid position-relative">
    <!-- top slider Start -->
    <WidgetSlider :widgetId="2" />
    <!-- top slider END-->
    <div class="container-fluid hero-wrapper">
      <div class="row m-0">
        <div class="col-lg-7 px-0">
          <div class="main-heading">
            <h1 class="text-black fw-bolder mb-3">NAVIGATE MARKETS <br>TOGETHER!</h1>
            <p class="mb-5 lh-base text-black">CONQUER MARKET LABYRINTHS: SAVVY INSIGHTS &amp; DYNAMIC
              CHATS.
            </p>
          </div>

          <!-- Form HTML Start -->
          <div class="hero-foem-wrapper">
            <form class="hero-form mt-0" id="quick-register">
              <div class="row gy-3">
                <div class="form-group col-md-5">
                  <!-- <label for="user-name" class="text-white">Your Name</label> -->
                  <input type="text"
                    class="form-control bg-transparent text-black py-3 border border-1 border-black hero-form-input"
                    name="username" id="username" placeholder="Your Name" fdprocessedid="xhligk">
                </div>
                <div class="form-group col-md-5">
                  <!-- <label for="user-email" class="text-white">Your Email</label> -->
                  <input type="text"
                    class="form-control bg-transparent text-black py-3 border border-1 border-black hero-form-input"
                    name="email" id="email" placeholder="Your Email" fdprocessedid="8tpu39">
                </div>
                <span style="display:none" class="msg text-white bg-danger p-2 rounded-1"></span>
                <div class="submit-form col-md-2">
                  <button class="btn btn-hero btn-primary fw-bolder hero-sign-up">Sign
                    Up</button>
                </div>
              </div>
            </form>
          </div>
          <!-- Form HTML End -->
        </div>
        <div class="col-lg-5 hero-graph">
          <!-- build/images/hero-graph.png -->
          <img src="build/images/hero_mobile.png" alt="Graph" class="scroll-image d-lg-block d-none">
        </div>

      </div>
    </div>
  </section>
</template>
<script>
import WidgetSlider from './WidgetSlider.vue';
export default {
  components: {
    WidgetSlider
  }
};

</script>
<style>
.oil-widget-icon {
  filter: invert(1);
}

.market-summary:hover .oil-widget-icon {
  filter: invert(0);
}
</style>