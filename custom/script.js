
// <!-- slider auto play code  -->
$(document).ready(function(){
    $('.home-slider').owlCarousel({
        items: 1,
        loop: true,
        margin: 0,
        autoplay: true,
        autoplayTimeout: 4000,
        autoplayHoverPause: true,
        dots: true,
        nav: false
    });
});
