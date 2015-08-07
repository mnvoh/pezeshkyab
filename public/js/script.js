(function($) {
    $(document).ready(function() {
        $('select#gp_sp').change(function() {
            if($(this).val() == 'sp') {
                $('#specialty_detail').slideDown(500);
            }
            else {
                $('#specialty_detail').slideUp(500);
            }
        });

        $('.calpage').click(function() {
            $('.calpage').removeClass('selected');
            $(this).addClass('selected');
            $('#date').val($(this).find('input[name="cal-value"]').val());
        });
    });
})(jQuery);