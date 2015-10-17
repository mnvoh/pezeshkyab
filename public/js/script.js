(function($) {
    $(document).ready(function() {
        /**
         * Handle the clicks on the reservation dates which are shown like calendar pages.
         */
        $('.calpage').click(function() {
            $('.calpage').removeClass('selected');
            $(this).addClass('selected');
            $('#reservation_id').val($(this).find('input[name="cal-value"]').val());
        });

        /**
         * Handle the nationality change which toggles between national code and passport number
         */
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

        /**
         * in the search form, glow the parent div when the child gets focus
         */
        $('.main-search-input').focus(function() {
            $(this).parents("div.form-control").addClass("form-control-focus");
        }).blur(function() {
            $(this).parents("div.form-control").removeClass("form-control-focus");
        });

        /**
         * in advanced search, the schedule range selection is washed out, and clicking the
         * filter by schedule checkbox should return it to normal status.
         */
        $('input#search_schedule').click(function() {
            if(!$(this).prop('checked')) {
                $('.disabled-form-group-overlay').show();
            }
            else {
                $('.disabled-form-group-overlay').hide();
            }
        });


        /**
         * Do quick search using elastic in the doctor selection sections.
         * @type {ElasticSearch}
         */
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


        /**
         * Initiate summernote
         */
        $('#summernote').summernote({
            height: 300,
            minHeight: null,
            maxHeight: null,
            focus: true,
        }).code($('#summernote-prev-value').html());


        /**
         * Edit the doctor's bio
         */
        $('a#show-new-bio-form').click(function() {
            $('p#doctor-bio').hide();
            $('#new-bio-form').toggle("fast");
        });


        /**
         * initiate flip counter
         */
        if($('div#flip-counter').length) {
            $('#flip-counter').flipCounterInit();
            var flipCounterNewVal = $('#flip-counter').data('val');
            $('#flip-counter').flipCounterUpdate(flipCounterNewVal);
        }

        /**
         * popup the email sending modal and then send email using ajax
         */
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

        /**
         * if there's the #moderators hash in the login page, change the tabs accordingly
         * @type {*|HTMLElement}
         */
        var tab_sel_mod = $('a#tab-sel-mod');
        if(window.location.hash == "#moderators" && tab_sel_mod.length) {
            tab_sel_mod.click();
        }


        /**
         *
         * FIVE STAR
         */

        var divFiveStar = $('div.fivestar');
        divFiveStar.mousemove(setFiveStarToMousePositionTemp);
        divFiveStar.mouseleave(setFiveStarToInputValue);
        divFiveStar.click(setFiveStarToMouseClickPosition);


        /**
         * Interchange select.select2slider with jquery-ui sliders
         *
         */
        var select = $("select.select2slider");
        if(select.length) {
            var slider = $("<div class='slider'></div>").insertAfter(select).slider({
                min: 1,
                max: select.find('option').length,
                range: "min",
                value: select[ 0 ].selectedIndex + 1,
                slide: function( event, ui ) {
                    select[ 0 ].selectedIndex = ui.value - 1;
                    $('label.slider-label').html(select.find('option:nth-child(' + ui.value + ')').html());
                }
            });
            var label = $("<label class='slider-label'></label>").insertAfter(slider.parent());
            label.html(select.find('option:selected').text())
            select.change(function() {
                slider.slider( "value", this.selectedIndex + 1 );
            });
        }


        /**
         * Initiate uploaders
         *
         */

        $('#upload-avatar>a').click(function() {
            var fileInput = document.getElementById('avatar-file');
            fileInput.click();
            fileInput.addEventListener('change', function() {
                var file = this.files[0];
                var csrf = $('input[name=_token]').val();
                var xhr = new XMLHttpRequest();

                (xhr.upload || xhr).addEventListener('progress', function(e) {
                    var done = e.loaded
                    var total = e.total;
                    var percent = Math.round(done/total*100) + '%';
                    $('#upload-avatar>.cprogress').width(percent);
                });
                xhr.addEventListener('load', function(e) {
                    var response = $.parseJSON(this.responseText);
                    if(response.error) {
                        alert(response.error_desc);
                        return;
                    }
                    var avatarImg = $('.avatar200>img');
                    avatarImg.attr('src', response.new_image);
                    avatarImg.css({width: "100%", height: "100%", margin: 0});
                    $('#upload-avatar>.cprogress').width(0);

                });
                xhr.open('post', $(fileInput).data('url'), true);
                var fd = new FormData;
                fd.append("file", file);
                fd.append("_token", csrf);
                xhr.setRequestHeader('X-XSRF-TOKEN', csrf);
                xhr.send(fd);
            });

        });


        /**
         * Fullsizable - fullscreen image viewer
         *
         */
        $('a.fullsizable').fullsizable();


        /**
         * In the admins home, if the number is bigger than 7 character, add a small class to it
         *
         */
        $('.admin-stat-item>span.stat').each(function(index, value) {
            if($(this).text().length > 9) {
                $(this).addClass('tiny');
            }
            else if($(this).text().length > 7) {
                $(this).addClass('small');
            }
            else if($(this).text().length > 4) {
                $(this).addClass('medium');
            }
        });
    });
})(jQuery);

function refreshDoctorPickerResults(data, xhr) {
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

function pickDoctor() {
    var id = $(this).data("doctorid");
    var label = $(this).html();
    $('div#doctor-picker>div#dp-items>p').remove();
    $('div#doctor-picker>div#dp-items').hide();
    $('div#doctor-picker>input[type="hidden"]').val(id);
    $('div#doctor-picker>label').html(label);
    $('div#doctor-picker>input[type="text"]').val('');
};

function prepareSummernoteSubmission() {
    $('textarea#summernote-code').html($('#summernote').code());
};

function setFiveStarToMouseClickPosition(event) {
    var localX = event.pageX - $(this).offset().left;
    var rating = (localX / $(this).width()) * 5;
    var ratingInt = parseInt(rating);
    var ratingFloat = rating - ratingInt;
    var value;

    for(var i = 1; i <= 5; i++) {
        $(this).find('span:nth-child(' + i + ')').removeClass();
    }

    for(var j = 1; j <= ratingInt; j++) {
        $(this).find('span:nth-child(' + j + ')').addClass('fa fa-star');
    }

    if(ratingFloat >= 0.5) {
        value = ratingInt + 1;
        $(this).find('span:nth-child(' + (ratingInt + 1) + ')').addClass('fa fa-star');
    }
    else {
        value = ratingInt + 0.5;
        $(this).find('span:nth-child(' + (ratingInt + 1) + ')').addClass('fa fa-star-half-o');
    }


    for(var k = ratingInt + 2; k <= 5; k++) {
        $(this).find('span:nth-child(' + k + ')').addClass('fa fa-star-o');
    }

    value = value > 5 ? 5 : value;
    $(this).find('input').val(value);
}

function setFiveStarToInputValue() {
    var rating = $(this).find('input').val();
    var ratingInt = parseInt(rating);
    var ratingFloat = rating - ratingInt;
    for(var i = 1; i <= 5; i++) {
        $(this).find('span:nth-child(' + i + ')').removeClass();
    }

    for(var j = 1; j <= ratingInt; j++) {
        $(this).find('span:nth-child(' + j + ')').addClass('fa fa-star');
    }

    if(ratingFloat > 0.5) {
        $(this).find('span:nth-child(' + (ratingInt + 1) + ')').addClass('fa fa-star');
    }
    else if(ratingFloat > 0) {
        $(this).find('span:nth-child(' + (ratingInt + 1) + ')').addClass('fa fa-star-half-o');
    }
    else {
        $(this).find('span:nth-child(' + (ratingInt + 1) + ')').addClass('fa fa-star-o');
    }

    for(var k = ratingInt + 2; k <= 5; k++) {
        $(this).find('span:nth-child(' + k + ')').addClass('fa fa-star-o');
    }
}

function setFiveStarToMousePositionTemp(event) {
    var localX = event.pageX - $(this).offset().left;
    var rating = (localX / $(this).width()) * 5;
    var ratingInt = parseInt(rating);
    var ratingFloat = rating - ratingInt;

    for(var i = 1; i <= 5; i++) {
        $(this).find('span:nth-child(' + i + ')').removeClass();
    }

    for(var j = 1; j <= ratingInt; j++) {
        $(this).find('span:nth-child(' + j + ')').addClass('fa fa-star');
    }

    if(ratingFloat >= 0.5) {
        $(this).find('span:nth-child(' + (ratingInt + 1) + ')').addClass('fa fa-star');
    }
    else {
        $(this).find('span:nth-child(' + (ratingInt + 1) + ')').addClass('fa fa-star-half-o');
    }

    for(var k = ratingInt + 2; k <= 5; k++) {
        $(this).find('span:nth-child(' + k + ')').addClass('fa fa-star-o');
    }
}