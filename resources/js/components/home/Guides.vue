<template>
  <section class="Guides-section container-fluid py-80">
    <div class="container">
      <div class="heading-summary">
        <h2 class="icon-heading mb-4 px-10 ">How To Guides</h2>
        <!-- Carousel Multiple Items Start -->
        <div class="guide-slider">
          <div class="guide-content-slider">
            <a href="" class="guide-card-hover d-block">
              <div class="guide-card-wrapper"
                style="background-image: url(https://richtv.io/wp-content/uploads/2022/11/technical-analysis-final-Featured-image-1.jpg); background-size: cover; background-position: center center; background-position: center center;">
                <div class="overlay-guide"></div>
                <div class="post-count position-relative">
                  <span>01.</span>
                </div>
                <div class="guide-content position-relative">
                  <h4>Initial jobless claims </h4>
                  <P class="text-white">Lorem ipsum dolor sit amet, consectetur adipisicing
                    elit. Sit
                    dolorum quasi
                    mollitia dolores obcaecati</P>
                  <div class="read-more-link-artical d-inline-flex align-items-center gap-2">
                    <span>Read more</span><i class="bi bi-arrow-right"></i>
                  </div>
                </div>
              </div>
            </a>
          </div>
          <div class="guide-content-slider">
            <a href="" class="guide-card-hover d-block">
              <div class="guide-card-wrapper"
                style="background-image: url(https://richtv.io/wp-content/uploads/2022/11/f.png); background-size: cover; background-position: center center;">
                <div class="overlay-guide"></div>
                <div class="post-count position-relative">
                  <span>02.</span>
                </div>
                <div class="guide-content position-relative">
                  <h4>Initial jobless claims </h4>
                  <P class="text-white">Lorem ipsum dolor sit amet, consectetur adipisicing
                    elit. Sit
                    dolorum quasi
                    mollitia dolores obcaecati</P>
                  <div class="read-more-link-artical d-inline-flex align-items-center gap-2">
                    <span>Read more</span><i class="bi bi-arrow-right"></i>
                  </div>
                </div>
              </div>
            </a>
          </div>
          <div class="guide-content-slider">
            <a href="" class="guide-card-hover d-block">
              <div class="guide-card-wrapper"
                style="background-image: url(https://richtv.io/wp-content/uploads/2023/03/U.S.-construction-spending.jpg); background-size: cover; background-position: center center;">
                <div class="overlay-guide"></div>
                <div class="post-count position-relative">
                  <span>03.</span>
                </div>
                <div class="guide-content position-relative">
                  <h4>Initial jobless claims </h4>
                  <P class="text-white">Lorem ipsum dolor sit amet, consectetur adipisicing
                    elit. Sit
                    dolorum quasi
                    mollitia dolores obcaecati</P>
                  <div class="read-more-link-artical d-inline-flex align-items-center gap-2">
                    <span>Read more</span><i class="bi bi-arrow-right"></i>
                  </div>
                </div>
              </div>
            </a>
          </div>
          <div class="guide-content-slider">
            <a href="" class="guide-card-hover d-block">
              <div class="guide-card-wrapper"
                style="background-image: url(https://richtv.io/wp-content/uploads/2022/11/f.png); background-size: cover; background-position: center center;">
                <div class="overlay-guide"></div>
                <div class="post-count position-relative">
                  <span>04.</span>
                </div>
                <div class="guide-content position-relative">
                  <h4>Initial jobless claims </h4>
                  <P class="text-white">Lorem ipsum dolor sit amet, consectetur adipisicing
                    elit. Sit
                    dolorum quasi
                    mollitia dolores obcaecati</P>
                  <div class="read-more-link-artical d-inline-flex align-items-center gap-2">
                    <span>Read more</span><i class="bi bi-arrow-right"></i>
                  </div>
                </div>
              </div>
            </a>
          </div>
          <div class="guide-content-slider">
            <a href="" class="guide-card-hover d-block">
              <div class="guide-card-wrapper"
                style="background-image: url(https://richtv.io/wp-content/uploads/2023/03/U.S.-construction-spending.jpg); background-size: cover; background-position: center center;">
                <div class="overlay-guide"></div>
                <div class="post-count position-relative">
                  <span>05.</span>
                </div>
                <div class="guide-content position-relative">
                  <h4>Initial jobless claims </h4>
                  <P class="text-white">Lorem ipsum dolor sit amet, consectetur adipisicing
                    elit. Sit
                    dolorum quasi
                    mollitia dolores obcaecati</P>
                  <div class="read-more-link-artical d-inline-flex align-items-center gap-2">
                    <span>Read more</span><i class="bi bi-arrow-right"></i>
                  </div>
                </div>
              </div>
            </a>
          </div>
          <div class="guide-content-slider">
            <a href="" class="guide-card-hover d-block">
              <div class="guide-card-wrapper"
                style="background-image: url(https://richtv.io/wp-content/uploads/2023/03/U.S.-construction-spending.jpg); background-size: cover; background-position: center center;">
                <div class="overlay-guide"></div>
                <div class="post-count position-relative">
                  <span>06.</span>
                </div>
                <div class="guide-content position-relative">
                  <h4>Initial jobless claims </h4>
                  <P class="text-white">Lorem ipsum dolor sit amet, consectetur adipisicing
                    elit. Sit
                    dolorum quasi
                    mollitia dolores obcaecati</P>
                  <div class="read-more-link-artical d-inline-flex align-items-center gap-2">
                    <span>Read more</span><i class="bi bi-arrow-right"></i>
                  </div>
                </div>
              </div>
            </a>
          </div>
        </div>
      </div>
    </div>
  </section>
</template>
<script>
export default {
  mounted() {
    $('.guide-slider').slick({
    dots: false,
    infinite: true,
    speed: 1000,
    arrows: true,
    // autoplay: true,
    slidesToShow: 3,
    responsive: [{
        breakpoint: 992,
        settings: {
            slidesToShow: 2,
            swipeToSlide: true,
        }
    }, {
        breakpoint: 768,
        settings: {
            slidesToShow: 1,
            swipeToSlide: true,
        }
    }
    ]
});
  }
}
</script>