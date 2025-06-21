(function ($) {
    "use strict";

    const widgetOffcanvas = function ($scope, $) {
        let animationDuration;

        if ($scope.hasClass('tmpcoder-offcanvas-entrance-animation-pro-sl')) {
            $scope.removeClass('tmpcoder-offcanvas-entrance-animation-pro-sl').addClass('tmpcoder-offcanvas-entrance-animation-fade');
        } else if ($scope.hasClass('tmpcoder-offcanvas-entrance-animation-pro-gr')) {
            $scope.removeClass('tmpcoder-offcanvas-entrance-animation-pro-gr').addClass('tmpcoder-offcanvas-entrance-animation-fade');
        }

        if ($scope.hasClass('tmpcoder-offcanvas-entrance-type-pro-ps')) {
            $scope.removeClass('tmpcoder-offcanvas-entrance-type-pro-ps').addClass('tmpcoder-offcanvas-entrance-type-cover');
        }

        function openOffcanvas(offcanvasSelector) {
            if (!$scope.hasClass('tmpcoder-offcanvas-entrance-type-push') && !$scope.find('.tmpcoder-offcanvas-content').hasClass('tmpcoder-offcanvas-content-relative')) {
                $('body').addClass('tmpcoder-offcanvas-body-overflow');
            }
            animationDuration = +offcanvasSelector.find('.tmpcoder-offcanvas-content').css('animation-duration').replace('s', '') * 1000;
            offcanvasSelector.fadeIn(animationDuration);
            offcanvasSelector.addClass('tmpcoder-offcanvas-wrap-active');
            if ($scope.hasClass('tmpcoder-offcanvas-entrance-animation-slide')) {
                if (offcanvasSelector.find('.tmpcoder-offcanvas-content').hasClass('tmpcoder-offcanvas-slide-in')) {
                    offcanvasSelector.find('.tmpcoder-offcanvas-content').removeClass('tmpcoder-offcanvas-slide-in').addClass('tmpcoder-offcanvas-slide-out');
                } else {
                    offcanvasSelector.find('.tmpcoder-offcanvas-content').removeClass('tmpcoder-offcanvas-slide-out').addClass('tmpcoder-offcanvas-slide-in');
                }
            } else if ($scope.hasClass('tmpcoder-offcanvas-entrance-animation-grow')) {
                if (offcanvasSelector.find('.tmpcoder-offcanvas-content').hasClass('tmpcoder-offcanvas-grow-in')) {
                    offcanvasSelector.find('.tmpcoder-offcanvas-content').removeClass('tmpcoder-offcanvas-grow-in').addClass('tmpcoder-offcanvas-grow-out');
                } else {
                    offcanvasSelector.find('.tmpcoder-offcanvas-content').removeClass('tmpcoder-offcanvas-grow-out').addClass('tmpcoder-offcanvas-grow-in');
                }
            } else if ($scope.hasClass('tmpcoder-offcanvas-entrance-animation-fade')) {
                if (offcanvasSelector.find('.tmpcoder-offcanvas-content').hasClass('tmpcoder-offcanvas-fade-in')) {
                    offcanvasSelector.find('.tmpcoder-offcanvas-content').removeClass('tmpcoder-offcanvas-fade-in').addClass('tmpcoder-offcanvas-fade-out');
                } else {
                    offcanvasSelector.find('.tmpcoder-offcanvas-content').removeClass('tmpcoder-offcanvas-fade-out').addClass('tmpcoder-offcanvas-fade-in');
                }
            }

            $(window).trigger('resize');
        }

        function closeOffcanvas(offcanvasSelector) {
            if (!$scope.hasClass('tmpcoder-offcanvas-entrance-type-push') && !$scope.find('.tmpcoder-offcanvas-content').hasClass('tmpcoder-offcanvas-content-relative')) {
                $('body').removeClass('tmpcoder-offcanvas-body-overflow');
            }
            if ($scope.hasClass('tmpcoder-offcanvas-entrance-animation-slide')) {
                offcanvasSelector.find('.tmpcoder-offcanvas-content').removeClass('tmpcoder-offcanvas-slide-in').addClass('tmpcoder-offcanvas-slide-out');
            } else if ($scope.hasClass('tmpcoder-offcanvas-entrance-animation-grow')) {
                offcanvasSelector.find('.tmpcoder-offcanvas-content').removeClass('tmpcoder-offcanvas-grow-in').addClass('tmpcoder-offcanvas-grow-out');
            } else if ($scope.hasClass('tmpcoder-offcanvas-entrance-animation-fade')) {
                offcanvasSelector.find('.tmpcoder-offcanvas-content').removeClass('tmpcoder-offcanvas-fade-in').addClass('tmpcoder-offcanvas-fade-out');
            }

            offcanvasSelector.fadeOut(animationDuration);
            offcanvasSelector.removeClass('tmpcoder-offcanvas-wrap-active');
            // setTimeout(function() {
            // }, 600);
        }

        if ($scope.hasClass('tmpcoder-offcanvas-entrance-type-push')) {

            function growBodyWidth() {

                if ($('.tmpcoder-offcanvas-body-inner-wrap-' + $scope.data('id')).length < 1) {
                    var offcanvasWrap = $('.tmpcoder-offcanvas-wrap-' + $scope.data('id')).clone();
                    $('.tmpcoder-offcanvas-wrap-' + $scope.data('id')).remove();

                    if (!($('.tmpcoder-offcanvas-body-inner-wrap-' + $scope.data('id')).length > 0)) {
                        $("body").wrapInner('<div class="tmpcoder-offcanvas-body-inner-wrap-' + $scope.data('id') + '" />');
                    }

                    bodyInnerWrap = $('.tmpcoder-offcanvas-body-inner-wrap-' + $scope.data('id'));

                    bodyInnerWrap.css('position', 'relative');

                    if (!(bodyInnerWrap.prev('.tmpcoder-offcanvas-wrap').length > 0)) {
                        console.log(offcanvasWrap);
                        document.querySelector('body').insertBefore(offcanvasWrap[0], document.querySelector('.tmpcoder-offcanvas-body-inner-wrap-' + $scope.data('id')));
                    }

                    offcanvasSelector = $('.tmpcoder-offcanvas-wrap-' + $scope.data('id'));
                }

                openOffcanvas(offcanvasSelector);

                $('body').addClass('tmpcoder-offcanvas-body-overflow');

                if (offcanvasSelector.find('.tmpcoder-offcanvas-content').hasClass('tmpcoder-offcanvas-content-left')) {
                    // bodyInnerWrap.animate({'margin-left': offcanvasSelector.find('.tmpcoder-offcanvas-content').width() + 'px'}, 'slow');
                    bodyInnerWrap.css({
                        'transition-duration': offcanvasSelector.find('.tmpcoder-offcanvas-content').css('animation-duration'),
                        'transform': 'translateX(' + offcanvasSelector.find('.tmpcoder-offcanvas-content').outerWidth() + 'px)',
                    });
                } else if (offcanvasSelector.find('.tmpcoder-offcanvas-content').hasClass('tmpcoder-offcanvas-content-right')) {
                    // bodyInnerWrap.animate({'margin-right': offcanvasSelector.find('.tmpcoder-offcanvas-content').width() + 'px'}, 'slow');
                    bodyInnerWrap.css({
                        'transition-duration': offcanvasSelector.find('.tmpcoder-offcanvas-content').css('animation-duration'),
                        'transform': 'translateX(-' + offcanvasSelector.find('.tmpcoder-offcanvas-content').outerWidth() + 'px)',
                    });
                } else if (offcanvasSelector.find('.tmpcoder-offcanvas-content').hasClass('tmpcoder-offcanvas-content-top')) {
                    // bodyInnerWrap.animate({'margin-top': offcanvasSelector.find('.tmpcoder-offcanvas-content').outerHeight() + 'px'}, 'slow');
                    bodyInnerWrap.css({
                        'transition-duration': offcanvasSelector.find('.tmpcoder-offcanvas-content').css('animation-duration'),
                        'margin-top': offcanvasSelector.find('.tmpcoder-offcanvas-content').outerHeight() + 'px',
                    });
                }
            }

            function reduceBodyWidth() {

                if (!bodyInnerWrap && !offcanvasSelector) {
                    bodyInnerWrap = $('.tmpcoder-offcanvas-body-inner-wrap-' + $scope.data('id'));
                    offcanvasSelector = $('.tmpcoder-offcanvas-wrap-' + $scope.data('id'));
                }

                closeOffcanvas(offcanvasSelector);

                if (offcanvasSelector.find('.tmpcoder-offcanvas-content').hasClass('tmpcoder-offcanvas-content-left')) {
                    // bodyInnerWrap.animate({'margin-left': 0}, 'slow');
                    bodyInnerWrap.css({ 'transform': 'translateX(0px)' });
                } else if (offcanvasSelector.find('.tmpcoder-offcanvas-content').hasClass('tmpcoder-offcanvas-content-right')) {
                    // bodyInnerWrap.animate({'margin-right': 0}, 'slow');
                    bodyInnerWrap.css({ 'transform': 'translateX(0px)' });
                } else if (offcanvasSelector.find('.tmpcoder-offcanvas-content').hasClass('tmpcoder-offcanvas-content-top')) {
                    // bodyInnerWrap.animate({'margin-top': 0}, 'slow');
                    bodyInnerWrap.css({ 'margin-top': 0 });
                }

                $('body').removeClass('tmpcoder-offcanvas-body-overflow');
                setTimeout(function () {
                    var cnt = $('.tmpcoder-offcanvas-body-inner-wrap-' + $scope.data('id')).contents();
                    $('.tmpcoder-offcanvas-body-inner-wrap-' + $scope.data('id')).replaceWith(cnt);
                }, 1000);
            }

            function closeTriggers() {
                offcanvasSelector.on('click', function (e) {
                    if (!e.target.classList.value.includes('tmpcoder-offcanvas-content') && !e.target.closest('.tmpcoder-offcanvas-content')) {
                        reduceBodyWidth();
                    }
                });

                $(document).on('keyup', function (event) {
                    if (event.key == "Escape") {
                        reduceBodyWidth();
                    }
                });

                offcanvasSelector.find('.tmpcoder-close-offcanvas').on('click', function () {
                    reduceBodyWidth();
                });
            }

            if (!($('.tmpcoder-offcanvas-body-inner-wrap-' + $scope.data('id')).length > 0)) {
                $("body").wrapInner('<div class="tmpcoder-offcanvas-body-inner-wrap-' + $scope.data('id') + '" />');
            }

            var bodyInnerWrap = $('.tmpcoder-offcanvas-body-inner-wrap-' + $scope.data('id'));

            bodyInnerWrap.css('position', 'relative');

            if (!(bodyInnerWrap.prev('.tmpcoder-offcanvas-wrap').length > 0)) {
                $scope.find('.tmpcoder-offcanvas-wrap').addClass('tmpcoder-offcanvas-wrap-' + $scope.data('id'));

                document.querySelector('body').insertBefore($scope.find('.tmpcoder-offcanvas-wrap')[0], document.querySelector('.tmpcoder-offcanvas-body-inner-wrap-' + $scope.data('id')));
            }

            var offcanvasSelector = $('.tmpcoder-offcanvas-wrap-' + $scope.data('id'));

            $scope.find('.tmpcoder-offcanvas-trigger').on('click', function () {
                if ($('.tmpcoder-offcanvas-wrap-' + $scope.data('id')).length > 0 && $scope.find('.tmpcoder-offcanvas-wrap').length > 0) {
                    $('.tmpcoder-offcanvas-wrap-' + $scope.data('id')).remove();
                    $scope.find('.tmpcoder-offcanvas-wrap').addClass('tmpcoder-offcanvas-wrap-' + $scope.data('id'));
                    document.querySelector('body').insertBefore($scope.find('.tmpcoder-offcanvas-wrap')[0], document.querySelector('.tmpcoder-offcanvas-body-inner-wrap-' + $scope.data('id')));
                    offcanvasSelector = $('.tmpcoder-offcanvas-wrap-' + $scope.data('id'));
                }

                if (offcanvasSelector.hasClass('tmpcoder-offcanvas-wrap-active')) {
                    reduceBodyWidth();
                } else {
                    growBodyWidth();
                }
            });

            if ('yes' === $scope.find('.tmpcoder-offcanvas-container').data('offcanvas-open')) {
                $scope.find('.tmpcoder-offcanvas-trigger').trigger('click');
            }

            closeTriggers();

            $('body').on('click', function () {
                closeTriggers();
            });

            var mutationObserver = new MutationObserver(function (mutations) {
                closeTriggers();
            });

            mutationObserver.observe($scope[0], {
                childList: true,
                subtree: true,
            });
        } else {

            $scope.find('.tmpcoder-offcanvas-trigger').on('click', function () {
                if (!$scope.find('.tmpcoder-offcanvas-wrap').hasClass('tmpcoder-offcanvas-wrap-active')) {
                    openOffcanvas($scope.find('.tmpcoder-offcanvas-wrap'));
                } else if ($scope.find('.tmpcoder-offcanvas-wrap').hasClass('tmpcoder-offcanvas-wrap-active') && $scope.find('.tmpcoder-offcanvas-wrap').hasClass('tmpcoder-offcanvas-wrap-relative')) {
                    closeOffcanvas($scope.find('.tmpcoder-offcanvas-wrap'));
                }
            });

            $scope.find('.tmpcoder-offcanvas-wrap').on('click', function (e) {
                if (!e.target.classList.value.includes('tmpcoder-offcanvas-content') && !e.target.closest('.tmpcoder-offcanvas-content')) {
                    closeOffcanvas($scope.find('.tmpcoder-offcanvas-wrap'));
                }
            });

            if ('yes' === $scope.find('.tmpcoder-offcanvas-container').data('offcanvas-open')) {
                $scope.find('.tmpcoder-offcanvas-trigger').trigger('click');
            }

            $(document).on('keyup', function (event) {
                if (event.key == "Escape") {
                    closeOffcanvas($scope.find('.tmpcoder-offcanvas-wrap'));
                }
            });

            $scope.find('.tmpcoder-close-offcanvas').on('click', function () {
                closeOffcanvas($scope.find('.tmpcoder-offcanvas-wrap'));
            });
        }
    }
    
    $(window).on('elementor/frontend/init', function () {
        elementorFrontend.hooks.addAction("frontend/element_ready/tmpcoder-offcanvas.default",
            widgetOffcanvas);
    });
})(jQuery);