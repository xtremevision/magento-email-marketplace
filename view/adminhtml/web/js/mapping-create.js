require([
    'jquery',
    'Magento_Ui/js/modal/alert',
], function ($, alert) {
    $(document).ready(function () {
        $(document).on('change', 'select#emag_category_id', loadCharacteristics);

        $('.js-emkp-save-mapping').on('click', function (e) {
            e.preventDefault();

            let invalidFields = 0;
            $('#js-mapping-form').find('select[required]').each(function () {
                if ($(this).val()) {
                    $(this).closest('._required').removeClass('_error');
                    $(this).closest('div').find('.js-emkp-mapping-error').hide()

                    return;
                }

                $(this).closest('._required').addClass('_error');
                $(this).closest('div').find('.js-emkp-mapping-error').css('display', 'block');

                invalidFields++;
            });

            if (invalidFields > 0) {
                return;
            }

            $('body').loader('show');

            let params = $('.js-emkp-mapping-input').serialize();
            params += '&form_key=' + window.FORM_KEY;

            $.ajax({
                url: window.emkp_save_mapping_url,
                method: 'POST',
                data: params,
                dataType: 'json',
                success: function (response) {
                    if (!response.error) {
                        window.location.href = response.redirectUrl;
                    } else {
                        alert({
                            title: 'An error occurred',
                            content: response.message,
                        });
                    }

                    $('body').loader('hide');
                },
                error: function (a, b, c) {
                    alert({
                        title: 'An error occured',
                        content: 'Please refresh the page and try again.',
                        actions: {
                            always: function () {
                            }
                        }
                    });


                    $('body').loader('hide');
                }
            })
        });

        $('select[required]').on('change', function () {
            if (!$(this).val()) {
                return;
            }

            $(this).closest('._required').removeClass('_error');
            $(this).closest('div').find('.js-emkp-mapping-error').hide()
        });

        // show characteristics form when emag category select is created (at page load)
        setTimeout(initCharacteristicsForm, 250);
    });

    function loadCharacteristics() {
        let categoryId = $('select#emag_category_id').val();

        $('#js-mapping-form').find('._required').removeClass('_error');
        $('#js-mapping-form').find('.js-emkp-mapping-error').hide();


        if (!categoryId) {
            return;

        }

        $('body').loader('show');
        $.ajax({
            url: window.emkp_mapping_categories_url,
            method: 'POST',
            data: {
                form_key: window.FORM_KEY,
                category_id: categoryId,
                mapping_id: $('input.js-emkp-mapping-input[type="hidden"]').val()
            },
            dataType: 'html',
            success: function (response) {
                $('#emkp_characterisics_div').parent().html(response);

                $('body').loader('hide');


                $(document).ready(function () {
                    let allowedValuesLinks = $('#emkp_characterisics_div').find('.js-emkp-show-allowed-values');
                    allowedValuesLinks.on('click', function (e) {
                        e.preventDefault();
                        let showValuesUrl = $(this).data('values-url'),
                            characteristicId = $(this).data('characteristic-id');
                        $('body').loader('show');
                        $.ajax({
                            url: showValuesUrl,
                            method: 'POST',
                            data: {
                                form_key: window.FORM_KEY,
                                characteristic_id: characteristicId
                            },
                            dataType: 'JSON',
                            success: function (response) {
                                $('body').loader('hide');
                                
                                showAlert(response.message);
                            }
                        });
                    });
                });
            },
            error: function () {
                $('#emkp_characterisics_div').parent().html('');

                $('body').loader('hide');
            }
        });

    }

    function initCharacteristicsForm() {
        if ($('select#emag_category_id').length) {
            loadCharacteristics();

            return;
        }

        setTimeout(initCharacteristicsForm, 250);
    }

    function showAlert(message) {
        alert({
            title: 'Values:',
            content: message
        });
    }
});
