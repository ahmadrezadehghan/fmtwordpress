(function ($) {
    "use strict";

    const widgetMagazineGrid = function ($scope, $) {
        // Settings
        var iGrid = $scope.find('.tmpcoder-magazine-grid-wrap'),
            settings = iGrid.attr('data-slick'),
            dataSlideEffect = iGrid.attr('data-slide-effect');

        // Slider
        if (typeof settings !== typeof undefined && settings !== false) {
            iGrid.slick({
                fade: 'fade' === dataSlideEffect ? true : false
            });
        }

        $(document).ready(function () {
            iGrid.css('opacity', 1);
        });

        var iGridLength = iGrid.find('.tmpcoder-mgzn-grid-item').length;

        // Media Hover Link
        if ('yes' === iGrid.find('.tmpcoder-grid-media-wrap').attr('data-overlay-link') && !editorCheck()) {
            iGrid.find('.tmpcoder-grid-media-wrap').css('cursor', 'pointer');

            iGrid.find('.tmpcoder-grid-media-wrap').on('click', function (event) {
                var targetClass = event.target.className;

                if (-1 !== targetClass.indexOf('inner-block') || -1 !== targetClass.indexOf('tmpcoder-cv-inner') ||
                    -1 !== targetClass.indexOf('tmpcoder-grid-media-hover')) {
                    event.preventDefault();

                    var itemUrl = $(this).find('.tmpcoder-grid-media-hover-bg').attr('data-url');

                    itemUrl = TmpcodersanitizeURL(itemUrl);

                    // GOGA - leave if necessary
                    if (iGrid.find('.tmpcoder-grid-item-title a').length) {
                        if ('_blank' === iGrid.find('.tmpcoder-grid-item-title a').attr('target')) {
                            window.open(itemUrl, '_blank').focus();
                        } else {
                            window.location.href = itemUrl;
                        }
                    }
                }
            });
        }

        // Sharing
        if ($scope.find('.tmpcoder-sharing-trigger').length) {
            var sharingTrigger = $scope.find('.tmpcoder-sharing-trigger'),
                sharingInner = $scope.find('.tmpcoder-post-sharing-inner'),
                sharingWidth = 5;

            // Calculate Width
            sharingInner.first().find('a').each(function () {
                sharingWidth += $(this).outerWidth() + parseInt($(this).css('margin-right'), 10);
            });

            // Calculate Margin
            var sharingMargin = parseInt(sharingInner.find('a').css('margin-right'), 10);

            // Set Positions
            if ('left' === sharingTrigger.attr('data-direction')) {
                // Set Width
                sharingInner.css('width', sharingWidth + 'px');

                // Set Position
                sharingInner.css('left', - (sharingMargin + sharingWidth) + 'px');
            } else if ('right' === sharingTrigger.attr('data-direction')) {
                // Set Width
                sharingInner.css('width', sharingWidth + 'px');

                // Set Position
                sharingInner.css('right', - (sharingMargin + sharingWidth) + 'px');
            } else if ('top' === sharingTrigger.attr('data-direction')) {
                // Set Margins
                sharingInner.find('a').css({
                    'margin-right': '0',
                    'margin-top': sharingMargin + 'px'
                });

                // Set Position
                sharingInner.css({
                    'top': -sharingMargin + 'px',
                    'left': '50%',
                    '-webkit-transform': 'translate(-50%, -100%)',
                    'transform': 'translate(-50%, -100%)'
                });
            } else if ('right' === sharingTrigger.attr('data-direction')) {
                // Set Width
                sharingInner.css('width', sharingWidth + 'px');

                // Set Position
                sharingInner.css({
                    'left': sharingMargin + 'px',
                    // 'bottom' : - ( sharingInner.outerHeight() + sharingTrigger.outerHeight() ) +'px',
                });
            } else if ('bottom' === sharingTrigger.attr('data-direction')) {
                // Set Margins
                sharingInner.find('a').css({
                    'margin-right': '0',
                    'margin-bottom': sharingMargin + 'px'
                });

                // Set Position
                sharingInner.css({
                    'bottom': -sharingMargin + 'px',
                    'left': '50%',
                    '-webkit-transform': 'translate(-50%, 100%)',
                    'transform': 'translate(-50%, 100%)'
                });
            }

            if ('click' === sharingTrigger.attr('data-action')) {
                sharingTrigger.on('click', function () {
                    var sharingInner = $(this).next();

                    if ('hidden' === sharingInner.css('visibility')) {
                        sharingInner.css('visibility', 'visible');
                        sharingInner.find('a').css({
                            'opacity': '1',
                            'top': '0'
                        });

                        setTimeout(function () {
                            sharingInner.find('a').addClass('tmpcoder-no-transition-delay');
                        }, sharingInner.find('a').length * 100);
                    } else {
                        sharingInner.find('a').removeClass('tmpcoder-no-transition-delay');

                        sharingInner.find('a').css({
                            'opacity': '0',
                            'top': '-5px'
                        });
                        setTimeout(function () {
                            sharingInner.css('visibility', 'hidden');
                        }, sharingInner.find('a').length * 100);
                    }
                });
            } else {
                sharingTrigger.on('mouseenter', function () {
                    var sharingInner = $(this).next();

                    sharingInner.css('visibility', 'visible');
                    sharingInner.find('a').css({
                        'opacity': '1',
                        'top': '0',
                    });

                    setTimeout(function () {
                        sharingInner.find('a').addClass('tmpcoder-no-transition-delay');
                    }, sharingInner.find('a').length * 100);
                });
                $scope.find('.tmpcoder-grid-item-sharing').on('mouseleave', function () {
                    var sharingInner = $(this).find('.tmpcoder-post-sharing-inner');

                    sharingInner.find('a').removeClass('tmpcoder-no-transition-delay');

                    sharingInner.find('a').css({
                        'opacity': '0',
                        'top': '-5px'
                    });
                    setTimeout(function () {
                        sharingInner.css('visibility', 'hidden');
                    }, sharingInner.find('a').length * 100);
                });
            }
        }

        // Likes
        if ($scope.find('.tmpcoder-post-like-button').length) {

            $scope.find('.tmpcoder-post-like-button').on('click', function () {
                var current = $(this);

                if ('' !== current.attr('data-post-id')) {

                    $.ajax({
                        type: 'POST',
                        url: current.attr('data-ajax'),
                        data: {
                            action: 'tmpcoder_likes_init',
                            post_id: current.attr('data-post-id'),
                            nonce: current.attr('data-nonce')
                        },
                        beforeSend: function () {
                            current.fadeTo(500, 0.5);
                        },
                        success: function (response) {
                            // Get Icon
                            var iconClass = current.attr('data-icon');

                            // Get Count
                            var countHTML = response.count;

                            if ('' === countHTML.replace(/<\/?[^>]+(>|$)/g, "")) {
                                countHTML = '<span class="tmpcoder-post-like-count">' + current.attr('data-text') + '</span>';

                                if (!current.hasClass('tmpcoder-likes-zero')) {
                                    current.addClass('tmpcoder-likes-zero');
                                }
                            } else {
                                current.removeClass('tmpcoder-likes-zero');
                            }

                            // Update Icon
                            if (current.hasClass('tmpcoder-already-liked')) {
                                current.prop('title', 'Like');
                                current.removeClass('tmpcoder-already-liked');
                                current.html('<i class="' + iconClass.replace('fas', 'far') + '"></i>' + countHTML);
                            } else {
                                current.prop('title', 'Unlike');
                                current.addClass('tmpcoder-already-liked');
                                current.html('<i class="' + iconClass.replace('far', 'fas') + '"></i>' + countHTML);
                            }

                            current.fadeTo(500, 1);
                        }
                    });

                }

                return false;
            });

        }

    }
    
    $(window).on('elementor/frontend/init', function () {
        elementorFrontend.hooks.addAction("frontend/element_ready/tmpcoder-magazine-grid.default",
            widgetMagazineGrid);
    });
})(jQuery);