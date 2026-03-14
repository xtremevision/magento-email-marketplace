require([
    'jquery',
    'Magento_Ui/js/modal/alert',
], function ($, alert) {
    $(document).ready(function () {

        let importButton = $('.js-import-emag-data');
		let onclickAttr = importButton.attr('onclick');
		if (typeof onclickAttr !== 'undefined' && onclickAttr !== false)
		{
			importUrl = importButton.attr('onclick').match(/\bhttps?:\/\/\S+/gi);
	        importButton.removeAttr('onclick');
			importUrl = importUrl.length ? importUrl[0].replace(/';/g, '') : null;
		}

        importButton.on('click', function (e) {
            e.preventDefault();

            /*if (!importUrl) {
                alert('An error occured. Please refresh the page!');

                return;
            }*/

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
            content: message,
            actions: {
                always: function () {
                    window.location.reload();
                }
            }
        });
    }
});
