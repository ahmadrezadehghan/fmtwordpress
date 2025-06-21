(function ($) {
    "use strict";

    window.actionTargetProductId = window.actionTargetProductId || null;

    if (typeof VideoLightBoxWidget != 'function') {
        window.VideoLightBoxWidget = function () {
        }
    }

    window.hasRtl = function () {
        if (jQuery("body").hasClass("rtl")) {
            return true;
        }
        else {
            return false;
        }
    }

    window.changeActionTargetProductId = function(productId) {
        actionTargetProductId = productId;
    }

    jQuery('body').on('removed_from_cart', function (ev, fragments, hash, button) {
        setTimeout(function () {
            if (jQuery('.refresh-tmpcoder-cart-qty').length > 0) {
                jQuery('.tmpcoder-cart-total .tmpcoder-total-qty').text(jQuery('.refresh-tmpcoder-cart-qty').val());
                jQuery('.tmpcoder-cart-popup .tmpcoder-cart-popup-count').text(jQuery('.refresh-tmpcoder-cart-qty').val());
            }
            if (jQuery('.refresh-tmpcoder-cart-total').length > 0) {
                jQuery('.tmpcoder-cart-total .woocommerce-Price-amount').replaceWith(jQuery('.refresh-tmpcoder-cart-total .woocommerce-Price-amount').clone());
            }
        }, 200);
    });

    jQuery('body').on('removed_from_cart added_to_cart updated_cart_totals', function (event) {

        if (jQuery(".mini-cart-custom-icon").val() == 1) {
            jQuery(".tmpcoder-cart-popup-body").addClass('custom-remove-icon');
        }
        jQuery("#tmpcoder-cart-button").load(location.href + " #tmpcoder-cart-button>*", "");
        jQuery("#tmpcoder-cart-popup").load(location.href + " #tmpcoder-cart-popup>*", "");
    });

    window.editorCheck = function() {
        return jQuery('body').hasClass('elementor-editor-active') ? true : false;
    }

    const widgetSection = function ($scope, $) {

        if ($scope.attr('data-tmpcoder-particles') || $scope.find('.tmpcoder-particle-wrapper').attr('data-tmpcoder-particles-editor')) {
            particlesEffect();
        }

        if ($scope.hasClass('tmpcoder-jarallax') || $scope.hasClass('tmpcoder-jarallax-yes')) {
            parallaxBackground();
        }

        if ($scope.hasClass('tmpcoder-parallax-yes')) {
            parallaxMultiLayer();
        }

        if ($scope.hasClass('tmpcoder-sticky-section-yes')) {
            stickySection();
        }

        function stickySection() {
            var positionType = !editorCheck() ? $scope.attr('data-tmpcoder-position-type') : $scope.find('.tmpcoder-sticky-section-yes-editor').attr('data-tmpcoder-position-type'),
                positionLocation = !editorCheck() ? $scope.attr('data-tmpcoder-position-location') : $scope.find('.tmpcoder-sticky-section-yes-editor').attr('data-tmpcoder-position-location'),
                positionOffset = !editorCheck() ? $scope.attr('data-tmpcoder-position-offset') : $scope.find('.tmpcoder-sticky-section-yes-editor').attr('data-tmpcoder-position-offset'),
                viewportWidth = $('body').prop('clientWidth') + 17,
                availableDevices = !editorCheck() ? $scope.attr('data-tmpcoder-sticky-devices') : $scope.find('.tmpcoder-sticky-section-yes-editor').attr('data-tmpcoder-sticky-devices'),
                activeDevices = !editorCheck() ? $scope.attr('data-tmpcoder-active-breakpoints') : $scope.find('.tmpcoder-sticky-section-yes-editor').attr('data-tmpcoder-active-breakpoints'),
                stickySectionExists = $scope.hasClass('tmpcoder-sticky-section-yes') || $scope.find('.tmpcoder-sticky-section-yes-editor') ? true : false,
                positionStyle,
                adminBarHeight,
                stickyEffectsOffset = 0,
                stickyHideDistance = 0,
                $window = $(window),
                prevScrollPos = $window.scrollTop(),
                stickyHeaderFooter = '',
                stickyAnimation = 'none',
                stickyAnimationHide = '',
                headerFooterZIndex = !editorCheck() ? $scope.attr('data-tmpcoder-z-index') : $scope.find('.tmpcoder-sticky-section-yes-editor').attr('data-tmpcoder-z-index'),
                stickType = !editorCheck() ? $scope.attr('data-tmpcoder-sticky-type') : $scope.find('.tmpcoder-sticky-section-yes-editor').attr('data-tmpcoder-sticky-type');

            var distanceFromTop = $scope.offset().top;

            if ($scope.data('settings').sticky_animation) {
                stickyAnimation = $scope.data('settings').sticky_animation;
            } else {
                stickyAnimation = $scope.find('.tmpcoder-sticky-section-yes-editor').attr('data-tmpcoder-sticky-animation');
            }

            var stickyAnimDuration = $scope.attr('data-tmpcoder-animation-duration') ? $scope.attr('data-tmpcoder-animation-duration') + 's' : 500 + 's';

            // if ( editorCheck() ) { // needs different approach
            //  if ( $scope.next('section').length > 0 && ($scope.next('section').offset().top < ($scope.offset().top + $scope.height())) ) {
            //      $scope.next('section').css('margin-top', $scope.offset().top + $scope.height() + 'px');
            //  }
            // }

            if ($scope.closest('div[data-elementor-type="wp-post"]').length > 0) {
                stickyHeaderFooter = $scope.closest('div[data-elementor-type="wp-post"]');
            } else if ($scope.closest('div[data-elementor-type="header"]').length > 0) {
                stickyHeaderFooter = $scope.closest('div[data-elementor-type="header"]');
            } else if ($scope.closest('div[data-elementor-type="footer"]').length > 0) {
                stickyHeaderFooter = $scope.closest('div[data-elementor-type="footer"]');
            }

            if (!$scope.find('.tmpcoder-sticky-section-yes-editor').length) {
                positionType = $scope.attr('data-tmpcoder-position-type');
                positionLocation = $scope.attr('data-tmpcoder-position-location');
                positionOffset = $scope.attr('data-tmpcoder-position-offset');
                availableDevices = $scope.attr('data-tmpcoder-sticky-devices');
                activeDevices = $scope.attr('data-tmpcoder-active-breakpoints');
                headerFooterZIndex = $scope.attr('data-tmpcoder-z-index');
            }

            if ('top' === positionLocation && 'auto' === $scope.css('top')) {
                var offsetTop = 0;
                $scope.css('top', 0);
            } else {
                var offsetTop = +$scope.css('top').slice(0, -2);
            }

            if (0 == availableDevices.length) {
                positionType = 'relative';
            }

            if (editorCheck() && availableDevices) {
                var attributes = $scope.find('.tmpcoder-sticky-section-yes-editor').attr('data-tmpcoder-sticky-devices');
                $scope.attr('data-tmpcoder-sticky-devices', attributes);
                availableDevices = $scope.attr('data-tmpcoder-sticky-devices');
            }

            changePositionType();
            changeAdminBarOffset();

            $(window).smartresize(function () {
                distanceFromTop = $scope.offset().top;
                viewportWidth = $('body').prop('clientWidth') + 17;
                if ($(window).scrollTop() <= stickyEffectsOffset) {
                    changePositionType();
                }
            });

            if (!stickySectionExists) {
                // positionStyle = 'relative';
                positionStyle = 'fixed';
            }

            function changePositionType() {
                if (!$scope.hasClass('tmpcoder-sticky-section-yes') && !$scope.find('.tmpcoder-sticky-section-yes-editor')) {
                    positionStyle = 'relative';
                    return;
                }

                var checkDevices = [['mobile_sticky', 768], ['mobile_extra_sticky', 881], ['tablet_sticky', 1025], ['tablet_extra_sticky', 1201], ['laptop_sticky', 1216], ['desktop_sticky', 2400], ['widescreen_sticky', 4000]];
                var emptyVariables = [];

                var checkedDevices = checkDevices.filter((item, index) => {
                    return activeDevices.indexOf(item[0]) != -1;
                }).reverse();

                checkedDevices.forEach((device, index) => {
                    if (device[1] > viewportWidth) {
                        var deviceName = device[0].replace("_sticky", "");

                        if ('desktop' == deviceName) {
                            if ($scope.data('settings')) {
                                stickyEffectsOffset = distanceFromTop + $scope.data('settings').tmpcoder_sticky_effects_offset;
                            } else {
                                stickyEffectsOffset = distanceFromTop + $scope.find('.tmpcoder-sticky-section-yes-editor').attr('data-tmpcoder-offset-settings');
                            }
                        } else {
                            if ($scope.data('settings')) {
                                stickyEffectsOffset = distanceFromTop + $scope.data('settings')['tmpcoder_sticky_effects_offset_' + deviceName];
                            } else {
                                stickyEffectsOffset = distanceFromTop + $scope.find('.tmpcoder-sticky-section-yes-editor').attr('data-tmpcoder-offset-settings');
                            }
                        }

                        if (availableDevices.indexOf(device[0]) === -1) {
                            positionStyle = activeDevices?.indexOf(device[0]) !== -1 ? 'relative' : (emptyVariables[index - 1] ? emptyVariables[index - 1] : positionType);
                            // positionStyle = activeDevices && activeDevices.indexOf(device[0]) !== -1 ? 'static' : (emptyVariables[index - 1] ? emptyVariables[index - 1] : positionType);
                            emptyVariables[index] = positionStyle;
                        } else if (availableDevices.indexOf(device[0]) !== -1) {
                            positionStyle = positionType;
                        }
                    }
                });

                var handleScroll = function () {
                    let scrollPos = $window.scrollTop();

                    if ('fixed' != positionStyle) {
                        if (scrollPos > distanceFromTop) {
                            applyPosition();
                        } else if (scrollPos <= distanceFromTop) {

                            // $scope.css({ 'position': 'relative' });
                            
                            /* Updated below position because section`is content jerk when section sticky */
                            $scope.css({ 'position': 'sticky' });
                        }
                    }

                    if ('relative' !== positionStyle) {
                        stickyEffectsOffset = 0;
                        if (scrollPos > stickyEffectsOffset) {
                            if ('yes' == $scope.data('tmpcoder-replace-header')) {

                                if ('yes' === $scope.data('tmpcoder-sticky-hide')) {

                                    if (scrollPos >= distanceFromTop) {
                                        $scope.addClass('tmpcoder-visibility-hidden');
                                    }

                                    if (scrollPos < prevScrollPos) {
                                        $scope.next().addClass('tmpcoder-hidden-header').addClass('tmpcoder-' + stickyAnimation + '-in');
                                    }
                                } else {
                                    $scope.addClass('tmpcoder-visibility-hidden');
                                    $scope.next().addClass('tmpcoder-hidden-header').addClass('tmpcoder-' + stickyAnimation + '-in');
                                }
                            } else {
                                $scope.addClass('tmpcoder-sticky-header');
                            }
                        } else if (scrollPos <= stickyEffectsOffset) {
                            if ('yes' == $scope.data('tmpcoder-replace-header')) {
                                $scope.next().removeClass('tmpcoder-hidden-header');
                                $scope.removeClass('tmpcoder-visibility-hidden');
                                $scope.next().removeClass('tmpcoder-' + stickyAnimation + '-in');
                            } else {
                                $scope.removeClass('tmpcoder-sticky-header');
                            }
                        }
                    }

                    if ('yes' === $scope.data('tmpcoder-sticky-hide')) {
                        distanceFromTop = 0;
                        if (scrollPos >= distanceFromTop) {
                            if (scrollPos < prevScrollPos) {
                                // Scrolling up
                                if ('yes' === $scope.data('tmpcoder-replace-header')) {
                                    $scope.next().removeClass('tmpcoder-' + stickyAnimation + '-out');
                                    $scope.next().addClass('tmpcoder-' + stickyAnimation + '-in');
                                } else {
                                    $scope.removeClass('tmpcoder-' + stickyAnimation + '-out');
                                    $scope.addClass('tmpcoder-' + stickyAnimation + '-in');
                                }
                            } else {
                                // Scrolling down or no direction change
                                if ('yes' === $scope.data('tmpcoder-replace-header')) {
                                    $scope.next().removeClass('tmpcoder-' + stickyAnimation + '-in');
                                    $scope.next().addClass('tmpcoder-' + stickyAnimation + '-out');
                                } else {
                                    $scope.removeClass('tmpcoder-' + stickyAnimation + '-in');
                                    $scope.addClass('tmpcoder-' + stickyAnimation + '-out');
                                }
                            }
                        }

                        // else if ( scrollPos <= stickyHideDistance ) {
                        //  // At or above the top
                        //  $scope.removeClass('tmpcoder-sticky-hide');
                        // }    
                    }

                    // Clear any previous timeout
                    clearTimeout(scrollEndTimeout);

                    // Set a new timeout to update prevScrollPos after 150 milliseconds (adjust the delay as needed)
                    scrollEndTimeout = setTimeout(() => {
                        prevScrollPos = scrollPos;
                    }, 10);
                }

                // const debouncedHandleScroll = _.debounce(handleScroll, 50);

                if ('sticky' == positionStyle) {
                    // $(window).scroll(debouncedHandleScroll);
                    $(window).scroll(handleScroll);

                    // $(window).scroll(function() {
                    //  debounceScroll(handleScroll, 50);
                    // });
                } else if ('fixed' == positionStyle) {
                    applyPosition();
                    $(window).scroll(handleScroll);
                }

                if ('yes' == $scope.data('tmpcoder-replace-header')) {
                    $scope.next().get(0).style.setProperty('--tmpcoder-animation-duration', stickyAnimDuration);
                }

                function debounceScroll(method, delay) {
                    clearTimeout(method._tId);
                    method._tId = setTimeout(function () {
                        method();
                    }, delay);
                }

                let scrollEndTimeout;
            }

            function applyPosition() {
                var bottom = +window.innerHeight - (+$scope.css('top').slice(0, -2) + $scope.height());
                var top = +window.innerHeight - (+$scope.css('bottom').slice(0, -2) + $scope.height());

                if ('yes' === $scope.data('tmpcoder-sticky-hide') && prevScrollPos < $window.scrollTop()) {
                    return;
                }

                if ('' == stickType) {
                    stickType = 'fixed';
                }

                $scope.css({ 'position': stickType });
            }

            function changeAdminBarOffset() {
                if ($('#wpadminbar').length) {
                    adminBarHeight = $('#wpadminbar').css('height').slice(0, $('#wpadminbar').css('height').length - 2);
                    // if ( 'top'  ===  positionLocation && ( 'fixed' == $scope.css('position')  || 'sticky' == $scope.css('position') ) ) {
                    if ('top' === positionLocation && ('fixed' == $scope.css('position'))) {
                        $scope.css('top', +adminBarHeight + offsetTop + 'px');
                        $scope.css('bottom', 'auto');
                    }
                }
            }
        }

        function particlesEffect() {
            var elementType = $scope.data('element_type'),
                sectionID = $scope.data('id'),
                particlesJSON = !editorCheck() ? $scope.attr('data-tmpcoder-particles') : $scope.find('.tmpcoder-particle-wrapper').attr('data-tmpcoder-particles-editor');

            if (('section' === elementType || 'container' === elementType) && undefined !== particlesJSON) {
                // Frontend
                if (!editorCheck()) {
                    $scope.prepend('<div class="tmpcoder-particle-wrapper" id="tmpcoder-particle-' + sectionID + '"></div>');

                    particlesJS('tmpcoder-particle-' + sectionID, $scope.attr('particle-source') == 'tmpcoder_particle_json_custom' ? JSON.parse(particlesJSON) : modifyJSON(particlesJSON));

                    setTimeout(function () {
                        window.dispatchEvent(new Event('resize'));
                    }, 500);

                    setTimeout(function () {
                        window.dispatchEvent(new Event('resize'));
                    }, 1500);
                    // Editor
                } else {
                    if ($scope.hasClass('tmpcoder-particle-yes')) {
                        particlesJS('tmpcoder-particle-' + sectionID, $scope.find('.tmpcoder-particle-wrapper').attr('particle-source') == 'tmpcoder_particle_json_custom' ? JSON.parse(particlesJSON) : modifyJSON(particlesJSON));

                        $scope.find('.elementor-column').css('z-index', 9);

                        setTimeout(function () {
                            window.dispatchEvent(new Event('resize'));
                        }, 500);

                        setTimeout(function () {
                            window.dispatchEvent(new Event('resize'));
                        }, 1500);
                    } else {
                        $scope.find('.tmpcoder-particle-wrapper').remove();
                    }
                }
            }
        }

        function modifyJSON(json) {
            var wpJson = JSON.parse(json),
                particles_quantity = !editorCheck() ? $scope.attr('tmpcoder-quantity') : $scope.find('.tmpcoder-particle-wrapper').attr('tmpcoder-quantity'),
                particles_color = !editorCheck() ? $scope.attr('tmpcoder-color') || '#000000' : $scope.find('.tmpcoder-particle-wrapper').attr('tmpcoder-color') ? $scope.find('.tmpcoder-particle-wrapper').attr('tmpcoder-color') : '#000000',
                particles_speed = !editorCheck() ? $scope.attr('tmpcoder-speed') : $scope.find('.tmpcoder-particle-wrapper').attr('tmpcoder-speed'),
                particles_shape = !editorCheck() ? $scope.attr('tmpcoder-shape') : $scope.find('.tmpcoder-particle-wrapper').attr('tmpcoder-shape'),
                particles_size = !editorCheck() ? $scope.attr('tmpcoder-size') : $scope.find('.tmpcoder-particle-wrapper').attr('tmpcoder-size');

            wpJson.particles.size.value = particles_size;
            wpJson.particles.number.value = particles_quantity;
            wpJson.particles.color.value = particles_color;
            wpJson.particles.shape.type = particles_shape;
            wpJson.particles.line_linked.color = particles_color;
            wpJson.particles.move.speed = particles_speed;

            return wpJson;
        }

        function throttle(fn, delay) {
            let lastCall = 0;
            return function (...args) {
                const now = new Date().getTime();
                if (now - lastCall < delay) {
                    return;
                }
                lastCall = now;
                return fn(...args);
            };
        }

        // Zoom in animation logic
        function initializeScrollZoomAnimationTrigger($newScope) {

            if (window.matchMedia('(prefers-reduced-motion: reduce)').matches) return;

            const animationTriggerElements = Array.from(document.getElementsByClassName($newScope));

            if (animationTriggerElements.length === 0) return;

            const scaleAmount = 0.2 / 100;

            animationTriggerElements.forEach((element) => {
                let elementIsVisible = false;
                const observer = new IntersectionObserver((elements) => {
                    elements.forEach((entry) => {
                        elementIsVisible = entry.isIntersecting;
                    });
                });
                observer.observe(element);
                window.addEventListener(
                    'scroll',
                    throttle(() => {
                        if (!elementIsVisible) return;
                        element.style.setProperty('scale', 1 + scaleAmount * percentageSeen(element));
                    }),
                    { passive: true }
                );
            });
        }

        function percentageSeen(element) {
            const viewportHeight = window.innerHeight;
            const scrollY = window.scrollY;
            const elementPositionY = element.getBoundingClientRect().top + scrollY;
            const elementHeight = element.offsetHeight;

            if (elementPositionY > scrollY + viewportHeight) {
                // If we haven't reached the image yet
                return 0;
            } else if (elementPositionY + elementHeight < scrollY) {
                // If we've completely scrolled past the image
                return 100;
            }

            // When the image is in the viewport
            const distance = scrollY + viewportHeight - elementPositionY;
            let percentage = distance / ((viewportHeight + elementHeight) / 100);
            return Math.round(percentage);
        }

        function parallaxBackground() {
            if ($scope.hasClass('tmpcoder-jarallax-yes')) {
                if (!editorCheck() && $scope.hasClass('tmpcoder-jarallax')) {
                    $scope.css('background-image', 'url("' + $scope.attr('bg-image') + '")');

                    if ($scope.attr('scroll-effect') == 'scale') {
                        $scope.css('background-image', '');

                        $scope.find('.e-con-inner,.elementor-container').css('z-index', 1);

                        $scope.append('<div class="tmpcoder-custom-zoom-effect" style="background-image: url(' + $scope.attr('bg-image') + ');background-position: center center;background-repeat: no-repeat;background-size: cover;position: absolute;top: 0px;left: 0px;width: 100%;height: 100%;"></div>');
                        initializeScrollZoomAnimationTrigger('tmpcoder-custom-zoom-effect');
                    }
                    else {
                        $scope.jarallax({
                            type: $scope.attr('scroll-effect'),
                            speed: $scope.attr('speed-data'),
                        });
                    }

                } else if (editorCheck()) {
                    $scope.css('background-image', 'url("' + $scope.find('.tmpcoder-jarallax').attr('bg-image-editor') + '")');
                    $scope.jarallax({
                        type: $scope.find('.tmpcoder-jarallax').attr('scroll-effect-editor'),
                        speed: $scope.find('.tmpcoder-jarallax').attr('speed-data-editor')
                    });
                }
            }
        }

        function parallaxMultiLayer() {
            if ($scope.hasClass('tmpcoder-parallax-yes')) {
                var scene = document.getElementsByClassName('tmpcoder-parallax-multi-layer');

                var parallaxInstance = Array.from(scene).map(item => {
                    return new Parallax(item, {
                        invertY: item.getAttribute('direction') == 'yes' ? true : false,
                        invertX: item.getAttribute('direction') == 'yes' ? true : false,
                        scalarX: item.getAttribute('scalar-speed'),
                        scalarY: item.getAttribute('scalar-speed'),
                        hoverOnly: true,
                        pointerEvents: true
                    });
                });

                parallaxInstance.forEach(parallax => {
                    parallax.friction(0.2, 0.2);
                });
            }
            // if ( ! editorCheck() ) {                        
            var newScene = [];

            document.querySelectorAll('.tmpcoder-parallax-multi-layer').forEach((element, index) => {
                element.parentElement.style.position = "relative";
                element.style.position = "absolute";
                newScene.push(element);
                element.remove();
            });

            document.querySelectorAll('.tmpcoder-parallax-ml-children').forEach((element, index) => {
                element.style.position = "absolute";
                element.style.top = element.getAttribute('style-top');
                element.style.left = element.getAttribute('style-left');
            });

            $('.tmpcoder-parallax-yes').each(function (index) {
                $(this).append(newScene[index]);
            });
            // }
        }

        // ***** Container Spasing Start ***** //

        function container_spacer() {
            var win = jQuery(window).width();

            var con = 0;
            if (jQuery('.elementor-section-boxed .elementor-container').length) {
                con = jQuery('.elementor-section-boxed .elementor-container').width();
            }

            var total = (win - con) / 2;

            jQuery('.tmpcoder-dynamic-padding-left').css('padding-left', total);
            jQuery('.tmpcoder-dynamic-padding-right').css('padding-right', total);
        }

        $(window).on('load', function () {
            container_spacer();
        });

        $(window).resize(function () {
            container_spacer();
        });

    }

    jQuery(window).on('elementor/frontend/init', function () {

        jQuery(document).on("click", '.dialog-lightbox-widget .elementor-video-container', function (e) {
            jQuery(".dialog-close-button").trigger("click");
        });

        $(function () {
            $(window).resize();
        });
      
        elementorFrontend.hooks.addAction("frontend/element_ready/global",
            widgetSection);
    })

    jQuery('.tmpcoder-testimonial-prev-arrow').on('click', function (e) {
        e.stopPropagation();
        var slide = hasRtl() ? 'slickNext' : 'slickPrev';
        jQuery(this).parent().parent().find('.tmpcoder-testimonial-carousel').slick(slide);
    });

    jQuery('.tmpcoder-testimonial-next-arrow').on('click', function (e) {
        e.stopPropagation();
        var slide = hasRtl() ? 'slickPrev' : 'slickNext';
        jQuery(this).parent().parent().find('.tmpcoder-testimonial-carousel').slick(slide);
    });

    jQuery('.tmpcoder-grid-slider-prev-arrow').on('click', function (e) {
        e.stopPropagation();
        var slide = hasRtl() ? 'slickNext' : 'slickPrev';
        jQuery(this).parent().prev().slick(slide);
    });

    jQuery('.tmpcoder-grid-slider-next-arrow').on('click', function (e) {
        e.stopPropagation();
        var slide = hasRtl() ? 'slickPrev' : 'slickNext';
        jQuery(this).parent().prev().slick(slide);
    });

}(jQuery));

// Resize Function - Debounce
(function ($, sr) {
    var debounce = function (func, threshold, execAsap) {
        var timeout;

        return function debounced() {
            var obj = this, args = arguments;
            function delayed() {
                if (!execAsap)
                    func.apply(obj, args);
                timeout = null;
            };

            if (timeout)
                clearTimeout(timeout);
            else if (execAsap)
                func.apply(obj, args);

            timeout = setTimeout(delayed, threshold || 100);
        };
    }
    // smartresize 
    jQuery.fn[sr] = function (fn) { return fn ? this.bind('resize', debounce(fn)) : this.trigger(sr); };
})(jQuery, 'smartresize');