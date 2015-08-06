<div id="medical-question" class="medical-question">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <h2 class="section-heading text-center">{{ trans('main.medical_question') }}</h2>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-12">
                <h3 class="section-subheading  text-center text-muted">{{ trans('main.medical_question_desc') }}</h3>
            </div>
        </div>

        <form action="#" method="post">
            <div class="row">
                <div class="col-sm-12 col-md-6">
                    <div class="form-group">
                        <input type="text" class="form-control" id="q_name"
                               placeholder="{{ trans('main2.your_name') }} *"/>
                    </div>


                    <div class="form-group">
                        <input type="email" class="form-control" id="q_email"
                               placeholder="{{ trans('main.email_address') }} *"/>
                    </div>

                    <div class="form-group">
                        <input type="text" class="form-control" id="q_doctor"
                               placeholder="{{ trans('main.doctor_name') }} *"/>
                    </div>

                    <div class="form-group">
                        @include('cities_select')
                    </div>

                    <div class="form-group">
                        @include('specialties_select')
                    </div>
                </div>
                <div class="col-sm-12 col-md-6">
                    <div class="form-group">
                        <input type="text" class="form-control" id="q_title"
                               placeholder="{{ trans('main.title') }} *"/>
                    </div>

                    <textarea class="form-control" rows="8"
                              placeholder="{{ trans('main.your_question') }} *"></textarea>
                </div>
            </div>

            <div class="row vertical-spacing"></div>

            <div class="row">
                <div class="col-lg-12 text-center">
                    <button type="submit" class="btn btn-success btn-xlg">
                        {{ trans('main.ask') }}
                    </button>
                </div>
            </div>

        </form>
    </div>
</div>