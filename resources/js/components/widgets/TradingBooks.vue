<template>
  <div class="trading-books-wrapper bg-white px-5 pt-3 pb-4 border-1 border rounded-2 shadow-sm">
    <div class="text-center">
      <h1 class="fw-bold fs-1 text-uppercase">TRADING BOOKS <span class="videos-count fs-12 fw-light">(7)</span></h1>
      <div class="border-heading d-inline-block mt-4 mb-3"></div>
    </div>
    <div class="trading-books-slider">
      <div class="books-slider-wrapper card px-2 py-3">
        <div target="_blank" class="d-md-flex gap-4 align-items-center">
          <div class="book-img">
            <img src="https://s3.wasabisys.com/rpdapp1/upload/photos/2023/img/edu-pdf-icons/stockmarket-101.png"
              alt="book cover">
          </div>
          <div class="book-dic">
            <h2 class="pt-2 fs-6 mb-0 lh-base">RICH TV'S DAILY TRAINING MANUAL</h2>
            <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Ad autem libero enim cumque, cupiditate
              reprehenderit!</p>
            <a href="https://dev.richtv.io/themes/wowonder/trading-school/rpd-training-manual.pdf"
              class="btn btn-primary">Download Now</a>
          </div>
        </div>
      </div>
      <div class="books-slider-wrapper card px-2 py-3">
        <div target="_blank" class="d-md-flex gap-4 align-items-center">
          <div class="book-img">
            <img src="https://s3.wasabisys.com/rpdapp1/upload/photos/2023/img/edu-pdf-icons/stockmarket-101.png"
              alt="book cover">
          </div>
          <div class="book-dic">
            <h2 class="pt-2 fs-6 mb-0 lh-base">RICH TV'S DAILY TRAINING MANUAL</h2>
            <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Ad autem libero enim cumque, cupiditate
              reprehenderit!</p>
            <a href="https://dev.richtv.io/themes/wowonder/trading-school/rpd-training-manual.pdf"
              class="btn btn-primary">Download Now</a>
          </div>
        </div>
      </div>
      <div class="books-slider-wrapper card px-2 py-3">
        <div target="_blank" class="d-md-flex gap-4 align-items-center">
          <div class="book-img">
            <img src="https://s3.wasabisys.com/rpdapp1/upload/photos/2023/img/edu-pdf-icons/stockmarket-101.png"
              alt="book cover">
          </div>
          <div class="book-dic">
            <h2 class="pt-2 fs-6 mb-0 lh-base">RICH TV'S DAILY TRAINING MANUAL</h2>
            <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Ad autem libero enim cumque, cupiditate
              reprehenderit!</p>
            <a href="https://dev.richtv.io/themes/wowonder/trading-school/rpd-training-manual.pdf"
              class="btn btn-primary">Download Now</a>
          </div>
        </div>
      </div>
      <div class="books-slider-wrapper card px-2 py-3">
        <div target="_blank" class="d-md-flex gap-4 align-items-center">
          <div class="book-img">
            <img src="https://s3.wasabisys.com/rpdapp1/upload/photos/2023/img/edu-pdf-icons/stockmarket-101.png"
              alt="book cover">
          </div>
          <div class="book-dic">
            <h2 class="pt-2 fs-6 mb-0 lh-base">RICH TV'S DAILY TRAINING MANUAL</h2>
            <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Ad autem libero enim cumque, cupiditate
              reprehenderit!</p>
            <a href="https://dev.richtv.io/themes/wowonder/trading-school/rpd-training-manual.pdf"
              class="btn btn-primary">Download Now</a>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>
<script>

export default {
  mounted() {
    $('.trading-books-slider').slick({
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
        }
      ]
    });
  }
}
</script>