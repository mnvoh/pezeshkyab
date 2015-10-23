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
					<a class="dropdown-toggle" id="linksDropDown" data-toggle="dropdown"
					   aria-haspopup="true" aria-expanded="true">
						{{ trans('main.links') }}
						<span class="caret"></span>
					</a>
					<ul class="dropdown-menu" aria-labelledby="linksDropDown">
						@foreach(\App\Models\Link::all() as $link)
							<li>
								<a href="{{ $link->url }}">{{ $link->title }}</a>
							</li>
						@endforeach
					</ul>
                </li>
                <li>
                    <a href="{{ route('search.find') }}" id="show-find-doctor"> {{ trans('main.find_a_doctor') }} </a>
                </li>
            </ul>
            <ul class="nav navbar-nav navbar-right">
                @if(\Illuminate\Support\Facades\Auth::check())
                    <li><a href="{{ route('user.logout') }}"> {{ trans('main.logout') }} </a></li>
				@elseif(\App\Auth\AdminAuth::check())
					<li><a href="{{ route('admins.home') }}"> {{ trans('main.administration') }} </a></li>
					<li><a href="{{ route('admins.logout') }}"> {{ trans('main.logout') }} </a></li>
                @else
                    <li><a href="{{ route('user.login') }}"> {{ trans('main.login') }} </a></li>
                    <li><a href="{{ route('user.register') }}"> {{ trans('main.register') }} </a></li>
                @endif

                @foreach($langs as $l => $ll)
                    @if($l != $lang)
                        <li><a href="<?php echo LangChanger::change($l); ?>"> <?php echo $ll; ?> </a></li>
                    @endif
                @endforeach
            </ul>
        </nav>
    </div>

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
                    <img src="{{ url('/img/carousel/1.jpg') }}" alt="{{ trans('main.carousel_title_1') }}" />
                    <div class="carousel-caption">
                        <h1 class="hidden-xs">{{ trans('main.carousel_title_1') }}</h1>
                        <p class="hidden-xs">{{ trans('main.carousel_desc_1') }}</p>
                        <a href="{{ route('search.find') }}" title="{{ trans('main.carousel_title_1') }}"
                                class="btn btn-default btn-lg">
                            {{ trans('main.carousel_title_1') }}
                        </a>
                    </div>
                </div>
                <div class="item">
                    <img src="{{ url('/img/carousel/2.jpg') }}" alt="{{ trans('main.carousel_title_2') }}" />
                    <div class="carousel-caption">
                        <h1 class="hidden-xs">{{ trans('main.carousel_title_2') }}</h1>
                        <p class="hidden-xs">{{ trans('main.carousel_desc_2') }}</p>
                        <a href="{{ route('appointment.book', ['step' => 1]) }}" title="{{ trans('main.carousel_title_2') }}"
                           class="btn btn-default btn-lg">
                            {{ trans('main.carousel_title_2') }}
                        </a>
                    </div>
                </div>
                <div class="item">
                    <img src="{{ url('/img/carousel/3.jpg') }}" alt="{{ trans('main.carousel_title_3') }}" />
                    <div class="carousel-caption">
                        <h1 class="hidden-xs">{{ trans('main.carousel_title_3') }}</h1>
                        <p class="hidden-xs">{{ trans('main.carousel_desc_3') }}</p>
                        <a href="{{ route('main.docfinder_home') }}#medical-question" title="{{ trans('main.carousel_title_3') }}"
                           class="btn btn-default btn-lg">
                            {{ trans('main.carousel_title_3.1') }}
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
                <a href="{{ route('search.find') }}" title="{{ trans('main.systems_doctors') }}">
                    <img src="{{ url('img/quicklinks/doctors.svg') }}" alt="{{ trans('main.systems_doctors') }}"
                            width="96" height="96"/>
                    <h3>{{ trans('main.systems_doctors') }}</h3>
                    <p>{{ trans('main.systems_doctors_desc') }}</p>
                </a>
            </div>
            <div class="col-xs-12 col-sm-6 col-md-3 col-lg-3 quick-link nopadding">
                <a href="{{ route('appointment.book', ['step' => 1]) }}" title="{{ trans('main.online_appointment_booking') }}">
                    <img src="{{ url('img/quicklinks/schedule.svg') }}" alt="{{ trans('main.online_appointment_booking') }}"
                         width="96" height="96"/>
                    <h3>{{ trans('main.online_appointment_booking') }}</h3>
                    <p>{{ trans('main.online_appointment_booking_desc') }}</p>
                </a>
            </div>
            <div class="col-xs-12 col-sm-6 col-md-3 col-lg-3 quick-link nopadding">
                <a href="{{ route('main.insurances') }}" title="{{ trans('main.insurance') }}">
                    <img src="{{ url('img/quicklinks/insurances.svg') }}" alt="{{ trans('main.insurance') }}"
                         width="96" height="96"/>
                    <h3>{{ trans('main.insurance') }}</h3>
                    <p>{{ trans('main.insurance_desc') }}</p>
                </a>
            </div>
            <div class="col-xs-12 col-sm-6 col-md-3 col-lg-3 quick-link nopadding">
                <a href="{{ route('main.fees') }}" title="{{ trans('main.fees') }}">
                    <img src="{{ url('img/quicklinks/fees.svg') }}" alt="{{ trans('main.fees') }}"
                         width="96" height="96"/>
                    <h3>{{ trans('main.fees') }}</h3>
                    <p>{{ trans('main.fees_desc') }}</p>
                </a>
            </div>
        </div>
    <?php endif; ?>
</header>