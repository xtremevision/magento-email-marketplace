require([
    'jquery',
    'select2',
], function ($) {
    $(document).ready(function () {
        let importButton = $('#shipping_settings_shipping_group_locality');

        let searchUrl = importButton.data('action');

        importButton.select2(
            {
                width: '100%',
                minimumInputLength: 3,
                ajax: {
                    url: searchUrl,
                    delay: 500,
                    data: function (params) {
                        return {
                            name: params.term
                        };
                    },
                    processResults: function (data, params) {
                        params.page = params.page || 1;

                        return {
                            results: data['message']
                        };
                    }
                }
            }
        );
    });
});
