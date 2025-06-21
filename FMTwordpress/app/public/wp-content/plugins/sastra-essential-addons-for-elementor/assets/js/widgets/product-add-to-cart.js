(function ($) {
    "use strict";

    const widgetProductAddToCart = function ($scope, $) {
        var qtyInput = jQuery('.woocommerce .tmpcoder-quantity-wrapper'),
            qtyInputInStock = qtyInput.find('input.qty').attr('max') ? qtyInput.find('input.qty').attr('max') : 99999999,
            qtyLayout = $scope.find('.tmpcoder-product-add-to-cart').attr('layout-settings'),
            qtyWrapper = $scope.find('.tmpcoder-add-to-cart-icons-wrap'),
            plusIconChild = !$scope.find('.tmpcoder-add-to-cart-icons-wrap').length ? 'last-child' : 'first-child',
            minusIconChild = !$scope.find('.tmpcoder-add-to-cart-icons-wrap').length ? 'first-child' : 'last-child';

        $scope.find('input.qty').each(function () {
            if (!$(this).val()) {
                $(this).val(0);
            }
        });

        $scope.find('.variations').find('select').on('change', function () {
            var resetButtonDisplay = false;
            $scope.find('.variations').find('select').each(function () {
                if ('choose an option' !== $(this).find('option:selected').text().toLowerCase()) {
                    resetButtonDisplay = true;
                }
            });

            if (resetButtonDisplay == false) {
                $scope.find('.reset_variations').css('display', 'none');
            } else {
                $scope.find('.reset_variations').css('display', 'inline-block');
            }
        });

        // convert to text input
        if (qtyLayout !== 'default') {
            qtyInput.find('input.qty').attr('type', 'text').removeAttr('step').removeAttr('min').removeAttr('max');
            // qtyInput.find('input.qty').attr('type', 'text').removeAttr('step').removeAttr('max');
        }

        // plus
        qtyInput.on('click', 'i:' + plusIconChild, function () {

            if (parseInt(jQuery(this).prev('.quantity').find('input.qty').val(), 10) < qtyInputInStock && qtyLayout == 'both') {

                if (parseInt(jQuery(this).prev('.quantity').find('input.qty').val(), 10) == 0) {
                    jQuery('.single_add_to_cart_button').removeAttr('style');
                }

                jQuery(this).prev('.quantity').find('input.qty').val(parseInt(jQuery(this).prev('.quantity').find('input.qty').val(), 10) + 1);
                jQuery('input[name="update_cart"]').removeAttr('disabled');
            } else if (parseInt(jQuery(this).parent().siblings('.quantity').find('input.qty').val(), 10) < qtyInputInStock && qtyLayout !== 'both' && qtyLayout !== 'default') {
                jQuery(this).parent().siblings('.quantity').find('input.qty').val(parseInt(jQuery(this).parent().siblings('.quantity').find('input.qty').val(), 10) + 1);
                jQuery('input[name="update_cart"]').removeAttr('disabled');

                var qty = jQuery(this).parent().siblings('.quantity').find('input.qty').val();

                if (qty < 1) {
                    jQuery('.single_add_to_cart_button').css('pointer-events', 'none');
                    jQuery('.single_add_to_cart_button').css('opacity', '0.5');
                }
                else {
                    jQuery('.single_add_to_cart_button').removeAttr('style');
                }
            }
        });

        // minus
        qtyInput.on('click', 'i:' + minusIconChild, function () {

            if (parseInt(jQuery(this).next('.quantity').find('input.qty').val(), 10) > 1 && qtyLayout == 'both') {
                jQuery(this).next('.quantity').find('input.qty').val(parseInt(jQuery(this).next('.quantity').find('input.qty').val(), 10) - 1);
                jQuery('input[name="update_cart"]').removeAttr('disabled');
            } else if (parseInt(jQuery(this).parent().siblings('.quantity').find('input.qty').val(), 10) > 0 && qtyLayout !== 'both' && qtyLayout !== 'default') {
                jQuery(this).parent().siblings('.quantity').find('input.qty').val(parseInt(jQuery(this).parent().siblings('.quantity').find('input.qty').val(), 10) - 1);
                jQuery('input[name="update_cart"]').removeAttr('disabled');

                var qty = jQuery(this).parent().siblings('.quantity').find('input.qty').val();

                if (qty < 1) {
                    jQuery('.single_add_to_cart_button').css('pointer-events', 'none');
                    jQuery('.single_add_to_cart_button').css('opacity', '0.5');
                }
                else {
                    jQuery('.single_add_to_cart_button').removeAttr('style');
                }
            }
        });

        jQuery(document).on('keyup change blur', 'input.qty', function () {
            if (jQuery(this).val() < 1) {
                jQuery('.single_add_to_cart_button').css('pointer-events', 'none');
                jQuery('.single_add_to_cart_button').css('opacity', '0.5');
            }
            else {
                jQuery('.single_add_to_cart_button').removeAttr('style');
            }
        });

        qtyInput.find('input.qty').keyup(function () {
            if (jQuery(this).val() > qtyInputInStock) {
                jQuery(this).val(qtyInputInStock);
            }
        });

        if ('yes' === $scope.find('.tmpcoder-product-add-to-cart').data('ajax-add-to-cart')) {
            if (!$('div[data-elementor-type="tmpcoder-theme-builder"]').hasClass('product-type-external')) {
                $scope.find('.single_add_to_cart_button').on('click', ajaxAddToCart);
            }
        }

        function ajaxAddToCart(e) {
            e.preventDefault();

            let $form = $(this).closest('form');

            var $variationForm = $form.closest('.variations_form');

            let isGrouped = $form.hasClass('grouped_form');

            if (!$form[0].checkValidity()) {
                $form[0].reportValidity();

                return false;
            }

            let $thisBtn = $(this),
                product_id = $thisBtn.val() || '',
                cartFormData = $form.serialize();

            // // Get the ID of the selected variation
            // let variation_id = $scope.find('input[name="variation_id"]').val();
            // console.log(window['wc_variation_form']);
            // // Get the data of the selected variation
            // let variation_data = window['wc_variation_form'].variation_data[variation_id];

            // // Get the availability HTML of the selected variation
            // let availability_html = variation_data.availability_html;

            // // Check if the variation is in stock
            // if (availability_html.indexOf('In stock') !== -1) {
            //   console.log('Selected variation is in stock');
            // } else {
            //   console.log('Selected variation is out of stock');
            // }

            if (isGrouped) {
                let nonZero = false;
                $scope.find('.woocommerce-grouped-product-list-item__quantity').find('input').each(function () {
                    if ($(this).val() > 0) {
                        nonZero = true;
                    }
                });

                if (!nonZero) {
                    // The grouped product does not have the required number of items selected
                    alert(tmpcoder_plugin_script.chooseQuantityText);
                    return;
                }
            }

            $.ajax({
                type: 'POST',
                url: tmpcoder_plugin_script.ajax_url,
                data: 'action=tmpcoder_add_cart_single_product&add-to-cart=' + product_id + '&' + cartFormData,
                beforeSend: function () {
                    if ($variationForm.length > 0 && !$variationForm.find('.variations select').val()) {
                        // Do not trigger added_to_cart event if options are not selected for variable product
                        return;
                    }
                    if ($thisBtn.hasClass('disabled')) {
                        return
                    }

                    $thisBtn.removeClass('added').addClass('loading');
                },
                complete: function () {
                    if ($variationForm.length > 0 && !$variationForm.find('.variations select').val()) {
                        // Do not trigger added_to_cart event if options are not selected for variable product
                        return;
                    }

                    if ($thisBtn.hasClass('disabled')) {
                        return
                    }

                    $thisBtn.addClass('added').removeClass('loading');
                },
                success: function (response) {

                    // GOGA - remove later
                    if (response.notices && response.notices.length > 0) {

                        // The selected variation is low in stock, display a warning message
                        if (response.notices[0].type === 'wc_low_stock') {
                            alert('Only ' + response.notices[0].message + ' left in stock!');
                        } else {
                            alert(response.notices[0].message);
                        }
                    }

                    if (response.error && response.product_url) {
                        window.location = response.product_url;
                        return;
                    }

                    if (typeof wc_add_to_cart_params === 'undefined') {
                        return false;
                    }

                    if ($variationForm.length > 0 && !$variationForm.find('.variations select').val()) {
                        // Do not trigger added_to_cart event if options are not selected for variable product
                        return;
                    }

                    if ($thisBtn.hasClass('disabled')) {
                        return;
                    }

                    $(document.body).trigger('wc_fragment_refresh');
                    $(document.body).trigger('added_to_cart', [response.fragments, response.cart_hash, $thisBtn]);

                    setTimeout(function () {
                        $thisBtn.removeClass('added');
                        var currentCartCount = parseInt($('.tmpcoder-mini-cart-icon-count').text());
                        var updatedCartCount = parseInt($scope.find('.tmpcoder-quantity-wrapper .qty').val());
                        $('.tmpcoder-mini-cart-icon-count').text(currentCartCount + updatedCartCount);

                        if ($('.refresh-tmpcoder-cart-qty').length > 0) {
                            $('.tmpcoder-cart-total .tmpcoder-total-qty').text($('.refresh-tmpcoder-cart-qty').val());
                            $('.tmpcoder-cart-popup .tmpcoder-cart-popup-count').text($('.refresh-tmpcoder-cart-qty').val());
                        }
                        if ($('.refresh-tmpcoder-cart-total').length > 0) {
                            $('.tmpcoder-cart-total .woocommerce-Price-amount').replaceWith($('.refresh-tmpcoder-cart-total .woocommerce-Price-amount').clone());
                        }
                    }, 200);
                },
            });
        }
    }
    
    $(window).on('elementor/frontend/init', function () {
        elementorFrontend.hooks.addAction("frontend/element_ready/tmpcoder-woo-add-to-cart.default",
            widgetProductAddToCart);
    });
})(jQuery);