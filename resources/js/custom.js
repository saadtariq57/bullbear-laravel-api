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
    $('.video-slider').slick({
        dots: false,
        infinite: true,
        speed: 1500,
        arrows: true,
        autoplay: true,
        slidesToShow: 3,
        responsive: [{
            breakpoint: 1200,
            settings: {
                slidesToShow: 2,
                swipeToSlide: true,
            }
        },
        {
            breakpoint: 768,
            settings: {
                slidesToShow: 1,
                swipeToSlide: true,
            }
        }
        ]
    });
});
$('.wide-slider').slick({
    // centerMode: true,
    // centerPadding: '300px',
    slidesToShow: 3,
    dots: true,
    arrows: false,
    autoplay: true,
    speed: 2000,
    // autoplaySpeed: 4500,
    cssEase: 'ease-out',
    responsive: [
        {
            breakpoint: 1400,
            settings: {
                arrows: false,
                // centerMode: true,
                // centerPadding: '30px',
                slidesToShow: 2,
            }
        },
        {
            breakpoint: 992,
            settings: {
                arrows: false,
                // centerMode: true,
                // centerPadding: '40px',
                slidesToShow: 1
            }
        },
        {
            breakpoint: 768,
            settings: {
                // centerPadding: '0px',
                slidesToShow: 1
            }
        }
    ]
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
// scrolling image animation
const image = document.querySelector(".scroll-image");
let currentScroll = window.pageYOffset;

function scrollDirection() {
    const newScroll = window.pageYOffset;
    const scrollDirection = newScroll > currentScroll ? "down" : "up";
    currentScroll = newScroll;
    return scrollDirection;
}

if (image) {
    function scrollUpdate() {
        const direction = scrollDirection();

        if (direction === "down") {
            image.style.transform = "rotateY(30deg)";
        } else {
            image.style.transform = "rotateY(0deg)";
        }
    }

    window.addEventListener("scroll", scrollUpdate);
}
// feed page form focus js
function feedoverlay() {
    var element = document.getElementById("focus-overlay");
    element.classList.add("focus-overlay");
}
function hideoverlay() {
    var element = document.getElementById("focus-overlay");
    element.classList.remove("focus-overlay");
    var x = document.getElementById("user-poster-con");
    x.classList.remove("d-none");
    var y = document.getElementById("user-color-con");
    y.classList.add("d-none");
}
function showColor() {
    var x = document.getElementById("user-poster-con");
    x.classList.add("d-none");
    var y = document.getElementById("user-color-con");
    y.classList.remove("d-none");
}
function hideColor() {
    var x = document.getElementById("user-poster-con");
    x.classList.remove("d-none");
    var y = document.getElementById("user-color-con");
    y.classList.add("d-none");
}
// feed page form focus js end
// watchlist add search js 
$(document).ready(function () {
    const $addSymbolBtn = $('.add-symbol-btn');
    const $symbolSearchForm = $('.symbol-search-form');
    function toggleSymbolSearchForm() {
        $symbolSearchForm.toggle();
    }
    $addSymbolBtn.on('click', function (event) {
        event.stopPropagation(); // Prevent body click event from firing
        toggleSymbolSearchForm();
    });
    $(document).on('click', function (event) {
        if (!$(event.target).closest('.symbol-search-form, .add-symbol-btn').length) {
            $symbolSearchForm.hide();
        }
    });
});
// watchlist add search js end
