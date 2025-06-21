(function ($) {
    "use strict";

    const widgetFeatureList = function ($scope, $) {

        $scope.find('.tmpcoder-feature-list-item:not(:last-of-type)').find('.tmpcoder-feature-list-icon-wrap').each(function (index) {
            var offsetTop = $scope.find('.tmpcoder-feature-list-item').eq(index + 1).find('.tmpcoder-feature-list-icon-wrap').offset().top;

            $(this).find('.tmpcoder-feature-list-line').height(offsetTop - $(this).offset().top + 'px');
        });

        $(window).resize(function () {
            $scope.find('.tmpcoder-feature-list-item:not(:last-of-type)').find('.tmpcoder-feature-list-icon-wrap').each(function (index) {
                var offsetTop = $scope.find('.tmpcoder-feature-list-item').eq(index + 1).find('.tmpcoder-feature-list-icon-wrap').offset().top;

                $(this).find('.tmpcoder-feature-list-line').height(offsetTop - $(this).offset().top + 'px');
            });
        })
    }
    
    $(window).on('elementor/frontend/init', function () {
        elementorFrontend.hooks.addAction('frontend/element_ready/tmpcoder-feature-list.default', widgetFeatureList);
    });
})(jQuery);