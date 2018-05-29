var $ = jQuery.noConflict();

var AjaxForm =
    {
        alert_selector: false,

        action_url: false,

        run: function () {

            var this_class = this;

            this_class.alert_selector = "[data-alert='alert-area']";

            this_class.init("[action$='AjaxForm.php']");


        },
        init: function (selector) {
            var this_class = this;

            $(selector).submit(function (e) {

                e.preventDefault();

                var method = $(this).attr('method');
                var action = $(this).attr('action');
                var form = $(this);
                var data = $(this).serialize();
                var button = $(this).find("[type='submit']");
                var alert_area = $(this).find(this_class.alert_selector);


                button.removeAttr('disabled');


                $.ajax({
                    type: method,
                    url: action,
                    data: data,
                    dataType: 'json',

                    beforeSend: function () {
                        button.attr('disabled', 'disabled');
                    },

                    success: function (result) {

                        button.removeAttr('disabled');

                        alert_area.text(result.data.message);

                        if (result.success) {
                            alert_area.removeClass('no-message').addClass('success');

                            form.find('input, texarea').each(function () {


                                if ('hidden' !== $(this).attr('type') && 'submit' !== $(this).attr('type')) {

                                    if ("TEXTAREA" === $(this).prop("tagName")) {
                                        $(this).text('')
                                    } else {
                                        $(this).value('');
                                    }
                                }

                            });

                        } else {

                            ///

                        }

                    },

                    error:function () {
                        button.removeAttr('disabled');
                    }

                });

            });

        },

    };

$(document).ready(function () {
    AjaxForm.run();
});