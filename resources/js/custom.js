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
