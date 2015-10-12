(function($) {
    $(document).ready(function() {
        $('.calpage').click(function() {
            $('.calpage').removeClass('selected');
            $(this).addClass('selected');
            $('#reservation_id').val($(this).find('input[name="cal-value"]').val());
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
        }).blur(function() {
            $(this).parents("div.form-control").removeClass("form-control-focus");
        });;

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

        var es = new ElasticSearch({
            host: document.domain,
            callback: refreshDoctorPickerResults
        });

        $('div#doctor-picker input[type="text"]').keyup(function() {
            if($(this).val().length <= 0) {
                $('div#doctor-picker>div#dp-items>p').remove();
                $('div#doctor-picker>div#dp-items').hide();
                return;
            }

            var data = new Object();
            data.query = new Object();
            data.query.match = new Object();
            data.query.match._all = new Object();
            data.query.match._all.query = $(this).val();
            data.query.match._all.operator = "and";
            data.query.match._all.fuzziness = "AUTO";
            es.request("POST", "pezeshkyab/doctor/_search", data);
        });

        $('#summernote').summernote({
            height: 300,
            minHeight: null,
            maxHeight: null,
            focus: true,
        }).code($('#summernote-prev-value').html());

        $('a#show-new-bio-form').click(function() {
            $('p#doctor-bio').hide();
            $('#new-bio-form').toggle("fast");
        });

        if($('div#flip-counter').length) {
            $('#flip-counter').flipCounterInit();
            var flipCounterNewVal = $('#flip-counter').data('val');
            $('#flip-counter').flipCounterUpdate(flipCounterNewVal);
        }

        $('.email-patient-form').submit(function() {
            var reservation_id = $(this).find('input[name="reservation_id"]').val();
            var email = $(this).find('input[name="email"]').val();
            var name = $(this).find('input[name="name"]').val();

            $('#patient-compose-mail-to').html(name + "&lt;" + email + "&gt;");
            $('#mail-to-reservation-id').val(reservation_id);
            $('#ajax-form').show();
            $('#email-patient-modal').modal('show');

            return false;
        });

        $('#ajax-form').submit(function() {
            var url = $(this).prop('action');

            $.ajax({
                type: "POST",
                url: url,
                data: $(this).serialize(),
                success: function(results) {
                    if(results.error) {
                        $('#ajax-form').find('p.text-error').html(results.description);
                    }
                    else {
                        $('#ajax-form').hide();
                        $('#email-patient-modal h3.text-success').show();
                    }
                },
                error: function(data) {
                    alert('error');
                }
            });

            return false;
        });

        var tab_sel_mod = $('a#tab-sel-mod');
        if(window.location.hash == "#moderators" && tab_sel_mod.length) {
            tab_sel_mod.click();
        }
    });
})(jQuery);

var refreshDoctorPickerResults = function(data, xhr) {
    var results = data;
    var hits = results.hits.hits;
    $('div#doctor-picker>div#dp-items>p').remove();
    $('div#doctor-picker>div#dp-items').show();
    for(var i = 0; i < hits.length && i < 13; i++) {
        var id = hits[i]._id;
        var fullname = hits[i]._source.fullname;
        var specialties = hits[i]._source.specialty;
        var cities = hits[i]._source.city;

        var specialtiesString = "";
        var citiesString = "";

        if(typeof specialties != 'undefined') {
            for (var j = 0; j < specialties.length; j++) {
                if (specialtiesString.length > 0) {
                    specialtiesString += "?";
                }
                specialtiesString += specialties[j];
            }
        }

        if(typeof specialties != 'undefined') {
            for (var j = 0; j < cities.length; j++) {
                if (citiesString.length > 0) {
                    citiesString += "?";
                }
                citiesString += cities[j];
            }
        }

        var itemString = fullname + " &middot; " + specialtiesString + " &middot; " + citiesString;
        $('div#doctor-picker>div#dp-items').append(
            '<p class="dp-item" data-doctorid="'+id+'">' + itemString + '</p>');
    }
    $('div#doctor-picker>div#dp-items>p').click(pickDoctor);
};

var pickDoctor = function() {
    var id = $(this).data("doctorid");
    var label = $(this).html();
    $('div#doctor-picker>div#dp-items>p').remove();
    $('div#doctor-picker>div#dp-items').hide();
    $('div#doctor-picker>input[type="hidden"]').val(id);
    $('div#doctor-picker>label').html(label);
    $('div#doctor-picker>input[type="text"]').val('');
};

var prepareSummernoteSubmission = function() {
    $('textarea#summernote-code').html($('#summernote').code());
};