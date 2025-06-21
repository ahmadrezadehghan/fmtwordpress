(function ($) {
    "use strict";

    const widgetSearch = function ($scope) {
        var isFound = false;

        $scope.find('.tmpcoder-search-form-input').on({
            focus: function () {
                $scope.addClass('tmpcoder-search-form-input-focus');
            },
            blur: function () {
                $scope.removeClass('tmpcoder-search-form-input-focus');
            }
        });

        if ($scope.find('.tmpcoder-category-select').length > 0) {
            // Set the selected value on page load
            $(document).ready(function () {
                var tmpcoderSelectedCategory = localStorage.getItem('tmpcoderSelectedCategory');
                if (tmpcoderSelectedCategory) {
                    $scope.find('.tmpcoder-category-select option').each(function () {
                        if ($(this).val() === tmpcoderSelectedCategory) {
                            isFound = true;
                            $scope.find('.tmpcoder-category-select').val(tmpcoderSelectedCategory);
                            return false; // Breaks out of the .each() loop
                        } else {
                            $scope.find('.tmpcoder-category-select').val(0);
                        }
                    });
                }
            });

            $scope.find('.tmpcoder-category-select').on('change', function (e) {

                var selectedValue = $(this).val();
                localStorage.setItem('tmpcoderSelectedCategory', selectedValue);

                if ($scope.find('.tmpcoder-search-form-input').attr('ajax-search') === 'yes') {
                    postsOffset = 0;
                    $scope.find('.tmpcoder-data-fetch').hide();
                    $scope.find('.tmpcoder-data-fetch ul').html('');
                    ajaxSearchCall($scope.find('.tmpcoder-search-form-input'), postsOffset, e);
                }
            });
        }

        var prevData;
        var searchTimeout = null;

        function ajaxSearchCall(thisObject, postsOffset, e) {
            if (e.which === 13) {
                return false;
            }

            if (searchTimeout != null) {
                clearTimeout(searchTimeout);
            }
            var optionPostType = ($scope.find('.tmpcoder-category-select').length > 0 && $scope.find('.tmpcoder-category-select').find('option:selected').data('post-type'));
            var tmpcoderTaxonomyType = $scope.find('.tmpcoder-search-form-input').attr('tmpcoder-taxonomy-type');

            if ($scope.find('.tmpcoder-category-select').length > 0) {
                if (!tmpcoderTaxonomyType) {
                    if ($scope.find('.tmpcoder-search-form-input').attr('tmpcoder-query-type') == 'product') {
                        tmpcoderTaxonomyType = 'product_cat';
                    } else {
                        tmpcoderTaxonomyType = 'category';
                    }
                }
            }

            searchTimeout = setTimeout(() => {
                var thisValue = thisObject.val();
                $.ajax({
                    type: 'POST',
                    url: tmpcoder_plugin_script.ajax_url,
                    data: {
                        action: 'tmpcoder_data_fetch',
                        nonce: tmpcoder_plugin_script.nonce,
                        tmpcoder_keyword: $scope.find('.tmpcoder-search-form-input').val(),
                        tmpcoder_query_type: $scope.find('.tmpcoder-search-form-input').attr('tmpcoder-query-type'),
                        tmpcoder_option_post_type: optionPostType ? $scope.find('.tmpcoder-category-select').find('option:selected').data('post-type') : '',
                        tmpcoder_taxonomy_type: tmpcoderTaxonomyType,
                        tmpcoder_category: $scope.find('.tmpcoder-category-select').length > 0 ? $scope.find('.tmpcoder-category-select').val() : '',
                        tmpcoder_number_of_results: $scope.find('.tmpcoder-search-form-input').attr('number-of-results'),
                        tmpcoder_search_results_offset: postsOffset,
                        tmpcoder_show_description: $scope.find('.tmpcoder-search-form-input').attr('show-description'),
                        tmpcoder_number_of_words: $scope.find('.tmpcoder-search-form-input').attr('number-of-words'),
                        tmpcoder_show_ajax_thumbnail: $scope.find('.tmpcoder-search-form-input').attr('show-ajax-thumbnails'),
                        tmpcoder_show_view_result_btn: $scope.find('.tmpcoder-search-form-input').attr('show-view-result-btn'),
                        tmpcoder_view_result_text: $scope.find('.tmpcoder-search-form-input').attr('view-result-text'),
                        tmpcoder_no_results: $scope.find('.tmpcoder-search-form-input').attr('no-results'),
                        tmpcoder_exclude_without_thumb: $scope.find('.tmpcoder-search-form-input').attr('exclude-without-thumb'),
                        tmpcoder_ajax_search_link_target: $scope.find('.tmpcoder-search-form-input').attr('link-target'),
                        // tmpcoder_ajax_search_img_size: $scope.find('.tmpcoder-search-form-input').attr('ajax-search-img-size')
                    },
                    success: function (data) {
                        $scope.closest('section').addClass('tmpcoder-section-z-index');
                        if ($scope.find('.tmpcoder-data-fetch ul').html() === '') {
                            $scope.find('.tmpcoder-pagination-loading').hide();
                            $scope.find('.tmpcoder-data-fetch ul').html(data);
                            $scope.find('.tmpcoder-no-more-results').fadeOut(100);
                            setTimeout(function () {
                                if (!data.includes('tmpcoder-no-results')) {
                                    $scope.find('.tmpcoder-ajax-search-pagination').css('display', 'flex');
                                    if ($scope.find('.tmpcoder-data-fetch ul').find('li').length < $scope.find('.tmpcoder-search-form-input').attr('number-of-results') ||
                                        $scope.find('.tmpcoder-data-fetch ul').find('li').length == $scope.find('.tmpcoder-data-fetch ul').find('li').data('number-of-results')) {
                                        $scope.find('.tmpcoder-ajax-search-pagination').css('display', 'none');
                                        $scope.find('.tmpcoder-load-more-results').fadeOut(100);
                                    } else {
                                        $scope.find('.tmpcoder-ajax-search-pagination').css('display', 'flex');
                                        $scope.find('.tmpcoder-load-more-results').fadeIn(100);
                                    }
                                } else {
                                    $scope.find('.tmpcoder-ajax-search-pagination').css('display', 'none');
                                }
                            }, 100);
                            prevData = data;
                        } else {
                            if (data != prevData) {
                                prevData = data;
                                if (data.includes('tmpcoder-no-results')) {
                                    $scope.find('.tmpcoder-ajax-search-pagination').css('display', 'none');
                                    $scope.find('.tmpcoder-data-fetch ul').html('');
                                    $scope.closest('section').removeClass('tmpcoder-section-z-index');
                                } else {
                                    $scope.find('.tmpcoder-ajax-search-pagination').css('display', 'flex');
                                }

                                $scope.find('.tmpcoder-data-fetch ul').append(data);

                                if (data == '') {
                                    $scope.find('.tmpcoder-load-more-results').fadeOut(100);
                                    setTimeout(function () {
                                        $scope.find('.tmpcoder-pagination-loading').hide();
                                        $scope.find('.tmpcoder-no-more-results').fadeIn(100);
                                    }, 100);
                                } else {
                                    $scope.find('.tmpcoder-pagination-loading').hide();
                                    $scope.find('.tmpcoder-load-more-results').show();
                                }

                                if ($scope.find('.tmpcoder-data-fetch ul').find('li').length < $scope.find('.tmpcoder-search-form-input').attr('number-of-results')) {
                                    $scope.find('.tmpcoder-load-more-results').fadeOut(100);
                                    setTimeout(function () {
                                        $scope.find('.tmpcoder-pagination-loading').hide();
                                        $scope.find('.tmpcoder-no-more-results').fadeIn(100);
                                    }, 100);
                                } else {
                                    $scope.find('.tmpcoder-load-more-results').show();
                                }

                                if ($scope.find('.tmpcoder-data-fetch ul').find('li').length == $scope.find('.tmpcoder-data-fetch ul').find('li').data('number-of-results')) {
                                    $scope.find('.tmpcoder-load-more-results').fadeOut(100);
                                    setTimeout(function () {
                                        $scope.find('.tmpcoder-pagination-loading').hide();
                                        $scope.find('.tmpcoder-no-more-results').fadeIn(100);
                                    }, 100);
                                } else {
                                    $scope.find('.tmpcoder-load-more-results').show();
                                }
                                // $scope.find( '.tmpcoder-pagination-loading' ).hide();
                            }
                        }

                        if (data.includes('tmpcoder-no-results')) {
                            $scope.find('.tmpcoder-ajax-search-pagination').css('display', 'none');
                            $scope.find('.tmpcoder-load-more-results').fadeOut();
                        } else {
                            $scope.find('.tmpcoder-ajax-search-pagination').css('display', 'flex');
                        }

                        if (thisValue.length > 2) {
                            $scope.find('.tmpcoder-data-fetch').slideDown(200);
                            $scope.find('.tmpcoder-data-fetch ul').fadeTo(200, 1);
                        } else {
                            $scope.find('.tmpcoder-data-fetch').slideUp(200);
                            $scope.find('.tmpcoder-data-fetch ul').fadeTo(200, 0);
                            setTimeout(function () {
                                $scope.find('.tmpcoder-data-fetch ul').html('');
                                $scope.find('.tmpcoder-no-results').remove();
                                $scope.closest('section').removeClass('tmpcoder-section-z-index');
                            }, 600);
                            postsOffset = 0;
                        }
                    },
                    error: function (error) {
                        console.log(error);
                    }
                });
            }, 400);
        }

        if ($scope.find('.tmpcoder-search-form-input').attr('ajax-search') === 'yes') {

            $scope.find('.tmpcoder-search-form').attr('autocomplete', 'off');

            var postsOffset = 0;

            $scope.find('.tmpcoder-load-more-results').on('click', function (e) {
                postsOffset += +$scope.find('.tmpcoder-search-form-input').attr('number-of-results');
                $scope.find('.tmpcoder-load-more-results').hide();
                $scope.find('.tmpcoder-pagination-loading').css('display', 'inline-block');
                ajaxSearchCall($scope.find('.tmpcoder-search-form-input'), postsOffset, e);
            });

            $scope.find('.tmpcoder-search-form-input').on('keyup', function (e) {
                postsOffset = 0;
                $scope.find('.tmpcoder-data-fetch').hide();
                $scope.find('.tmpcoder-data-fetch ul').html('');
                ajaxSearchCall($(this), postsOffset, e);
            });

            $scope.find('.tmpcoder-data-fetch').on('click', '.tmpcoder-close-search', function () {
                $scope.find('.tmpcoder-search-form-input').val('');
                $scope.find('.tmpcoder-data-fetch').slideUp(200);
                setTimeout(function () {
                    $scope.find('.tmpcoder-data-fetch ul').html('');
                    $scope.find('.tmpcoder-no-results').remove();
                    $scope.closest('section').removeClass('tmpcoder-section-z-index');
                }, 400);
                postsOffset = 0;
            });

            $('body').on('click', function (e) {
                if (!e.target.classList.value.includes('tmpcoder-data-fetch') && !e.target.closest('.tmpcoder-data-fetch')) {
                    if (!e.target.classList.value.includes('tmpcoder-search-form') && !e.target.closest('.tmpcoder-search-form')) {
                        $scope.find('.tmpcoder-search-form-input').val('');
                        $scope.find('.tmpcoder-data-fetch').slideUp(200);
                        setTimeout(function () {
                            $scope.find('.tmpcoder-data-fetch ul').html('');
                            $scope.find('.tmpcoder-no-results').remove();
                            $scope.closest('section').removeClass('tmpcoder-section-z-index');
                        }, 400);
                        postsOffset = 0;
                    }
                }
            });

            var mutationObserver = new MutationObserver(function (mutations) {
                $scope.find('.tmpcoder-data-fetch li').on('click', function () {
                    var itemUrl = $(this).find('a').attr('href');
                    var itemUrlTarget = $(this).find('a').attr('target');
                    window.open(itemUrl, itemUrlTarget).focus();
                });
            });

            // Listen to Mini Cart Changes
            mutationObserver.observe($scope[0], {
                childList: true,
                subtree: true,
            });
        }
    }
    
    $(window).on('elementor/frontend/init', function () {
        elementorFrontend.hooks.addAction('frontend/element_ready/tmpcoder-search.default', widgetSearch);
    });
})(jQuery);