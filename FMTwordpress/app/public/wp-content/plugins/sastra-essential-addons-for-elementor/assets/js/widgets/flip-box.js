(function ($) {
    "use strict";

    const widgetFlipBox = function ($scope, $) {

        var $flipBox = $scope.find('.tmpcoder-flip-box'),
            flipBoxTrigger = $flipBox.data('trigger');

        if ('box' === flipBoxTrigger) {

            $flipBox.find('.tmpcoder-flip-box-front').on('click', function () {
                $(this).closest('.tmpcoder-flip-box').addClass('tmpcoder-flip-box-active');
            });

            $(window).on('click', function () {
                if ($(event.target).closest('.tmpcoder-flip-box').length === 0) {
                    $flipBox.removeClass('tmpcoder-flip-box-active');
                }
            });

        } else if ('btn' == flipBoxTrigger) {

            $flipBox.find('.tmpcoder-flip-box-btn').on('click', function () {
                $(this).closest('.tmpcoder-flip-box').addClass('tmpcoder-flip-box-active');
            });

            $(window).on('click', function () {
                if ($(event.target).closest('.tmpcoder-flip-box').length === 0) {
                    $flipBox.removeClass('tmpcoder-flip-box-active');
                }
            });


        } else if ('hover' == flipBoxTrigger) {

            $flipBox.hover(function () {
                $(this).toggleClass('tmpcoder-flip-box-active');
            });

        }
    }

    $(window).on('elementor/frontend/init', function () {
        elementorFrontend.hooks.addAction('frontend/element_ready/tmpcoder-flip-box.default', widgetFlipBox);
    });
})(jQuery);