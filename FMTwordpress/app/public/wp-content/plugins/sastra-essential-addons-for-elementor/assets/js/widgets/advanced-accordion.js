(function ($) {
    "use strict";

    const widgetAdvancedAccordion = function ($scope, $) {
        var acc = $scope.find('.tmpcoder-acc-button');
        var accItemWrap = $scope.find('.tmpcoder-accordion-item-wrap');
        var accordionType = $scope.find('.tmpcoder-advanced-accordion').data('accordion-type');
        var activeIndex = +$scope.find('.tmpcoder-advanced-accordion').data('active-index') - 1;
        var accordionTrigger = $scope.find('.tmpcoder-advanced-accordion').data('accordion-trigger');
        var interactionSpeed = +$scope.find('.tmpcoder-advanced-accordion').data('interaction-speed') * 1000;

        // ?active_panel=panel-index#your-id
        var activeTabIndexFromLocation = window.location.href.indexOf("active_panel=");

        if (activeTabIndexFromLocation > -1) {
            activeIndex = +window.location.href.substring(activeTabIndexFromLocation, window.location.href.lastIndexOf("#")).replace("active_panel=", '') - 1;
        }

        if ('click' === accordionTrigger) {

            if (accordionType == 'accordion') {
                acc.on("click", function () {
                    var thisIndex = acc.index(this);
                    acc.each(function (index) {
                        index != thisIndex ? $(this).removeClass('tmpcoder-acc-active') : '';
                    });
                    $scope.find('.tmpcoder-acc-panel').each(function (index) {
                        index != thisIndex ? $(this).removeClass('tmpcoder-acc-panel-active') && $(this).slideUp(interactionSpeed) : '';
                    });
                    $(this).toggleClass("tmpcoder-acc-active");
                    var panel = $(this).next();
                    if (!panel.hasClass('tmpcoder-acc-panel-active')) {
                        panel.slideDown(interactionSpeed);
                        panel.addClass('tmpcoder-acc-panel-active');
                    } else {
                        panel.slideUp(interactionSpeed);
                        panel.removeClass('tmpcoder-acc-panel-active');
                    }
                });
            } else {
                acc.each(function () {
                    $(this).on("click", function () {
                        $(this).toggleClass("tmpcoder-acc-active");
                        var panel = $(this).next();
                        if (!panel.hasClass('tmpcoder-acc-panel-active')) {
                            panel.slideDown(interactionSpeed);
                            panel.addClass('tmpcoder-acc-panel-active');
                        } else {
                            panel.slideUp(interactionSpeed);
                            panel.removeClass('tmpcoder-acc-panel-active');
                        }
                    });
                });
            }

            acc && (activeIndex > -1 && acc.eq(activeIndex).trigger('click'));
        } else if (accordionTrigger == 'hover') {
            accItemWrap.on("mouseenter", function () {
                var thisIndex = accItemWrap.index(this);

                $(this).find('.tmpcoder-acc-button').addClass("tmpcoder-acc-active");

                var panel = $(this).find('.tmpcoder-acc-panel');
                panel.slideDown(interactionSpeed);
                panel.addClass('tmpcoder-acc-panel-active');

                accItemWrap.each(function (index) {
                    if (index != thisIndex) {
                        $(this).find('.tmpcoder-acc-button').removeClass("tmpcoder-acc-active");
                        var panel = $(this).find('.tmpcoder-acc-panel');
                        panel.slideUp(interactionSpeed);
                        panel.removeClass('tmpcoder-acc-panel-active');
                    }
                });
            });

            accItemWrap && (activeIndex > -1 && accItemWrap.eq(activeIndex).trigger('mouseenter'));
        }

        $scope.find('.tmpcoder-acc-search-input').on({
            focus: function () {
                $scope.addClass('tmpcoder-acc-search-input-focus');
            },
            blur: function () {
                $scope.removeClass('tmpcoder-search-form-input-focus');
            }
        });

        let allInAcc = $scope.find('.tmpcoder-advanced-accordion > *');

        $scope.find('i.fa-times').on('click', function () {
            $scope.find('.tmpcoder-acc-search-input').val('');
            $scope.find('.tmpcoder-acc-search-input').trigger('keyup');
        });

        var iconBox = $scope.find('.tmpcoder-acc-icon-box');

        iconBox.each(function () {
            $(this).find('.tmpcoder-acc-icon-box-after').css({
                'border-top': $(this).height() / 2 + 'px solid transparent',
                'border-bottom': $(this).height() / 2 + 'px solid transparent'
            });
        });

        $(window).resize(function () {
            iconBox.each(function () {
                $(this).find('.tmpcoder-acc-icon-box-after').css({
                    'border-top': $(this).height() / 2 + 'px solid transparent',
                    'border-bottom': $(this).height() / 2 + 'px solid transparent'
                });
            });
        });

        $scope.find('.tmpcoder-acc-search-input').on('keyup', function () {
            setTimeout(() => {
                let thisValue = $(this).val();
                if (thisValue.length > 0) {
                    $scope.find('.tmpcoder-acc-search-input-wrap').find('i.fa-times').css('display', 'inline-block');
                    allInAcc.each(function () {
                        if ($(this).hasClass('tmpcoder-accordion-item-wrap')) {
                            var itemWrap = $(this);
                            if (itemWrap.text().toUpperCase().indexOf(thisValue.toUpperCase()) == -1) {
                                itemWrap.hide();
                                if (itemWrap.find('.tmpcoder-acc-button').hasClass('tmpcoder-acc-active') && itemWrap.find('.tmpcoder-acc-panel').hasClass('tmpcoder-acc-panel-active')) {
                                    itemWrap.find('.tmpcoder-acc-button').removeClass('tmpcoder-acc-active');
                                    itemWrap.find('.tmpcoder-acc-panel').removeClass('tmpcoder-acc-panel-active');
                                }
                            } else {
                                itemWrap.show();
                                if (!itemWrap.find('.tmpcoder-acc-button').hasClass('tmpcoder-acc-active') && !itemWrap.find('.tmpcoder-acc-panel').hasClass('tmpcoder-acc-panel-active')) {
                                    itemWrap.find('.tmpcoder-acc-button').addClass('tmpcoder-acc-active');
                                    itemWrap.find('.tmpcoder-acc-panel').addClass('tmpcoder-acc-panel-active');
                                    itemWrap.find('.tmpcoder-acc-panel').slideDown(interactionSpeed);
                                }
                            }
                        }
                    });
                } else {
                    $scope.find('.tmpcoder-acc-search-input-wrap').find('i.fa-times').css('display', 'none');
                    allInAcc.each(function () {
                        if ($(this).hasClass('tmpcoder-accordion-item-wrap')) {
                            $(this).show();
                            if ($(this).find('.tmpcoder-acc-panel').hasClass('tmpcoder-acc-panel-active')) {
                                $(this).find('.tmpcoder-acc-panel').removeClass('tmpcoder-acc-panel-active');
                            }
                            if ($(this).find('.tmpcoder-acc-button').hasClass('tmpcoder-acc-active')) {
                                $(this).find('.tmpcoder-acc-button').removeClass('tmpcoder-acc-active')
                            }
                            $(this).find('.tmpcoder-acc-panel').slideUp(interactionSpeed);
                        }
                    });
                    // if ('click' === accordionTrigger) {
                    //  acc && (activeIndex > -1 && acc.eq(activeIndex).trigger('click'));
                    // } else if ( 'hover' === accordionTrigger ) {
                    //  accItemWrap &&  (activeIndex > -1 && accItemWrap.eq(activeIndex).trigger('mouseenter'));
                    // }
                }
            }, 1000);
        });
    }
    
    $(window).on('elementor/frontend/init', function () {
        elementorFrontend.hooks.addAction("frontend/element_ready/tmpcoder-advanced-accordion.default",
            widgetAdvancedAccordion);
    });
})(jQuery);

