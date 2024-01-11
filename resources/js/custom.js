// Header Scroll JS Start
const header = document.querySelector('.main-header');

window.addEventListener('scroll', () => {
    if (header && window.scrollY >= 50) {
        header.classList.add('scroll');
    } else if (header) {
        header.classList.remove('scroll');
    }
});
// Header Scroll JS end
// slick slider js
$(document).ready(function () {
   
});


// slick slider js end
// DISCLAIMER js 
$(".show-more , .show-desc").click(function () {
    $(".slide-up-down p , .slide-up-down span").slideToggle();
    $(this).hide();
  });
  $(".show-less , .less-desc").click(function () {
    $(".slide-up-down p , .slide-up-down span").slideToggle();
    setTimeout(function () {
      $(".show-more , .show-desc").show();
    }, 500);
  });
// DISCLAIMER js End
