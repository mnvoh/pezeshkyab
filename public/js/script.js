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

        $('.main-search-input').focus(function() {
            $(this).parents("div.form-control").addClass("form-control-focus");
        });
        $('.main-search-input').blur(function() {
            $(this).parents("div.form-control").removeClass("form-control-focus");
        });

        $('#show-find-doctor').click(function() {
             $('div.main-search-container').slideToggle(200);
        });
        $('#btn-adv-search').click(function() {
            $('div.main-search-container div.adv-search').slideToggle(200);
            var currentState = $('input#s_adv').prop('checked');
            $('input#s_adv').prop('checked', !currentState);

            if(!currentState) {
                initMap();
            }
        });
    });
})(jQuery);