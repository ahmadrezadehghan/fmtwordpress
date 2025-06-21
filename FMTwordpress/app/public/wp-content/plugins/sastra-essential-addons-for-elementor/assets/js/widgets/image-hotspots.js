(function ($) {
    "use strict";

    const widgetImageHotspots = function ($scope, $) {

        var $imgHotspots = $scope.find('.tmpcoder-image-hotspots'),
            hotspotsOptions = $imgHotspots.data('options'),
            $hotspotItem = $imgHotspots.find('.tmpcoder-hotspot-item'),
            tooltipTrigger = hotspotsOptions.tooltipTrigger;

        if ('click' === tooltipTrigger) {
            $hotspotItem.on('click', function () {
                if ($(this).hasClass('tmpcoder-tooltip-active')) {
                    $(this).removeClass('tmpcoder-tooltip-active');
                } else {
                    $hotspotItem.removeClass('tmpcoder-tooltip-active');
                    $(this).addClass('tmpcoder-tooltip-active');
                }
                event.stopPropagation();
            });

            $(window).on('click', function () {
                $hotspotItem.removeClass('tmpcoder-tooltip-active');
            });

        } else if ('hover' === tooltipTrigger) {
            $hotspotItem.on('mouseenter', function () {
                $(this).addClass('tmpcoder-tooltip-active');
            });

            $hotspotItem.on('mouseleave', function () {
                $(this).removeClass('tmpcoder-tooltip-active');
            });

        } else {
            $hotspotItem.addClass('tmpcoder-tooltip-active');
        }
    }
    
    $(window).on('elementor/frontend/init', function () {
        elementorFrontend.hooks.addAction("frontend/element_ready/tmpcoder-image-hotspots.default",
            widgetImageHotspots);
    });
})(jQuery);