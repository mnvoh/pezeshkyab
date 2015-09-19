<!-- master nav
====================================-->
<header class="navbar navbar-static-top" id="top" role="banner">
    <div class="container navbar-container">
        <div class="navbar-header">
            <button class="navbar-toggle collapsed" type="button" data-toggle="collapse"
                    data-target="#bs-navbar" aria-controls="bs-navbar" aria-expanded="false">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <a href="{{ url('/') }}" class="navbar-brand">
                <img src="{{url('/img/logo.png')}}" alt="{{ trans('main.selector_page_title') }}"
                     class="navbar-logo"/>
            </a>
        </div>
        <nav id="bs-navbar" class="collapse navbar-collapse">
            <ul class="nav navbar-nav">
                <li>
                    <a href="{{ route('main.docfinder_home') }}"> {{ trans('main.site_name') }} </a>
                </li>
                <li>
                    <a href="{{ route('main.about') }}"> {{ trans('main.about') }} </a>
                </li>
                <li class="active">
                    <a href="{{ route('main.contact') }}"> {{ trans('main.contact') }} </a>
                </li>
                <li>
                    <a href="{{ route('main.links') }}"> {{ trans('main.links') }} </a>
                </li>
                <li>
                    <a href="javascript:;" id="show-find-doctor"> {{ trans('main3.find_a_doctor') }} </a>
                </li>
            </ul>
            <ul class="nav navbar-nav navbar-right">
                <?php if(\Illuminate\Support\Facades\Auth::check()): ?>
                    <li><a href="{{ route('user.logout') }}"> {{ trans('main3.logout') }} </a></li>
                <?php else: ?>
                    <li><a href="{{ route('user.login') }}"> {{ trans('main.login') }} </a></li>
                    <li><a href="{{ route('user.register') }}"> {{ trans('main.register') }} </a></li>
                <?php endif; ?>
                <?php foreach($langs as $l => $ll): ?>
                    <?php if($l != $lang): ?>
                        <li><a href="<?php echo LangChanger::change($l); ?>"> <?php echo $ll; ?> </a></li>
                    <?php endif; ?>
                <?php endforeach; ?>
            </ul>
        </nav>
    </div>


    <?php if(!isset($no_search)): ?>
        <div class="main-search-container <?php if(!isset($showSearchForm)) { echo "hidden-search"; } ?>">
            <div class="container">
                <div class="row">
                    <div class="col-xs-12">
                        <h1>{{ trans('main3.find_a_doctor') }}</h1>
                        <form method="get" action="{{ route('search.find') }}">
                            <div class="form-control main-searchbox-wrapper">
                                <a id="btn-adv-search">
                                    <span class="glyphicon glyphicon-cog"></span>
                                </a>

                                <button type="submit" class="btn-success">
                                    <span class="glyphicon glyphicon-search"></span>
                                </button>

                                <div class="input-wrapper">
                                    <input type="text" class="noborder main-search-input" name="s_q"
                                           placeholder="{{trans('main3.search_example')}}" autocomplete="on"
                                            @if(isset($showSearchForm))
                                                value="{{ filter_input(INPUT_GET, "s_q") }}"
                                            @endif
                                            />
                                </div>
                            </div>

                            <br />

                            <div class="adv-search">
                                <input type="checkbox" class="hidden" name="s_adv" id="s_adv" />
                                <div class="form-group">
                                    <label>{{ trans('main3.search_rating') }}</label>
                                    <select name="s_rating" id="s_rating" name="s_rating"
                                            class="form-control inline-form-control">
                                        <option value="0">{{ trans('main3.doesnt_matter') }}</option>
                                        <option value="1">1</option>
                                        <option value="2">2</option>
                                        <option value="3">3</option>
                                        <option value="4">4</option>
                                    </select>
                                </div>

                                <div class="form-group">
                                    <label>{{ trans('main3.search_schedule') }}</label>

                                    <br />
                                    <label style="width: 50px;">{{ trans('main3.from') }}: </label>
                                    <span class="form-control date-wrapper">
                                        {{ trans('main3.date') }}
                                        <input type="text" name="s_date_from_y" id="s_date_from_y"
                                               class="noborder" value="{{ $today_year }}" />
                                        /
                                        <input type="text" name="s_date_from_m" id="s_date_from_m"
                                               class="noborder" value="{{ $today_month }}" />
                                        /
                                        <input type="text" name="s_date_from_d" id="s_date_from_d"
                                               class="noborder" value="{{ $today_date }}" />

                                        {{ trans('main3.time') }}
                                        <input type="text" name="s_date_from_h" id="s_date_from_h"
                                               class="noborder" value="{{ $today_hour }}" />
                                        :
                                        <input type="text" name="s_date_from_min" id="s_date_from_min"
                                               class="noborder" value="{{ $today_minute }}" />
                                    </span>
                                    <br />
                                    <br />
                                    <label style="width: 50px;">{{ trans('main3.to') }}: </label>
                                    <span class="form-control date-wrapper">
                                        {{ trans('main3.date') }}
                                        <input type="text" name="s_date_to_y" id="s_date_to_y"
                                               class="noborder" value="{{ $twoday_year }}" />
                                        /
                                        <input type="text" name="s_date_to_m" id="s_date_to_m"
                                               class="noborder" value="{{ $twoday_month }}" />
                                        /
                                        <input type="text" name="s_date_to_d" id="s_date_to_d"
                                               class="noborder" value="{{ $twoday_date }}" />

                                        {{ trans('main3.time') }}
                                        <input type="text" name="s_date_to_h" id="s_date_to_h"
                                               class="noborder" value="{{ $twoday_hour }}" />
                                        :
                                        <input type="text" name="s_date_to_min" id="s_date_to_min"
                                               class="noborder" value="{{ $twoday_minute }}" />
                                    </span>
                                </div>

                                <div class="form-group">
                                    <label>{{ trans('main3.search_radius') }}</label>
                                    <select name="s_distance" id="s_distance" class="form-control inline-form-control">
                                        <option value="0">{{ trans('main3.doesnt_matter') }}</option>
                                        <option value="500">500 {{ trans('main3.meters') }}</option>
                                        <option value="1000">1 {{ trans('main3.km') }}</option>
                                        <option value="2000">2 {{ trans('main3.km') }}</option>
                                        <option value="3000">3 {{ trans('main3.km') }}</option>
                                        <option value="5000">5 {{ trans('main3.km') }}</option>
                                        <option value="10000">10 {{ trans('main3.km') }}</option>
                                        <option value="20000">20 {{ trans('main3.km') }}</option>
                                    </select>
                                </div>

                                <label class="help-block">
                                    {{ trans('main3.s_distance_help') }}
                                </label>

                                <div id="map-canvas">

                                </div>
                                <input type="hidden" name="locationLat" />
                                <input type="hidden" name="locationLon" />
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    <?php endif; ?>


    <?php if(isset($includeMainCarousel) && $includeMainCarousel): ?>
        <div id="main-carousel" class="carousel slide" data-ride="carousel">
            <ol class="carousel-indicators">
                <li data-target="#main-carousel" data-slide-to="0" class="active"></li>
                <li data-target="#main-carousel" data-slide-to="1"></li>
                <li data-target="#main-carousel" data-slide-to="2"></li>
            </ol>

            <!-- Wrapper for slides -->
            <div class="carousel-inner" role="listbox">
                <div class="item active">
                    <img src="{{ url('/img/carousel/1.jpg') }}" alt="{{ trans('main2.carousel_title_1') }}" />
                    <div class="carousel-caption">
                        <h1 class="hidden-xs">{{ trans('main2.carousel_title_1') }}</h1>
                        <p class="hidden-xs">{{ trans('main2.carousel_desc_1') }}</p>
                        <a href="{{ route('search.find') }}" title="{{ trans('main2.carousel_title_1') }}"
                                class="btn btn-default btn-lg">
                            {{ trans('main2.carousel_title_1') }}
                        </a>
                    </div>
                </div>
                <div class="item">
                    <img src="{{ url('/img/carousel/2.jpg') }}" alt="{{ trans('main2.carousel_title_2') }}" />
                    <div class="carousel-caption">
                        <h1 class="hidden-xs">{{ trans('main2.carousel_title_2') }}</h1>
                        <p class="hidden-xs">{{ trans('main2.carousel_desc_2') }}</p>
                        <a href="{{ route('appointment.book', ['step' => 1]) }}" title="{{ trans('main2.carousel_title_2') }}"
                           class="btn btn-default btn-lg">
                            {{ trans('main2.carousel_title_2') }}
                        </a>
                    </div>
                </div>
                <div class="item">
                    <img src="{{ url('/img/carousel/3.jpg') }}" alt="{{ trans('main2.carousel_title_3') }}" />
                    <div class="carousel-caption">
                        <h1 class="hidden-xs">{{ trans('main2.carousel_title_3') }}</h1>
                        <p class="hidden-xs">{{ trans('main2.carousel_desc_3') }}</p>
                        <a href="{{ route('main.docfinder_home') }}#medical-question" title="{{ trans('main2.carousel_title_3') }}"
                           class="btn btn-default btn-lg">
                            {{ trans('main2.carousel_title_3.1') }}
                        </a>
                    </div>
                </div>
            </div>

            <!-- Controls -->
            <a class="left carousel-control" href="#main-carousel" role="button" data-slide="prev">
                <span class="glyphicon glyphicon-chevron-left" aria-hidden="true"></span>
                <span class="sr-only">Previous</span>
            </a>
            <a class="right carousel-control" href="#main-carousel" role="button" data-slide="next">
                <span class="glyphicon glyphicon-chevron-right" aria-hidden="true"></span>
                <span class="sr-only">Next</span>
            </a>
        </div>


        <div id="quick-links" class="row">
            <div class="col-xs-12 col-sm-6 col-md-3 col-lg-3 quick-link nopadding">
                <a href="{{ route('search.find') }}" title="{{ trans('main2.systems_doctors') }}">
                    <img src="{{ url('img/quicklinks/doctors.svg') }}" alt="{{ trans('main2.systems_doctors') }}"
                            width="96" height="96"/>
                    <h3>{{ trans('main2.systems_doctors') }}</h3>
                    <p>{{ trans('main2.systems_doctors_desc') }}</p>
                </a>
            </div>
            <div class="col-xs-12 col-sm-6 col-md-3 col-lg-3 quick-link nopadding">
                <a href="{{ route('appointment.book', ['step' => 1]) }}" title="{{ trans('main2.online_appointment_booking') }}">
                    <img src="{{ url('img/quicklinks/schedule.svg') }}" alt="{{ trans('main2.online_appointment_booking') }}"
                         width="96" height="96"/>
                    <h3>{{ trans('main2.online_appointment_booking') }}</h3>
                    <p>{{ trans('main2.online_appointment_booking_desc') }}</p>
                </a>
            </div>
            <div class="col-xs-12 col-sm-6 col-md-3 col-lg-3 quick-link nopadding">
                <a href="{{ route('main.insurances') }}" title="{{ trans('main2.insurance') }}">
                    <img src="{{ url('img/quicklinks/insurances.svg') }}" alt="{{ trans('main2.insurance') }}"
                         width="96" height="96"/>
                    <h3>{{ trans('main2.insurance') }}</h3>
                    <p>{{ trans('main2.insurance_desc') }}</p>
                </a>
            </div>
            <div class="col-xs-12 col-sm-6 col-md-3 col-lg-3 quick-link nopadding">
                <a href="{{ route('main.fees') }}" title="{{ trans('main2.fees') }}">
                    <img src="{{ url('img/quicklinks/fees.svg') }}" alt="{{ trans('main2.fees') }}"
                         width="96" height="96"/>
                    <h3>{{ trans('main2.fees') }}</h3>
                    <p>{{ trans('main2.fees_desc') }}</p>
                </a>
            </div>
        </div>
    <?php endif; ?>
</header>