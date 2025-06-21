(function ($) {
    "use strict";

    const widgetWishlistButton = function ($scope, $) {
        $.ajax({
            url: tmpcoder_plugin_script.ajax_url,
            type: 'POST',
            data: {
                action: 'check_product_in_wishlist',
                product_id: $scope.find('.tmpcoder-wishlist-add').data('product-id'),
                nonce: tmpcoder_plugin_script.nonce,
            },
            success: function (response) {
                if (true == response) {
                    if (!$scope.find('.tmpcoder-wishlist-add').hasClass('tmpcoder-button-hidden')) {
                        $scope.find('.tmpcoder-wishlist-add').addClass('tmpcoder-button-hidden');
                    }

                    if ($scope.find('.tmpcoder-wishlist-remove').hasClass('tmpcoder-button-hidden')) {
                        $scope.find('.tmpcoder-wishlist-remove').removeClass('tmpcoder-button-hidden');
                    }
                }
            }
        });

        $scope.find('.tmpcoder-wishlist-add').click(function (e) {
            e.preventDefault();
            var product_id = $(this).data('product-id');

            $(this).fadeTo(500, 0);

            $.ajax({
                url: tmpcoder_plugin_script.ajax_url,
                type: 'POST',
                data: {
                    action: 'add_to_wishlist',
                    product_id: product_id,
                    nonce: tmpcoder_plugin_script.nonce,
                },
                success: function () {
                    $scope.find('.tmpcoder-wishlist-add[data-product-id="' + product_id + '"]').hide();
                    $scope.find('.tmpcoder-wishlist-remove[data-product-id="' + product_id + '"]').show();
                    $scope.find('.tmpcoder-wishlist-remove[data-product-id="' + product_id + '"]').fadeTo(500, 1);
                    changeActionTargetProductId(product_id);
                    $(document).trigger('added_to_wishlist');
                },
                error: function (response) {
                    var error_message = response.responseJSON.message;
                    // Display error message
                    alert(error_message);
                }
            });
        });
        $scope.find('.tmpcoder-wishlist-remove').on('click', function (e) {
            e.preventDefault();
            var product_id = $(this).data('product-id');

            $(this).fadeTo(500, 0);

            $.ajax({
                url: tmpcoder_plugin_script.ajax_url,
                type: 'POST',
                data: {
                    action: 'remove_from_wishlist',
                    product_id: product_id,
                    nonce: tmpcoder_plugin_script.nonce,
                },
                success: function () {
                    $scope.find('.tmpcoder-wishlist-remove[data-product-id="' + product_id + '"]').hide();
                    $scope.find('.tmpcoder-wishlist-add[data-product-id="' + product_id + '"]').show();
                    $scope.find('.tmpcoder-wishlist-add[data-product-id="' + product_id + '"]').fadeTo(500, 1);
                    changeActionTargetProductId(product_id);
                    $(document).trigger('removed_from_wishlist');
                }
            });
        });

        $(document).on('removed_from_wishlist', function () {
            $scope.find('.tmpcoder-wishlist-remove[data-product-id="' + actionTargetProductId + '"]').hide();
            $scope.find('.tmpcoder-wishlist-add[data-product-id="' + actionTargetProductId + '"]').show();
            $scope.find('.tmpcoder-wishlist-add[data-product-id="' + actionTargetProductId + '"]').fadeTo(500, 1);
        });
    }
    
    $(window).on('elementor/frontend/init', function () {
        elementorFrontend.hooks.addAction("frontend/element_ready/tmpcoder-wishlist-button-pro.default",
            widgetWishlistButton);
    });
})(jQuery);