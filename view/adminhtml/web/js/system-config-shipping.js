require([
    'jquery',
    'Magento_Ui/js/modal/alert',
], function ($, alert) {
    $(document).ready(function () {

        let importButton = $('#import_localities_button'),
            importUrl = importButton.data('url');

        importButton.removeAttr('onclick');

        importButton.on('click', function (e) {
            e.preventDefault();

            if (!importUrl) {
                alert('An error occured. Please refresh the page!');

                return;
            }

            $('body').loader({
                texts: {
                    loaderText: 'Importing data...'
                }
            }).loader('show');

            $.ajax({
                url: importUrl,
                method: 'POST',
                data: {form_key: window.FORM_KEY},
                dataType: 'JSON',
                success: function (response) {
                    showAlert(response.message);
                    $('body').loader('hide');

                },
                error: function () {
                    showAlert('An error occured. Please refresh the page.');

                    $('body').loader('hide');
                }
            })
        });
    });

    function showAlert(message) {
        alert({
            title: 'Import status',
            content: message
        });
    }
});
