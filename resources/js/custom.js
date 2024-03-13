

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
