(function($) {
    $(document).ready(function() {
        $('.calpage').click(function() {
            $('.calpage').removeClass('selected');
            $(this).addClass('selected');
            $('#date').val($(this).find('input[name="cal-value"]').val());
        });
    });
})(jQuery);