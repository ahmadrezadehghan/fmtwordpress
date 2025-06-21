(function ($) {
    "use strict";

    const widgetTaxonomyList = function ($scope) {
        var taxList = $scope.find('.tmpcoder-taxonomy-list');

        if (taxList.data('show-on-click') == 'yes') {

            // $scope.find('.tmpcoder-tax-dropdown').css('margin-left', -($scope.find('.tmpcoder-tax-dropdown').width()));

            taxList.find('.tmpcoder-taxonomy i.tmpcoder-tax-dropdown').on('click', function (e) {

                e.preventDefault();

                if (taxList.find('.tmpcoder-sub-taxonomy[data-term-id="child-' + $(this).closest('li').data('term-id') + '"]').hasClass('tmpcoder-sub-hidden')) {
                    $(this).removeClass('fa-caret-right').addClass('fa-caret-down');
                    // $scope.find('.fa-caret-down').css('margin-left', -($scope.find('.fa-caret-down').width()));
                    taxList.find('.tmpcoder-sub-taxonomy[data-term-id="child-' + $(this).closest('li').data('term-id') + '"]').removeClass('tmpcoder-sub-hidden');
                } else {
                    $(this).removeClass('fa-caret-down').addClass('fa-caret-right');
                    // $scope.find('.fa-caret-right').css('margin-left', -($scope.find('.fa-caret-right').width()));
                    taxList.find('.tmpcoder-sub-taxonomy[data-term-id="child-' + $(this).closest('li').data('term-id') + '"]').addClass('tmpcoder-sub-hidden');

                    taxList.find('.tmpcoder-inner-sub-taxonomy[data-term-id="grandchild-' + $(this).closest('li').data('term-id') + '"]').each(function () {
                        if (!$(this).hasClass('tmpcoder-sub-hidden')) {
                            taxList.find('.tmpcoder-sub-taxonomy[data-id="' + $(this).data('parent-id') + '"] i.tmpcoder-tax-dropdown').removeClass('fa-caret-down').addClass('fa-caret-right');
                            // $scope.find('.fa-caret-right').css('margin-left', -($scope.find('.fa-caret-right').width()));
                            $(this).addClass('tmpcoder-sub-hidden');
                        }
                    });

                    taxList.find('.tmpcoder-inner-sub-taxonomy-2[data-term-id="great-grandchild-' + $(this).closest('li').data('term-id') + '"]').each(function () {
                        if (!$(this).hasClass('tmpcoder-sub-hidden')) {
                            taxList.find('.tmpcoder-sub-taxonomy[data-id="' + $(this).data('parent-id') + '"] i.tmpcoder-tax-dropdown').removeClass('fa-caret-down').addClass('fa-caret-right');
                            // $scope.find('.fa-caret-right').css('margin-left', -($scope.find('.fa-caret-right').width()));
                            $(this).addClass('tmpcoder-sub-hidden');
                        }
                    });

                    // if (!taxList.find('.tmpcoder-inner-sub-taxonomy[data-term-id="grandchild-'+ $(this).parent('li').data('term-id') +'"]').hasClass('tmpcoder-sub-hidden')) {
                    //  taxList.find('.tmpcoder-sub-taxonomy[data-term-id="child-'+ $(this).parent('li').data('term-id') +'"] i').removeClass('fa-caret-down').addClass('fa-caret-right');
                    //  taxList.find('.tmpcoder-inner-sub-taxonomy[data-term-id="grandchild-'+ $(this).parent('li').data('term-id') +'"]').addClass('tmpcoder-sub-hidden');
                    // }
                }

                taxList.find('.tmpcoder-inner-sub-taxonomy[data-term-id="grandchild-' + $(this).closest('li').data('term-id') + '"] i.tmpcoder-tax-dropdown').removeClass('fa-caret-down').addClass('fa-caret-right');

                if (!taxList.find('.tmpcoder-inner-sub-taxonomy-2[data-term-id="great-grandchild-' + $(this).closest('li').data('term-id') + '"]').hasClass('tmpcoder-sub-hidden')) {
                    taxList.find('.tmpcoder-inner-sub-taxonomy-2[data-term-id="great-grandchild-' + $(this).closest('li').data('term-id') + '"]').addClass('tmpcoder-sub-hidden');
                }
            });

            taxList.find('.tmpcoder-sub-taxonomy i.tmpcoder-tax-dropdown').on('click', function (e) {

                e.preventDefault();

                if (taxList.find('.tmpcoder-inner-sub-taxonomy[data-parent-id="' + $(this).closest('li').data('id') + '"]').hasClass('tmpcoder-sub-hidden')) {
                    $(this).removeClass('fa-caret-right').addClass('fa-caret-down');
                    // $scope.find('.fa-caret-down').css('margin-left', -($scope.find('.fa-caret-down').width()));
                    taxList.find('.tmpcoder-inner-sub-taxonomy[data-parent-id="' + $(this).closest('li').data('id') + '"]').removeClass('tmpcoder-sub-hidden');
                } else {
                    $(this).removeClass('fa-caret-down').addClass('fa-caret-right');
                    // taxList.find('.tmpcoder-sub-taxonomy i').removeClass('fa-caret-down').addClass('fa-caret-right');
                    // $scope.find('.fa-caret-right').css('margin-left', -($scope.find('.fa-caret-right').width()));
                    taxList.find('.tmpcoder-inner-sub-taxonomy[data-parent-id="' + $(this).closest('li').data('id') + '"]').addClass('tmpcoder-sub-hidden');
                }

                taxList.find('.tmpcoder-inner-sub-taxonomy[data-parent-id="' + $(this).closest('li').data('id') + '"] i.tmpcoder-tax-dropdown').removeClass('fa-caret-down').addClass('fa-caret-right');

                if (!taxList.find('.tmpcoder-inner-sub-taxonomy-2[data-term-id="great-grandchild-' + $(this).closest('li').data('term-id').replace('child-', '') + '"]').hasClass('tmpcoder-sub-hidden')) {
                    taxList.find('.tmpcoder-inner-sub-taxonomy-2[data-term-id="great-grandchild-' + $(this).closest('li').data('term-id').replace('child-', '') + '"]').addClass('tmpcoder-sub-hidden');
                }
            });

            taxList.find('.tmpcoder-inner-sub-taxonomy i.tmpcoder-tax-dropdown').on('click', function (e) {

                e.preventDefault();

                if (taxList.find('.tmpcoder-inner-sub-taxonomy-2[data-parent-id="' + $(this).closest('li').data('id') + '"]').hasClass('tmpcoder-sub-hidden')) {
                    $(this).removeClass('fa-caret-right').addClass('fa-caret-down');
                    // $scope.find('.fa-caret-down').css('margin-left', -($scope.find('.fa-caret-down').width()));
                    taxList.find('.tmpcoder-inner-sub-taxonomy-2[data-parent-id="' + $(this).closest('li').data('id') + '"]').removeClass('tmpcoder-sub-hidden');
                } else {
                    $(this).removeClass('fa-caret-down').addClass('fa-caret-right');
                    // taxList.find('.tmpcoder-sub-taxonomy i').removeClass('fa-caret-down').addClass('fa-caret-right');
                    // $scope.find('.fa-caret-right').css('margin-left', -($scope.find('.fa-caret-right').width()));
                    taxList.find('.tmpcoder-inner-sub-taxonomy-2[data-parent-id="' + $(this).closest('li').data('id') + '"]').addClass('tmpcoder-sub-hidden');
                }
            });
        }
    }
    
    $(window).on('elementor/frontend/init', function () {
        elementorFrontend.hooks.addAction('frontend/element_ready/tmpcoder-taxonomy-list.default', widgetTaxonomyList);
    });
})(jQuery);