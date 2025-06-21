(function ($) {
    "use strict";

    const widgetPostsTimeline = function ($scope, $) {

        var iScrollTarget = $scope.find('.tmpcoder-timeline-centered').length > 0 ? $scope.find('.tmpcoder-timeline-centered') : '',
            element = $scope.find('.tmpcoder-timeline-centered').length > 0 ? $scope.find('.tmpcoder-timeline-centered') : '',
            pagination = $scope.find('.tmpcoder-grid-pagination').length > 0 ? $scope.find('.tmpcoder-grid-pagination') : '',
            middleLine = $scope.find('.tmpcoder-middle-line').length > 0 ? $scope.find('.tmpcoder-middle-line') : '',
            timelineFill = $scope.find(".tmpcoder-timeline-fill").length > 0 ? $scope.find(".tmpcoder-timeline-fill") : '',
            lastIcon = $scope.find('.tmpcoder-main-line-icon.tmpcoder-icon:last').length > 0 ? $scope.find('.tmpcoder-main-line-icon.tmpcoder-icon:last') : '',
            firstIcon = $scope.find('.tmpcoder-main-line-icon.tmpcoder-icon').length > 0 ? $scope.find('.tmpcoder-main-line-icon.tmpcoder-icon').first() : '',
            scopeClass = '.elementor-element-' + $scope.attr('data-id'),
            aosOffset = $scope.find('.tmpcoder-story-info-vertical').attr('data-animation-offset') ? +$scope.find('.tmpcoder-story-info-vertical').attr('data-animation-offset') : '',
            aosDuration = $scope.find('.tmpcoder-story-info-vertical').attr('data-animation-duration') ? +$scope.find('.tmpcoder-story-info-vertical').attr('data-animation-duration') : '';


        if ($scope.find('.tmpcoder-timeline-centered').length > 0) {

            $(window).resize(function () {
                removeLeftAlignedClass();
            });

            $(window).smartresize(function () {
                removeLeftAlignedClass();
            });

            setTimeout(function () {
                removeLeftAlignedClass();
                $(window).trigger('resize');
            }, 500);

            adjustMiddleLineHeight(middleLine, timelineFill, lastIcon, firstIcon, element);

            setTimeout(function () {
                adjustMiddleLineHeight(middleLine, timelineFill, lastIcon, firstIcon, element);
                $(window).trigger('resize');
            }, 500);

            $(window).smartresize(function () {
                adjustMiddleLineHeight(middleLine, timelineFill, lastIcon, firstIcon, element);
            });

            $(window).resize(function () {
                adjustMiddleLineHeight(middleLine, timelineFill, lastIcon, firstIcon, element);
            });

            if ('load-more' !== iScrollTarget.attr('data-pagination')) {
                $scope.find('.tmpcoder-grid-pagination').css('visibility', 'hidden');
            }

            if (typeof AOS !== 'undefined') {
                AOS.init({
                    offset: parseInt(aosOffset),
                    duration: aosDuration,
                    once: true,
                });
            }

            postsTimelineFill(lastIcon, firstIcon);

            $(window).on('scroll', function () {
                postsTimelineFill(lastIcon, firstIcon);
            });

            // init Infinite Scroll
            if (!$scope.find('.elementor-repeater-items').length && !editorCheck() && ('load-more' === $scope.find('.tmpcoder-timeline-centered').data('pagination') || 'infinite-scroll' === $scope.find('.tmpcoder-timeline-centered').data('pagination'))) {
                var threshold = iScrollTarget !== undefined && 'load-more' === iScrollTarget.attr('data-pagination') ? false : 10;
                // var navClass = scopeClass +' .tmpcoder-load-more-btn';

                if (typeof $.fn.infiniteScroll == "function") {

                    iScrollTarget.infiniteScroll({
                        path: scopeClass + ' .tmpcoder-grid-pagination a',
                        hideNav: false,
                        append: scopeClass + '.tmpcoder-timeline-entry',
                        history: false,
                        scrollThreshold: threshold,
                        status: scopeClass + ' .page-load-status',
                    });
                }

                // Request
                iScrollTarget.on('request.infiniteScroll', function (event, path) {
                    $scope.find('.tmpcoder-load-more-btn').hide();
                    $scope.find('.tmpcoder-pagination-loading').css('display', 'inline-block');
                });

                var pagesLoaded = 0;

                iScrollTarget.on('load.infiniteScroll', function (event, response) {
                    pagesLoaded++;

                    // get posts from response
                    var items = $(response).find(scopeClass).find('.tmpcoder-timeline-entry');
                    iScrollTarget.infiniteScroll('appendItems', items);

                    if (!$scope.find('.tmpcoder-one-sided-timeline').length && !$scope.find('.tmpcoder-one-sided-timeline-left').length) {
                        $scope.find('.tmpcoder-timeline-entry').each(function (index, value) {
                            $(this).removeClass('tmpcoder-right-aligned tmpcoder-left-aligned');
                            if (0 == index % 2) {
                                $(this).addClass('tmpcoder-left-aligned');
                                $(this).find('.tmpcoder-story-info-vertical').attr('data-aos', $(this).find('.tmpcoder-story-info-vertical').attr('data-aos-left'));
                            } else {
                                $(this).addClass('tmpcoder-right-aligned');
                                $(this).find('.tmpcoder-story-info-vertical').attr('data-aos', $(this).find('.tmpcoder-story-info-vertical').attr('data-aos-right'));
                            }
                        });
                    }

                    AOS.init({
                        offset: parseInt(aosOffset),
                        duration: aosDuration,
                        once: true,
                    });

                    $(window).scroll();

                    $scope.find('.tmpcoder-pagination-loading').hide();
                    // $scope.find( '.tmpcoder-load-more-btn' ).fadeIn();
                    if (iScrollTarget.data('max-pages') - 1 !== pagesLoaded) { // $pagination_max_pages
                        if ('load-more' === iScrollTarget.attr('data-pagination')) {
                            $scope.find('.tmpcoder-load-more-btn').fadeIn();
                        }
                    } else {
                        $scope.find('.tmpcoder-pagination-finish').fadeIn(1000);
                        pagination.delay(2000).fadeOut(1000);
                    }

                    middleLine = $scope.find('.tmpcoder-middle-line');
                    timelineFill = $scope.find(".tmpcoder-timeline-fill");
                    lastIcon = $scope.find('.tmpcoder-main-line-icon.tmpcoder-icon:last');
                    firstIcon = $scope.find('.tmpcoder-main-line-icon.tmpcoder-icon').first();
                    element = $scope.find('.tmpcoder-timeline-centered');

                    adjustMiddleLineHeight(middleLine, timelineFill, lastIcon, firstIcon, element);
                    $(window).trigger('resize');
                    postsTimelineFill(lastIcon, firstIcon);
                });

                if (!editorCheck()) {
                    
                    if (typeof $.fn.infiniteScroll == "function") {

                        $scope.find('.tmpcoder-load-more-btn').on('click', function () {
                            iScrollTarget.infiniteScroll('loadNextPage');
                            return false;
                        });

                        if ('infinite-scroll' == iScrollTarget.attr('data-pagination')) {
                            iScrollTarget.infiniteScroll('loadNextPage');
                        }
                    }
                }
            }
        }

        if ($scope.find('.swiper-wrapper').length) {

            var swiperLoader = function swiperLoader(swiperElement, swiperConfig) {
                // if ('undefined' === typeof Swiper) {
                //  var asyncSwiper = elementorFrontend.utils.swiper;     
                //  return new asyncSwiper(swiperElement, swiperConfig).then( function (newSwiperInstance) {
                //      return newSwiperInstance;
                //  });
                //  } else {
                //  console.log(Swiper);
                //  return swiperPromise(swiperElement, swiperConfig);  
                // }

                // Check if swiperPromise is necessary
                var asyncSwiper = elementorFrontend.utils.swiper;
                return new asyncSwiper(swiperElement, swiperConfig).then(function (newSwiperInstance) {
                    return newSwiperInstance;
                });
            };

            var swiperPromise = function swiperPromise(swiperElement, swiperConfig) {
                return new Promise(function (resolve, reject) {
                    var swiperInstance = new Swiper(swiperElement, swiperConfig);
                    resolve(swiperInstance);
                });
            };

            var horizontal = $scope.find('.tmpcoder-horizontal-bottom').length ? '.tmpcoder-horizontal-bottom' : '.tmpcoder-horizontal';
            var swiperSlider = $scope.find(horizontal + ".swiper-container");

            var slidestoshow = swiperSlider.data("slidestoshow");

            swiperLoader(swiperSlider, {
                spaceBetween: +swiperSlider.data('swiper-space-between'),
                loop: swiperSlider.data('loop') === 'yes' ? true : false,
                autoplay: swiperSlider.data("autoplay") !== 'yes' ? false : {
                    delay: +swiperSlider.attr('data-swiper-delay'),
                    disableOnInteraction: false,
                    pauseOnMouseEnter: swiperSlider.data('swiper-poh') === 'yes' ? true : false,
                },
                on: {
                    init: function () {
                        if ($scope.find('.tmpcoder-timeline-outer-container').length > 0) {
                            $scope.find('.tmpcoder-timeline-outer-container').css('opacity', 1);
                        }
                    },
                },
                speed: +swiperSlider.attr('data-swiper-speed'),
                slidesPerView: swiperSlider.data("slidestoshow"),
                direction: 'horizontal',
                pagination: {
                    el: '.tmpcoder-swiper-pagination',
                    type: 'progressbar',
                },
                navigation: {
                    nextEl: '.tmpcoder-button-next',
                    prevEl: '.tmpcoder-button-prev',
                },
                // Responsive breakpoints
                breakpoints: {
                    // when window width is >= 320px
                    320: {
                        slidesPerView: 1,
                    },
                    // when window width is >= 480px
                    480: {
                        slidesPerView: 2,
                    },
                    // when window width is >= 640px
                    769: { // 640
                        slidesPerView: slidestoshow,
                    }
                },
            });

            //   swiperSlider.data('pause-on-hover') === 'yes' && swiperSlider.hover(function() {
            //    (this).swiper.autoplay.stop();
            //   }, function() {
            //    (this).swiper.autoplay.start();
            //   });

        } else {
            $(document).ready(function () {
                // Handler when all assets (including images) are loaded
                if ($scope.find('.tmpcoder-timeline-outer-container').length) {
                    $scope.find('.tmpcoder-timeline-outer-container').css('opacity', 1);
                }
            });
        }

        function removeLeftAlignedClass() {
            if ($scope.find('.tmpcoder-centered').length) {
                if (window.innerWidth <= 767) {
                    $scope.find('.tmpcoder-wrapper .tmpcoder-timeline-centered').removeClass('tmpcoder-both-sided-timeline').addClass('tmpcoder-one-sided-timeline').addClass('tmpcoder-remove-one-sided-later');
                    $scope.find('.tmpcoder-wrapper .tmpcoder-left-aligned').removeClass('tmpcoder-left-aligned').addClass('tmpcoder-right-aligned').addClass('tmpcoder-remove-right-aligned-later');
                } else {
                    $scope.find('.tmpcoder-wrapper .tmpcoder-timeline-centered.tmpcoder-remove-one-sided-later').removeClass('tmpcoder-one-sided-timeline').addClass('tmpcoder-both-sided-timeline').removeClass('tmpcoder-remove-one-sided-later');
                    $scope.find('.tmpcoder-wrapper .tmpcoder-remove-right-aligned-later').removeClass('tmpcoder-right-aligned').addClass('tmpcoder-left-aligned').removeClass('tmpcoder-remove-right-aligned-later');
                }
            }
        }

        function postsTimelineFill(lastIcon, firstIcon) {
            if (!$scope.find('.tmpcoder-timeline-fill').length) {
                return;
            }

            if ($scope.find('.tmpcoder-timeline-entry:eq(0)').prev('.tmpcoder-year-wrap').length > 0) {
                firstIcon = $scope.find('.tmpcoder-year-label').eq(0);
            }

            if (timelineFill.length) {
                var fillHeight = timelineFill.css('height').slice(0, -2),
                    docScrollTop = document.documentElement.scrollTop,
                    clientHeight = document.documentElement.clientHeight / 2;

                if (!((docScrollTop + clientHeight - (firstIcon.offset().top)) > lastIcon.offset().top - firstIcon.offset().top + parseInt(lastIcon.css('height').slice(0, -2)))) {
                    timelineFill.css('height', (docScrollTop + clientHeight - (firstIcon.offset().top)) + 'px');
                }

                $scope.find('.tmpcoder-main-line-icon.tmpcoder-icon').each(function () {
                    if ($(this).offset().top < parseInt(firstIcon.offset().top + parseInt(fillHeight))) {
                        $(this).addClass('tmpcoder-change-border-color');
                    } else {
                        $(this).removeClass('tmpcoder-change-border-color');
                    }
                });
            }
        }

        function adjustMiddleLineHeight(middleLine, timelineFill, lastIcon, firstIcon, element) {
            element = $scope.find('.tmpcoder-timeline-centered');
            if (!$scope.find('.tmpcoder-both-sided-timeline').length && !$scope.find('.tmpcoder-one-sided-timeline').length && !$scope.find('.tmpcoder-one-sided-timeline-left').length) {
                return;
            }

            if ($scope.find('.tmpcoder-timeline-entry:eq(0)').prev('.tmpcoder-year-wrap').length > 0) {
                firstIcon = $scope.find('.tmpcoder-year-label').eq(0);
            }

            var firstIconOffset = firstIcon.offset().top;
            var lastIconOffset = lastIcon.offset().top;
            var middleLineTop = (firstIconOffset - element.offset().top) + 'px';
            // var middleLineHeight = (lastIconOffset - (lastIcon.css('height').slice(0, -2)/2 + (firstIconOffset - firstIcon.css('height').slice(0, -2)))) + 'px';
            var middleLineHeight = lastIconOffset - firstIconOffset + parseInt(lastIcon.css('height').slice(0, -2));
            var middleLineMaxHeight = firstIconOffset - lastIconOffset + 'px !important';

            middleLine.css('top', middleLineTop);
            middleLine.css('height', middleLineHeight);
            // middleLine.css('maxHeight', middleLineMaxHeight);
            timelineFill !== '' ? timelineFill.css('top', middleLineTop) : '';
        }
    }

    $(window).on('elementor/frontend/init', function () {
        elementorFrontend.hooks.addAction('frontend/element_ready/tmpcoder-posts-timeline.default', widgetPostsTimeline);
    });
})(jQuery);