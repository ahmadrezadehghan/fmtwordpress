(function ($) {
    "use strict";

    const widgetMegaMenu = function ($scope, $) {

        var $navMenu = $scope.find('.tmpcoder-nav-menu-container'),
            $mobileNavMenu = $scope.find('.tmpcoder-mobile-nav-menu-container');

        // Menu
        var subMenuFirst = $navMenu.find('.tmpcoder-nav-menu > li.menu-item-has-children'),
            subMenuDeep = $navMenu.find('.tmpcoder-sub-menu li.menu-item-has-children');

        if ($scope.find('.tmpcoder-mobile-toggle').length) {
            $scope.find('a').on('click', function () {
                if (this.pathname == window.location.pathname && !($(this).parent('li').children().length > 1)) {
                    $scope.find('.tmpcoder-mobile-toggle').trigger('click');
                }
            });
        }

        // Click
        if ($navMenu.attr('data-trigger') === 'click') {

            // First Sub
            subMenuFirst.children('a').on('click', function (e) {
                var currentItem = $(this).parent(),
                    childrenSub = currentItem.children('.tmpcoder-sub-menu, .tmpcoder-sub-mega-menu');

                // Reset
                subMenuFirst.not(currentItem).removeClass('tmpcoder-sub-open');
                if ($navMenu.hasClass('tmpcoder-nav-menu-horizontal') || ($navMenu.hasClass('tmpcoder-nav-menu-vertical'))) {
                    subMenuAnimation(subMenuFirst.children('.tmpcoder-sub-menu, .tmpcoder-sub-mega-menu'), false);
                }

                if (!currentItem.hasClass('tmpcoder-sub-open')) {
                    e.preventDefault();
                    currentItem.addClass('tmpcoder-sub-open');
                    subMenuAnimation(childrenSub, true);
                } else {
                    currentItem.removeClass('tmpcoder-sub-open');
                    subMenuAnimation(childrenSub, false);
                }
            });

            // Deep Subs
            subMenuDeep.on('click', function (e) {
                var currentItem = $(this),
                    childrenSub = currentItem.children('.tmpcoder-sub-menu');

                // Reset
                if ($navMenu.hasClass('tmpcoder-nav-menu-horizontal')) {
                    subMenuAnimation(subMenuDeep.find('.tmpcoder-sub-menu'), false);
                }

                if (!currentItem.hasClass('tmpcoder-sub-open')) {
                    e.preventDefault();
                    currentItem.addClass('tmpcoder-sub-open');
                    subMenuAnimation(childrenSub, true);

                } else {
                    currentItem.removeClass('tmpcoder-sub-open');
                    subMenuAnimation(childrenSub, false);
                }
            });

            // Reset Subs on Document click
            $(document).mouseup(function (e) {
                if (!subMenuFirst.is(e.target) && subMenuFirst.has(e.target).length === 0) {
                    subMenuFirst.not().removeClass('tmpcoder-sub-open');
                    subMenuAnimation(subMenuFirst.children('.tmpcoder-sub-menu, .tmpcoder-sub-mega-menu'), false);
                }
                if (!subMenuDeep.is(e.target) && subMenuDeep.has(e.target).length === 0) {
                    subMenuDeep.removeClass('tmpcoder-sub-open');
                    subMenuAnimation(subMenuDeep.children('.tmpcoder-sub-menu'), false);
                }
            });

            // Hover
        } else {
            // Mouse Over
            subMenuFirst.on('mouseenter', function () {
                subMenuAnimation($(this).children('.tmpcoder-sub-menu, .tmpcoder-sub-mega-menu'), true);
            });

            subMenuDeep.on('mouseenter', function () {
                subMenuAnimation($(this).children('.tmpcoder-sub-menu'), true);
            });

            // Mouse Leave
            subMenuFirst.on('mouseleave', function () {
                subMenuAnimation($(this).children('.tmpcoder-sub-menu, .tmpcoder-sub-mega-menu'), false);
            });

            subMenuDeep.on('mouseleave', function () {
                subMenuAnimation($(this).children('.tmpcoder-sub-menu'), false);
            });
        }

        // Mobile Menu
        var mobileMenu = $mobileNavMenu.find('.tmpcoder-mobile-nav-menu');

        // Toggle Button
        $mobileNavMenu.find('.tmpcoder-mobile-toggle').on('click', function () {
            // Change Toggle Text
            if (!$(this).hasClass('tmpcoder-mobile-toggle-open')) {
                $(this).addClass('tmpcoder-mobile-toggle-open');

                if ($(this).find('.tmpcoder-mobile-toggle-text').length) {
                    $(this).children().eq(0).hide();
                    $(this).children().eq(1).show();
                }
            } else {
                $(this).removeClass('tmpcoder-mobile-toggle-open');
                $(this).trigger('focusout');

                if ($(this).find('.tmpcoder-mobile-toggle-text').length) {
                    $(this).children().eq(1).hide();
                    $(this).children().eq(0).show();
                }
            }

            // Show Menu
            if ($scope.hasClass('tmpcoder-mobile-menu-display-offcanvas')) {
                $(this).closest('.elementor-top-section').addClass('tmpcoder-section-full-height');
                $('body').css('overflow', 'hidden');
                $(this).parent().siblings('.tmpcoder-mobile-mega-menu-wrap').toggleClass('tmpcoder-mobile-mega-menu-open');
            } else {
                $(this).parent().siblings('.tmpcoder-mobile-mega-menu-wrap').stop().slideToggle();
            }

            // Hide Off-Canvas Menu
            $scope.find('.mobile-mega-menu-close').on('click', function () {
                $(this).closest('.tmpcoder-mobile-mega-menu-wrap').removeClass('tmpcoder-mobile-mega-menu-open');
                $('body').css('overflow', 'visible');
                $(this).closest('.elementor-top-section').removeClass('tmpcoder-section-full-height');
            });
            $scope.find('.tmpcoder-mobile-mega-menu-overlay').on('click', function () {
                $(this).siblings('.tmpcoder-mobile-mega-menu-wrap').removeClass('tmpcoder-mobile-mega-menu-open');
                $('body').css('overflow', 'visible');
                $(this).closest('.elementor-top-section').removeClass('tmpcoder-section-full-height');
            });

            // Fix Width
            fullWidthMobileDropdown();
        });

        // Sub Menu Class
        mobileMenu.find('.sub-menu').removeClass('tmpcoder-sub-menu').addClass('tmpcoder-mobile-sub-menu');

        // Add Submenu Icon
        let mobileSubIcon = mobileMenu.find('.tmpcoder-mobile-sub-icon'),
            mobileSubIconClass = 'fas ';

        if ($scope.hasClass('tmpcoder-sub-icon-caret-down')) {
            mobileSubIconClass += 'fa-caret-down';
        } else if ($scope.hasClass('tmpcoder-sub-icon-angle-down')) {
            mobileSubIconClass += 'fa-angle-down';
        } else if ($scope.hasClass('tmpcoder-sub-icon-chevron-down')) {
            mobileSubIconClass += 'fa-chevron-down';
        } else if ($scope.hasClass('tmpcoder-sub-icon-plus')) {
            mobileSubIconClass += 'fa-plus';
        }

        mobileSubIcon.addClass(mobileSubIconClass);

        // Sub Menu Dropdown
        mobileMenu.find('.menu-item-has-children > a .tmpcoder-mobile-sub-icon, .menu-item-has-children > a[href="#"]').on('click', function (e) {
            e.preventDefault();
            e.stopPropagation();

            var parentItem = $(this).closest('li.menu-item');

            // Toggle
            if (!parentItem.hasClass('tmpcoder-mobile-sub-open')) {
                e.preventDefault();
                parentItem.addClass('tmpcoder-mobile-sub-open');

                if (!$scope.hasClass('tmpcoder-mobile-menu-display-offcanvas')) {
                    $(window).trigger('resize');
                    parentItem.children('.tmpcoder-mobile-sub-menu').first().stop().slideDown();
                }

                // Mega Menu
                if (parentItem.hasClass('tmpcoder-mega-menu-true')) {
                    if (parentItem.hasClass('tmpcoder-mega-menu-ajax') && !parentItem.find('.tmpcoder-mobile-sub-mega-menu').find('.elementor').length) {
                        let subIcon = parentItem.find('.tmpcoder-mobile-sub-icon');

                        $.ajax({
                            type: 'GET',
                            url: tmpcoder_plugin_script.resturl + '/tmpcodermegamenu/',
                            data: {
                                item_id: parentItem.data('id')
                            },
                            beforeSend: function () {
                                subIcon.removeClass(mobileSubIconClass).addClass('fas fa-circle-notch fa-spin');
                            },
                            success: function (response) {
                                subIcon.removeClass('fas fa-circle-notch fa-spin').addClass(mobileSubIconClass);

                                if ($scope.hasClass('tmpcoder-mobile-menu-display-offcanvas')) {
                                    parentItem.find('.tmpcoder-menu-offcanvas-back').after(response);
                                    offCanvasSubMenuAnimation(parentItem);
                                } else {
                                    parentItem.find('.tmpcoder-mobile-sub-mega-menu').html(response);
                                    parentItem.children('.tmpcoder-mobile-sub-mega-menu').slideDown();
                                }

                                parentItem.find('.tmpcoder-mobile-sub-mega-menu').find('.elementor-element').each(function () {
                                    elementorFrontend.elementsHandler.runReadyTrigger($(this));
                                });
                            }
                        });
                    } else {
                        if ($scope.hasClass('tmpcoder-mobile-menu-display-offcanvas')) {
                            offCanvasSubMenuAnimation(parentItem);
                        } else {
                            parentItem.children('.tmpcoder-mobile-sub-mega-menu').slideDown();
                        }
                    }
                } else {
                    if ($scope.hasClass('tmpcoder-mobile-menu-display-offcanvas')) {
                        offCanvasSubMenuAnimation(parentItem);
                    }
                }

            } else {
                // SlideUp
                parentItem.removeClass('tmpcoder-mobile-sub-open');

                if (!$scope.hasClass('tmpcoder-mobile-menu-display-offcanvas')) {
                    parentItem.children('.tmpcoder-mobile-sub-menu').slideUp();
                    parentItem.children('.tmpcoder-mobile-sub-mega-menu').slideUp();
                }
            }
        });

        // Off-Canvas Back Button
        $scope.find('.tmpcoder-menu-offcanvas-back').on('click', function () {
            $(this).closest('.tmpcoder-mobile-mega-menu').removeClass('tmpcoder-mobile-sub-offcanvas-open');
            $(this).closest('.menu-item').removeClass('tmpcoder-mobile-sub-open');
            $scope.find('.tmpcoder-mobile-mega-menu-wrap').removeAttr('style');
            $scope.find('.tmpcoder-mobile-sub-mega-menu').removeAttr('style');
        });

        // Run Functions
        MegaMenuCustomWidth();
        fullWidthMobileDropdown();

        // Run Functions on Resize
        $(window).smartresize(function () {
            MegaMenuCustomWidth();
            fullWidthMobileDropdown();
        });

        // Mega Menu Full or Custom Width
        function MegaMenuCustomWidth() {
            let megaItem = $scope.find('.tmpcoder-mega-menu-true');

            megaItem.each(function () {
                let megaSubMenu = $(this).find('.tmpcoder-sub-mega-menu')

                if ($(this).hasClass('tmpcoder-mega-menu-width-full')) {
                    megaSubMenu.css({
                        'max-width': $(window).width() + 'px',
                        'left': - $scope.find('.tmpcoder-nav-menu-container').offset().left + 'px'
                    }); // conditions for sticky replace needed
                } else if ($(this).hasClass('tmpcoder-mega-menu-width-stretch')) {
                    // Sections (Old)
                    if (0 === $(this).closest('.e-con').length) {
                        var elContainer = $(this).closest('.elementor-section');
                        elContainer = elContainer.hasClass('elementor-inner-section') ? elContainer : elContainer.children('.elementor-container');

                        var elWidgetGap = !elContainer.hasClass('elementor-inner-section') ? elContainer.find('.elementor-element-populated').css('padding') : '0';
                        elWidgetGap = parseInt(elWidgetGap.replace('px', ''), 10);

                        // Container (New)
                    } else {
                        var elContainer = $(this).closest('.e-con-inner');

                        var elWidgetGap = elContainer.find('.elementor-element.e-con').css('padding'),
                            elWidgetGap = parseInt(elWidgetGap, 10);
                    }

                    var elContainerWidth = elContainer.outerWidth() - (elWidgetGap * 2),
                        offsetLeft = -($scope.offset().left - elContainer.offset().left) + elWidgetGap;

                    megaSubMenu.css({
                        'width': elContainerWidth + 'px',
                        'left': offsetLeft + 'px'
                    });
                } else if ($(this).hasClass('tmpcoder-mega-menu-width-custom')) {
                    megaSubMenu.css({
                        'width': $(this).data('custom-width') + 'px',
                    });
                } else if ($(this).hasClass('tmpcoder-mega-menu-width-default') && $(this).hasClass('tmpcoder-mega-menu-pos-relative')) {
                    megaSubMenu.css({
                        'width': $(this).closest('.elementor-column').outerWidth() + 'px',
                    });
                }
            });
        }

        // Full Width Dropdown
        function fullWidthMobileDropdown() {
            if (!$scope.hasClass('tmpcoder-mobile-menu-full-width') || !$scope.closest('.elementor-column').length) {
                return;
            }

            var eColumn = $scope.closest('.elementor-column'),
                mWidth = $scope.closest('.elementor-top-section').outerWidth() - 2 * mobileMenu.offset().left,
                mPosition = eColumn.offset().left + parseInt(eColumn.css('padding-left'), 10);

            mobileMenu.parent('div').css({
                'width': mWidth + 'px',
                'left': - mPosition + 'px'
            });
        }

        // Sub Menu Animation
        function subMenuAnimation(selector, show) {
            if (show === true) {
                selector.stop().addClass('tmpcoder-animate-sub');
            } else {
                selector.stop().removeClass('tmpcoder-animate-sub');
            }
        }

        // Off-Canvas Sub Menu Animation
        function offCanvasSubMenuAnimation(selector) {
            let title = selector.children('a').clone().children().remove().end().text();

            selector.closest('.tmpcoder-mobile-mega-menu').addClass('tmpcoder-mobile-sub-offcanvas-open');
            selector.find('.tmpcoder-menu-offcanvas-back').find('h3').text(title);

            let parentItem = $scope.find('.tmpcoder-mobile-mega-menu').children('.tmpcoder-mobile-sub-open'),
                subSelector = parentItem.children('ul').length ? parentItem.children('ul') : parentItem.children('.tmpcoder-mobile-sub-mega-menu'),
                subHeight = subSelector.outerHeight();

            if (subHeight > $(window).height()) {
                $scope.find('.tmpcoder-mobile-sub-mega-menu').not(selector.find('.tmpcoder-mobile-sub-mega-menu')).hide();
                $scope.find('.tmpcoder-mobile-mega-menu-wrap').css('overflow-y', 'scroll');
            }
        }
    }
    
    $(window).on('elementor/frontend/init', function () {
        elementorFrontend.hooks.addAction("frontend/element_ready/tmpcoder-mega-menu.default",
            widgetMegaMenu);
    });
})(jQuery);