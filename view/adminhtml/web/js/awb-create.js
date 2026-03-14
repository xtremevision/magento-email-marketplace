require(['jquery', 'select2',], function ($) {
    $(document).ready(function () {
        setTimeout(initLocalitiesSelect, 250);
    });

    function initLocalitiesSelect() {
        let $select = $('select[name="locality_id"]');

        if ($select.length) {
            $select.select2({
                width: '100%',
                minimumInputLength: 3,
                ajax: {
                    url: window.emkp_localities_ajax_url,
                    delay: 250,
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
            });

            return;
        }

        setTimeout(initLocalitiesSelect, 250);
    }
});
