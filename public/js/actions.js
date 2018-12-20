/**
 * Created by wizard on 12/18/18.
 */
(function (window, $){
    // Actions for magazines page

    // 1. Sorting main page
    $(document).ready(function() {
        $('select[name="sort"]').on('change', function (event) {
            console.log($(this).val());
            switch ($(this).val()) {
                case 'DATE_CREATE-DESC':
                    window.location = window.location.pathname + '?sort_by=created_at&sort_order=desc';
                    break;
                case 'NAME-ASC':
                    window.location = window.location.pathname + '?sort_by=name&sort_order=asc';
                    break;
            }
        })
    });

    // 2. Sidebar actions

})(window, jQuery)
