(function ($) {
    "use strict";

    const widgetCompareButton = function ($scope, $) {
        $.ajax({
            url: tmpcoder_plugin_script.ajax_url,
            type: 'POST',
            data: {
                action: 'check_product_in_compare',
                product_id: $scope.find('.tmpcoder-compare-add').data('product-id'),
                nonce: tmpcoder_plugin_script.nonce,
            },
            success: function (response) {
                if (true == response) {
                    if (!$scope.find('.tmpcoder-compare-add').hasClass('tmpcoder-button-hidden')) {
                        $scope.find('.tmpcoder-compare-add').addClass('tmpcoder-button-hidden');
                    }

                    if ($scope.find('.tmpcoder-compare-remove').hasClass('tmpcoder-button-hidden')) {
                        $scope.find('.tmpcoder-compare-remove').removeClass('tmpcoder-button-hidden');
                    }
                }
            }
        });

        // $(document).ready(function() {
        $scope.find('.tmpcoder-compare-add').click(function (e) {
            e.preventDefault();
            var product_id = $(this).data('product-id');
            var event_target = $(this);

            $(this).fadeTo(500, 0);

            $.ajax({
                url: tmpcoder_plugin_script.ajax_url,
                type: 'POST',
                data: {
                    action: 'add_to_compare',
                    product_id: product_id,
                    nonce: tmpcoder_plugin_script.nonce,
                },
                success: function () {
                    $scope.find('.tmpcoder-compare-add[data-product-id="' + product_id + '"]').hide();
                    $scope.find('.tmpcoder-compare-remove[data-product-id="' + product_id + '"]').show();
                    $scope.find('.tmpcoder-compare-remove[data-product-id="' + product_id + '"]').fadeTo(500, 1);
                    changeActionTargetProductId(product_id);
                    $(document).trigger('added_to_compare');

                /* Add new script for compare popup - start */

                    console.log(event_target.data('atcompare-popup'));

                    if ('popup' === event_target.data('atcompare-popup')) {

                        // Popup Link needs wishlist
                        var popupText = $('.elementor-widget-tmpcoder-woo-product-title .elementor-heading-title').text(),
                            popupLink = tmpcoder_plugin_script.comparePageURL,
                            popupTarget = 'yes' == event_target.data('open-in-new-tab') ? '_blank' : '_self',
                            // popupTarget = '_blank',
                            popupImageSrc = $('.wp-post-image').length ? $('.wp-post-image').data('src') : '',
                            popupAnimation = event_target.data('atcompare-animation'),
                            // popupAnimation = 'slide-left',
                            fadeOutIn = event_target.data('atcompare-fade-out-in'),
                            animTime = event_target.data('atcompare-animation-time'),
                            popupImage,
                            animationClass = 'tmpcoder-added-to-compare-default',
                            removeAnimationClass;

                        if ('slide-left' === popupAnimation) {
                            animationClass = 'tmpcoder-added-to-compare-slide-in-left';
                            removeAnimationClass = 'tmpcoder-added-to-compare-slide-out-left';
                        } else if ('scale-up' === popupAnimation) {
                            animationClass = 'tmpcoder-added-to-compare-scale-up';
                            removeAnimationClass = 'tmpcoder-added-to-compare-scale-down';
                        } else if ('skew' === popupAnimation) {
                            animationClass = 'tmpcoder-added-to-compare-skew';
                            removeAnimationClass = 'tmpcoder-added-to-compare-skew-off';
                        } else if ('fade' === popupAnimation) {
                            animationClass = 'tmpcoder-added-to-compare-fade';
                            removeAnimationClass = 'tmpcoder-added-to-compare-fade-out';
                        } else {
                            removeAnimationClass = 'tmpcoder-added-to-compare-popup-hide';
                        }

                        if ('' !== popupImageSrc) {
                            popupImage = '<div class="tmpcoder-added-tcomp-popup-img"><img src=' + popupImageSrc + ' alt="" /></div>';
                        } else {
                            popupImage = '';
                        }

                        console.log(popupImageSrc);

                        if (!($scope.find('#tmpcoder-added-to-comp-' + product_id).length > 0)) {

                            console.log(popupLink);

                            $scope.append('<div id="tmpcoder-added-to-comp-' + product_id + '" class="tmpcoder-added-to-compare-popup ' + animationClass + '">' + popupImage + '<div class="tmpcoder-added-tc-title"><p>' + popupText + ' was added to Compare</p><p><a target=' + popupTarget + ' href=' + popupLink + '>View Compare</a></p></div></div>');

                            setTimeout(() => {
                                $scope.find('#tmpcoder-added-to-comp-' + product_id).addClass(removeAnimationClass);
                                setTimeout(() => {
                                    $scope.find('#tmpcoder-added-to-comp-' + product_id).remove();
                                }, animTime * 1000);
                            }, fadeOutIn * 1000);
                        }
                    }

                /* Add new script for compare popup -end */

                },
                error: function (response) {
                    var error_message = response.responseJSON.message;
                    // Display error message
                    alert(error_message);
                }
            });
        });
        $scope.find('.tmpcoder-compare-remove').click(function (e) {
            e.preventDefault();
            var product_id = $(this).data('product-id');

            $(this).fadeTo(500, 0);

            $.ajax({
                url: tmpcoder_plugin_script.ajax_url,
                type: 'POST',
                data: {
                    action: 'remove_from_compare',
                    product_id: product_id,
                    nonce: tmpcoder_plugin_script.nonce,
                },
                success: function () {
                    $scope.find('.tmpcoder-compare-remove[data-product-id="' + product_id + '"]').hide();
                    $scope.find('.tmpcoder-compare-add[data-product-id="' + product_id + '"]').show();
                    $scope.find('.tmpcoder-compare-add[data-product-id="' + product_id + '"]').fadeTo(500, 1);
                    changeActionTargetProductId(product_id);
                    $(document).trigger('removed_from_compare');
                }
            });
        });

        $(document).on('removed_from_compare', function () {
            $scope.find('.tmpcoder-compare-remove[data-product-id="' + actionTargetProductId + '"]').hide();
            $scope.find('.tmpcoder-compare-add[data-product-id="' + actionTargetProductId + '"]').show();
            $scope.find('.tmpcoder-compare-add[data-product-id="' + actionTargetProductId + '"]').fadeTo(500, 1);
        });

        // });

    } // end widgetCompareButton
    
    $(window).on('elementor/frontend/init', function () {
        elementorFrontend.hooks.addAction("frontend/element_ready/tmpcoder-compare-button-pro.default",
            widgetCompareButton);
    });
})(jQuery);