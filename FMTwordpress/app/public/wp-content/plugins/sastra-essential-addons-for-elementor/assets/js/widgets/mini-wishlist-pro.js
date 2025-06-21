(function ($) {
    "use strict";

    const widgetMiniWishlist = function ($scope, $) {

        if (!($scope.find('.tmpcoder-wishlist-count').length > 0 && 0 == $scope.find('.tmpcoder-wishlist-count').text())) {
            $scope.find('.tmpcoder-wishlist-count').css('display', 'inline-flex');
        } else {

        }

        function wishlistRemoveHandler() {
            $scope.find('.tmpcoder-wishlist-remove').on('click', function (e) {
                e.preventDefault();
                var product_id = $(this).data('product-id');
                $.ajax({
                    url: tmpcoder_plugin_script.ajax_url,
                    type: 'POST',
                    data: {
                        action: 'remove_from_wishlist',
                        product_id: product_id,
                        nonce: tmpcoder_plugin_script.nonce,
                    },
                    success: function () {
                        $scope.find('.tmpcoder-wishlist-product[data-product-id="' + product_id + '"]').remove();
                        changeActionTargetProductId(product_id);
                        $(document).trigger('removed_from_wishlist');
                    }
                });
            });
        }

        wishlistRemoveHandler();

        var mutationObserver = new MutationObserver(function (mutations) {
            wishlistRemoveHandler();
        });

        mutationObserver.observe($scope[0], {
            childList: true,
            subtree: true,
        });

        $.ajax({
            url: tmpcoder_plugin_script.ajax_url,
            type: 'POST',
            data: {
                action: 'count_wishlist_items',
                nonce: tmpcoder_plugin_script.nonce,
            },
            success: function (response) {
                if ($scope.find('.tmpcoder-wishlist-count').css('display') == 'none' && 0 < response.wishlist_count) {
                    $scope.find('.tmpcoder-wishlist-count').text(response.wishlist_count);
                    $scope.find('.tmpcoder-wishlist-count').css('display', 'inline-flex');
                } else if (0 == response.wishlist_count) {
                    $scope.find('.tmpcoder-wishlist-count').css('display', 'none');
                    $scope.find('.tmpcoder-wishlist-count').text(response.wishlist_count);
                } else {
                    $scope.find('.tmpcoder-wishlist-count').text(response.wishlist_count);
                }

                if (true) {
                    // Get all elements with the class 'tmpcoder-wishlist-product' and their product IDs
                    var productElements = $scope.find('.tmpcoder-wishlist-product');
                    var productIds = productElements.map(function () {
                        return $(this).data('product-id');
                    }).get();

                    // Filter out the items in the response that match the product IDs
                    var newWishlistItems = response.wishlist_items.filter(function (item) {
                        return !productIds.includes(item.product_id);
                    });

                    // Convert the wishlist_items to an array of product_ids for easier searching
                    var wishlistProductIds = response.wishlist_items.map(function (item) {
                        return item.product_id;
                    });

                    productElements.each(function () {
                        var productId = $(this).data('product-id');

                        // If the product ID is not in the wishlistProductIds array, remove the element
                        if (!wishlistProductIds.includes(productId)) {
                            $(this).remove();
                        }
                    });

                    newWishlistItems.forEach(function (item) {
                        $scope.find('.tmpcoder-wishlist-products').append('<li class="tmpcoder-wishlist-product" data-product-id="' + item.product_id + '"><a class="tmpcoder-wishlist-product-img" href="' + item.product_url + '">' + item.product_image + '</a><div><a href="' + item.product_url + '">' + item.product_title + '</a><div class="tmpcoder-wishlist-product-price">' + item.product_price + '</div></div><span class="tmpcoder-wishlist-remove" data-product-id="' + item.product_id + '"></span></li>');
                    });
                }
            }
        });

        $(document).on('added_to_wishlist', function () {
            $.ajax({
                url: tmpcoder_plugin_script.ajax_url,
                type: 'POST',
                data: {
                    action: 'update_mini_wishlist',
                    product_id: actionTargetProductId,
                    nonce: tmpcoder_plugin_script.nonce,
                },
                success: function (response) {
                    if ($scope.find('.tmpcoder-wishlist-products').find('li[data-product-id=' + response.product_id + ']').length == 0) {
                        $scope.find('.tmpcoder-wishlist-products').append('<li class="tmpcoder-wishlist-product" data-product-id="' + response.product_id + '"><a class="tmpcoder-wishlist-product-img" href="' + response.product_url + '">' + response.product_image + '</a><div><a href="' + response.product_url + '">' + response.product_title + '</a><div class="tmpcoder-wishlist-product-price">' + response.product_price + '</div></div><span class="tmpcoder-wishlist-remove" data-product-id="' + response.product_id + '"></span></li>');
                    }

                    $scope.find('.tmpcoder-wishlist-count').text(response.wishlist_count);
                    $scope.find('.tmpcoder-wishlist-count').css('display', 'inline-flex');
                }
            });
        });

        $(document).on('removed_from_wishlist', function () {
            $scope.find('.tmpcoder-wishlist-product[data-product-id="' + actionTargetProductId + '"]').remove();
            $.ajax({
                url: tmpcoder_plugin_script.ajax_url,
                type: 'POST',
                data: {
                    action: 'update_mini_wishlist',
                    product_id: actionTargetProductId,
                    nonce: tmpcoder_plugin_script.nonce,
                },
                success: function (response) {
                    $scope.find('.tmpcoder-wishlist-count').text(response.wishlist_count);

                    if (response.wishlist_count == 0) {
                        $scope.find('.tmpcoder-wishlist-count').css('display', 'none');
                    } else {
                        $scope.find('.tmpcoder-wishlist-count').css('display', 'inline-flex');
                    }
                }
            });
        });
        $scope.find('.tmpcoder-wishlist').css({ "display": "none" });

        var animationSpeed = $scope.find('.tmpcoder-wishlist-wrap').length != 0 ? $scope.find('.tmpcoder-wishlist-wrap').data('animation') : 600;

        $('body').on('click', function (e) {
            if (!e.target.classList.value.includes('tmpcoder-wishlist-wrap') && !e.target.closest('.tmpcoder-wishlist-wrap') && !e.target.classList.value.includes('tmpcoder-wishlist-inner-wrap') && !e.target.closest('.tmpcoder-wishlist-inner-wrap') ) {
                if ($scope.hasClass('tmpcoder-wishlist-slide')) {
                    $scope.find('.tmpcoder-wishlist').slideUp(animationSpeed);
                } else {
                    $scope.find('.tmpcoder-wishlist').fadeOut(animationSpeed);
                }
            }
        });

        if (0 !== $scope.hasClass('tmpcoder-wishlist-sidebar').length) {
            if ($('#wpadminbar').length) {
                $scope.find('.tmpcoder-wishlist').css({
                    // 'top': $('#wpadminbar').css('height'),
                    // 'height': $scope.find('.tmpcoder-shopping-cart-wrap').css('height') -  $('#wpadminbar').css('height')
                    'z-index': 999999
                });
            }

            closeSideBar();

            $scope.find('.tmpcoder-wishlist').on('click', function (e) {
                if (!e.target.classList.value.includes('tmpcoder-wishlist-inner-wrap') && !e.target.closest('.tmpcoder-wishlist-inner-wrap')) {
                    $scope.find('.tmpcoder-wishlist-inner-wrap').addClass('tmpcoder-wishlist-slide-out');
                    $scope.find('.tmpcoder-wishlist-slide-out').css('animation-speed', animationSpeed);
                    $scope.find('.tmpcoder-wishlist').fadeOut(animationSpeed);
                    $('body').removeClass('tmpcoder-wishlist-sidebar-body');
                    setTimeout(function () {
                        $scope.find('.tmpcoder-wishlist-inner-wrap').removeClass('tmpcoder-wishlist-slide-out');
                        $scope.find('.tmpcoder-wishlist').css({ "display": "none" });
                    }, animationSpeed + 100);
                }
            });
        }

        if ($scope.find('.tmpcoder-wishlist').length) {
            if ($scope.hasClass('tmpcoder-wishlist-sidebar') || $scope.hasClass('tmpcoder-wishlist-dropdown')) {
                $scope.find('.tmpcoder-wishlist-toggle-btn').on('click', function (e) {
                    e.stopPropagation();
                    e.preventDefault();
                    if ('none' === $scope.find('.tmpcoder-wishlist').css("display")) {
                        if ($scope.hasClass('tmpcoder-wishlist-slide')) {
                            $scope.find('.tmpcoder-wishlist').slideDown(animationSpeed);
                        } else {
                            $scope.find('.tmpcoder-wishlist').fadeIn(animationSpeed);
                        }
                        if ($scope.hasClass('tmpcoder-wishlist-sidebar')) {
                            $scope.find('.tmpcoder-wishlist').fadeIn(animationSpeed);
                            $scope.find('.tmpcoder-wishlist-inner-wrap').addClass('tmpcoder-wishlist-slide-in');
                            $scope.find('.tmpcoder-wishlist-slide-in').css('animation-speed', animationSpeed);
                            $('body').addClass('tmpcoder-wishlist-sidebar-body');
                        }
                        setTimeout(function () {
                            $scope.find('.tmpcoder-wishlist').removeClass('tmpcoder-wishlist-slide-in');
                            if ($scope.hasClass('tmpcoder-wishlist-sidebar')) {
                                $scope.find('.tmpcoder-wishlist').trigger('resize');
                            }
                        }, animationSpeed + 100);
                    } else {
                        if ($scope.hasClass('tmpcoder-wishlist-slide')) {
                            $scope.find('.tmpcoder-wishlist').slideUp(animationSpeed);
                        } else {
                            $scope.find('.tmpcoder-wishlist').fadeOut(animationSpeed);
                        }
                    }
                });
            }
        }

        var mutationObserver = new MutationObserver(function (mutations) {
            if (0 !== $scope.hasClass('tmpcoder-wishlist-sidebar').length) {
                closeSideBar();
            }

            $scope.find('.tmpcoder-wishlist-product').on('click', '.tmpcoder-wishlist-remove', function () {
                $(this).closest('li').addClass('tmpcoder-before-remove-from-wishlist');
            });

            if ($scope.find('.tmpcoder-wishlist-product').length !== 0) {
                $scope.find('.tmpcoder-wishlist-empty').addClass('tmpcoder-wishlist-empty-hidden');
                $scope.find('.tmpcoder-view-wishlist').removeClass('tmpcoder-hidden-element');
            } else {
                $scope.find('.tmpcoder-wishlist-empty').removeClass('tmpcoder-wishlist-empty-hidden');
                $scope.find('.tmpcoder-view-wishlist').addClass('tmpcoder-hidden-element');
            }
        });

        // Listen to Mini Cart Changes
        mutationObserver.observe($scope[0], {
            childList: true,
            subtree: true,
        });

        function closeSideBar() {
            $scope.find('.tmpcoder-close-wishlist span').on('click', function (e) {
                $scope.find('.tmpcoder-wishlist-inner-wrap').addClass('tmpcoder-wishlist-slide-out');
                $scope.find('.tmpcoder-wishlist-slide-out').css('animation-speed', animationSpeed);
                $scope.find('.tmpcoder-wishlist').fadeOut(animationSpeed);
                $('body').removeClass('tmpcoder-wishlist-sidebar-body');
				setTimeout(function () {
                    $scope.find('.tmpcoder-wishlist-inner-wrap').removeClass('tmpcoder-wishlist-slide-out');
                    $scope.find('.tmpcoder-wishlist').css({ "display": "none" });
                }, animationSpeed + 100);
            });
        }
    } // end widgetMiniWishlist
    
    $(window).on('elementor/frontend/init', function () {
        elementorFrontend.hooks.addAction("frontend/element_ready/tmpcoder-mini-wishlist-pro.default",
            widgetMiniWishlist);
    });
})(jQuery);