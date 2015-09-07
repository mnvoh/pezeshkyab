(function($) {
    $(document).ready(function() {
        $('.calpage').click(function() {
            $('.calpage').removeClass('selected');
            $(this).addClass('selected');
            $('#date').val($(this).find('input[name="cal-value"]').val());
        });

        $('select#nationality').change(function() {
            if(this.value == "fo") {
                $('#signup-national-code').slideUp(300);
                $('#signup-passport-number').slideDown(300);
            }
            else {
                $('#signup-national-code').slideDown(300);
                $('#signup-passport-number').slideUp(300);
            }
        });
    });
})(jQuery);