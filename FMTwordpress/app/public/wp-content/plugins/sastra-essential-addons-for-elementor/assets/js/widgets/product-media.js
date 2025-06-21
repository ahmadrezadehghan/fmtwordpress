(function ($) {
    "use strict";

    const widgetProductMedia = function ($scope, $) {
        // Fix Main Slider Distortion
        $(document).ready(function ($) {
            $(window).trigger('resize');
            setTimeout(function () {
                $(window).trigger('resize');
                $scope.find('.tmpcoder-product-media-wrap').removeClass('tmpcoder-zero-opacity');
            }, 1000);
        });

        var sliderIcons = $scope.find('.tmpcoder-gallery-slider-arrows-wrap');
        sliderIcons.remove();

        $(document).ready(function ($) {
            if ($scope.find('.woocommerce-product-gallery__trigger').length) {
                $scope.find('.woocommerce-product-gallery__trigger').remove();
            }
        });

        $scope.find('.flex-viewport').append(sliderIcons);

        $scope.find('.tmpcoder-gallery-slider-arrow').on('click', function () {
            if ($(this).hasClass('tmpcoder-gallery-slider-prev-arrow')) {
                $scope.find('a.flex-prev').trigger('click');
            } else if ($(this).hasClass('tmpcoder-gallery-slider-next-arrow')) {
                $scope.find('a.flex-next').trigger('click');
            }
        });

        // Lightbox
        var lightboxSettings = $('.tmpcoder-product-media-wrap').attr('data-lightbox');

        if (typeof lightboxSettings !== typeof undefined && lightboxSettings !== false && !editorCheck()) {

            $scope.find('.woocommerce-product-gallery__image').each(function () {
                $(this).attr('data-lightbox', lightboxSettings);
                $(this).attr('data-src', $(this).find('a').attr('href'));
            });


            $scope.find('.woocommerce-product-gallery__image').on('click', function (e) {
                e.stopPropagation();
            });

            $scope.find('.tmpcoder-product-media-lightbox').on('click', function () {
                $scope.find('.woocommerce-product-gallery__image').trigger('click');
            });

            var MediaWrap = $scope.find('.woocommerce-product-gallery__wrapper');
            lightboxSettings = JSON.parse(lightboxSettings);

            // Init Lightbox
            MediaWrap.lightGallery(lightboxSettings);

            // Show/Hide Controls
            MediaWrap.on('onAferAppendSlide.lg, onAfterSlide.lg', function (event, prevIndex, index) {
                var lightboxControls = $('#lg-actual-size, #lg-zoom-in, #lg-zoom-out, #lg-download'),
                    lightboxDownload = $('#lg-download').attr('href');

                if ($('#lg-download').length) {
                    if (-1 === lightboxDownload.indexOf('wp-content')) {
                        lightboxControls.addClass('tmpcoder-hidden-element');
                    } else {
                        lightboxControls.removeClass('tmpcoder-hidden-element');
                    }
                }

                // Autoplay Button
                if ('' === lightboxSettings.autoplay) {
                    $('.lg-autoplay-button').css({
                        'width': '0',
                        'height': '0',
                        'overflow': 'hidden'
                    });
                }
            });
        }

        if ($scope.hasClass('tmpcoder-product-media-thumbs-slider') && $scope.hasClass('tmpcoder-product-media-thumbs-vertical')) {

            var thumbsToShow = $scope.find('.tmpcoder-product-media-wrap').data('slidestoshow');
            var thumbsToScroll = +$scope.find('.tmpcoder-product-media-wrap').data('slidestoscroll');

            $scope.find('.flex-control-nav').css('height', ((100 / thumbsToShow) * $scope.find('.flex-control-nav li').length) + '%');

            $scope.find('.flex-control-nav').wrap('<div class="tmpcoder-fcn-wrap"></div>');

            var thumbIcon1 = $scope.find('.tmpcoder-thumbnail-slider-prev-arrow');
            var thumbIcon2 = $scope.find('.tmpcoder-thumbnail-slider-next-arrow');

            thumbIcon1.remove();
            thumbIcon2.remove();

            if ($scope.find('.tmpcoder-product-media-wrap').data('slidestoshow') < $scope.find('.flex-control-nav li').length) {
                $scope.find('.tmpcoder-fcn-wrap').prepend(thumbIcon1);
                $scope.find('.tmpcoder-fcn-wrap').append(thumbIcon2);
            }

            var posy = 0;
            var slideCount = 0;

            $scope.find('.tmpcoder-thumbnail-slider-next-arrow').on('click', function () {
                // var currTrans =  $scope.find('.flex-control-nav').css('transform') != 'none' ? $scope.find('.flex-control-nav').css('transform').split(/[()]/)[1] : 0;
                // posx = currTrans ? currTrans.split(',')[4] : 0;
                if ((slideCount + thumbsToScroll) < $scope.find('.flex-control-nav li').length - 1) {
                    posy++;
                    slideCount = slideCount + thumbsToScroll;
                    $scope.find('.flex-control-nav').css('transform', 'translateY(' + (parseInt(-posy) * (parseInt($scope.find('.flex-control-nav li:last-child').css('height').slice(0, -2)) + parseInt($scope.find('.flex-control-nav li').css('margin-bottom'))) * thumbsToScroll) + 'px)');
                    if (posy >= 1) {
                        $scope.find('.tmpcoder-thumbnail-slider-prev-arrow').attr('disabled', false);
                    } else {
                        $scope.find('.tmpcoder-thumbnail-slider-prev-arrow').attr('disabled', true);
                    }
                } else {
                    posy = 0;
                    slideCount = 0;
                    $scope.find('.flex-control-nav').css('transform', `translateY(0)`);
                    $scope.find('.tmpcoder-thumbnail-slider-prev-arrow').attr('disabled', true);
                }
            });

            $scope.find('.tmpcoder-thumbnail-slider-prev-arrow').on('click', function () {
                if (posy >= 1) {
                    posy--;
                    if (posy == 0) {
                        $(this).attr('disabled', true);
                    }
                    slideCount = slideCount - thumbsToScroll;
                    $scope.find('.flex-control-nav').css('transform', 'translateY(' + parseInt(-posy) * (parseInt($scope.find('.flex-control-nav li').css('height').slice(0, -2)) + parseInt($scope.find('.flex-control-nav li:last-child').css('margin-top'))) * thumbsToScroll + 'px)');
                    if (slideCount < $scope.find('.flex-control-nav li').length - 1) {
                        $scope.find('.tmpcoder-thumbnail-slider-next-arrow').attr('disabled', false);
                    } else {
                        $scope.find('.tmpcoder-thumbnail-slider-next-arrow').attr('disabled', true);
                    }
                } else {
                    // slideCount = $scope.find('.flex-control-nav li').length - 1;
                    // $scope.find('.flex-control-nav').css('transform', `translateX(0)`);
                    $(this).attr('disabled', true);
                }
            });
        }

        if ($scope.hasClass('tmpcoder-product-media-thumbs-slider') && $scope.find('.tmpcoder-product-media-wrap').hasClass('tmpcoder-product-media-thumbs-horizontal')) {

            var thumbsToShow = $scope.find('.tmpcoder-product-media-wrap').data('slidestoshow');
            var thumbsToScroll = +$scope.find('.tmpcoder-product-media-wrap').data('slidestoscroll');

            $scope.find('.flex-control-nav').css('width', ((100 / thumbsToShow) * $scope.find('.flex-control-nav li').length) + '%');

            $scope.find('.flex-control-nav').wrap('<div class="tmpcoder-fcn-wrap"></div>');

            var thumbIcon1 = $scope.find('.tmpcoder-thumbnail-slider-prev-arrow');
            var thumbIcon2 = $scope.find('.tmpcoder-thumbnail-slider-next-arrow');

            thumbIcon1.remove();
            thumbIcon2.remove();

            if ($scope.find('.tmpcoder-product-media-wrap').data('slidestoshow') < $scope.find('.flex-control-nav li').length) {
                $scope.find('.tmpcoder-fcn-wrap').prepend(thumbIcon1);
                $scope.find('.tmpcoder-fcn-wrap').append(thumbIcon2);
                $scope.find('.tmpcoder-thumbnail-slider-arrow').removeClass('tmpcoder-tsa-hidden');
            }

            var posx = 0;
            var slideCount = 0;
            $scope.find('.tmpcoder-thumbnail-slider-prev-arrow').attr('disabled', true);


            // Calculate item width and margin once
            var itemWidth = parseFloat($scope.find('.flex-control-nav li').css('width'));
            var itemMargin = parseFloat($scope.find('.flex-control-nav li').css('margin-right'));
            var totalItems = $scope.find('.flex-control-nav li').length;
            var containerWidth = $scope.find('.flex-control-nav').parent().width();
            var totalWidth = (itemWidth + itemMargin) * totalItems;

            $scope.find('.tmpcoder-thumbnail-slider-next-arrow').on('click', function () {
                var maxPosx = Math.ceil((totalWidth - containerWidth) / ((itemWidth + itemMargin) * thumbsToScroll));

                if (posx < maxPosx) {
                    posx++;
                    slideCount += thumbsToScroll;
                    var translateXValue = Math.min(posx * (itemWidth + itemMargin) * thumbsToScroll, totalWidth - containerWidth);
                    $scope.find('.flex-control-nav').css('transform', 'translateX(-' + translateXValue + 'px)');

                    // Update previous arrow state
                    $scope.find('.tmpcoder-thumbnail-slider-prev-arrow').attr('disabled', posx <= 0);

                    // Update next arrow state
                    $scope.find('.tmpcoder-thumbnail-slider-next-arrow').attr('disabled', posx >= maxPosx);
                }
            });

            $scope.find('.tmpcoder-thumbnail-slider-prev-arrow').on('click', function () {
                if (posx > 0) {
                    posx--;
                    slideCount -= thumbsToScroll;
                    var translateXValue = posx * (itemWidth + itemMargin) * thumbsToScroll;
                    $scope.find('.flex-control-nav').css('transform', 'translateX(-' + translateXValue + 'px)');

                    // Update previous arrow state
                    $scope.find('.tmpcoder-thumbnail-slider-prev-arrow').attr('disabled', posx <= 0);

                    // Update next arrow state
                    var maxPosx = Math.ceil((totalWidth - containerWidth) / ((itemWidth + itemMargin) * thumbsToScroll));
                    $scope.find('.tmpcoder-thumbnail-slider-next-arrow').attr('disabled', posx >= maxPosx);
                }
            });

        }
    } // End widgetProductMedia
    
    $(window).on('elementor/frontend/init', function () {
        elementorFrontend.hooks.addAction("frontend/element_ready/tmpcoder-product-media.default",
            widgetProductMedia);
    });
})(jQuery);