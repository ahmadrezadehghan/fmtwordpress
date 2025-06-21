(function ($) {
    "use strict";

    const widgetMailchimp = function ($scope, $) {
        var mailchimpForm = $scope.find('form');

        mailchimpForm.on('submit', function (e) {
            e.preventDefault();

            var buttonText = $(this).find('button').text();

            // Change Text
            $(this).find('button').text($(this).find('button').data('loading'));

            var $formdata = $(this).serializeArray();
            var result = {};
            $.each($formdata, function () {
                result[this.name] = this.value;
            });

            result['action'] = 'mailchimp_subscribe';
            result['listId'] = mailchimpForm.data('list-id');
            result['nonce'] = tmpcoder_plugin_script.nonce;

            $.ajax({
                url: tmpcoder_plugin_script.ajax_url,
                type: 'POST',
                data: result,
                success: function (data) {
                    if ('yes' == mailchimpForm.data('clear-fields')) {
                        mailchimpForm.find('input').each(function () {
                            $(this).val('');
                        });
                    }

                    mailchimpForm.find('button').text(buttonText);

                    if ('subscribed' === data.status) {
                        $scope.find('.tmpcoder-mailchimp-success-message').show();
                    } else {
                        $scope.find('.tmpcoder-mailchimp-error-message').show();
                    }

                    $scope.find('.tmpcoder-mailchimp-message').fadeIn();
                }
            });

        });

    }
    
    $(window).on('elementor/frontend/init', function () {
        elementorFrontend.hooks.addAction('frontend/element_ready/tmpcoder-mailchimp.default', widgetMailchimp);
    });
})(jQuery);