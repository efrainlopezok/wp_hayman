(function($) {
    $(window).scroll(function() {
        if ($(this).scrollTop() > 1) {
            $('.site-header').addClass("sticky");
        } else {
            $('.site-header').removeClass("sticky");
        }
    });

    $('.horizontal-slider').slick({
        dots: false,
        arrows: true,
        prevArrow: '<span class="prev"></span>',
        nextArrow: '<span class="next"></span>',
        speed: 500,
        fade: true,
        cssEase: 'linear'
    });

    $('.v-slider').slick({
        dots: false,
        arrows: true,
        prevArrow: '<span class="prev-join"></span>',
        nextArrow: '<span class="next-join"></span>',
        speed: 500,
        slidesToShow: 1,
        slidesToScroll: 1,
        infinite: true,
        vertical: false,
        autoplay: true,
        autoplaySpeed: 8000,
        responsive: [{
            breakpoint: 600,
            settings: {
                dots: false
            }
        }, ]
    });


    /* Gallery Pages
    - - - - - - - - - - - - - - - - - - - -*/
    /*$('.gallery-thumb-slider').slick({
        centerMode: true,
        centerPadding: '0',
        slidesToShow: 7,
        prevArrow: '<span class="prev"></span>',
        nextArrow: '<span class="next"></span>',
        responsive: [{
                breakpoint: 1200,
                settings: {
                    slidesToShow: 6,
                }
            },
            {
                breakpoint: 1000,
                settings: {
                    slidesToShow: 5,
                }
            },
            {
                breakpoint: 900,
                settings: {
                    slidesToShow: 4,
                }
            },
            {
                breakpoint: 700,
                settings: {
                    slidesToShow: 3,
                }
            },
            {
                breakpoint: 600,
                settings: {
                    slidesToShow: 2,
                }
            }
        ]
    });*/
    $('.gallery-slider').slick({
        dots: false,
        infinite: true,
        speed: 500,
        cssEase: 'linear',
        prevArrow: '<span class="prev"></span>',
        nextArrow: '<span class="next"></span>'
    });
    $('.gallery-thumb-slider').on('swipe', function(event, slick, direction) {
        if (direction == "left")
            $('.gallery-slider').slick("slickPrev");
        else
            $('.gallery-slider').slick("slickNext");
    });
    $('.gallery-thumb-slider').on('beforeChange', function(event, slick, currentSlide, nextSlide) {
        $('.gallery-slider').slick("slickGoTo", (nextSlide));
    });

    $('.am-slide').slick({

        infinite: true,
        slidesToShow: 6,
        slidesToScroll: 3,
        arrows: true,
        prevArrow: '<span class="prev"></span>',
        nextArrow: '<span class="next"></span>',
        responsive: [
        {
            breakpoint: 1024,
            settings: {
                slidesToShow: 3,
                slidesToScroll: 1,
                infinite: true,
                dots: false
            }
        },
        {
            breakpoint: 600,
            settings: {
                centerMode: true,
                slidesToShow: 2,
                slidesToScroll: 1,
                dots: true
            }
        },
        {
            breakpoint: 480,
            settings: {
                centerMode: true,
                slidesToShow: 1,
                slidesToScroll: 1,
                dots: true
            }
        }
        // You can unslick at a given breakpoint now by adding:
        // settings: "unslick"
        // instead of a settings object
        ]
    });


    /* Testimonial slider
    - - - - - - - - - - - - - - - - - - - -*/
    $('.testimonial-slider').slick({
        dots: true,
        infinite: true,
        slidesToShow: 3,

        centerMode: true,
        slidesToScroll: 3,
        // autoplay: true,
        //autoplaySpeed: 5000,
        variableWidth: true,
        prevArrow: '<span class="prev"></span>',
        nextArrow: '<span class="next"></span>',
    });

    $('.testimonial-slider .slick-current').addClass("center");
    $('.testimonial-slider .slick-current').next().addClass("center_right");
    $('.testimonial-slider .slick-current').prev().addClass("center_left");
    $('.testimonial-slider').on('beforeChange', function(event, slick, currentSlide, nextSlide) {
        //     //console.log(nextSlide);
        $('.testimonial-slider .slick-slide').removeClass("center center_right center_left");
    });
    $('.testimonial-slider').on('afterChange', function(event, slick, currentSlide, nextSlide) {
        //console.log(nextSlide);
        $('.testimonial-slider .slick-slide').removeClass("center center_left center_right");
        $('.testimonial-slider .slick-current').addClass("center");
        $('.testimonial-slider .slick-current').next().addClass("center_right");
        $('.testimonial-slider .slick-current').prev().addClass("center_left");

    });

    $('.grid').each(function() { // the containers for all your galleries
        $(this).magnificPopup({
            delegate: 'div.grid-item', // the selector for gallery item
            type: 'image',
            gallery: {
                enabled: true,
                navigateByImgClick: true
            }
        });

    });

    /*slide grid*/
    var width_win = $(window).width();
    if (width_win <= 800) {
        $('.pricing .row-fluid').slick({
            infinite: true,
            slidesToShow: 1,
            slidesToScroll: 1,
            arrows: false,
            dots: true,
            responsive: [
            {
                breakpoint: 600,
                settings: {
                    slidesToShow: 1,
                    slidesToScroll: 1
                }
            },
            {
                breakpoint: 480,
                settings: {
                    slidesToShow: 1,
                    slidesToScroll: 1
                }
            }
            ]
        });

        $('.testimonial-grid .item-grid').removeClass("one-half first");
        $('.testimonial-grid').slick({
            infinite: true,
            slidesToShow: 1,
            slidesToScroll: 1,
            arrows: false,
            dots: true
        });

        $('.grid-slide').slick({
            centerMode: true,
            infinite: true,
            slidesToShow: 1,
            slidesToScroll: 1,
            arrows: false,
            dots: true,
            responsive: [
            {
                breakpoint: 1024,
                settings: {
                    slidesToShow: 2,
                    slidesToScroll: 2,
                    infinite: true,
                }
            },
            {
                breakpoint: 600,
                settings: {
                    slidesToShow: 2,
                    slidesToScroll: 2
                }
            },
            {
                breakpoint: 480,
                settings: {
                    slidesToShow: 1,
                    slidesToScroll: 1
                }
            }
            ]
        });
    }

})(jQuery);

jQuery(document).ready(function() {
    jQuery('.image-popup').magnificPopup({ type: 'image' });
    jQuery('.image-gallery').each(function() { jQuery(this).magnificPopup({ delegate: "a", type: "image", gallery: { enabled: true, navigateByImgClick: true, preload: [0, 1] } }) })
    jQuery('.grid').masonry({
        itemSelector: '.grid-item',
        columnWidth: 30
    });
});