/**
 * Created by wizard on 12/5/18.
 */
$(document).ready(function() {
    $('input[name="PERSON_TYPE"]').on('click', function(event) {
        var el = event.target;
        if ($(el).val() == 'physical') {
            $('#phys_user_form').show();
            $('#legal_user_form').hide();
        } else if ($(el).val() == 'legal') {
            $('#legal_user_form').show();
            $('#phys_user_form').hide();
        }
    });

    $('#ORDER_FORM').on('beforeSubmit', orderValidate);

    var orderValidate = function (event) {
        if ($('input[name="PERSON_TYPE"]:checked').val() == 'physical') {

        } else {

        }
    }
});
