(function($) {
    $(document).ready(function() {
        $('select#nationality').change(function() {
            if($(this).val() == 'ir') {
                $('#signup-national-code').slideDown(500);
                $('#signup-passport-number').slideUp(500);
            }
            else {
                $('#signup-national-code').slideUp(500);
                $('#signup-passport-number').slideDown(500);
            }
        });

        $('.calpage').click(function() {
            $('.calpage').removeClass('selected');
            $(this).addClass('selected');
            $('#date').val($(this).find('input[name="cal-value"]').val());
        });
    });
})(jQuery);