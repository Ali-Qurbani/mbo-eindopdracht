window.$ = window.jQuery = require('jquery');
require('owl.carousel');
window.popper = require('@popperjs/core');
require('bootstrap');

$('#crypto-price-line .owl-carousel').owlCarousel({
    loop: true,
    nav: false,
    autoplay: true,
    dots: false,
    slideTransition: 'linear',
    autoplayTimeout: 2000,
    autoplaySpeed: 2000,
    autoplayHoverPause: false,
    touchDrag: false,
    mouseDrag: false,
    center: true,
    responsive:{
        0:{
            items:2
        },
        600:{
            items:3
        },
        1200:{
            items:7
        }
    }
})