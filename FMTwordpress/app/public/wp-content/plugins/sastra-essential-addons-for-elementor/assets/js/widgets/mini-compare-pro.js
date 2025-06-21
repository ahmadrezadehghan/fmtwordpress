(function ($) {
    "use strict";

    const widgetMiniCompare = function ($scope, $) {

        if (!($scope.find('.tmpcoder-compare-count').length > 0 && 0 == $scope.find('.tmpcoder-compare-count').text())) {
            $scope.find('.tmpcoder-compare-count').css('display', 'inline-flex');
        }

        // WITH AJAX
        if ($scope.hasClass('tmpcoder-compare-style-popup')) {
            $scope.find('.tmpcoder-compare-toggle-btn').on('click', function (e) {
                e.preventDefault();

                $('body').addClass('tmpcoder-body-overflow-hidden');

                $scope.find('.tmpcoder-compare-bg').removeClass('tmpcoder-compare-popup-hidden');
                $scope.find('.tmpcoder-compare-popup').removeClass('tmpcoder-compare-fade-out').addClass('tmpcoder-compare-fade-in');
                $scope.find('.tmpcoder-compare-bg').removeClass('tmpcoder-compare-fade-out').addClass('tmpcoder-compare-fade-in');

                $scope.find('.tmpcoder-compare-popup-inner-wrap').html('<div class="tmpcoder-compare-loader-wrap"><div class="tmpcoder-double-bounce"><div class="tmpcoder-child tmpcoder-double-bounce1"></div><div class="tmpcoder-child tmpcoder-double-bounce2"></div></div></div>');
                $.ajax({
                    url: tmpcoder_plugin_script.ajax_url,
                    type: 'POST',
                    data: {
                        nonce: tmpcoder_plugin_script.nonce,
                        action: 'tmpcoder_get_page_content',
                        tmpcoder_compare_page_id: tmpcoder_plugin_script.comparePageID
                    },
                    success: function (response) {
                        $scope.find('.tmpcoder-compare-popup-inner-wrap').html(response.data.content);
                        widgetCompare($scope);

                        $scope.find('.tmpcoder-compare-remove').click(function (e) {
                            e.preventDefault();
                            var productID = $(this).data('product-id');

                            $.ajax({
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
                                    if (!($scope.find('.tmpcoder-compare-popup-inner-wrap').find('.tmpcoder-compare-remove').length > 0)) {
                                        $scope.find('.tmpcoder-compare-products').addClass('tmpcoder-hidden-element');
                                        $scope.find('.tmpcoder-compare-empty').removeClass('tmpcoder-hidden-element');
                                    } else {
                                        $scope.find('.tmpcoder-compare-empty').addClass('tmpcoder-hidden-element');
                                        $scope.find('.tmpcoder-compare-products').removeClass('tmpcoder-hidden-element');
                                    }
                                    $(document).trigger('removed_from_compare');
                                }
                            });
                        });
                    },
                    error: function (xhr, status, error) {
                        console.log(xhr.responseText);
                    }
                });
            });

            $scope.find('.tmpcoder-close-compare').click(function (e) {
                $scope.find('.tmpcoder-compare-popup').removeClass('tmpcoder-compare-fade-in').addClass('tmpcoder-compare-fade-out');
                $scope.find('.tmpcoder-compare-bg').removeClass('tmpcoder-compare-fade-in').addClass('tmpcoder-compare-fade-out');
                setTimeout(function () {
                    $scope.find('.tmpcoder-compare-bg').addClass('tmpcoder-compare-popup-hidden');
                    $('body').removeClass('tmpcoder-body-overflow-hidden');
                }, 600)
            });

            $scope.find('.tmpcoder-compare-bg').click(function (e) {
                if (!e.target.classList.value.includes('tmpcoder-compare-popup') && !e.target.closest('.tmpcoder-compare-popup')) {
                    var thisTarget = $(this);
                    $scope.find('.tmpcoder-compare-popup').removeClass('tmpcoder-compare-fade-in').addClass('tmpcoder-compare-fade-out');
                    $scope.find('.tmpcoder-compare-bg').removeClass('tmpcoder-compare-fade-in').addClass('tmpcoder-compare-fade-out');
                    setTimeout(function () {
                        thisTarget.addClass('tmpcoder-compare-popup-hidden');
                        $('body').removeClass('tmpcoder-body-overflow-hidden');
                    }, 600);
                }
            });

        }

        $.ajax({
            url: tmpcoder_plugin_script.ajax_url,
            type: 'POST',
            data: {
                action: 'count_compare_items',
                nonce: tmpcoder_plugin_script.nonce,
            },
            success: function (response) {
                if ($scope.find('.tmpcoder-compare-count').css('display') == 'none' && 0 < response.compare_count) {
                    $scope.find('.tmpcoder-compare-count').text(response.compare_count);
                    $scope.find('.tmpcoder-compare-count').css('display', 'inline-flex');
                } else if (0 == response.compare_count) {
                    $scope.find('.tmpcoder-compare-count').css('display', 'none');
                    $scope.find('.tmpcoder-compare-count').text(response.compare_count);
                } else {
                    $scope.find('.tmpcoder-compare-count').text(response.compare_count);
                }
            },
            error: function (error) {
                console.log(error);
            }
        });

        $(document).on('removed_from_compare', function () {
            $.ajax({
                url: tmpcoder_plugin_script.ajax_url,
                type: 'POST',
                data: {
                    action: 'update_mini_compare',
                    product_id: actionTargetProductId,
                    nonce: tmpcoder_plugin_script.nonce,
                },
                success: function (response) {
                    $scope.find('.tmpcoder-compare-count').text(response.compare_count);

                    if (response.compare_count == 0) {
                        $scope.find('.tmpcoder-compare-count').css('display', 'none');
                    } else {
                        $scope.find('.tmpcoder-compare-count').css('display', 'inline-flex');
                    }
                }
            });
        });

        $(document).on('added_to_compare', function () {
            $.ajax({
                url: tmpcoder_plugin_script.ajax_url,
                type: 'POST',
                data: {
                    action: 'update_mini_compare',
                    product_id: actionTargetProductId,
                    nonce: tmpcoder_plugin_script.nonce,
                },
                success: function (response) {
                    $scope.find('.tmpcoder-compare-count').text(response.compare_count);
                    $scope.find('.tmpcoder-compare-count').css('display', 'inline-flex');
                }
            });
        });
    } // end widgetMiniCompare
    
    $(window).on('elementor/frontend/init', function () {
        elementorFrontend.hooks.addAction("frontend/element_ready/tmpcoder-mini-compare-pro.default",
            widgetMiniCompare);
    });
})(jQuery);