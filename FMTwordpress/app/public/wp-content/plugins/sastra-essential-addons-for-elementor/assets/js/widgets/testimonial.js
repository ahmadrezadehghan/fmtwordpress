(function ($) {
    "use strict";

    const widgetTestimonialCarousel = function ($scope, $) {
        var testimonialCarousel = $scope.find('.tmpcoder-testimonial-carousel');
        var settings = JSON.parse(testimonialCarousel.attr('data-slick'));

        // Slider Columns
        var sliderClass = $scope.attr('class'),
            sliderColumnsDesktop = sliderClass.match(/tmpcoder-testimonial-slider-columns-\d/) ? +sliderClass.match(/tmpcoder-testimonial-slider-columns-\d/).join().slice(-1) : 2,
            sliderColumnsWideScreen = sliderClass.match(/columns--widescreen\d/) ? +sliderClass.match(/columns--widescreen\d/).join().slice(-1) : sliderColumnsDesktop,
            sliderColumnsLaptop = sliderClass.match(/columns--laptop\d/) ? +sliderClass.match(/columns--laptop\d/).join().slice(-1) : sliderColumnsDesktop,
            sliderColumnsTablet = sliderClass.match(/columns--tablet\d/) ? +sliderClass.match(/columns--tablet\d/).join().slice(-1) : 2,
            sliderColumnsTabletExtra = sliderClass.match(/columns--tablet_extra\d/) ? +sliderClass.match(/columns--tablet_extra\d/).join().slice(-1) : sliderColumnsTablet,
            sliderColumnsMobileExtra = sliderClass.match(/columns--mobile_extra\d/) ? +sliderClass.match(/columns--mobile_extra\d/).join().slice(-1) : sliderColumnsTablet,
            sliderColumnsMobile = sliderClass.match(/columns--mobile\d/) ? +sliderClass.match(/columns--mobile\d/).join().slice(-1) : 1,
            sliderSlidesToScroll = settings.sliderSlidesToScroll,
            dataSlideEffect = testimonialCarousel.attr('data-slide-effect');

        testimonialCarousel.slick({
            appendArrows: $scope.find('.tmpcoder-testimonial-controls'),
            appendDots: $scope.find('.tmpcoder-testimonial-dots'),
            customPaging: function (slider, i) {
                var slideNumber = (i + 1),
                    totalSlides = slider.slideCount;

                return '<span class="tmpcoder-testimonial-dot"></span>';
            },
            slidesToShow: sliderColumnsDesktop,
            responsive: [
                {
                    breakpoint: 10000,
                    settings: {
                        slidesToShow: sliderColumnsWideScreen,
                        slidesToScroll: sliderSlidesToScroll > sliderColumnsWideScreen ? 1 : sliderSlidesToScroll,
                        fade: (1 == sliderColumnsWideScreen && 'fade' === dataSlideEffect) ? true : false
                    }
                },
                {
                    breakpoint: 2399,
                    settings: {
                        slidesToShow: sliderColumnsDesktop,
                        slidesToScroll: sliderSlidesToScroll > sliderColumnsDesktop ? 1 : sliderSlidesToScroll,
                        fade: (1 == sliderColumnsDesktop && 'fade' === dataSlideEffect) ? true : false
                    }
                },
                {
                    breakpoint: 1221,
                    settings: {
                        slidesToShow: sliderColumnsLaptop,
                        slidesToScroll: sliderSlidesToScroll > sliderColumnsLaptop ? 1 : sliderSlidesToScroll,
                        fade: (1 == sliderColumnsLaptop && 'fade' === dataSlideEffect) ? true : false
                    }
                },
                {
                    breakpoint: 1200,
                    settings: {
                        slidesToShow: sliderColumnsTabletExtra,
                        slidesToScroll: sliderSlidesToScroll > sliderColumnsTabletExtra ? 1 : sliderSlidesToScroll,
                        fade: (1 == sliderColumnsTabletExtra && 'fade' === dataSlideEffect) ? true : false
                    }
                },
                {
                    breakpoint: 1024,
                    settings: {
                        slidesToShow: sliderColumnsTablet,
                        slidesToScroll: sliderSlidesToScroll > sliderColumnsTablet ? 1 : sliderSlidesToScroll,
                        fade: (1 == sliderColumnsTablet && 'fade' === dataSlideEffect) ? true : false
                    }
                },
                {
                    breakpoint: 880,
                    settings: {
                        slidesToShow: sliderColumnsMobileExtra,
                        slidesToScroll: sliderSlidesToScroll > sliderColumnsMobileExtra ? 1 : sliderSlidesToScroll,
                        fade: (1 == sliderColumnsMobileExtra && 'fade' === dataSlideEffect) ? true : false
                    }
                },
                {
                    breakpoint: 768,
                    settings: {
                        slidesToShow: sliderColumnsMobile,
                        slidesToScroll: sliderSlidesToScroll > sliderColumnsMobile ? 1 : sliderSlidesToScroll,
                        fade: (1 == sliderColumnsMobile && 'fade' === dataSlideEffect) ? true : false
                    }
                }
            ],
        });

        // Show Arrows On Hover
        if ($scope.hasClass('tmpcoder-testimonial-nav-fade')) {
            $scope.on('mouseover', function () {
                $scope.parent().find('.tmpcoder-testimonial-arrow').css({
                    'opacity': 1,
                });
            });
            $scope.parent().on('mouseout', function () {
                $scope.find('.tmpcoder-testimonial-arrow').css({
                    'opacity': 0,
                });
            });
        }

        // on Load
        if ($scope.find('.slick-dots').length) {
            // Calculate Width
            var dotsWrapWidth = $scope.find('.slick-dots li').outerWidth() * $scope.find('.slick-dots li').length - parseInt($scope.find('.slick-dots li span').css('margin-right'), 10);

            // Set Width
            $scope.find('.slick-dots').css('width', dotsWrapWidth);
        }

        $(window).smartresize(function () {
            setTimeout(function () {
                if ($scope.find('.slick-dots').length) {
                    // Calculate Width
                    var dotsWrapWidth = $scope.find('.slick-dots li').outerWidth() * $scope.find('.slick-dots li').length - parseInt($scope.find('.slick-dots li span').css('margin-right'), 10);

                    // Set Width
                    $scope.find('.slick-dots').css('width', dotsWrapWidth);
                }
            }, 300);
        });
    }
    
    $(window).on('elementor/frontend/init', function () {
        elementorFrontend.hooks.addAction("frontend/element_ready/tmpcoder-testimonial.default",
            widgetTestimonialCarousel);
    });
})(jQuery);