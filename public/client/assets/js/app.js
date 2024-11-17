$(document).ready(function () {
    $('input[name="cat"]').on('change', function () {
        $(this).closest('form').submit();
    });

    $('#categories').change(function() {
        $(this).closest('form').submit();
    });
});