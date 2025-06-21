(function ($) {
    "use strict";

    window.widgetCompare = function ($scope, $) {

        jQuery.ajax({
            url: tmpcoder_plugin_script.ajax_url,
            type: 'POST',
            data: {
                action: 'count_compare_items',
                remove_text: $scope.find('.tmpcoder-compare-table-wrap').attr('remove_from_compare_text'),
                compare_empty_text: $scope.find('.tmpcoder-compare-table-wrap').attr('compare_empty_text'),
                element_addcart_simple_txt: $scope.find('.tmpcoder-compare-table-wrap').attr('element_addcart_simple_txt'),
                element_addcart_grouped_txt: $scope.find('.tmpcoder-compare-table-wrap').attr('element_addcart_grouped_txt'),
                element_addcart_variable_txt: $scope.find('.tmpcoder-compare-table-wrap').attr('element_addcart_variable_txt'),
                nonce: tmpcoder_plugin_script.nonce,
            },
            success: function (response) {
                if (true) {
                    $scope.find('.tmpcoder-compare-table-wrap').html(response.compare_table);
                }
            },
            error: function (error) {
                console.log(error);
            }
        });

        $scope.on('click', '.tmpcoder-compare-remove', function (e) {
            e.preventDefault();
            var productID = jQuery(this).data('product-id');

            jQuery.ajax({
                url: tmpcoder_plugin_script.ajax_url,
                type: 'POST',
                data: {
                    action: 'remove_from_compare',
                    product_id: productID,
                    nonce: tmpcoder_plugin_script.nonce,
                },
                success: function () {
                    changeActionTargetProductId(productID);
                    $scope.find('[data-product-id="' + productID + '"]').remove();
                    if (!($scope.find('.tmpcoder-compare-remove').length > 0)) {
                        $scope.find('.tmpcoder-compare-products').addClass('tmpcoder-hidden-element');
                        $scope.find('.tmpcoder-compare-empty').removeClass('tmpcoder-hidden-element');
                    } else {
                        $scope.find('.tmpcoder-compare-empty').addClass('tmpcoder-hidden-element');
                        $scope.find('.tmpcoder-compare-products').removeClass('tmpcoder-hidden-element');
                    }
                    jQuery(document).trigger('removed_from_compare');
                }
            });
        });

        jQuery('body').on('added_to_cart', function (ev, fragments, hash, button) {
            button.next().fadeTo(700, 1);

            button.css('display', 'none');
        });
    } // end widgetCompare
    
    $(window).on('elementor/frontend/init', function () {
        elementorFrontend.hooks.addAction("frontend/element_ready/tmpcoder-compare-pro.default",
            widgetCompare);
    });
})(jQuery);